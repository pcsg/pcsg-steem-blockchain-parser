<?php

namespace PCSG\SteemBlockchainParser;

/**
 * Class Output
 *
 * @package PCSG\SteemBlockchainParser
 */
class Output
{
    const LEVEL_DEBUG = 1;
    const LEVEL_INFO = 2;
    const LEVEL_WARNING = 4;
    const LEVEL_ERROR = 8;
    const LEVEL_CRITICAL = 16;

    /**
     * Issues a critical message to the output
     *
     * @param $msg
     * @throws \Exception
     */
    public static function critical($msg)
    {
        if (self::getConfiguredLoglevel() > self::LEVEL_CRITICAL) {
            return;
        }

        $msg = self::buildMessage($msg, [
            "timestamp" => self::getTimestamp(),
            "level"     => "critical"
        ]);

        $msg = "\e[91m".$msg."\e[0m";

        self::writeLn($msg);
    }

    /**
     * Issues an error message to the output
     *
     * @param $msg
     * @throws \Exception
     */
    public static function error($msg)
    {
        if (self::getConfiguredLoglevel() > self::LEVEL_ERROR) {
            return;
        }

        $msg = self::buildMessage($msg, [
            "timestamp" => self::getTimestamp(),
            "level"     => "error"
        ]);

        $msg = "\e[91m".$msg."\e[0m";

        self::writeLn($msg);
    }

    /**
     * Issues a warning message to the output
     *
     * @param $msg
     * @throws \Exception
     */
    public static function warning($msg)
    {
        if (self::getConfiguredLoglevel() > self::LEVEL_WARNING) {
            return;
        }

        $msg = self::buildMessage($msg, [
            "timestamp" => self::getTimestamp(),
            "level"     => "warning"
        ]);

        $msg = "\e[93m".$msg."\e[0m";

        self::writeLn($msg);
    }

    /**
     * Issues an info message to the output
     *
     * @param $msg
     * @throws \Exception
     */
    public static function info($msg)
    {
        if (self::getConfiguredLoglevel() > self::LEVEL_INFO) {
            return;
        }

        $msg = self::buildMessage($msg, [
            "timestamp" => self::getTimestamp(),
            "level"     => "info"
        ]);

        $msg = "\e[1;37m".$msg."\e[0m";

        self::writeLn($msg);
    }

    /**
     * Issues a debug message to the output
     *
     * @param $msg
     * @throws \Exception
     */
    public static function debug($msg)
    {
        if (self::getConfiguredLoglevel() > self::LEVEL_DEBUG) {
            return;
        }

        $msg = self::buildMessage($msg, [
            "timestamp" => self::getTimestamp(),
            "level"     => "debug"
        ]);

        self::writeLn($msg);
    }

    /**
     * Prints one line to the output
     *
     * @param $msg
     */
    protected static function writeLn($msg)
    {
        echo $msg.PHP_EOL;
    }

    /**
     * Returns the timestamp from the
     *
     * @return false|string
     */
    protected static function getTimestamp()
    {
        try {
            $format = Config::getInstance()->get("messages", "message_timestamp_format");
        } catch (\Exception $Exception) {
            $format = "H:i:s";
        }

        return date($format);
    }

    /**
     * Builds the message in a unified way.
     * Adds timestamps, levels etc
     *
     * @param $msg
     * @param array $params
     *
     * @return string
     */
    protected static function buildMessage($msg, array $params)
    {
        $timestamp = isset($params['timestamp']) ? $params['timestamp'] : "";
        $level     = isset($params['level']) ? $params['level'] : "";

        $prfx = "";
        if (!empty($timestamp)) {
            $prfx = $timestamp;
        }

        if (!empty($level)) {
            $prfx = $prfx." | ".str_pad(strtoupper($level), 8, " ", STR_PAD_RIGHT);
        }

        return $prfx." - ".$msg;
    }

    /**
     * Returns the configured output level
     * @return int
     * @throws \Exception
     */
    protected static function getConfiguredLoglevel()
    {
        $configValue = Config::getInstance()->get("messages", "message_level");
        $configValue = trim(strtolower($configValue));

        switch ($configValue) {
            // Debug
            case self::LEVEL_DEBUG:
            case "debug":
                return self::LEVEL_DEBUG;
                break;

            // Info
            case self::LEVEL_INFO:
            case "info":
                return self::LEVEL_INFO;
                break;

            // Warning
            case self::LEVEL_WARNING:
            case "warning":
                return self::LEVEL_WARNING;
                break;

            // Error
            case self::LEVEL_ERROR:
            case "error":
                return self::LEVEL_ERROR;
                break;

            // Critical
            case self::LEVEL_CRITICAL:
            case "critical":
                return self::LEVEL_CRITICAL;
                break;

            //Default:
            default:
                return self::LEVEL_INFO;
        }
    }
}
