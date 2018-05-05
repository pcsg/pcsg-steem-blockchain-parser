<?php

namespace PCSG\SteemBlockchainParser;

use GuzzleHttp\Psr7\Response;
use JsonRPC\Client;

/**
 * Class Parser
 *
 * @package PCSG\SteemBlockchainParser
 */
class Parser
{
    protected $RPCClient;
    protected $RPCClients = [];

    /** @var Database */
    protected static $Database = null;

    /**
     * Parser constructor.
     *
     * @throws \Exception
     */
    public function __construct()
    {
        $this->RPCClient = new RPCClient();

        $rpcUrls = Config::getInstance()->get("steem", "rpcurls");

        foreach ($rpcUrls as $url) {
            $this->RPCClients[] = \Graze\GuzzleHttp\JsonRpc\Client::factory($url);
        }

        // TODO Test DB connectivity
    }

    /**
     * @param $blockID
     * @throws \Exception
     */
    public function parseSingleBlock($blockID)
    {
        $Block = new Block($blockID);
        $Block->parseFromBlockChain();
    }

    /**
     * @param $startBlock
     * @param $endBlock
     */
    public function parseBlockRange($startBlock, $endBlock)
    {
    }

    /**
     * Parses a ranger of blocks asynchronously
     *
     * @param $startBlockNumber - The blocknumber which should be parsed first
     * @param $endBlockNumber - The last block number that should be parsed. If set to false, the end of the blockchain will be used
     * @param $concurrentRequestNumber - The amount of concurrent requests that should be sent
     *
     * @throws \Exception
     */
    public function parseBlockRangeAsync($startBlockNumber, $endBlockNumber = false, $concurrentRequestNumber = 4)
    {
        $endOfBlockchain = false;

        while ($endBlockNumber == false || $startBlockNumber < $endBlockNumber) {
            // Select a random node to query data from
            $GuzzleRPC = $this->selectRandomClient();

            if ($endBlockNumber !== false) {
                $concurrentRequestNumber = min($endBlockNumber - $startBlockNumber, $concurrentRequestNumber);
            }

            Output::info("Requesting Blocks ".$startBlockNumber." - ".($startBlockNumber + $concurrentRequestNumber));
            $Requests = [];

            for ($i = 0; $i < $concurrentRequestNumber; $i++) {
                $Requests[] = $GuzzleRPC->request($startBlockNumber, "get_block", [$startBlockNumber]);
                $startBlockNumber++;
            }

            $Responses = $GuzzleRPC->sendAllAsync($Requests)->wait(true);

            /** @var Response $Response */
            foreach ($Responses as $Response) {
                $json = $Response->getBody()->getContents();
                $data = json_decode($json, true);

                $id        = $data['id'];
                $blockData = $data['result'];


                if (empty($blockData)) {
                    $endOfBlockchain = $id;
                    break;
                }

                $Block = new Block($id);
                $Block->parseArray($blockData);
            }

            if ($endOfBlockchain !== false) {
                Output::info("Reached end of Blockchain at Blocknumber: ".$endOfBlockchain);

                return;
            }
        }
    }

    /**
     * Returns the last block from the database
     *
     * @return int
     */
    public function getLatestBlockFromDatabase()
    {
        try {
            $result = self::getDatabase()->fetch([
                "from"  => "sbds_core_blocks",
                "limit" => 1,
                "order" => [
                    "block_num" => "desc"
                ]
            ]);
        } catch (\Exception $Exception) {
            return 0;
        }

        if (empty($result)) {
            return 0;
        }

        if (!isset($result[0]['block_num'])) {
            return 0;
        }

        return (int)$result[0]['block_num'];
    }

    /**
     * Returns the database handler
     *
     * @return Database
     * @throws \Exception
     */
    public static function getDatabase()
    {
        if (is_null(self::$Database)) {
            self::$Database = new Database();
        }

        return self::$Database;
    }

    /**
     * Selects a random RPC Client.
     * Each client will request data from a different RPC Steemit Node
     *
     * @return \Graze\GuzzleHttp\JsonRpc\Client
     */
    protected function selectRandomClient()
    {
        $index = rand(0, count($this->RPCClients) - 1);

        return $this->RPCClients[$index];
    }
}
