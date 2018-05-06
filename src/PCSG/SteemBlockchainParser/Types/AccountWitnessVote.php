<?php

/**
 * This file contains PCSG\SteemBlockchainParser\Types\AccountWitnessVote
 */

namespace PCSG\SteemBlockchainParser\Types;

use PCSG\SteemBlockchainParser\Block;

/**
 * Class AccountWitnessVote
 * - Handle an account witness vote
 *
 * @package PCSG\SteemBlockchainParser\Types
 */
class AccountWitnessVote extends AbstractType
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
        $this->getDatabase()->insert("sbds_tx_account_witness_votes", [
            // Meta
            "block_num"       => $Block->getBlockNumber(),
            "transaction_num" => $transNum,
            "operation_num"   => $opNum,
            "timestamp"       => $Block->getDateTime(),
            "operation_type"  => 'account_witness_vote',

            // Data
            "account"         => $data['account'],
            "witness"         => $data['witness'],
            "approve"         => $data['approve']
        ]);
    }
}
