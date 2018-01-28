<?php

namespace PCSG\SBPP;

use QUITest\QUI\Utils\Text\QUIUtilsTextWordTest;

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

    public function __construct($blockNumber)
    {
        $this->blockNumber = $blockNumber;
    }

    public function parse()
    {
        Output::info("Parsing Block ".$this->blockNumber);
        $this->loadDataFromChain();

        Parser::getDatabase()->getPDO()->beginTransaction();

        try {
            $this->insertBlockIntoDatabase();
        } catch (\Exception $Exception) {
            Output::error("MySql Error -".$Exception->getMessage()."(Code: ".$Exception->getCode().")");
            Parser::getDatabase()->getPDO()->rollBack();

            return;
        }

        foreach ($this->transactions as $transationIndex => $transactionData) {
            $transactionNum = $transationIndex + 1;
            $operations = $transactionData['operations'];
            foreach ($operations as $operationIndex => $operationDetails) {
                $operationNum = $operationIndex + 1;
                $opType = $operationDetails[0];
                $opData = $operationDetails[1];

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

    public function isBlockInDatabase()
    {
        // TODO
    }

    /**
     * Inserts the blocks raw meta data into the databse
     */
    protected function insertBlockIntoDatabase()
    {
        Parser::getDatabase()->insert(
            "sbds_core_blocks",
            array(
                "raw" => "",
                "block_num" => $this->blockNumber,
                "previous" => $this->previous,
                "timestamp" => $this->dateTime,
                "witness" => $this->witness,
                "witness_signature" => $this->witness_signature,
                "transaction_merkle_root" => $this->transaktion_merkle_root
            )
        );
    }

    /**
     * Inserts the given operation into the database
     * @param $transNum
     * @param $opNum
     * @param $type
     * @param $data
     */
    protected function insertOperation($transNum, $opNum, $type, $data)
    {
        Output::debug("  Inserting Operation b:{$this->blockNumber} t:{$transNum} o:{$opNum} of type ".$type);

        switch ($type) {
            case 'vote':
                $this->insertVote($transNum, $opNum, $data);
                break;
            case 'comment':
                $this->insertComment($transNum, $opNum, $data);
                break;
            case 'claim_reward_balance':
                $this->insertClaimRewardBalanace($transNum, $opNum, $data);
                break;
            case 'transfer':
                $this->insertTransfer($transNum, $opNum, $data);
                break;
            case 'custom_json':
                $this->insertCustomJson($transNum, $opNum, $data);
                break;
            case 'comment_options':
                $this->insertCommentOptions($transNum, $opNum, $data);
                break;
            case 'account_update':
                $this->insertAccountUpdate($transNum, $opNum, $data);
                break;
            case 'delete_comment':
                $this->insertDeleteComment($transNum, $opNum, $data);
                break;
            case 'transfer_to_vesting':
                $this->insertTransferToVesting($transNum, $opNum, $data);
                break;
            case 'limit_order_create':
                $this->insertLimitOrderCreate($transNum, $opNum, $data);
                break;
            case 'delegate_vesting_shares':
                $this->insertDelegateVestingShares($transNum, $opNum, $data);
                break;
            case 'limit_order_cancel':
                $this->insertLimitOrderCancel($transNum, $opNum, $data);
                break;
            case 'feed_publish':
                $this->insertFeedPublish($transNum, $opNum, $data);
                break;
            case 'account_create_with_delegation':
                $this->insertAccountCreateWithDelegation($transNum, $opNum, $data);
                break;
            case 'account_witness_vote':
                $this->insertAccountWitnessVote($transNum, $opNum, $data);
                break;
            case 'convert':
                $this->insertConvert($transNum, $opNum, $data);
                break;
            case 'pow':
                $this->insertPow($transNum, $opNum, $data);
                break;
            case 'account_create':
                $this->insertAccountCreate($transNum, $opNum, $data);
                break;
            case 'witness_update':
                $this->insertWitnessUpdate($transNum, $opNum, $data);
                break;
            case 'set_withdraw_vesting_route':
                $this->insertWithdrawVestingRoutes($transNum, $opNum, $data);
                break;
            case 'transfer_to_savings':
                $this->insertTransferToSavings($transNum, $opNum, $data);
                break;
            case 'cancel_transfer_from_savings':
                $this->insertCancelTransferFromSavings($transNum, $opNum, $data);
                break;
            case 'withdraw_vesting':
                $this->insertWithdrawVesting($transNum, $opNum, $data);
                break;
            case 'transfer_from_savings':
                $this->insertTransferFromSavings($transNum, $opNum, $data);
                break;
            case 'account_witness_proxy':
                $this->insertAccountWitnessProxy($transNum, $opNum, $data);
                break;
            default:
                file_put_contents(
                    dirname(dirname(dirname(dirname(__FILE__))))."/missingOperations.txt",
                    $type.PHP_EOL,
                    FILE_APPEND
                );
                Output::warning("    -> Unknown operation type '".$type."' in b:{$this->blockNumber} t:{$transNum} o:{$opNum}");
                break;
        }
    }

    #region Operation Inserts

    /**
     * Inserts a vote operation into the database
     *
     * @param $transNum
     * @param $opNum
     * @param $data
     */
    protected function insertVote($transNum, $opNum, $data)
    {
        Parser::getDatabase()->insert(
            "sbds_tx_votes",
            array(
                // Meta
                "block_num" => $this->blockNumber,
                "transaction_num" => $transNum,
                "operation_num" => $opNum,
                "operation_type" => "vote",
                // Data
                "timestamp" => $this->dateTime,
                "voter" => $data['voter'],
                "author" => $data['author'],
                "permlink" => $data['permlink'],
                "weight" => $data['weight']
            )
        );
    }

    /**
     * Inserts a comment operation into the database
     *
     * @param $transNum
     * @param $opNum
     * @param $data
     */
    protected function insertComment($transNum, $opNum, $data)
    {
        Parser::getDatabase()->insert(
            "sbds_tx_comments",
            array(
                // Meta
                "block_num" => $this->blockNumber,
                "transaction_num" => $transNum,
                "operation_num" => $opNum,
                "operation_type" => "comment",
                // Data
                "timestamp" => $this->dateTime,
                "author" => $data['author'],
                "permlink" => $data['permlink'],
                "parent_author" => $data['parent_author'],
                "parent_permlink" => $data['parent_permlink'],
                "title" => $data['title'],
                "body" => $data['body'],
                "json_metadata" => $data['json_metadata']
            )
        );
    }

    /**
     * Inserts a custom json entry into the database
     *
     * @param $transNum
     * @param $opNum
     * @param $data
     */
    protected function insertCustomJson($transNum, $opNum, $data)
    {
        Parser::getDatabase()->insert(
            "sbds_tx_custom_jsons",
            array(
                // Meta
                "block_num" => $this->blockNumber,
                "transaction_num" => $transNum,
                "operation_num" => $opNum,
                "timestamp" => $this->dateTime,
                "operation_type" => "custom_json",
                // Data
                "tid" => $data['id'],
                "required_auths" => json_encode($data['required_auths']),
                "required_posting_auths" => json_encode($data['required_posting_auths']),
                "json" => $data['json']
            )
        );
    }

    /**
     * Inserts a transfer operation
     *
     * @param $transNum
     * @param $opNum
     * @param $data
     */
    protected function insertTransfer($transNum, $opNum, $data)
    {

        // Split currency and amount
        $amount = explode(" ", $data['amount'])[0];
        $currency = explode(" ", $data['amount'])[1];

        Parser::getDatabase()->insert(
            "sbds_tx_transfers",
            array(
                // Meta
                "block_num" => $this->blockNumber,
                "transaction_num" => $transNum,
                "operation_num" => $opNum,
                "timestamp" => $this->dateTime,
                "operation_type" => "transfer",
                // Data
                "from" => $data['from'],
                "to" => $data['to'],
                "amount" => $amount,
                "amount_symbol" => $currency,
                "memo" => $data['memo']
            )
        );
    }

    /**
     * Inserts a claim reward balance operation into the database
     *
     * @param $transNum
     * @param $opNum
     * @param $data
     */
    protected function insertClaimRewardBalanace($transNum, $opNum, $data)
    {
        Parser::getDatabase()->insert(
            "sbds_tx_claim_reward_balances",
            array(
                // Meta
                "block_num" => $this->blockNumber,
                "transaction_num" => $transNum,
                "operation_num" => $opNum,
                "timestamp" => $this->dateTime,
                "operation_type" => 'claim_reward_balance',
                // Data
                "account" => $data['account'],
                "reward_steem" => str_replace(" STEEM", "", $data['reward_steem']),
                "reward_sbd" => str_replace(" SBD", "", $data['reward_sbd']),
                "reward_vests" => str_replace(" VESTS", "", $data['reward_vests']),
            )
        );
    }

    /**
     * Inserts account updates into the database
     *
     * @param $transNum
     * @param $opNum
     * @param $data
     */
    protected function insertAccountUpdate($transNum, $opNum, $data)
    {
        // TODO Check key_auth1 and key_auth2 again
        Parser::getDatabase()->insert(
            "sbds_tx_account_updates",
            array(
                // Meta
                "block_num" => $this->blockNumber,
                "transaction_num" => $transNum,
                "operation_num" => $opNum,
                "timestamp" => $this->dateTime,
                "operation_type" => 'account_update',
                // Data
                "account" => $data['account'],
                "memo_key" => $data['memo_key'],
                "json_metadata" => $data['json_metadata']

            )
        );
    }

    /**
     * Inserts an transfer to vestin operation
     *
     * @param $transNum
     * @param $opNum
     * @param $data
     */
    protected function insertTransferToVesting($transNum, $opNum, $data)
    {
        $amount = explode(" ", $data['amount'])[0];
        $currency = explode(" ", $data['amount'])[1];

        Parser::getDatabase()->insert(
            "sbds_tx_transfer_to_vestings",
            array(
                // Meta
                "block_num" => $this->blockNumber,
                "transaction_num" => $transNum,
                "operation_num" => $opNum,
                "timestamp" => $this->dateTime,
                "operation_type" => 'transfer_to_vesting',
                // Data
                "from" => $data['from'],
                "to" => $data['to'],
                "amount" => $amount,
                "amount_symbol" => $currency

            )
        );
    }

    /**
     * Inserts a 'limit_order_create' Operation in to the database
     *
     * @param $transNum
     * @param $opNum
     * @param $data
     */
    protected function insertLimitOrderCreate($transNum, $opNum, $data)
    {

        Parser::getDatabase()->insert(
            "sbds_tx_limit_order_creates",
            array(
                // Meta
                "block_num" => $this->blockNumber,
                "transaction_num" => $transNum,
                "operation_num" => $opNum,
                "timestamp" => $this->dateTime,
                "operation_type" => 'limit_order_create',
                // Data
                "owner" => $data['owner'],
                "orderid" => $data['orderid'],
                // TODO Check again for cancel value in limit_order_create
                //"cancel" => $data[''],
                "amount_to_sell" => $data['amount_to_sell'],
                "min_to_receive" => $data['min_to_receive'],
                "fill_or_kill" => $data['fill_or_kill'],
                "expiration" => $data['expiration']
            )
        );
    }

    /**
     * Inserts a 'feed_publish' Operation into the database
     *
     * @param $transNum
     * @param $opNum
     * @param $data
     */
    protected function insertFeedPublish($transNum, $opNum, $data)
    {
        Parser::getDatabase()->insert(
            "sbds_tx_feed_publishes",
            array(
                // Meta
                "block_num" => $this->blockNumber,
                "transaction_num" => $transNum,
                "operation_num" => $opNum,
                "timestamp" => $this->dateTime,
                "operation_type" => 'feed_publish',
                // Data
                "publisher" => $data['publisher'],
                "exchange_rate_base" => $data['exchange_rate']['base'],
                "exchange_rate_quote" => $data['exchange_rate']['quote']
            )
        );
    }

    /**
     * Inserts a 'account_create_with_delegation' operation into the database
     *
     * @param $transNum
     * @param $opNum
     * @param $data
     */
    protected function insertAccountCreateWithDelegation($transNum, $opNum, $data)
    {
        Parser::getDatabase()->insert(
            "sbds_tx_account_create_with_delegations",
            array(
                // Meta
                "block_num" => $this->blockNumber,
                "transaction_num" => $transNum,
                "operation_num" => $opNum,
                "timestamp" => $this->dateTime,
                "operation_type" => 'account_create_with_delegation',
                // Data
                "fee" => $data['fee'],
                "delegation" => $data['delegation'],
                "creator" => $data['creator'],
                "new_account_name" => $data['new_account_name'],
                "owner_key" => $data['owner']['key_auths'][0][0],
                "active_key" => $data['active']['key_auths'][0][0],
                "posting_key" => $data['posting']['key_auths'][0][0],
                "memo_key" => $data['memo_key'],
                "json_metadata" => $data['json_metadata']
            )
        );
    }

    /**
     * Insert an 'account_create' operation into the database
     *
     * @param $transNum
     * @param $opNum
     * @param $data
     */
    protected function insertAccountCreate($transNum, $opNum, $data)
    {
        Parser::getDatabase()->insert(
            "sbds_tx_account_creates",
            array(
                // Meta
                "block_num" => $this->blockNumber,
                "transaction_num" => $transNum,
                "operation_num" => $opNum,
                "timestamp" => $this->dateTime,
                "operation_type" => 'account_create',
                // Data
                "fee" => $data['fee'],
                "creator" => $data['creator'],
                "new_account_name" => $data['new_account_name'],
                "owner_key" => $data['owner']['key_auths'][0][0],
                "active_key" => $data['active']['key_auths'][0][0],
                "posting_key" => $data['posting']['key_auths'][0][0],
                "memo_key" => $data['memo_key'],
                "json_metadata" => $data['json_metadata']
            )
        );
    }

    /**
     * Insert a 'pow' operation into the database
     *
     * @param $transNum
     * @param $opNum
     * @param $data
     */
    protected function insertPow($transNum, $opNum, $data)
    {
        Parser::getDatabase()->insert(
            "sbds_tx_pows",
            array(
                // Meta
                "block_num" => $this->blockNumber,
                "transaction_num" => $transNum,
                "operation_num" => $opNum,
                "timestamp" => $this->dateTime,
                "operation_type" => 'pow',
                // Data
                "worker_account" => $data['worker_account'],
                "block_id" => $data['block_id']
            )
        );
    }

    /**
     * Inserts a 'convert' operation into the database
     *
     * @param $transNum
     * @param $opNum
     * @param $data
     */
    protected function insertConvert($transNum, $opNum, $data)
    {
        Parser::getDatabase()->insert(
            "sbds_tx_converts",
            array(
                // Meta
                "block_num" => $this->blockNumber,
                "transaction_num" => $transNum,
                "operation_num" => $opNum,
                "timestamp" => $this->dateTime,
                "operation_type" => 'convert',
                // Data
                "owner" => $data['owner'],
                "requestid" => $data['requestid'],
                "amount" => $data['amount']

            )
        );
    }

    /**
     * Inserts a 'account_witness_vote' operation into the database
     *
     * @param $transNum
     * @param $opNum
     * @param $data
     */
    protected function insertAccountWitnessVote($transNum, $opNum, $data)
    {
        Parser::getDatabase()->insert(
            "sbds_tx_account_witness_votes",
            array(
                // Meta
                "block_num" => $this->blockNumber,
                "transaction_num" => $transNum,
                "operation_num" => $opNum,
                "timestamp" => $this->dateTime,
                "operation_type" => 'account_witness_vote',
                // Data
                "account" => $data['account'],
                "witness" => $data['witness'],
                "approve" => $data['approve']
            )
        );
    }

    /**
     * Inserts a 'delegate_vesting_shares' operation into the database
     *
     * @param $transNum
     * @param $opNum
     * @param $data
     */
    protected function insertDelegateVestingShares($transNum, $opNum, $data)
    {
        Parser::getDatabase()->insert(
            "sbds_tx_delegate_vesting_shares",
            array(
                // Meta
                "block_num" => $this->blockNumber,
                "transaction_num" => $transNum,
                "operation_num" => $opNum,
                "timestamp" => $this->dateTime,
                "operation_type" => 'delegate_vesting_shares',
                // Data
                "delegator" => $data['delegator'],
                "delegatee" => $data['delegatee'],
                "vesting_shares" => $data['approve']
            )
        );
    }

    /**
     * Inserts a 'comment_options' operation into the database
     *
     * @param $transNum
     * @param $opNum
     * @param $data
     */
    protected function insertCommentOptions($transNum, $opNum, $data)
    {
        // TODO check extension key from blockchain - Currently unhandled
        Parser::getDatabase()->insert(
            "sbds_tx_comments_options",
            array(
                // Meta
                "block_num" => $this->blockNumber,
                "transaction_num" => $transNum,
                "operation_num" => $opNum,
                "timestamp" => $this->dateTime,
                "operation_type" => 'comment_options',
                // Data
                "author" => $data['author'],
                "permlink" => $data['permlink'],
                "max_accepted_payout" => $data['max_accepted_payout'],
                "percent_steem_dollars" => $data['percent_steem_dollars'],
                "allow_votes" => $data['allow_votes'],
                "allow_curation_rewards" => $data['allow_curation_rewards']
            )
        );
    }

    /**
     * Inserts a 'limit_order_cancel' operation into the database
     *
     * @param $transNum
     * @param $opNum
     * @param $data
     */
    protected function insertLimitOrderCancel($transNum, $opNum, $data)
    {
        // TODO Check if operation cancle should delete order from database
        Parser::getDatabase()->insert(
            "sbds_tx_limit_order_cancels",
            array(
                // Meta
                "block_num" => $this->blockNumber,
                "transaction_num" => $transNum,
                "operation_num" => $opNum,
                "timestamp" => $this->dateTime,
                "operation_type" => 'limit_order_cancel',
                // Data
                "owner" => $data['owner'],
                "orderid" => $data['orderid']
            )
        );
    }

    /**
     * Inserts a 'delete_comment' operation into the database
     *
     * @param $transNum
     * @param $opNum
     * @param $data
     */
    protected function insertDeleteComment($transNum, $opNum, $data)
    {
        // TODO Check if 'deleteCVomment' should delete comment from database
        Parser::getDatabase()->insert(
            "sbds_tx_delete_comments",
            array(
                // Meta
                "block_num" => $this->blockNumber,
                "transaction_num" => $transNum,
                "operation_num" => $opNum,
                "timestamp" => $this->dateTime,
                "operation_type" => 'delete_comment',
                // Data
                "author" => $data['author'],
                "permlink" => $data['permlink']
            )
        );
    }

    /**
     * Inserts
     *
     * @param $transNum
     * @param $opNum
     * @param $data
     */
    protected function insertWitnessUpdate($transNum, $opNum, $data)
    {
        Parser::getDatabase()->insert(
            "sbds_tx_witness_updates",
            array(
                // Meta
                "block_num" => $this->blockNumber,
                "transaction_num" => $transNum,
                "operation_num" => $opNum,
                "timestamp" => $this->dateTime,
                "operation_type" => 'witness_update',
                // Data
                "owner" => $data['owner'],
                "url" => $data['url'],
                "block_signing_key" => $data['block_signing_key'],
                "props_account_creation_fee" => $data['props']['account_creation_fee'],
                "props_maximum_block_size" => $data['props']['maximum_block_size'],
                "props_sbd_interest_rate" => $data['props']['sbd_interest_rate'],
                "fee" => $data['fee']
            )
        );
    }

    /**
     * Inserts a 'set_withdraw_vesting_route' operation into thze database
     *
     * @param $transNum
     * @param $opNum
     * @param $data
     */
    protected function insertWithdrawVestingRoutes($transNum, $opNum, $data)
    {
        Parser::getDatabase()->insert(
            "sbds_tx_withdraw_vesting_routes",
            array(
                // Meta
                "block_num" => $this->blockNumber,
                "transaction_num" => $transNum,
                "operation_num" => $opNum,
                "timestamp" => $this->dateTime,
                "operation_type" => 'set_withdraw_vesting_route',
                // Data
                "from_account" => $data['from_account'],
                "to_account" => $data['to_account'],
                "percent" => $data['percent'],
                "auto_vest" => $data['auto_vest']
            )
        );
    }

    /**
     * Inserts a 'transfer_to_savings' operation into the database
     *
     * @param $transNum
     * @param $opNum
     * @param $data
     */
    protected function insertTransferToSavings($transNum, $opNum, $data)
    {
        $amount = explode(" ", $data['amount'])[0];
        $currency = explode(" ", $data['amount'])[1];

        Parser::getDatabase()->insert(
            "sbds_tx_transfer_to_savings",
            array(
                // Meta
                "block_num" => $this->blockNumber,
                "transaction_num" => $transNum,
                "operation_num" => $opNum,
                "timestamp" => $this->dateTime,
                "operation_type" => 'transfer_to_savings',
                // Data
                "from" => $data['from'],
                "to" => $data['to'],
                "amount" => $amount,
                "amount_symbol" => $currency,
                "memo" => $data['memo']

            )
        );
    }

    /**
     * Inserts a 'cancel_transfer_from_savings' operation into the database
     *
     * @param $transNum
     * @param $opNum
     * @param $data
     */
    protected function insertCancelTransferFromSavings($transNum, $opNum, $data)
    {
        Parser::getDatabase()->insert(
            "sbds_tx_cancel_transfer_from_savings",
            array(
                // Meta
                "block_num" => $this->blockNumber,
                "transaction_num" => $transNum,
                "operation_num" => $opNum,
                "timestamp" => $this->dateTime,
                "operation_type" => 'cancel_transfer_from_savings',
                // Data
                "from" => $data['from'],
                "request_id" => $data['request_id']
            )
        );
    }

    /**
     * Inserts a 'withdraw_vesting' operation into the database
     *
     * @param $transNum
     * @param $opNum
     * @param $data
     */
    protected function insertWithdrawVesting($transNum, $opNum, $data)
    {
        Parser::getDatabase()->insert(
            "sbds_tx_withdraw_vestings",
            array(
                // Meta
                "block_num" => $this->blockNumber,
                "transaction_num" => $transNum,
                "operation_num" => $opNum,
                "timestamp" => $this->dateTime,
                "operation_type" => 'withdraw_vesting',
                // Data
                "account" => $data['account'],
                "vesting_shares" => $data['vesting_shares']
            )
        );
    }

    /**
     * Inserts a 'transfer_from_savings' operation into the database
     *
     * @param $transNum
     * @param $opNum
     * @param $data
     */
    protected function insertTransferFromSavings($transNum, $opNum, $data)
    {
        $amount = explode(" ", $data['amount'])[0];
        $currency = explode(" ", $data['amount'])[0];

        Parser::getDatabase()->insert(
            "sbds_tx_transfer_from_savings",
            array(
                // Meta
                "block_num" => $this->blockNumber,
                "transaction_num" => $transNum,
                "operation_num" => $opNum,
                "timestamp" => $this->dateTime,
                "operation_type" => 'transfer_from_savings',
                // Data
                "from" => $data['from'],
                "to" => $data['to'],
                "amount" => $amount,
                "amount_symbol" => $currency,
                "memo" => $data['memo'],
                "request_id" => $data['request_id']
            )
        );
    }

    /**
     * Inserts a 'account_witness_proxy' operation into the database
     *
     * @param $transNum
     * @param $opNum
     * @param $data
     */
    protected function insertAccountWitnessProxy($transNum, $opNum, $data)
    {
        Parser::getDatabase()->insert(
            "sbds_tx_account_witness_proxies",
            array(
                // Meta
                "block_num" => $this->blockNumber,
                "transaction_num" => $transNum,
                "operation_num" => $opNum,
                "timestamp" => $this->dateTime,
                "operation_type" => 'account_witness_proxy',
                // Data
                "account" => $data['account'],
                "Proxy" => $data['proxy']
            )
        );
    }

    #endregion

    /**
     * Loads the data from the blockchain into the object
     */
    protected function loadDataFromChain()
    {
        $RPCClient = new RPCClient();
        $blockData = $RPCClient->execute("get_block", array($this->blockNumber));
        $this->blockID = $blockData['block_id'];
        $this->dateTime = $blockData['timestamp'];
        $this->transactions = $blockData['transactions'];
        $this->previous = $blockData['previous'];
        $this->witness = $blockData['witness'];
        $this->witness_signature = $blockData['witness_signature'];
        $this->transaktion_merkle_root = $blockData['transaction_merkle_root'];
    }
}
