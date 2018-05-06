<?php

/**
 * This file contains PCSG\SteemBlockchainParser\Types\DeleteComment
 */

namespace PCSG\SteemBlockchainParser\Types;

use PCSG\SteemBlockchainParser\Block;

/**
 * Class DeleteComment
 * - Handle a delete comment
 *
 * @package PCSG\SteemBlockchainParser\Types
 */
class DeleteComment extends AbstractType
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
        $this->getDatabase()->insert("sbds_tx_delete_comments", [
            // Meta
            "block_num"       => $Block->getBlockNumber(),
            "transaction_num" => $transNum,
            "operation_num"   => $opNum,
            "timestamp"       => $Block->getDateTime(),
            "operation_type"  => 'delete_comment',

            // Data
            "author"          => $data['author'],
            "permlink"        => $data['permlink']
        ]);
    }
}
