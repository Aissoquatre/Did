<?php

namespace Did\Database;

use Did\Kernel\Environment;
use PDO;
use PDOException;

/**
 * Class AbstractConnection
 *
 * @package Did\Database
 * @author (c) Julien Bernard <hello@julien-bernard.com>
 */
abstract class AbstractConnection
{
    /**
     * @var PDO
     */
    protected $db;

    public function connect()
    {
        $database = Environment::get()->vars()['DATABASE'];

        try {
            $this->db = new PDO(
                'mysql:host=' . $database['host'] . ';port=' . $database['port'] . ';dbname=' . $database['dbname'] . ';charset=utf8',
                $database['user'],
                $database['password'],
                [
                    PDO::ATTR_PERSISTENT => true
                ]
            );
        } catch(PDOException $e) {
            echo 'Failed to connect to database server : ' . $e->getMessage();
        }
    }
}