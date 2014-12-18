<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 17.12.2014
 * Time: 1:58
 */

namespace app\models;

use core\generic\Model;
use core\generic\Property;
use core\validators\BelongsTo;
use core\validators\MoreOrEqual;

/**
 * Class Purchase
 * @package app\models
 *
 * @property    \core\property_types\Integer    user_id
 * @property    \core\property_types\Integer    product_id
 * @property    \core\property_types\DateTime   date
 * @property    \core\property_types\Integer    price
 * @property    \core\property_types\Integer    quantity
 * @property    \core\property_types\String     username
 * @property    \core\property_types\String     product
 */
class Purchase extends Model
{
    private $product_rest;

    public function __construct()
    {
        parent::__construct();
        $this->setTableName('purchase');
        $this->identifier('id', 'Integer')->title('Идентификатор');

        $this->property('user_id', 'Integer')
            ->title('Пользователь')
            ->validator(new BelongsTo($this->db, 'users', 'id'));

        $this->property('product_id', 'Integer')
            ->title('Продукт')
            ->validator(new BelongsTo($this->db, 'products', 'id'));

        $this->property('date', 'DateTime')->title('Дата покупки')->useAsDefault(time());
        $this->property('price', 'Integer')->title('Цена')->useAsDefault(0);
        $this->property('quantity', 'Integer')->title('Количество')->validator(new MoreOrEqual(1));

        $this->property('username', 'String')->readOnly();
        $this->property('product', 'String')->readOnly();
    }

    public function table($user_id = Property::NOT_INITIALIZED)
    {
        $params = [];
        $sql = 'SELECT' . ' purchase.*, username, products.name AS product'
            . ' FROM purchase'
            . ' INNER JOIN users ON purchase.user_id = users.id'
            . ' INNER JOIN products ON purchase.product_id = products.id';
        if (!empty($user_id)) {
            $sql .= ' WHERE users.id = ?';
            $params[] = $user_id;
        }
        $sql .= ' ORDER BY purchase.date';
        return $this->db->query($sql, $params);
    }

    protected function beforeCreate()
    {
        if (parent::beforeCreate()) {
            $this->db->query('BEGIN');

            // Lock table on case of concurrent access
            $sql = 'SELECT * FROM products WHERE id = ? FOR UPDATE';
            $row = $this->db->query($sql, [$this->product_id->get()])->row();
            if ($row->quantity < $this->quantity->get()) {
                $this->addError('Количество', 'Недостаточное количество на складе');
                $this->db->query('ROLLBACK');
                return false;
            }
            $this->price->set($row->price);
            $this->product_rest = intval($row->quantity) - $this->quantity->get();
            return true;
        }
        return false;
    }

    protected function afterCreate()
    {
        // Reduce product quantity in warehouse
        $product = (new Product());
        $product->id->set($this->product_id->get());
        $product->quantity->set($this->product_rest);
        $product->update();
        $this->db->query('COMMIT');
        return true;
    }
}