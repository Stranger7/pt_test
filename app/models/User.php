<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 16.12.2014
 * Time: 22:41
 */

namespace app\models;

use core\generic\Model;
use core\property_types\Password;
use core\validators\MatchedWith;
use core\validators\IsRequired;
use core\validators\IsUnique;
use core\validators\Range;

/**
 * Class User
 * @package app\models
 *
 * @property    \core\property_types\String     username
 * @property    \core\property_types\Password   password
 * @property    \core\property_types\String     confirm_password
 * @property    \core\property_types\Integer    role
 */
class User extends Model
{
    const ROLE_ADMIN    = 1;
    const ROLE_CUSTOMER = 2;

    public function __construct()
    {
        parent::__construct();
        $this->setTableName('users');
        $this->identifier('id', 'Integer')->title('Идентификатор');

        $this->property('username', 'String')
            ->title('Логин')
            ->validator(new IsUnique($this->db, $this->getTableName(), $this->id));

        $this->property('password', 'Password')->title('Пароль')->validator(new IsRequired());
        $this->property('confirm_password', 'String')->title('Подтверждение пароля')->readOnly();
        $this->password->validator(new MatchedWith($this->confirm_password));

        $this->property('role', 'Integer')->title('Роль')
            ->useAsDefault(self::ROLE_CUSTOMER)
            ->validator(new Range(self::ROLE_ADMIN, self::ROLE_CUSTOMER));
    }

    /**
     * @param string $username
     * @param string $password
     */
    public function authVerify($username, $password)
    {
        $row = $this->db->query(
            "SELECT * FROM {$this->getTableName()} WHERE username = ? ", [$username]
        )->row();
        if ($row) {
            $this->deployFromRow($row);
            $this->username->set($username);
            return ($row->password === Password::crypt($password, $this->createSalt()));
        }
        return false;
    }

    protected function beforeCreate()
    {
        if (parent::beforeCreate()) {
            $this->password->set(Password::crypt($this->password->get(), $this->createSalt()));
            return true;
        }
        return false;
    }

    /**
     * This function is responsible for selecting the encryption algorithm.
     * Encryption algorithm affects the speed of the application.
     * In this case, the algorithm is applied BlowFish:
     * time encryption password approximately 0.03 seconds
     *
     * @return string
     */
    private function createSalt()
    {
        return '$2a$08$' . substr(base64_encode(sha1($this->username->get())), 0, 22);
    }
}