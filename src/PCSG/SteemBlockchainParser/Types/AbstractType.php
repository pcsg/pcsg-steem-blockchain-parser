<?php

/**
 * This file contains PCSG\SteemBlockchainParser\Types\AbstractType
 */

namespace PCSG\SteemBlockchainParser\Types;

use PCSG\SteemBlockchainParser\Block;
use PCSG\SteemBlockchainParser\Parser;

/**
 * Class AbstractType
 * - Parent
 *
 * @package PCSG\SteemBlockchainParser\Types
 */
abstract class AbstractType
{
    /**
     * @var
     */
    protected $Block;

    /**
     * Process the data
     *
     * @param Block $Block
     * @param string $transNum
     * @param string $opNum
     * @param $data
     * @return mixed
     */
    abstract function process(Block $Block, $transNum, $opNum, $data);

    /**
     * Return the main database object
     *
     * @return \PCSG\SteemBlockchainParser\Database
     * @throws \Exception
     */
    protected function getDatabase()
    {
        return Parser::getDatabase();
    }
}
