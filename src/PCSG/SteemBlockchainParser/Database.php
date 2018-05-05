<?php

namespace PCSG\SteemBlockchainParser;

use QUI\Database\DB;

mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');

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

        $this->setAttribute('options', [
            \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
        ]);

        $this->PDO = $this->getNewPDO();
        $this->PDO->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }
}
