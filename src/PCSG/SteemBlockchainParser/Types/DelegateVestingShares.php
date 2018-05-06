<?php

/**
 * This file contains PCSG\SteemBlockchainParser\Types\DelegateVestingShares
 */

namespace PCSG\SteemBlockchainParser\Types;

use PCSG\SteemBlockchainParser\Block;

/**
 * Class DelegateVestingShares
 * - Handle a delegate vesting shares
 *
 * @package PCSG\SteemBlockchainParser\Types
 */
class DelegateVestingShares extends AbstractType
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
        $this->getDatabase()->insert("sbds_tx_delegate_vesting_shares", [
            // Meta
            "block_num"       => $Block->getBlockNumber(),
            "transaction_num" => $transNum,
            "operation_num"   => $opNum,
            "timestamp"       => $Block->getDateTime(),
            "operation_type"  => 'delegate_vesting_shares',

            // Data
            "delegator"       => $data['delegator'],
            "delegatee"       => $data['delegatee'],
            "vesting_shares"  => floatval($data['vesting_shares'])
        ]);
    }
}
