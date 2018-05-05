<?php

namespace PCSG\SteemBlockchainParser;

/**
 * Class Config
 *
 * @package PCSG\SteemBlockchainParser
 */
class Config
{
    /** @var Config */
    protected static $Instance = null;

    /** @var array */
    protected $config = [];

    /**
     * Config constructor.
     *
     * @throws \Exception
     */
    public function __construct()
    {
        $this->load();
    }

    /**
     * Returns the value of the setting in the given section
     *
     * @param $section
     * @param $config
     *
     * @return mixed
     * @throws \Exception
     */
    public function get($section, $config)
    {
        if (!isset($this->config[$section])) {
            throw new \Exception("Invalid section '".$section."'");
        }

        if (!isset($this->config[$section][$config])) {
            throw new \Exception("Invalid setting '".$config."' in '".$section."'");
        }

        return $this->config[$section][$config];
    }

    /**
     * Loads the config file into the config field.
     *
     * @throws \Exception
     */
    protected function load()
    {
        $configFile = dirname(dirname(dirname(dirname(__FILE__))))."/etc/config.ini.php";

        if (!file_exists($configFile)) {
            throw new \Exception("Configfile '".$configFile."' was not found!");
        }

        $config = parse_ini_file($configFile, true);

        if ($config === false) {
            throw new \Exception("Error while parsing the config file!");
        }

        $this->config = $config;
    }

    /**
     * @return Config
     *
     * @throws \Exception
     */
    public static function getInstance()
    {
        if (is_null(self::$Instance)) {
            self::$Instance = new Config();
        }

        return self::$Instance;
    }
}
