<?php

namespace PCSG\SteemBlockchainParser;

use QUI\Database\DB;

class Database extends DB
{
    public function __construct(array $attributes = array())
    {
        $attributes = array(
            "driver" => "mysql",
            "host" => Config::getInstance()->get("database", "host"),
            "dbname" => Config::getInstance()->get("database", "dbname"),
            "port" => Config::getInstance()->get("database", "port"),
            "user" => Config::getInstance()->get("database", "user"),
            "password" => Config::getInstance()->get("database", "password"),
        );
        
        parent::__construct($attributes);
    }
}
