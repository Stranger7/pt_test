<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 17.12.2014
 * Time: 22:01
 */

namespace app\web;

use core\generic\WebController;
use core\session_drivers\DbSession;

abstract class PublicGenericController extends WebController
{
    /**
     * @var DbSession
     */
    private $session;

    public function __construct()
    {
        parent::__construct();
        $this->session = new DbSession($this->request(), $this->db());
    }

    /**
     * @return DbSession
     */
    public function session()
    {
        return $this->session;
    }
}