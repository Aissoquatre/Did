<?php

namespace Did\Database;

/**
 * Class SmartConnector
 *
 * @package Did\Database
 * @author (c) Julien Bernard <hello@julien-bernard.com>
 */
class SmartConnector extends AbstractConnection
{
    /**
     * SmartConnector constructor.
     */
    public function __construct()
    {
        parent::connect();
    }
}