<?php
/**
 * This file is part of the Crystal package.
 *
 * (c) Sergey Novikov (novikov.stranger@gmail.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 16.12.2014
 * Time: 22:43
 */

namespace core\validators;


use core\generic\DbDriver;
use core\generic\Validator;

class IsUnique extends Validator
{
    /**
     * @var DbDriver
     */
    protected $db;

    /**
     * @var string
     */
    protected $table_name;

    /**
     * @param DbDriver $db
     * @param string $table_name
     */
    public function __construct(DbDriver $db, $table_name)
    {
        parent::__construct();
        $this->db = $db;
        $this->table_name = $table_name;
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return (!$this->db->getEntry(
            $this->table_name,
            [$this->property->name() => $this->property->preparedForDb()]
        ));
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return "value '{$this->property->get()}' is not unique for field `{$this->property->name()}`";
    }
}