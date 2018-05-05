<?php

/**
 * This file contains PCSG\SteemBlockchainParser\Types\LimitOrderCreate
 */

namespace PCSG\SteemBlockchainParser\Types;

use PCSG\SteemBlockchainParser\Block;

/**
 * Class LimitOrderCreate
 * - Handle a limit order create
 *
 * @package PCSG\SteemBlockchainParser\Types
 */
class LimitOrderCreate extends AbstractType
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
        $fillOrKill = $data['fill_or_kill'];

        if (empty($fillOrKill)) {
            $fillOrKill = 0;
        }

        $this->getDatabase()->insert("sbds_tx_limit_order_creates", [
            // Meta
            "block_num"       => $Block->getBlockNumber(),
            "transaction_num" => $transNum,
            "operation_num"   => $opNum,
            "timestamp"       => $Block->getDateTime(),
            "operation_type"  => 'limit_order_create',

            // Data
            "owner"           => $data['owner'],
            "orderid"         => $data['orderid'],

            // TODO Check again for cancel value in limit_order_create
            //"cancel" => $data[''],
            "amount_to_sell"  => floatval($data['amount_to_sell']),
            "min_to_receive"  => floatval($data['min_to_receive']),
            "fill_or_kill"    => $fillOrKill,
            "expiration"      => $data['expiration']
        ]);
    }
}
