<?php
/**
 * This file is part of the Crystal package.
 *
 * (c) Sergey Novikov (novikov.stranger@gmail.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 17.12.2014
 * Time: 1:41
 */

namespace core\validators;

class MoreOrEqual extends MoreThen
{
    /**
     * @return bool
     */
    public function isValid()
    {
        return ($this->property->get() >= $this->min);
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->property->name() . " less then {$this->min}";
    }
}