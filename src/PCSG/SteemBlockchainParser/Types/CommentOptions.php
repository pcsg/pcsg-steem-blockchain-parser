<?php

/**
 * This file contains PCSG\SteemBlockchainParser\Types\CommentOptions
 */

namespace PCSG\SteemBlockchainParser\Types;

use PCSG\SteemBlockchainParser\Block;

/**
 * Class CommentOptions
 * - Handle comment options
 *
 * @package PCSG\SteemBlockchainParser\Types
 */
class CommentOptions extends AbstractType
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
        // TODO check extension key from blockchain - Currently unhandled
        $this->getDatabase()->insert("sbds_tx_comments_options", [
            // Meta
            "block_num"              => $Block->getBlockNumber(),
            "transaction_num"        => $transNum,
            "operation_num"          => $opNum,
            "timestamp"              => $Block->getDateTime(),
            "operation_type"         => 'comment_options',

            // Data
            "author"                 => $data['author'],
            "permlink"               => $data['permlink'],
            "max_accepted_payout"    => $data['max_accepted_payout'],
            "percent_steem_dollars"  => $data['percent_steem_dollars'],
            "allow_votes"            => $data['allow_votes'],
            "allow_curation_rewards" => $data['allow_curation_rewards']
        ]);
    }
}
