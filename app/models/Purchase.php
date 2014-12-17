<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 17.12.2014
 * Time: 1:58
 */

namespace app\models;

use core\generic\Model;
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
 */
class Purchase extends Model
{
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
    }
}