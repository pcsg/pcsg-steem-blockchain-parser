<?php

/**
 * This file contains PCSG\SteemBlockchainParser\Types\LimitOrderCancel
 */

namespace PCSG\SteemBlockchainParser\Types;

use PCSG\SteemBlockchainParser\Block;

/**
 * Class LimitOrderCancel
 * - Handle a limit order cancel
 *
 * @package PCSG\SteemBlockchainParser\Types
 */
class LimitOrderCancel extends AbstractType
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
        $this->getDatabase()->insert("sbds_tx_limit_order_cancels", [
            // Meta
            "block_num"       => $Block->getBlockNumber(),
            "transaction_num" => $transNum,
            "operation_num"   => $opNum,
            "timestamp"       => $Block->getDateTime(),
            "operation_type"  => 'limit_order_cancel',

            // Data
            "owner"           => $data['owner'],
            "orderid"         => $data['orderid']
        ]);
    }
}
