<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 18.12.2014
 * Time: 20:02
 */

namespace app\web;

use app\models\Product;
use app\models\User;
use core\App;
use core\Utils;
use core\View;

class Purchase extends SecuredGenericController
{
    public function index()
    {
        App::view('purchase\index', [
            'title' => 'Покупки',
            'role' => $this->role(),
            'products' => (new Product())->entries('name')->result(),
            'js' => array_merge(View::defaultJS(), ['js/purchase.js']),
            'css' => View::defaultCSS()
        ]);
    }

    public function entries()
    {
        $purchase = new \app\models\Purchase();
        App::view('purchase\entries', [
            'purchase' => $purchase,
            'entries' => $purchase->table($this->session()->get('user_id'))->result()
        ]);
    }

    public function save()
    {
        $purchase = new \app\models\Purchase();
        $purchase->setValues($this->request()->post());
        $purchase->user_id->set($this->session()->get('user_id'));
        if ($purchase->create()) {
            echo json_encode(['result' => 1]);
        } else {
            echo json_encode([
                'result' => 0,
                'message' => Utils::arrayToString($purchase->getErrors())
            ]);
        }
    }

    public function all()
    {
        if ($this->role() != User::ROLE_ADMIN) {
            $this->http()->forbidden();
        }
        $purchase = new \app\models\Purchase();
        App::view('purchase\all', [
            'title' => 'Все покупки',
            'role' => $this->role(),
            'css' => View::defaultCSS(),
            'js' => View::defaultJS(),
            'purchase' => $purchase,
            'entries' => $purchase->table()->result()
        ]);
    }
}