<?php

/**
 * This file contains PCSG\SteemBlockchainParser\Types\ClaimRewardBalance
 */

namespace PCSG\SteemBlockchainParser\Types;

use PCSG\SteemBlockchainParser\Block;

/**
 * Class ClaimRewardBalance
 * - Handle a claim_reward_balances
 *
 * @package PCSG\SteemBlockchainParser\Types
 */
class ClaimRewardBalance extends AbstractType
{
    /**
     * Process the data
     *
     * @param Block $Block
     * @param string $transNum
     * @param string $opNum
     * @param $data
     * @return mixed|void
     * @throws \Exception
     */
    public function process(Block $Block, $transNum, $opNum, $data)
    {
        $this->getDatabase()->insert("sbds_tx_claim_reward_balances", [
            // Meta
            "block_num"       => $Block->getBlockNumber(),
            "transaction_num" => $transNum,
            "operation_num"   => $opNum,
            "timestamp"       => $Block->getDateTime(),
            "operation_type"  => 'claim_reward_balance',

            // Data
            "account"         => $data['account'],
            "reward_steem"    => str_replace(" STEEM", "", $data['reward_steem']),
            "reward_sbd"      => str_replace(" SBD", "", $data['reward_sbd']),
            "reward_vests"    => str_replace(" VESTS", "", $data['reward_vests']),
        ]);
    }
}
