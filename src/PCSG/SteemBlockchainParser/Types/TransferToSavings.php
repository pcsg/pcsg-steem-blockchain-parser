<?php

/**
 * This file contains PCSG\SteemBlockchainParser\Types\TransferToSavings
 */

namespace PCSG\SteemBlockchainParser\Types;

use PCSG\SteemBlockchainParser\Block;

/**
 * Class TransferToSavings
 * - Handle a transfer to savings
 *
 * @package PCSG\SteemBlockchainParser\Types
 */
class TransferToSavings extends AbstractType
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
        $amount   = explode(" ", $data['amount'])[0];
        $currency = explode(" ", $data['amount'])[1];

        $this->getDatabase()->insert("sbds_tx_transfer_to_savings", [
            // Meta
            "block_num"       => $Block->getBlockNumber(),
            "transaction_num" => $transNum,
            "operation_num"   => $opNum,
            "timestamp"       => $Block->getDateTime(),
            "operation_type"  => 'transfer_to_savings',

            // Data
            "from"            => $data['from'],
            "to"              => $data['to'],
            "amount"          => $amount,
            "amount_symbol"   => $currency,
            "memo"            => $data['memo']
        ]);
    }
}
