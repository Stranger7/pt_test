<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 18.12.2014
 * Time: 15:51
 */

namespace app\web;

use core\App;
use core\View;

class Main extends SecuredGenericController
{
    public function index()
    {
        App::view('main\index', [
            'role' => $this->role(),
            'title' => 'Главная страница',
            'js' => View::defaultJS(),
            'css' => View::defaultCSS()
        ]);
    }
}