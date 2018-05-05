<?php

require_once dirname(__FILE__)."/vendor/autoload.php";

try {
    $Parser = new \PCSG\SteemBlockchainParser\Parser();
    $Config = PCSG\SteemBlockchainParser\Config::getInstance();
} catch (\Exception $Exception) {
    echo $Exception->getMessage();
    echo PHP_EOL;
    exit;
}

// db test
try {
    $Parser->getDatabase();
} catch (\Exception $Exception) {
    echo $Exception->getMessage();
    echo PHP_EOL;
    exit;
}


$lastBlock = $Parser->getLatestBlockFromDatabase();

if ($lastBlock === 0) {
    try {
        $lastBlock = $Config->get('block', 'start');
    } catch (\Exception $Exception) {
    }
}

$Parser->parseBlockRangeAsync(
    $lastBlock + 1,
    false,
    \PCSG\SteemBlockchainParser\Config::getInstance()->get("requests", "concurrent_requests")
);
