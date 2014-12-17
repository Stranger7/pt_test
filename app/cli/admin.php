<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 17.12.2014
 * Time: 18:08
 */

namespace app\cli;

use app\models\User;
use core\generic\Controller;
use core\Utils;

class admin extends Controller
{
    public function create($username, $password)
    {
        $user = new User();
        $user->username->set($username);
        $user->password->set($password);
        $user->confirm_password->set($password);
        $user->role->set(User::ROLE_ADMIN);
        if ($user->create()) {
            echo "User '$username' created" . PHP_EOL;
        } else {
            echo Utils::contextToString($user->getErrors()) . PHP_EOL;
            echo "User '$username' NOT created" . PHP_EOL;
        }
    }
}