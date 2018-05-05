<?php

/**
 * This file contains PCSG\SteemBlockchainParser\Types\Pow
 */

namespace PCSG\SteemBlockchainParser\Types;

use PCSG\SteemBlockchainParser\Block;

/**
 * Class Pow
 * - Handle a pow
 *
 * @package PCSG\SteemBlockchainParser\Types
 */
class Pow extends AbstractType
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
        $this->getDatabase()->insert("sbds_tx_pows", [
            // Meta
            "block_num"       => $Block->getBlockNumber(),
            "transaction_num" => $transNum,
            "operation_num"   => $opNum,
            "timestamp"       => $Block->getDateTime(),
            "operation_type"  => 'pow',

            // Data
            "worker_account"  => $data['worker_account'],
            "block_id"        => $data['block_id']
        ]);
    }
}
