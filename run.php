<?php

require_once dirname(__FILE__)."/vendor/autoload.php";

$Parser = new \PCSG\SteemBlockchainParser\Parser();

$lastBlock = $Parser->getLatestBlockFromDatabase();

$Parser->parseBlockRangeAsync(
    $lastBlock + 1,
    false,
    \PCSG\SteemBlockchainParser\Config::getInstance()->get("requests", "concurrent_requests")
);
