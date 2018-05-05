<?php

/**
 * This file contains PCSG\SteemBlockchainParser\Types\Comment
 */

namespace PCSG\SteemBlockchainParser\Types;

use PCSG\SteemBlockchainParser\Block;

/**
 * Class Comment
 * - Handle a comment
 *
 * @package PCSG\SteemBlockchainParser\Types
 */
class Comment extends AbstractType
{
    /**
     * Process the data
     *
     * @param Block $Block
     * @param string $transNum
     * @param string $opNum
     * @param $data
     * @return mixed|void
     * @throws \Exception
     */
    public function process(Block $Block, $transNum, $opNum, $data)
    {
        $this->getDatabase()->insert("sbds_tx_comments", [
            // Meta
            "block_num"       => $Block->getBlockNumber(),
            "transaction_num" => $transNum,
            "operation_num"   => $opNum,
            "operation_type"  => "comment",

            // Data
            "timestamp"       => $Block->getDateTime(),
            "author"          => $data['author'],
            "permlink"        => $data['permlink'],
            "parent_author"   => $data['parent_author'],
            "parent_permlink" => $data['parent_permlink'],
            "title"           => $data['title'],
            "body"            => $data['body'],
            "json_metadata"   => $data['json_metadata']
        ]);
    }
}
