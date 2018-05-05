<?php

namespace PCSG\SteemBlockchainParser;

use QUI\Database\DB;

/**
 * Class Database
 *
 * @package PCSG\SteemBlockchainParser
 */
class Database extends DB
{
    /**
     * Database constructor.
     *
     * @param array $attributes
     * @throws \Exception
     */
    public function __construct(array $attributes = [])
    {
        $attributes = [
            "driver"   => "mysql",
            "host"     => Config::getInstance()->get("database", "host"),
            "dbname"   => Config::getInstance()->get("database", "dbname"),
            "port"     => Config::getInstance()->get("database", "port"),
            "user"     => Config::getInstance()->get("database", "user"),
            "password" => Config::getInstance()->get("database", "password"),
        ];

        parent::__construct($attributes);
    }
}
