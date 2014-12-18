<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 18.12.2014
 * Time: 15:15
 */

namespace app\web;

use app\models\User;
use core\App;
use core\Utils;
use core\View;

class Product extends SecuredGenericController
{
    public function __construct()
    {
        parent::__construct();
        if ($this->role() != User::ROLE_ADMIN) {
            $this->http()->forbidden();
        }
    }

    public function index()
    {
        App::view('product\index', [
            'title' => 'Товары',
            'role' => $this->role(),
            'js' => array_merge(View::defaultJS(), ['js/product.js']),
            'css' => View::defaultCSS()
        ]);
    }

    public function entry()
    {
        $product = new \app\models\Product();
        $product->id->set($this->request()->post('id'));
        echo json_encode($product->getEntry());
    }

    public function save()
    {
        $product = new \app\models\Product();
        $product->setValues($this->request()->post());
        $product->id->set($this->request()->post('id'));
        if ($product->id->get() ? $product->update() : $product->create()) {
            echo json_encode(['result' => 1]);
        } else {
            echo json_encode([
                'result' => 0,
                'message' => Utils::arrayToString($product->getErrors())
            ]);
        }
    }

    public function entries()
    {
        $product = new \app\models\Product();
        App::view('product\entries', [
            'entries' => $product->entries('name ASC')->result()
        ]);
    }
}