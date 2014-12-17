<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 17.12.2014
 * Time: 1:28
 */

namespace app\models;


use core\generic\Model;
use core\validators\IsUnique;
use core\validators\MoreOrEqual;
use core\validators\MoreThen;

/**
 * Class Product
 * @package app\models
 *
 * @property    \core\property_types\String     name
 * @property    \core\property_types\String     description
 * @property    \core\property_types\Integer    price
 * @property    \core\property_types\Integer    quantity
 */
class Product extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->setTableName('products');
        $this->identifier('id', 'Integer')->title('Идентификатор');

        $this->property('name', 'String')
            ->title('Наименование')
            ->validator(new IsUnique($this->db, $this->getTableName()));

        $this->property('description', 'String')
            ->title('Описание')
            ->useAsDefault('');

        $this->property('price', 'Integer')
            ->title('Цена')
            ->validator(new MoreThen(0));

        $this->property('quantity', 'Integer')
            ->title('Количество')
            ->validator(new MoreOrEqual(0));
    }
}