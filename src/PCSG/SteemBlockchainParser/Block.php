<?php

/**
 * This file contains PCSG\SteemBlockchainParser\Block
 */

namespace PCSG\SteemBlockchainParser;

use PCSG\SteemBlockchainParser\Types\AccountCreate;
use PCSG\SteemBlockchainParser\Types\AccountCreateWithDelegation;
use PCSG\SteemBlockchainParser\Types\AccountUpdate;
use PCSG\SteemBlockchainParser\Types\AccountWitnessProxy;
use PCSG\SteemBlockchainParser\Types\AccountWitnessVote;
use PCSG\SteemBlockchainParser\Types\CancelTransferFromSavings;
use PCSG\SteemBlockchainParser\Types\ClaimRewardBalance;
use PCSG\SteemBlockchainParser\Types\Comment;
use PCSG\SteemBlockchainParser\Types\CommentOptions;
use PCSG\SteemBlockchainParser\Types\Convert;
use PCSG\SteemBlockchainParser\Types\CustomJSON;
use PCSG\SteemBlockchainParser\Types\DelegateVestingShares;
use PCSG\SteemBlockchainParser\Types\DeleteComment;
use PCSG\SteemBlockchainParser\Types\FeedPublish;
use PCSG\SteemBlockchainParser\Types\LimitOrderCancel;
use PCSG\SteemBlockchainParser\Types\LimitOrderCreate;
use PCSG\SteemBlockchainParser\Types\Pow;
use PCSG\SteemBlockchainParser\Types\Pow2;
use PCSG\SteemBlockchainParser\Types\Transfer;
use PCSG\SteemBlockchainParser\Types\TransferFromSavings;
use PCSG\SteemBlockchainParser\Types\TransferToSavings;
use PCSG\SteemBlockchainParser\Types\TransferToVesting;
use PCSG\SteemBlockchainParser\Types\Vote;
use PCSG\SteemBlockchainParser\Types\WithdrawVesting;
use PCSG\SteemBlockchainParser\Types\WithdrawVestingRoutes;
use PCSG\SteemBlockchainParser\Types\WitnessUpdate;

/**
 * Class Block
 *
 * @package PCSG\SteemBlockchainParser
 */
class Block
{
    protected $blockNumber;

    protected $blockID;
    protected $transactions;
    protected $dateTime;
    protected $previous;
    protected $witness;
    protected $witness_signature;
    protected $transaktion_merkle_root;

    /**
     * Block constructor.
     *
     * @param $blockNumber
     */
    public function __construct($blockNumber)
    {
        $this->blockNumber = $blockNumber;
    }

    // region getter

    /**
     * Return the block number
     *
     * @return mixed
     */
    public function getBlockNumber()
    {
        return $this->blockNumber;
    }

    /**
     * @return mixed
     */
    public function getDateTime()
    {
        return $this->dateTime;
    }

    // endregion

    /**
     * Parses the given array into the block object and inserts all data into the database
     *
     * @param array $blockData
     * @throws \Exception
     */
    public function parseArray(array $blockData)
    {
        $this->loadDataFromArray($blockData);
        Parser::getDatabase()->getPDO()->beginTransaction();

        // Insert the raw block data into the database
        try {
            $this->insertBlockIntoDatabase();
        } catch (\Exception $Exception) {
            switch ($Exception->getCode()) {
                case 23000:
                    if (strpos($Exception->getMessage(), "1062 Duplicate entry") !== false) {
                        Output::warning("Skipped Block ".$this->blockNumber.": Already in Database");
                        Parser::getDatabase()->getPDO()->rollBack();

                        return;
                    }
                    break;
            }

            Output::error("MySql Error -".$Exception->getMessage()."(Code: ".$Exception->getCode().")");
            Parser::getDatabase()->getPDO()->rollBack();

            return;
        }

        // Insert the blocks operations into the database
        if (is_array($this->transactions)) {
            foreach ($this->transactions as $transactionIndex => $transactionData) {
                $transactionNum = $transactionIndex + 1;
                $operations     = $transactionData['operations'];

                foreach ($operations as $operationIndex => $operationDetails) {
                    $operationNum = $operationIndex + 1;
                    $opType       = $operationDetails[0];
                    $opData       = $operationDetails[1];

                    try {
                        $this->insertOperation($transactionNum, $operationNum, $opType, $opData);
                    } catch (\Exception $Exception) {
                        Output::error("MySql Error -".$Exception->getMessage()."(Code: ".$Exception->getCode().")");
                        Parser::getDatabase()->getPDO()->rollBack();

                        return;
                    }
                }
            }
        }

        Parser::getDatabase()->getPDO()->commit();
    }

