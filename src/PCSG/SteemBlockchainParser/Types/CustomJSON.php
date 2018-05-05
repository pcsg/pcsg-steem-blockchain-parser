<?php

/**
 * This file contains PCSG\SteemBlockchainParser\Types\CustomJSON
 */

namespace PCSG\SteemBlockchainParser\Types;

use PCSG\SteemBlockchainParser\Block;

/**
 * Class CustomJSON
 * - Handle a custom json
 *
 * @package PCSG\SteemBlockchainParser\Types
 */
class CustomJSON extends AbstractType
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
        $this->getDatabase()->insert("sbds_tx_custom_jsons", [
            // Meta
            "block_num"              => $Block->getBlockNumber(),
            "transaction_num"        => $transNum,
            "operation_num"          => $opNum,
            "timestamp"              => $Block->getDateTime(),
            "operation_type"         => "custom_json",

            // Data
            "tid"                    => $data['id'],
            "required_auths"         => json_encode($data['required_auths']),
            "required_posting_auths" => json_encode($data['required_posting_auths']),
            "json"                   => $data['json']
        ]);
    }
}
