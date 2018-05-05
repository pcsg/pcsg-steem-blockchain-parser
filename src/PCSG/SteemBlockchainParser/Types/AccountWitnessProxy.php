<?php

/**
 * This file contains PCSG\SteemBlockchainParser\Types\AccountWitnessProxy
 */

namespace PCSG\SteemBlockchainParser\Types;

use PCSG\SteemBlockchainParser\Block;

/**
 * Class Vote
 * - Handle a account witness proxy
 *
 * @package PCSG\SteemBlockchainParser\Types
 */
class AccountWitnessProxy extends AbstractType
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
        $this->getDatabase()->insert("sbds_tx_account_witness_proxies", [
            // Meta
            "block_num"       => $Block->getBlockNumber(),
            "transaction_num" => $transNum,
            "operation_num"   => $opNum,
            "timestamp"       => $Block->getDateTime(),
            "operation_type"  => 'account_witness_proxy',

            // Data
            "account"         => $data['account'],
            "Proxy"           => $data['proxy']
        ]);
    }
}
