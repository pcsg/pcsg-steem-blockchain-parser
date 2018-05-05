<?php

/**
 * This file contains PCSG\SteemBlockchainParser\Types\Pow2
 */

namespace PCSG\SteemBlockchainParser\Types;

use PCSG\SteemBlockchainParser\Block;

/**
 * Class Pow2
 * - Handle a pow2
 *
 * @package PCSG\SteemBlockchainParser\Types
 */
class Pow2 extends AbstractType
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
        $this->getDatabase()->insert("sbds_tx_pow2s", [
            // Meta
            "block_num"       => $Block->getBlockNumber(),
            "transaction_num" => $transNum,
            "operation_num"   => $opNum,
            "timestamp"       => $Block->getDateTime(),
            "operation_type"  => 'pow2',

            // Data
            "worker_account"  => $data['work'][1]['input']['worker_account'],
            "block_id"        => $data['work'][1]['input']['nonce']
        ]);
    }
}
