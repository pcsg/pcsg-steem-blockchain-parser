<?php

/**
 * This file contains PCSG\SteemBlockchainParser\Types\Convert
 */

namespace PCSG\SteemBlockchainParser\Types;

use PCSG\SteemBlockchainParser\Block;

/**
 * Class Convert
 * - Handle a convert
 *
 * @package PCSG\SteemBlockchainParser\Types
 */
class Convert extends AbstractType
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
        $this->getDatabase()->insert("sbds_tx_converts", [
            // Meta
            "block_num"       => $Block->getBlockNumber(),
            "transaction_num" => $transNum,
            "operation_num"   => $opNum,
            "timestamp"       => $Block->getDateTime(),
            "operation_type"  => 'convert',

            // Data
            "owner"           => $data['owner'],
            "requestid"       => $data['requestid'],
            "amount"          => $data['amount']
        ]);
    }
}
