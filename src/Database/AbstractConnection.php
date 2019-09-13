<?php

namespace Did\Database;

use Did\Kernel\Environment;
use PDO;

/**
 * Class AbstractConnection
 *
 * @package Did\Database
 * @author Julien Bernard <hello@julien-bernard.com>
 */
abstract class AbstractConnection
{
    protected $db;

    public function connect()
    {
        $database = Environment::get()->vars()['DATABASE'];

        try {
            $this->db = new PDO(
                'mysql:host=' . $database['host'] . ';port=' . $database['port'] . ';dbname=' . $database['dbname'],
                $database['user'],
                $database['password']
            );
        } catch(PDOException $e) {
            echo 'Failed to connect to database server : ' . $e->getMessage();
        }
    }
}