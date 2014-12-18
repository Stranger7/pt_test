<?php
/**
 * This file is part of the Crystal package.
 *
 * (c) Sergey Novikov (novikov.stranger@gmail.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 05.12.2014
 * Time: 1:26
 */

namespace core\generic;

/**
 * Class Property
 * @package core\generic
 */
abstract class Property
{
    const NOT_INITIALIZED = null;

    /**
     * @var string
     */
    protected $name = self::NOT_INITIALIZED;

    /**
     * @var string
     */
    protected $title = self::NOT_INITIALIZED;

    /**
     * @var mixed
     */
    protected $value = self::NOT_INITIALIZED;

    /**
     * @var mixed
     */
    protected $default = self::NOT_INITIALIZED;

    /**
     * if the read-only property, it is not used in the recording operations of the database
     * @var bool
     */
    protected $read_only = false;

    /**
     * @var array
     */
    private $validators = [];

    /**
     * @var array
     */
    private $errors = [];

    /*===============================================================*/
    /*                        M E T H O D S                          */
    /*===============================================================*/

    /**
     * @param $this
     */
    public function __construct($name)
    {
        $this->name($name);
    }

    /**
     * @param mixed $value
     * @return $this
     */
    public function set($value, $with_cast = true)
    {
        $this->value = ($with_cast ? $this->cast($value) : $value);
        return $this;
    }

    /**
     * @return mixed
     */
    public function get()
    {
        return $this->value;
    }

    /**
     * @param mixed $format
     * @return string
     */
    abstract public function asString($format = self::NOT_INITIALIZED);

    /**
     * This method returns the data prepared for "insert" and "update" operations in the database
     * @return string
     */
    abstract public function preparedForDb();

    /**
     * Sets for property self::NOT_INITIALIZED
     * @return $this
     */
    public function clear()
    {
        $this->value = self::NOT_INITIALIZED;
        return $this;
    }

    /**
     * Checks whether the property is initialized
     * @return bool
     */
    public function initialized()
    {
        return ($this->value !== self::NOT_INITIALIZED);
    }

    /**
     * @param mixed $default
     * @return $this
     */
    public function useAsDefault($default)
    {
        $this->default = $default;
        return $this;
    }

    /**
     * Assigns default value to property if property not initialized
     */
    public function applyDefault()
    {
        if (!$this->initialized() && $this->default !== self::NOT_INITIALIZED) {
            $this->value = $this->default;
        }
        return $this->get();
    }

    /**
     * Return true if property is empty, otherwise false
     * @return bool
     */
    abstract public function isEmpty();

    /**
     * @param null|string $name
     * @return $this|string
     */
    public function name($name = self::NOT_INITIALIZED)
    {
        if ($name === self::NOT_INITIALIZED) {
            return $this->name;
        } else {
            $this->name = $name;
            return $this;
        }
    }

    /**
     * @param null|string $title
     * @return $this|string
     */
    public function title($title = self::NOT_INITIALIZED)
    {
        if ($title === self::NOT_INITIALIZED) {
            return $this->title;
        } else {
            $this->title = $title;
            return $this;
        }
    }

    /**
     * Cast data to the appropriate type
     * @param mixed $value
     * @return mixed
     */
    abstract protected function cast($value);

    /**
     * Setter
     * @param bool $read_only
     * @return $this
     */
    public function readOnly($read_only = true)
    {
        $this->read_only = $read_only;
        return $this;
    }

    /**
     * Getter
     * @return bool
     */
    public function isReadOnly()
    {
        return $this->read_only;
    }

    /**
     * Add validator to internal array
     * @param Validator $validator
     * @return $this
     */
    public function validator(Validator $validator)
    {
        $validator->forProperty($this);
        $this->validators[] = $validator;
        return $this;
    }

    /**
     * Validates of field value
     * @return bool
     */
    public function isValid()
    {
        $valid = true;
        $this->errors = [];
        foreach ($this->validators as $validator) {
            $valid &= $this->execValidator($validator);
        }
        return $valid;
    }

    /**
     * Runs of validator
     * @param Validator $validator
     * @return bool
     */
    private function execValidator(Validator $validator)
    {
        if (!$validator->isValid()) {
            $this->addError($validator->getMessage());
            return false;
        }
        return true;
    }

    /**
     * Add error to internal array
     * @param string $message
     */
    public function addError($message)
    {
        $this->errors[] = $message;
    }

    /**
     * Get errors with array
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
}