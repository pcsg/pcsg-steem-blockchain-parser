<?php

/**
 * This file contains PCSG\SteemBlockchainParser\Types\Vote
 */

namespace PCSG\SteemBlockchainParser\Types;

use PCSG\SteemBlockchainParser\Block;

/**
 * Class Vote
 * - Handle a vote
 *
 * @package PCSG\SteemBlockchainParser\Types
 */
class Vote extends AbstractType
{
    /**
     * Process the data
     *
     * @param Block $Block
     * @param string $transNum
     * @param string $opNum
     * @param $data
     *
     * @return mixed|void
     *
     * @throws \Exception
     */
    public function process(Block $Block, $transNum, $opNum, $data)
    {
        $this->getDatabase()->insert("sbds_tx_votes", [
            // Meta
            "block_num"       => $Block->getBlockNumber(),
            "transaction_num" => $transNum,
            "operation_num"   => $opNum,
            "operation_type"  => "vote",

            // Data
            "timestamp"       => $Block->getDateTime(),
            "voter"           => $data['voter'],
            "author"          => $data['author'],
            "permlink"        => $data['permlink'],
            "weight"          => $data['weight']
        ]);
    }
}
