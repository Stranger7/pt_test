<?php
/**
 * This file is part of the Crystal package.
 *
 * (c) Sergey Novikov (novikov.stranger@gmail.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 03.10.2014
 * Time: 1:49
 */

namespace core\actuators;

use core\App;
use core\Config;
use core\DatabaseManager;
use core\Utils;

/**
 * Static Class DBInitializer
 * @package core\loaders
 */
class DBActuator implements ActuatorInterface
{
    /**
     * Scan config file, search section with prefix "db:" and do DB driver initialization
     */
    public static function run()
    {
        $section = App::config()->firstSection();
        while ($section) {
            if (strpos($section, Config::DB_PREFIX) === 0) {
                self::add($section);
            }
            $section = App::config()->nextSection();
        }
    }

    /**
     * Analysing section and call appropriate methods for variable setting
     * @param string $section
     * @throws \LogicException
     */
    private static function add($section)
    {
        $alias = str_replace(Config::DB_PREFIX, '', $section);
        $driver_name = 'core\\db_drivers\\' . self::getDriverName($section);
        $driver = new $driver_name;
        $auto_connect = false;
        $default = false;
        foreach(App::config()->get($section) as $item => $value) {
            if ($item != Config::DRIVER_SIGNATURE) {
                switch ($item) {
                    case Config::AUTO_CONNECT_SIGNATURE:
                        $auto_connect = Utils::boolValue($value);
                        break;
                    case Config::DEFAULT_SIGNATURE:
                        $default = Utils::boolValue($value);
                        break;
                    default:
                        $func = 'set' . Utils::toCamelCase($item);
                        if (method_exists($driver, $func)) {
                            $driver->$func($value);
                        }
                }
            }
        }
        App::logger()->debug("Database [$alias] with [$driver_name] initialized");
        if ($auto_connect) {
            if (method_exists($driver, 'connect')) {
                /** @var \core\generic\DbDriver $driver */
                $driver->connect();
            } else {
                throw new \LogicException("Method 'connect' not found in DB driver $driver_name", 501);
            }
        }
        DatabaseManager::getInstance()->add($alias, $driver, $default);
    }

    /**
     * Detects driver name
     * @param string $section
     * @return string
     * @throws \RuntimeException
     */
    private static function getDriverName($section)
    {
        foreach(App::config()->get($section) as $item => $value)
        {
            if ($item === Config::DRIVER_SIGNATURE) {
                return $value;
            }
        }
        throw new \RuntimeException("Can't find DB driver in section $section", 500);
    }
}
