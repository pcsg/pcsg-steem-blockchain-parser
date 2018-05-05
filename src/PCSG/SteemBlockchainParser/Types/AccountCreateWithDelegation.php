<?php

/**
 * This file contains PCSG\SteemBlockchainParser\Types\AccountCreateWithDelegation
 */

namespace PCSG\SteemBlockchainParser\Types;

use PCSG\SteemBlockchainParser\Block;

/**
 * Class AccountCreateWithDelegation
 * - Handle account creation with delegation
 *
 * @package PCSG\SteemBlockchainParser\Types
 */
class AccountCreateWithDelegation extends AbstractType
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
        $this->getDatabase()->insert("sbds_tx_account_create_with_delegations", [
            // Meta
            "block_num"        => $Block->getBlockNumber(),
            "transaction_num"  => $transNum,
            "operation_num"    => $opNum,
            "timestamp"        => $Block->getDateTime(),
            "operation_type"   => 'account_create_with_delegation',

            // Data
            "fee"              => $data['fee'],
            "delegation"       => $data['delegation'],
            "creator"          => $data['creator'],
            "new_account_name" => $data['new_account_name'],
            "owner_key"        => $data['owner']['key_auths'][0][0],
            "active_key"       => $data['active']['key_auths'][0][0],
            "posting_key"      => $data['posting']['key_auths'][0][0],
            "memo_key"         => $data['memo_key'],
            "json_metadata"    => $data['json_metadata']
        ]);
    }
}
