<?php

/**
 * This file contains PCSG\SteemBlockchainParser\Types\WitnessUpdate
 */

namespace PCSG\SteemBlockchainParser\Types;

use PCSG\SteemBlockchainParser\Block;

/**
 * Class WitnessUpdate
 * - Handle a witness update
 *
 * @package PCSG\SteemBlockchainParser\Types
 */
class WitnessUpdate extends AbstractType
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
        $this->getDatabase()->insert("sbds_tx_witness_updates", [
            // Meta
            "block_num"                  => $Block->getBlockNumber(),
            "transaction_num"            => $transNum,
            "operation_num"              => $opNum,
            "timestamp"                  => $Block->getDateTime(),
            "operation_type"             => 'witness_update',

            // Data
            "owner"                      => $data['owner'],
            "url"                        => $data['url'],
            "block_signing_key"          => $data['block_signing_key'],
            "props_account_creation_fee" => $data['props']['account_creation_fee'],
            "props_maximum_block_size"   => $data['props']['maximum_block_size'],
            "props_sbd_interest_rate"    => $data['props']['sbd_interest_rate'],
            "fee"                        => $data['fee']
        ]);
    }
}