    /**
     * @throws \Exception
     */
    public function parseFromBlockChain()
    {
        Output::info("Parsing Block ".$this->blockNumber);
        $this->loadDataFromChain();

        Parser::getDatabase()->getPDO()->beginTransaction();

        try {
            $this->insertBlockIntoDatabase();
        } catch (\Exception $Exception) {
            switch ($Exception->getCode()) {
                case 23000:
                    if (strpos($Exception->getMessage(), "1062 Duplicate entry") !== false) {
                        Output::warning("Skipped Block ".$this->blockNumber.": Already in Database");
                        Parser::getDatabase()->getPDO()->rollBack();

                        return;
                    }
                    break;
            }

            Output::error("MySql Error -".$Exception->getMessage()."(Code: ".$Exception->getCode().")");
            Parser::getDatabase()->getPDO()->rollBack();

            return;
        }

        foreach ($this->transactions as $transationIndex => $transactionData) {
            $transactionNum = $transationIndex + 1;
            $operations     = $transactionData['operations'];

            foreach ($operations as $operationIndex => $operationDetails) {
                $operationNum = $operationIndex + 1;
                $opType       = $operationDetails[0];
                $opData       = $operationDetails[1];

                try {
                    $this->insertOperation($transactionNum, $operationNum, $opType, $opData);
                } catch (\Exception $Exception) {
                    Output::error("MySql Error -".$Exception->getMessage()."(Code: ".$Exception->getCode().")");
                    Parser::getDatabase()->getPDO()->rollBack();

                    return;
                }
            }
        }

        Parser::getDatabase()->getPDO()->commit();
    }

    /**
     * Return, if the block is in the database
     */
    public function isBlockInDatabase()
    {
        // TODO
    }

    /**
     * Inserts the blocks raw meta data into the database
     *
     * @throws \Exception
     */
    protected function insertBlockIntoDatabase()
    {
        Parser::getDatabase()->insert("sbds_core_blocks", [
            "raw"                     => "",
            "block_num"               => $this->blockNumber,
            "previous"                => $this->previous,
            "timestamp"               => $this->dateTime,
            "witness"                 => $this->witness,
            "witness_signature"       => $this->witness_signature,
            "transaction_merkle_root" => $this->transaktion_merkle_root
        ]);
    }

    /**
     * Inserts the given operation into the database
     *
     * @param $transNum
     * @param $opNum
     * @param $type
     * @param $data
     *
     * @throws \Exception
     */
    protected function insertOperation($transNum, $opNum, $type, $data)
    {
        try {
            $observe = Config::getInstance()->get("observe");

            if (isset($observe[$type]) && (int)$observe[$type] === 0) {
                return;
            }
        } catch (\Exception $Exception) {
            if ($Exception->getCode() !== 404) {
                Output::debug($Exception->getTraceAsString());
            }
        }

        Output::debug("  Inserting Operation b:{$this->blockNumber} t:{$transNum} o:{$opNum} of type ".$type);

        switch ($type) {
            case 'vote':
                $Type = new Vote();
                break;

            case 'comment':
                $Type = new Comment();
                break;

            case 'claim_reward_balance':
                $Type = new ClaimRewardBalance();
                break;

            case 'transfer':
                $Type = new Transfer();
                break;

            case 'custom_json':
                $Type = new CustomJSON();
                break;

            case 'comment_options':
                $Type = new CommentOptions();
                break;

            case 'account_update':
                $Type = new AccountUpdate();
                break;

            case 'delete_comment':
                $Type = new DeleteComment();
                break;

            case 'transfer_to_vesting':
                $Type = new TransferToVesting();
                break;

            case 'limit_order_create':
                $Type = new LimitOrderCreate();
                break;

            case 'delegate_vesting_shares':
                $Type = new DelegateVestingShares();
                break;

            case 'limit_order_cancel':
                $Type = new LimitOrderCancel();
                break;

            case 'feed_publish':
                $Type = new FeedPublish();
                break;

            case 'account_create_with_delegation':
                $Type = new AccountCreateWithDelegation();
                break;

            case 'account_witness_vote':
                $Type = new AccountWitnessVote();
                break;

            case 'convert':
                $Type = new Convert();
                break;

            case 'pow':
                $Type = new Pow();
                break;

            case 'pow2':
                $Type = new Pow2();
                break;

            case 'account_create':
                $Type = new AccountCreate();
                break;

            case 'witness_update':
                $Type = new WitnessUpdate();
                break;

            case 'set_withdraw_vesting_route':
                $Type = new WithdrawVestingRoutes();
                break;

            case 'transfer_to_savings':
                $Type = new TransferToSavings();
                break;

            case 'cancel_transfer_from_savings':
                $Type = new CancelTransferFromSavings();
                break;

            case 'withdraw_vesting':
                $Type = new WithdrawVesting();
                break;

            case 'transfer_from_savings':
                $Type = new TransferFromSavings();
                break;

            case 'account_witness_proxy':
                $Type = new AccountWitnessProxy();
                break;

            default:
                file_put_contents(
                    dirname(dirname(dirname(dirname(__FILE__))))."/missingOperations.txt",
                    $type.PHP_EOL,
                    FILE_APPEND
                );

                Output::warning("    -> Unknown operation type '".$type."' in b:{$this->blockNumber} t:{$transNum} o:{$opNum}");

                return;
        }

        $Type->process($this, $transNum, $opNum, $data);
    }

