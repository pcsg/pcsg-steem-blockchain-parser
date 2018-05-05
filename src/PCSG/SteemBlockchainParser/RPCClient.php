<?php

namespace PCSG\SteemBlockchainParser;

use JsonRPC\Client;

/**
 * Class RPCClient
 *
 * @package PCSG\SteemBlockchainParser
 */
class RPCClient
{
    /** @var Client */
    protected $Client;

    /**
     * RPCClient constructor.
     *
     * @throws \Exception
     */
    public function __construct()
    {
        $rpcURL       = Config::getInstance()->get("steem", "blockchainurl");
        $this->Client = new Client($rpcURL);
    }

    /**
     * Executes the given function via RPC
     * @param $function
     * @param $parameter
     *
     * @return mixed
     */
    public function execute($function, $parameter)
    {
        $result = $this->Client->execute($function, $parameter);

        return $result;
    }
}
