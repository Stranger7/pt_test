<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 17.12.2014
 * Time: 22:02
 */

namespace app\web;

use app\models\User;
use core\App;
use core\Utils;
use core\View;

class Auth extends PublicGenericController
{
    public function index()
    {
        App::view('auth\index', [
            'title' => 'Авторизация',
            'js' => View::defaultJS(),
            'css' => View::defaultCSS()
        ]);
    }

    public function login()
    {
        $user = new User();
        if ($user->authVerify($this->request()->post('username'), $this->request()->post('password')))
        {
            $this->updateSession($user);
            echo json_encode(['result' => 1]);
        } else {
            echo json_encode([
                'result' => 0,
                'message' => 'Неверные логин/пароль'
            ]);
        }
    }

    public function register()
    {
        $user = new User();
        $user->setValues($this->request()->post());
        if ($user->create()) {
            $this->updateSession($user);
            echo json_encode(['result' => 1]);
        } else {
            echo json_encode([
                'result' => 0,
                'message' => Utils::arrayToString($user->getErrors())
            ]);
        }
    }

    public function logout()
    {
        $this->session()->destroy();
    }

    private function updateSession(\app\models\User $user)
    {
        $this->session()->set('authorized', '1');
        $this->session()->set('role', $user->role->get());
        $this->session()->set('user_id', $user->id->get());
    }
}