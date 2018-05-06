<?php

/**
 * This file contains PCSG\SteemBlockchainParser\Types\FeedPublish
 */

namespace PCSG\SteemBlockchainParser\Types;

use PCSG\SteemBlockchainParser\Block;

/**
 * Class FeedPublish
 * - Handle feet publish
 *
 * @package PCSG\SteemBlockchainParser\Types
 */
class FeedPublish extends AbstractType
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
        $this->getDatabase()->insert("sbds_tx_feed_publishes", [
            // Meta
            "block_num"           => $Block->getBlockNumber(),
            "transaction_num"     => $transNum,
            "operation_num"       => $opNum,
            "timestamp"           => $Block->getDateTime(),
            "operation_type"      => 'feed_publish',

            // Data
            "publisher"           => $data['publisher'],
            "exchange_rate_base"  => $data['exchange_rate']['base'],
            "exchange_rate_quote" => $data['exchange_rate']['quote']
        ]);
    }
}
