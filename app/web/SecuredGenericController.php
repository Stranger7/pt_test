<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 18.12.2014
 * Time: 15:03
 */

namespace app\web;

abstract class SecuredGenericController extends PublicGenericController
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->authorized()) {
            $this->http()->redirect('auth');
        }
    }

    private function authorized()
    {
        return ($this->session()->get('authorized') === '1');
    }

    protected function role()
    {
        return intval($this->session()->get('role'));
    }
}