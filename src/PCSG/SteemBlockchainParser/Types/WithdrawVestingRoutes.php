<?php

/**
 * This file contains PCSG\SteemBlockchainParser\Types\WithdrawVestingRoutes
 */

namespace PCSG\SteemBlockchainParser\Types;

use PCSG\SteemBlockchainParser\Block;

/**
 * Class WithdrawVestingRoutes
 * - Handle a withdraw vesting routes
 *
 * @package PCSG\SteemBlockchainParser\Types
 */
class WithdrawVestingRoutes extends AbstractType
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
        $autoVest = $data['auto_vest'];

        if (empty($autoVest)) {
            $autoVest = 0;
        }

        $this->getDatabase()->insert("sbds_tx_withdraw_vesting_routes", [
            // Meta
            "block_num"       => $Block->getBlockNumber(),
            "transaction_num" => $transNum,
            "operation_num"   => $opNum,
            "timestamp"       => $Block->getDateTime(),
            "operation_type"  => 'set_withdraw_vesting_route',

            // Data
            "from_account"    => $data['from_account'],
            "to_account"      => $data['to_account'],
            "percent"         => $data['percent'],
            "auto_vest"       => $autoVest
        ]);
    }
}
