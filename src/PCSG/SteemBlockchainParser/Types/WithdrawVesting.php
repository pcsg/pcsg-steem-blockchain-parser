<?php

/**
 * This file contains PCSG\SteemBlockchainParser\Types\WithdrawVesting
 */

namespace PCSG\SteemBlockchainParser\Types;

use PCSG\SteemBlockchainParser\Block;

/**
 * Class WithdrawVesting
 * - Handle a withdraw vesting
 *
 * @package PCSG\SteemBlockchainParser\Types
 */
class WithdrawVesting extends AbstractType
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
        $this->getDatabase()->insert("sbds_tx_withdraw_vestings", [
            // Meta
            "block_num"       => $Block->getBlockNumber(),
            "transaction_num" => $transNum,
            "operation_num"   => $opNum,
            "timestamp"       => $Block->getDateTime(),
            "operation_type"  => 'withdraw_vesting',

            // Data
            "account"         => $data['account'],
            "vesting_shares"  => floatval($data['vesting_shares'])
        ]);
    }
}
