<?php

/**
 * This file contains PCSG\SteemBlockchainParser\Types\Transfer
 */

namespace PCSG\SteemBlockchainParser\Types;

use PCSG\SteemBlockchainParser\Block;

/**
 * Class Transfer
 * - Handle a transfer
 *
 * @package PCSG\SteemBlockchainParser\Types
 */
class Transfer extends AbstractType
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
        // Split currency and amount
        $amount   = explode(" ", $data['amount'])[0];
        $currency = explode(" ", $data['amount'])[1];

        $this->getDatabase()->insert("sbds_tx_transfers", [
            // Meta
            "block_num"       => $Block->getBlockNumber(),
            "transaction_num" => $transNum,
            "operation_num"   => $opNum,
            "timestamp"       => $Block->getDateTime(),
            "operation_type"  => "transfer",

            // Data
            "from"            => $data['from'],
            "to"              => $data['to'],
            "amount"          => $amount,
            "amount_symbol"   => $currency,
            "memo"            => $data['memo']
        ]);
    }
}
