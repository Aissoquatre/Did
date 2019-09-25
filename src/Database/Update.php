<?php

namespace Did\Database;

/**
 * Class Update
 *
 * @package Did\Database
 * @author (c) Julien Bernard <hello@julien-bernard.com>
 */
class Update extends AbstractConnection
{
    public function __construct()
    {
        parent::connect();
    }

    public function run()
    {
        return true;
    }
}