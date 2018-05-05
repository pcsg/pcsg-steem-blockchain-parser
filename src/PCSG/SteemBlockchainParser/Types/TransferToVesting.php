<?php

/**
 * This file contains PCSG\SteemBlockchainParser\Types\TransferToVesting
 */

namespace PCSG\SteemBlockchainParser\Types;

use PCSG\SteemBlockchainParser\Block;

/**
 * Class TransferToVesting
 * - Handle transfer to vesting
 *
 * @package PCSG\SteemBlockchainParser\Types
 */
class TransferToVesting extends AbstractType
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

        $this->getDatabase()->insert("sbds_tx_transfer_to_vestings", [
            // Meta
            "block_num"       => $Block->getBlockNumber(),
            "transaction_num" => $transNum,
            "operation_num"   => $opNum,
            "timestamp"       => $Block->getDateTime(),
            "operation_type"  => 'transfer_to_vesting',

            // Data
            "from"            => $data['from'],
            "to"              => $data['to'],
            "amount"          => $amount,
            "amount_symbol"   => $currency
        ]);
    }
}
