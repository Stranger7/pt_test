<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 17.12.2014
 * Time: 13:06
 */

namespace app\cli;

use core\generic\Controller;

class db extends Controller
{
    /**
     * @var \core\db_drivers\MySQLi
     */
    private $db;

    public function __construct()
    {
        $this->db = $this->db();
    }

    public function create($my_root, $password)
    {
        $db_name = $this->db->getDatabase();
        $db_pass = $this->db->getPassword();
        $this->db->setUsername($my_root);
        $this->db->setPassword($password);
        $this->db->setDatabase(null);
        $this->db->connect();

        $this->db->query("CREATE DATABASE $db_name CHARACTER SET utf8 COLLATE utf8_general_ci");
        echo "Database '$db_name' created" . PHP_EOL;
        $this->db->query("CREATE USER '$db_name'@'localhost' IDENTIFIED BY '$db_pass'");
        $this->db->query("GRANT ALL ON $db_name.* TO '$db_name'@'localhost'");
        echo "User '$db_name' created" . PHP_EOL;

        $this->db->query("USE $db_name");

        $this->createTableUsers();
        $this->createTableProducts();
        $this->createTablePurchase();
        $this->createTableSessions();
    }

    public function drop($my_root, $password)
    {
        $db_name = $this->db->getDatabase();
        $this->db->setUsername($my_root);
        $this->db->setPassword($password);
        $this->db->setDatabase(null);
        $this->db->connect();

        $this->db->query("DROP DATABASE $db_name");
        echo "Database '$db_name' deleted" . PHP_EOL;
        $this->db->query("DROP USER `$db_name`@localhost");
        echo "User '$db_name' deleted" . PHP_EOL;
    }

    public function fixtures()
    {
        $table = 'products';
        $this->db->connect();
        $this->db->clearTable($table);
        echo "Table $table cleared" . PHP_EOL;

        $data[] = [
            'id'          => 1,
            'name'        => 'name1',
            'description' => 'description1',
            'price'       => 100,
            'quantity'    => 5
        ];
        $data[] = [
            'id'          => 2,
            'name'        => 'name2',
            'description' => 'description2',
            'price'       => 120,
            'quantity'    => 10
        ];
        $data[] = [
            'id'          => 3,
            'name'        => 'name3',
            'description' => 'description3',
            'price'       => 90,
            'quantity'    => 15
        ];
        foreach ($data as $row) {
            $this->db->createEntry($table, $row);
        }
        echo 'Fixtures applied' . PHP_EOL;
    }

    private function createTableUsers()
    {
        $sql =<<< SQL
CREATE TABLE users (
  id SERIAL NOT NULL,
  username VARCHAR(256) NOT NULL,
  password TEXT,
  role INT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (id),
  UNIQUE KEY login (username(32))
) ENGINE=InnoDB DEFAULT CHARSET=utf8
SQL;
        $this->db->query($sql);
        echo "Table 'users' created" . PHP_EOL;
    }

    private function createTableProducts()
    {
        $sql =<<< SQL
CREATE TABLE products (
  id SERIAL NOT NULL,
  name VARCHAR(256) NOT NULL,
  description TEXT,
  price INT NOT NULL,
  quantity INT NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY product_name (name(32))
) ENGINE=InnoDB DEFAULT CHARSET=utf8
SQL;
        $this->db->query($sql);
        echo "Table 'products' created" . PHP_EOL;
    }

    private function createTablePurchase()
    {
        $sql =<<< SQL
CREATE TABLE purchase (
  id SERIAL NOT NULL,
  user_id BIGINT UNSIGNED NOT NULL,
  product_id BIGINT UNSIGNED NOT NULL,
  `date` DATETIME NOT NULL,
  price INT NOT NULL,
  quantity INT NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY purchase_product_id (id, product_id),
  FOREIGN KEY (user_id) REFERENCES users(id) ON UPDATE CASCADE ON DELETE RESTRICT,
  FOREIGN KEY (product_id) REFERENCES products(id) ON UPDATE CASCADE ON DELETE RESTRICT
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SQL;
        $this->db->query($sql);
        echo "Table 'purchase' created" . PHP_EOL;
    }

    private function createTableSessions()
    {
        $sql =<<< SQL
CREATE TABLE sessions (
  id VARCHAR(32) NOT NULL,
  created DATETIME NOT NULL,
  updated DATETIME NOT NULL,
  data text,
  ip_address text,
  user_agent text,
  PRIMARY KEY (id)
)
SQL;
        $this->db->query($sql);
        echo "Table 'sessions' created" . PHP_EOL;
   }
}