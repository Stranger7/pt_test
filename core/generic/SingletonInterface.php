<?php
/**
 * This file is part of the Crystal package.
 *
 * (c) Sergey Novikov (novikov.stranger@gmail.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 09.12.2014
 * Time: 16:25
 */

namespace core\generic;


interface SingletonInterface
{
    public static function getInstance();
}