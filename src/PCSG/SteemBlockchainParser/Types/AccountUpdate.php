<?php

/**
 * This file contains PCSG\SteemBlockchainParser\Types\AccountUpdate
 */

namespace PCSG\SteemBlockchainParser\Types;

use PCSG\SteemBlockchainParser\Block;

/**
 * Class AccountUpdate
 * - Handle an account update
 *
 * @package PCSG\SteemBlockchainParser\Types
 */
class AccountUpdate extends AbstractType
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
        $this->getDatabase()->insert("sbds_tx_account_updates", [
            // Meta
            "block_num"       => $Block->getBlockNumber(),
            "transaction_num" => $transNum,
            "operation_num"   => $opNum,
            "timestamp"       => $Block->getDateTime(),
            "operation_type"  => 'account_update',

            // Data
            "account"         => $data['account'],
            "memo_key"        => $data['memo_key'],
            "json_metadata"   => $data['json_metadata']
        ]);
    }
}
