<?php

/**
 * This file contains PCSG\SteemBlockchainParser\Types\CancelTransferFromSavings
 */

namespace PCSG\SteemBlockchainParser\Types;

use PCSG\SteemBlockchainParser\Block;

/**
 * Class CancelTransferFromSavings
 * - Handle a transfer to savings
 *
 * @package PCSG\SteemBlockchainParser\Types
 */
class CancelTransferFromSavings extends AbstractType
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
        $this->getDatabase()->insert("sbds_tx_cancel_transfer_from_savings", [
            // Meta
            "block_num"       => $Block->getBlockNumber(),
            "transaction_num" => $transNum,
            "operation_num"   => $opNum,
            "timestamp"       => $Block->getDateTime(),
            "operation_type"  => 'cancel_transfer_from_savings',

            // Data
            "from"            => $data['from'],
            "request_id"      => $data['request_id']
        ]);
    }
}