    /**
     * Loads the data from the blockchain into the object
     *
     * @throws \Exception
     */
    protected function loadDataFromChain()
    {
        $RPCClient = new RPCClient();
        $blockData = $RPCClient->execute("get_block", [$this->blockNumber]);

        $this->blockID                 = $blockData['block_id'];
        $this->dateTime                = $blockData['timestamp'];
        $this->transactions            = $blockData['transactions'];
        $this->previous                = $blockData['previous'];
        $this->witness                 = $blockData['witness'];
        $this->witness_signature       = $blockData['witness_signature'];
        $this->transaktion_merkle_root = $blockData['transaction_merkle_root'];
    }

    /**
     * Loads the data from the given array into the object.
     * This can be used for mass imports, when you want to run paralell guzzle requests to enter a lot of blocks simultanously
     *
     * @param array $blockData
     */
    protected function loadDataFromArray(array $blockData)
    {
        $this->blockID                 = $blockData['block_id'];
        $this->dateTime                = $blockData['timestamp'];
        $this->transactions            = $blockData['transactions'];
        $this->previous                = $blockData['previous'];
        $this->witness                 = $blockData['witness'];
        $this->witness_signature       = $blockData['witness_signature'];
        $this->transaktion_merkle_root = $blockData['transaction_merkle_root'];
    }

    /**
     * Validates the block data.
     * Throws an exception if the validation fails
     *
     * @param array $blockData
     *
     *
     * @return true - Returns true on success.
     * @throws \Exception
     */
    protected function validateBlockData(array $blockData)
    {
        if (!is_array($blockData)) {
            throw new \Exception("The Blockdata has the wrong format. Expected: array  Received ".gettype($blockData));
        }

        if (!isset($blockData['block_id'])) {
            throw new \Exception("Missing key in block data: 'block_id'");
        }

        if (!isset($blockData['timestamp'])) {
            throw new \Exception("Missing key in block data: 'block_id'");
        }

        if (!isset($blockData['transactions'])) {
            throw new \Exception("Missing key in block data: 'block_id'");
        }

        if (!is_array($blockData['transactions'])) {
            throw new \Exception("The Transactions have the wrong format. Expected: array  Received ".gettype($blockData['transactions']));
        }

        if (!isset($blockData['previous'])) {
            throw new \Exception("Missing key in block data: 'block_id'");
        }

        if (!isset($blockData['witness'])) {
            throw new \Exception("Missing key in block data: 'block_id'");
        }

        if (!isset($blockData['witness_signature'])) {
            throw new \Exception("Missing key in block data: 'block_id'");
        }

        if (!isset($blockData['transaction_merkle_root'])) {
            throw new \Exception("Missing key in block data: 'block_id'");
        }

        return true;
    }
}
