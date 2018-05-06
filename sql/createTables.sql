-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server Version:               5.7.21-0ubuntu0.16.04.1 - (Ubuntu)
-- Server Betriebssystem:        Linux
-- HeidiSQL Version:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Exportiere Struktur von Tabelle steem.sbds_core_blocks
CREATE TABLE IF NOT EXISTS `sbds_core_blocks` (
  `raw` mediumtext,
  `block_num` int(11) NOT NULL,
  `previous` varchar(50) DEFAULT NULL,
  `timestamp` datetime DEFAULT NULL,
  `witness` varchar(50) DEFAULT NULL,
  `witness_signature` varchar(150) DEFAULT NULL,
  `transaction_merkle_root` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`block_num`),
  KEY `ix_sbds_core_blocks_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle steem.sbds_tx_account_creates
CREATE TABLE IF NOT EXISTS `sbds_tx_account_creates` (
  `block_num` int(11) NOT NULL,
  `transaction_num` smallint(6) NOT NULL,
  `operation_num` smallint(6) NOT NULL,
  `timestamp` datetime DEFAULT NULL,
  `fee` decimal(15,6) NOT NULL,
  `creator` varchar(50) NOT NULL,
  `new_account_name` varchar(50) DEFAULT NULL,
  `owner_key` varchar(80) NOT NULL,
  `active_key` varchar(80) NOT NULL,
  `posting_key` varchar(80) NOT NULL,
  `memo_key` varchar(250) NOT NULL,
  `json_metadata` text,
  `operation_type` enum('account_create') NOT NULL,
  PRIMARY KEY (`block_num`,`transaction_num`,`operation_num`),
  KEY `ix_sbds_tx_account_creates_operation_type` (`operation_type`),
  KEY `ix_sbds_tx_account_creates_creator` (`creator`),
  KEY `ix_sbds_tx_account_creates_timestamp` (`timestamp`),
  KEY `ix_sbds_tx_account_creates_block_num` (`block_num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle steem.sbds_tx_account_create_with_delegations
CREATE TABLE IF NOT EXISTS `sbds_tx_account_create_with_delegations` (
  `block_num` int(11) NOT NULL,
  `transaction_num` smallint(6) NOT NULL,
  `operation_num` smallint(6) NOT NULL,
  `timestamp` datetime DEFAULT NULL,
  `fee` decimal(15,6) NOT NULL,
  `delegation` decimal(15,6) NOT NULL,
  `creator` varchar(50) NOT NULL,
  `new_account_name` varchar(50) DEFAULT NULL,
  `owner_key` varchar(80) NOT NULL,
  `active_key` varchar(80) NOT NULL,
  `posting_key` varchar(80) NOT NULL,
  `memo_key` varchar(250) NOT NULL,
  `json_metadata` text,
  `operation_type` enum('account_create_with_delegation') NOT NULL,
  PRIMARY KEY (`block_num`,`transaction_num`,`operation_num`),
  KEY `ix_sbds_tx_account_create_with_delegations_new_account_name` (`new_account_name`),
  KEY `ix_sbds_tx_account_create_with_delegations_timestamp` (`timestamp`),
  KEY `ix_sbds_tx_account_create_with_delegations_block_num` (`block_num`),
  KEY `ix_sbds_tx_account_create_with_delegations_operation_type` (`operation_type`),
  KEY `ix_sbds_tx_account_create_with_delegations_creator` (`creator`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle steem.sbds_tx_account_updates
CREATE TABLE IF NOT EXISTS `sbds_tx_account_updates` (
  `block_num` int(11) NOT NULL,
  `transaction_num` smallint(6) NOT NULL,
  `operation_num` smallint(6) NOT NULL,
  `timestamp` datetime DEFAULT NULL,
  `account` varchar(50) DEFAULT NULL,
  `key_auth1` varchar(80) DEFAULT NULL,
  `key_auth2` varchar(80) DEFAULT NULL,
  `memo_key` varchar(250) DEFAULT NULL,
  `json_metadata` text,
  `operation_type` enum('account_update') NOT NULL,
  PRIMARY KEY (`block_num`,`transaction_num`,`operation_num`),
  KEY `ix_sbds_tx_account_updates_block_num` (`block_num`),
  KEY `ix_sbds_tx_account_updates_operation_type` (`operation_type`),
  KEY `ix_sbds_tx_account_updates_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle steem.sbds_tx_account_witness_proxies
CREATE TABLE IF NOT EXISTS `sbds_tx_account_witness_proxies` (
  `block_num` int(11) NOT NULL,
  `transaction_num` smallint(6) NOT NULL,
  `operation_num` smallint(6) NOT NULL,
  `timestamp` datetime DEFAULT NULL,
  `account` varchar(50) NOT NULL,
  `Proxy` varchar(50) NOT NULL,
  `operation_type` enum('account_witness_proxy') NOT NULL,
  PRIMARY KEY (`block_num`,`transaction_num`,`operation_num`),
  KEY `ix_sbds_tx_account_witness_proxies_timestamp` (`timestamp`),
  KEY `ix_sbds_tx_account_witness_proxies_block_num` (`block_num`),
  KEY `ix_sbds_tx_account_witness_proxies_operation_type` (`operation_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle steem.sbds_tx_account_witness_votes
CREATE TABLE IF NOT EXISTS `sbds_tx_account_witness_votes` (
  `block_num` int(11) NOT NULL,
  `transaction_num` smallint(6) NOT NULL,
  `operation_num` smallint(6) NOT NULL,
  `timestamp` datetime DEFAULT NULL,
  `account` varchar(50) NOT NULL,
  `witness` varchar(50) NOT NULL,
  `approve` tinyint(1) DEFAULT NULL,
  `operation_type` enum('account_witness_vote') NOT NULL,
  PRIMARY KEY (`block_num`,`transaction_num`,`operation_num`),
  KEY `ix_sbds_tx_account_witness_votes_block_num` (`block_num`),
  KEY `ix_sbds_tx_account_witness_votes_timestamp` (`timestamp`),
  KEY `ix_sbds_tx_account_witness_votes_operation_type` (`operation_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle steem.sbds_tx_cancel_transfer_from_savings
CREATE TABLE IF NOT EXISTS `sbds_tx_cancel_transfer_from_savings` (
  `block_num` int(11) NOT NULL,
  `transaction_num` smallint(6) NOT NULL,
  `operation_num` smallint(6) NOT NULL,
  `timestamp` datetime DEFAULT NULL,
  `from` varchar(50) DEFAULT NULL,
  `request_id` int(11) DEFAULT NULL,
  `operation_type` enum('cancel_transfer_from_savings') NOT NULL,
  PRIMARY KEY (`block_num`,`transaction_num`,`operation_num`),
  KEY `ix_sbds_tx_cancel_transfer_from_savings_block_num` (`block_num`),
  KEY `ix_sbds_tx_cancel_transfer_from_savings_operation_type` (`operation_type`),
  KEY `ix_sbds_tx_cancel_transfer_from_savings_from` (`from`),
  KEY `ix_sbds_tx_cancel_transfer_from_savings_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle steem.sbds_tx_change_recovery_accounts
CREATE TABLE IF NOT EXISTS `sbds_tx_change_recovery_accounts` (
  `block_num` int(11) NOT NULL,
  `transaction_num` smallint(6) NOT NULL,
  `operation_num` smallint(6) NOT NULL,
  `timestamp` datetime DEFAULT NULL,
  `account_to_recover` varchar(50) DEFAULT NULL,
  `new_recovery_account` varchar(50) DEFAULT NULL,
  `operation_type` enum('change_recovery_account') NOT NULL,
  PRIMARY KEY (`block_num`,`transaction_num`,`operation_num`),
  KEY `ix_sbds_tx_change_recovery_accounts_timestamp` (`timestamp`),
  KEY `ix_sbds_tx_change_recovery_accounts_block_num` (`block_num`),
  KEY `ix_sbds_tx_change_recovery_accounts_operation_type` (`operation_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle steem.sbds_tx_claim_reward_balances
CREATE TABLE IF NOT EXISTS `sbds_tx_claim_reward_balances` (
  `block_num` int(11) NOT NULL,
  `transaction_num` smallint(6) NOT NULL,
  `operation_num` smallint(6) NOT NULL,
  `timestamp` datetime DEFAULT NULL,
  `account` varchar(50) NOT NULL,
  `reward_steem` decimal(15,6) DEFAULT NULL,
  `reward_sbd` decimal(15,6) DEFAULT NULL,
  `reward_vests` decimal(15,6) DEFAULT NULL,
  `operation_type` enum('claim_reward_balance') NOT NULL,
  PRIMARY KEY (`block_num`,`transaction_num`,`operation_num`),
  KEY `ix_sbds_tx_claim_reward_balances_operation_type` (`operation_type`),
  KEY `ix_sbds_tx_claim_reward_balances_account` (`account`),
  KEY `ix_sbds_tx_claim_reward_balances_timestamp` (`timestamp`),
  KEY `ix_sbds_tx_claim_reward_balances_block_num` (`block_num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle steem.sbds_tx_comments
CREATE TABLE IF NOT EXISTS `sbds_tx_comments` (
  `block_num` int(11) NOT NULL,
  `transaction_num` smallint(6) NOT NULL,
  `operation_num` smallint(6) NOT NULL,
  `timestamp` datetime DEFAULT NULL,
  `author` varchar(50) NOT NULL,
  `permlink` varchar(512) NOT NULL,
  `parent_author` varchar(50) DEFAULT NULL,
  `parent_permlink` varchar(512) DEFAULT NULL,
  `title` varchar(512) DEFAULT NULL,
  `body` text,
  `json_metadata` text,
  `operation_type` enum('comment') NOT NULL,
  PRIMARY KEY (`block_num`,`transaction_num`,`operation_num`),
  KEY `ix_sbds_tx_comments_block_num` (`block_num`),
  KEY `ix_sbds_tx_comments_author` (`author`),
  KEY `ix_sbds_tx_comments_permlink` (`permlink`),
  KEY `ix_sbds_tx_comments_parent_author` (`parent_author`),
  KEY `ix_sbds_tx_comments_timestamp` (`timestamp`),
  KEY `ix_sbds_tx_comments_operation_type` (`operation_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle steem.sbds_tx_comments_options
CREATE TABLE IF NOT EXISTS `sbds_tx_comments_options` (
  `block_num` int(11) NOT NULL,
  `transaction_num` smallint(6) NOT NULL,
  `operation_num` smallint(6) NOT NULL,
  `timestamp` datetime DEFAULT NULL,
  `author` varchar(50) NOT NULL,
  `permlink` varchar(512) NOT NULL,
  `max_accepted_payout` decimal(15,6) NOT NULL,
  `percent_steem_dollars` int(6) DEFAULT NULL,
  `allow_votes` tinyint(1) NOT NULL,
  `allow_curation_rewards` tinyint(1) NOT NULL,
  `operation_type` enum('comment_options') NOT NULL,
  PRIMARY KEY (`block_num`,`transaction_num`,`operation_num`),
  KEY `ix_sbds_tx_comments_options_timestamp` (`timestamp`),
  KEY `ix_sbds_tx_comments_options_operation_type` (`operation_type`),
  KEY `ix_sbds_tx_comments_options_block_num` (`block_num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle steem.sbds_tx_converts
CREATE TABLE IF NOT EXISTS `sbds_tx_converts` (
  `block_num` int(11) NOT NULL,
  `transaction_num` smallint(6) NOT NULL,
  `operation_num` smallint(6) NOT NULL,
  `timestamp` datetime DEFAULT NULL,
  `owner` varchar(50) NOT NULL,
  `requestid` bigint(20) NOT NULL,
  `amount` decimal(15,6) NOT NULL,
  `operation_type` enum('convert') NOT NULL,
  PRIMARY KEY (`block_num`,`transaction_num`,`operation_num`),
  KEY `ix_sbds_tx_converts_timestamp` (`timestamp`),
  KEY `ix_sbds_tx_converts_block_num` (`block_num`),
  KEY `ix_sbds_tx_converts_operation_type` (`operation_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle steem.sbds_tx_customs
CREATE TABLE IF NOT EXISTS `sbds_tx_customs` (
  `block_num` int(11) NOT NULL,
  `transaction_num` smallint(6) NOT NULL,
  `operation_num` smallint(6) NOT NULL,
  `timestamp` datetime DEFAULT NULL,
  `tid` varchar(50) NOT NULL,
  `required_auths` varchar(250) DEFAULT NULL,
  `data` text,
  `operation_type` enum('custom') NOT NULL,
  PRIMARY KEY (`block_num`,`transaction_num`,`operation_num`),
  KEY `ix_sbds_tx_customs_timestamp` (`timestamp`),
  KEY `ix_sbds_tx_customs_block_num` (`block_num`),
  KEY `ix_sbds_tx_customs_operation_type` (`operation_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle steem.sbds_tx_custom_jsons
CREATE TABLE IF NOT EXISTS `sbds_tx_custom_jsons` (
  `block_num` int(11) NOT NULL,
  `transaction_num` smallint(6) NOT NULL,
  `operation_num` smallint(6) NOT NULL,
  `timestamp` datetime DEFAULT NULL,
  `tid` varchar(50) NOT NULL,
  `required_auths` varchar(250) DEFAULT NULL,
  `required_posting_auths` varchar(250) DEFAULT NULL,
  `json` text,
  `operation_type` enum('custom_json') NOT NULL,
  PRIMARY KEY (`block_num`,`transaction_num`,`operation_num`),
  KEY `ix_sbds_tx_custom_jsons_timestamp` (`timestamp`),
  KEY `ix_sbds_tx_custom_jsons_operation_type` (`operation_type`),
  KEY `ix_sbds_tx_custom_jsons_tid` (`tid`),
  KEY `ix_sbds_tx_custom_jsons_block_num` (`block_num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle steem.sbds_tx_decline_voting_rights
CREATE TABLE IF NOT EXISTS `sbds_tx_decline_voting_rights` (
  `block_num` int(11) NOT NULL,
  `transaction_num` smallint(6) NOT NULL,
  `operation_num` smallint(6) NOT NULL,
  `timestamp` datetime DEFAULT NULL,
  `account` varchar(50) NOT NULL,
  `decline` tinyint(1) DEFAULT NULL,
  `operation_type` enum('decline_voting_rights') NOT NULL,
  PRIMARY KEY (`block_num`,`transaction_num`,`operation_num`),
  KEY `ix_sbds_tx_decline_voting_rights_timestamp` (`timestamp`),
  KEY `ix_sbds_tx_decline_voting_rights_block_num` (`block_num`),
  KEY `ix_sbds_tx_decline_voting_rights_operation_type` (`operation_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle steem.sbds_tx_delegate_vesting_shares
CREATE TABLE IF NOT EXISTS `sbds_tx_delegate_vesting_shares` (
  `block_num` int(11) NOT NULL,
  `transaction_num` smallint(6) NOT NULL,
  `operation_num` smallint(6) NOT NULL,
  `timestamp` datetime DEFAULT NULL,
  `delegator` varchar(50) DEFAULT NULL,
  `delegatee` varchar(50) DEFAULT NULL,
  `vesting_shares` decimal(15,6) DEFAULT NULL,
  `operation_type` enum('delegate_vesting_shares') NOT NULL,
  PRIMARY KEY (`block_num`,`transaction_num`,`operation_num`),
  KEY `ix_sbds_tx_delegate_vesting_shares_block_num` (`block_num`),
  KEY `ix_sbds_tx_delegate_vesting_shares_operation_type` (`operation_type`),
  KEY `ix_sbds_tx_delegate_vesting_shares_delegatee` (`delegatee`),
  KEY `ix_sbds_tx_delegate_vesting_shares_delegator` (`delegator`),
  KEY `ix_sbds_tx_delegate_vesting_shares_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle steem.sbds_tx_delete_comments
CREATE TABLE IF NOT EXISTS `sbds_tx_delete_comments` (
  `block_num` int(11) NOT NULL,
  `transaction_num` smallint(6) NOT NULL,
  `operation_num` smallint(6) NOT NULL,
  `timestamp` datetime DEFAULT NULL,
  `author` varchar(50) NOT NULL,
  `permlink` varchar(256) NOT NULL,
  `operation_type` enum('delete_comment') NOT NULL,
  PRIMARY KEY (`block_num`,`transaction_num`,`operation_num`),
  KEY `ix_sbds_tx_delete_comments_block_num` (`block_num`),
  KEY `ix_sbds_tx_delete_comments_operation_type` (`operation_type`),
  KEY `ix_sbds_tx_delete_comments_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle steem.sbds_tx_escrow_approves
CREATE TABLE IF NOT EXISTS `sbds_tx_escrow_approves` (
  `block_num` int(11) NOT NULL,
  `transaction_num` smallint(6) NOT NULL,
  `operation_num` smallint(6) NOT NULL,
  `timestamp` datetime DEFAULT NULL,
  `from` varchar(50) DEFAULT NULL,
  `agent` varchar(50) DEFAULT NULL,
  `to` varchar(50) DEFAULT NULL,
  `who` varchar(50) DEFAULT NULL,
  `escrow_id` int(11) DEFAULT NULL,
  `approve` tinyint(1) DEFAULT NULL,
  `operation_type` enum('escrow_approve') NOT NULL,
  PRIMARY KEY (`block_num`,`transaction_num`,`operation_num`),
  KEY `ix_sbds_tx_escrow_approves_operation_type` (`operation_type`),
  KEY `ix_sbds_tx_escrow_approves_block_num` (`block_num`),
  KEY `ix_sbds_tx_escrow_approves_from` (`from`),
  KEY `ix_sbds_tx_escrow_approves_agent` (`agent`),
  KEY `ix_sbds_tx_escrow_approves_to` (`to`),
  KEY `ix_sbds_tx_escrow_approves_timestamp` (`timestamp`),
  KEY `ix_sbds_tx_escrow_approves_who` (`who`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle steem.sbds_tx_escrow_disputes
CREATE TABLE IF NOT EXISTS `sbds_tx_escrow_disputes` (
  `block_num` int(11) NOT NULL,
  `transaction_num` smallint(6) NOT NULL,
  `operation_num` smallint(6) NOT NULL,
  `timestamp` datetime DEFAULT NULL,
  `from` varchar(50) DEFAULT NULL,
  `agent` varchar(50) DEFAULT NULL,
  `to` varchar(50) DEFAULT NULL,
  `who` varchar(50) DEFAULT NULL,
  `escrow_id` int(11) DEFAULT NULL,
  `approve` tinyint(1) DEFAULT NULL,
  `operation_type` enum('escrow_dispute') NOT NULL,
  PRIMARY KEY (`block_num`,`transaction_num`,`operation_num`),
  KEY `ix_sbds_tx_escrow_disputes_operation_type` (`operation_type`),
  KEY `ix_sbds_tx_escrow_disputes_block_num` (`block_num`),
  KEY `ix_sbds_tx_escrow_disputes_from` (`from`),
  KEY `ix_sbds_tx_escrow_disputes_agent` (`agent`),
  KEY `ix_sbds_tx_escrow_disputes_to` (`to`),
  KEY `ix_sbds_tx_escrow_disputes_timestamp` (`timestamp`),
  KEY `ix_sbds_tx_escrow_disputes_who` (`who`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle steem.sbds_tx_escrow_releases
CREATE TABLE IF NOT EXISTS `sbds_tx_escrow_releases` (
  `block_num` int(11) NOT NULL,
  `transaction_num` smallint(6) NOT NULL,
  `operation_num` smallint(6) NOT NULL,
  `timestamp` datetime DEFAULT NULL,
  `from` varchar(50) DEFAULT NULL,
  `agent` varchar(50) DEFAULT NULL,
  `to` varchar(50) DEFAULT NULL,
  `escrow_id` int(11) DEFAULT NULL,
  `steem_amount` decimal(15,6) DEFAULT NULL,
  `sbd_amount` decimal(15,6) DEFAULT NULL,
  `who` varchar(50) DEFAULT NULL,
  `receiver` varchar(50) DEFAULT NULL,
  `operation_type` enum('escrow_release') NOT NULL,
  PRIMARY KEY (`block_num`,`transaction_num`,`operation_num`),
  KEY `ix_sbds_tx_escrow_releases_to` (`to`),
  KEY `ix_sbds_tx_escrow_releases_timestamp` (`timestamp`),
  KEY `ix_sbds_tx_escrow_releases_who` (`who`),
  KEY `ix_sbds_tx_escrow_releases_receiver` (`receiver`),
  KEY `ix_sbds_tx_escrow_releases_block_num` (`block_num`),
  KEY `ix_sbds_tx_escrow_releases_from` (`from`),
  KEY `ix_sbds_tx_escrow_releases_operation_type` (`operation_type`),
  KEY `ix_sbds_tx_escrow_releases_agent` (`agent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle steem.sbds_tx_escrow_transfers
CREATE TABLE IF NOT EXISTS `sbds_tx_escrow_transfers` (
  `block_num` int(11) NOT NULL,
  `transaction_num` smallint(6) NOT NULL,
  `operation_num` smallint(6) NOT NULL,
  `timestamp` datetime DEFAULT NULL,
  `from` varchar(50) DEFAULT NULL,
  `agent` varchar(50) DEFAULT NULL,
  `to` varchar(50) DEFAULT NULL,
  `escrow_id` int(11) DEFAULT NULL,
  `steem_amount` decimal(15,6) DEFAULT NULL,
  `sbd_amount` decimal(15,6) DEFAULT NULL,
  `json_metadata` text,
  `fee_amount` decimal(15,6) DEFAULT NULL,
  `fee_amount_symbol` varchar(5) DEFAULT NULL,
  `escrow_expiration` datetime DEFAULT NULL,
  `ratification_deadline` datetime DEFAULT NULL,
  `operation_type` enum('escrow_transfer') NOT NULL,
  PRIMARY KEY (`block_num`,`transaction_num`,`operation_num`),
  KEY `ix_sbds_tx_escrow_transfers_agent` (`agent`),
  KEY `ix_sbds_tx_escrow_transfers_to` (`to`),
  KEY `ix_sbds_tx_escrow_transfers_timestamp` (`timestamp`),
  KEY `ix_sbds_tx_escrow_transfers_escrow_expiration` (`escrow_expiration`),
  KEY `ix_sbds_tx_escrow_transfers_operation_type` (`operation_type`),
  KEY `ix_sbds_tx_escrow_transfers_ratification_deadline` (`ratification_deadline`),
  KEY `ix_sbds_tx_escrow_transfers_block_num` (`block_num`),
  KEY `ix_sbds_tx_escrow_transfers_from` (`from`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle steem.sbds_tx_feed_publishes
CREATE TABLE IF NOT EXISTS `sbds_tx_feed_publishes` (
  `block_num` int(11) NOT NULL,
  `transaction_num` smallint(6) NOT NULL,
  `operation_num` smallint(6) NOT NULL,
  `timestamp` datetime DEFAULT NULL,
  `publisher` varchar(50) NOT NULL,
  `exchange_rate_base` decimal(15,6) NOT NULL,
  `exchange_rate_quote` decimal(15,6) NOT NULL,
  `operation_type` enum('feed_publish') NOT NULL,
  PRIMARY KEY (`block_num`,`transaction_num`,`operation_num`),
  KEY `ix_sbds_tx_feed_publishes_block_num` (`block_num`),
  KEY `ix_sbds_tx_feed_publishes_operation_type` (`operation_type`),
  KEY `ix_sbds_tx_feed_publishes_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle steem.sbds_tx_limit_order_cancels
CREATE TABLE IF NOT EXISTS `sbds_tx_limit_order_cancels` (
  `block_num` int(11) NOT NULL,
  `transaction_num` smallint(6) NOT NULL,
  `operation_num` smallint(6) NOT NULL,
  `timestamp` datetime DEFAULT NULL,
  `owner` varchar(50) NOT NULL,
  `orderid` bigint(20) NOT NULL,
  `operation_type` enum('limit_order_cancel') NOT NULL,
  PRIMARY KEY (`block_num`,`transaction_num`,`operation_num`),
  KEY `ix_sbds_tx_limit_order_cancels_operation_type` (`operation_type`),
  KEY `ix_sbds_tx_limit_order_cancels_timestamp` (`timestamp`),
  KEY `ix_sbds_tx_limit_order_cancels_block_num` (`block_num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle steem.sbds_tx_limit_order_creates
CREATE TABLE IF NOT EXISTS `sbds_tx_limit_order_creates` (
  `block_num` int(11) NOT NULL,
  `transaction_num` smallint(6) NOT NULL,
  `operation_num` smallint(6) NOT NULL,
  `timestamp` datetime DEFAULT NULL,
  `owner` varchar(50) NOT NULL,
  `orderid` bigint(20) NOT NULL,
  `cancel` tinyint(1) DEFAULT NULL,
  `amount_to_sell` decimal(15,6) DEFAULT NULL,
  `min_to_receive` decimal(15,6) DEFAULT NULL,
  `fill_or_kill` tinyint(1) DEFAULT NULL,
  `expiration` datetime DEFAULT NULL,
  `operation_type` enum('limit_order_create') NOT NULL,
  PRIMARY KEY (`block_num`,`transaction_num`,`operation_num`),
  KEY `ix_sbds_tx_limit_order_creates_timestamp` (`timestamp`),
  KEY `ix_sbds_tx_limit_order_creates_operation_type` (`operation_type`),
  KEY `ix_sbds_tx_limit_order_creates_block_num` (`block_num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle steem.sbds_tx_pow2s
CREATE TABLE IF NOT EXISTS `sbds_tx_pow2s` (
  `block_num` int(11) NOT NULL,
  `transaction_num` smallint(6) NOT NULL,
  `operation_num` smallint(6) NOT NULL,
  `timestamp` datetime DEFAULT NULL,
  `worker_account` varchar(50) NOT NULL,
  `block_id` varchar(40) NOT NULL,
  `operation_type` enum('pow2') NOT NULL,
  PRIMARY KEY (`block_num`,`transaction_num`,`operation_num`),
  KEY `ix_sbds_tx_pow2s_worker_account` (`worker_account`),
  KEY `ix_sbds_tx_pow2s_timestamp` (`timestamp`),
  KEY `ix_sbds_tx_pow2s_block_num` (`block_num`),
  KEY `ix_sbds_tx_pow2s_operation_type` (`operation_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle steem.sbds_tx_pows
CREATE TABLE IF NOT EXISTS `sbds_tx_pows` (
  `block_num` int(11) NOT NULL,
  `transaction_num` smallint(6) NOT NULL,
  `operation_num` smallint(6) NOT NULL,
  `timestamp` datetime DEFAULT NULL,
  `worker_account` varchar(50) NOT NULL,
  `block_id` varchar(40) NOT NULL,
  `operation_type` enum('pow') NOT NULL,
  PRIMARY KEY (`block_num`,`transaction_num`,`operation_num`),
  KEY `ix_sbds_tx_pows_block_num` (`block_num`),
  KEY `ix_sbds_tx_pows_operation_type` (`operation_type`),
  KEY `ix_sbds_tx_pows_worker_account` (`worker_account`),
  KEY `ix_sbds_tx_pows_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle steem.sbds_tx_recover_accounts
CREATE TABLE IF NOT EXISTS `sbds_tx_recover_accounts` (
  `block_num` int(11) NOT NULL,
  `transaction_num` smallint(6) NOT NULL,
  `operation_num` smallint(6) NOT NULL,
  `timestamp` datetime DEFAULT NULL,
  `recovery_account` varchar(50) DEFAULT NULL,
  `account_to_recover` varchar(50) NOT NULL,
  `recovered` tinyint(1) DEFAULT NULL,
  `operation_type` enum('recover_account') NOT NULL,
  PRIMARY KEY (`block_num`,`transaction_num`,`operation_num`),
  KEY `ix_sbds_tx_recover_accounts_timestamp` (`timestamp`),
  KEY `ix_sbds_tx_recover_accounts_block_num` (`block_num`),
  KEY `ix_sbds_tx_recover_accounts_operation_type` (`operation_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle steem.sbds_tx_request_account_recoveries
CREATE TABLE IF NOT EXISTS `sbds_tx_request_account_recoveries` (
  `block_num` int(11) NOT NULL,
  `transaction_num` smallint(6) NOT NULL,
  `operation_num` smallint(6) NOT NULL,
  `timestamp` datetime DEFAULT NULL,
  `recovery_account` varchar(50) DEFAULT NULL,
  `account_to_recover` varchar(50) NOT NULL,
  `recovered` tinyint(1) DEFAULT NULL,
  `operation_type` enum('request_account_recovery') NOT NULL,
  PRIMARY KEY (`block_num`,`transaction_num`,`operation_num`),
  KEY `ix_sbds_tx_request_account_recoveries_block_num` (`block_num`),
  KEY `ix_sbds_tx_request_account_recoveries_operation_type` (`operation_type`),
  KEY `ix_sbds_tx_request_account_recoveries_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle steem.sbds_tx_transfers
CREATE TABLE IF NOT EXISTS `sbds_tx_transfers` (
  `block_num` int(11) NOT NULL,
  `transaction_num` smallint(6) NOT NULL,
  `operation_num` smallint(6) NOT NULL,
  `timestamp` datetime DEFAULT NULL,
  `from` varchar(50) DEFAULT NULL,
  `to` varchar(50) DEFAULT NULL,
  `amount` decimal(15,6) DEFAULT NULL,
  `amount_symbol` varchar(5) DEFAULT NULL,
  `memo` varchar(2048) DEFAULT NULL,
  `operation_type` enum('transfer') NOT NULL,
  PRIMARY KEY (`block_num`,`transaction_num`,`operation_num`),
  KEY `ix_sbds_tx_transfers_timestamp` (`timestamp`),
  KEY `ix_sbds_tx_transfers_operation_type` (`operation_type`),
  KEY `ix_sbds_tx_transfers_to` (`to`),
  KEY `ix_sbds_tx_transfers_from` (`from`),
  KEY `ix_sbds_tx_transfers_block_num` (`block_num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle steem.sbds_tx_transfer_from_savings
CREATE TABLE IF NOT EXISTS `sbds_tx_transfer_from_savings` (
  `block_num` int(11) NOT NULL,
  `transaction_num` smallint(6) NOT NULL,
  `operation_num` smallint(6) NOT NULL,
  `timestamp` datetime DEFAULT NULL,
  `from` varchar(50) DEFAULT NULL,
  `to` varchar(50) DEFAULT NULL,
  `amount` decimal(15,6) DEFAULT NULL,
  `amount_symbol` varchar(5) DEFAULT NULL,
  `memo` varchar(2048) DEFAULT NULL,
  `request_id` int(11) DEFAULT NULL,
  `operation_type` enum('transfer_from_savings') NOT NULL,
  PRIMARY KEY (`block_num`,`transaction_num`,`operation_num`),
  KEY `ix_sbds_tx_transfer_from_savings_to` (`to`),
  KEY `ix_sbds_tx_transfer_from_savings_from` (`from`),
  KEY `ix_sbds_tx_transfer_from_savings_timestamp` (`timestamp`),
  KEY `ix_sbds_tx_transfer_from_savings_block_num` (`block_num`),
  KEY `ix_sbds_tx_transfer_from_savings_operation_type` (`operation_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle steem.sbds_tx_transfer_to_savings
CREATE TABLE IF NOT EXISTS `sbds_tx_transfer_to_savings` (
  `block_num` int(11) NOT NULL,
  `transaction_num` smallint(6) NOT NULL,
  `operation_num` smallint(6) NOT NULL,
  `timestamp` datetime DEFAULT NULL,
  `from` varchar(50) DEFAULT NULL,
  `to` varchar(50) DEFAULT NULL,
  `amount` decimal(15,6) DEFAULT NULL,
  `amount_symbol` varchar(5) DEFAULT NULL,
  `memo` varchar(2048) DEFAULT NULL,
  `operation_type` enum('transfer_to_savings') NOT NULL,
  PRIMARY KEY (`block_num`,`transaction_num`,`operation_num`),
  KEY `ix_sbds_tx_transfer_to_savings_operation_type` (`operation_type`),
  KEY `ix_sbds_tx_transfer_to_savings_to` (`to`),
  KEY `ix_sbds_tx_transfer_to_savings_from` (`from`),
  KEY `ix_sbds_tx_transfer_to_savings_timestamp` (`timestamp`),
  KEY `ix_sbds_tx_transfer_to_savings_block_num` (`block_num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle steem.sbds_tx_transfer_to_vestings
CREATE TABLE IF NOT EXISTS `sbds_tx_transfer_to_vestings` (
  `block_num` int(11) NOT NULL,
  `transaction_num` smallint(6) NOT NULL,
  `operation_num` smallint(6) NOT NULL,
  `timestamp` datetime DEFAULT NULL,
  `from` varchar(50) DEFAULT NULL,
  `to` varchar(50) DEFAULT NULL,
  `amount` decimal(15,6) DEFAULT NULL,
  `amount_symbol` varchar(5) DEFAULT NULL,
  `operation_type` enum('transfer_to_vesting') NOT NULL,
  PRIMARY KEY (`block_num`,`transaction_num`,`operation_num`),
  KEY `ix_sbds_tx_transfer_to_vestings_timestamp` (`timestamp`),
  KEY `ix_sbds_tx_transfer_to_vestings_to` (`to`),
  KEY `ix_sbds_tx_transfer_to_vestings_from` (`from`),
  KEY `ix_sbds_tx_transfer_to_vestings_block_num` (`block_num`),
  KEY `ix_sbds_tx_transfer_to_vestings_operation_type` (`operation_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle steem.sbds_tx_votes
CREATE TABLE IF NOT EXISTS `sbds_tx_votes` (
  `block_num` int(11) NOT NULL,
  `transaction_num` smallint(6) NOT NULL,
  `operation_num` smallint(6) NOT NULL,
  `timestamp` datetime DEFAULT NULL,
  `voter` varchar(50) NOT NULL,
  `author` varchar(50) NOT NULL,
  `permlink` varchar(512) NOT NULL,
  `weight` int(11) DEFAULT NULL,
  `operation_type` enum('vote') NOT NULL,
  PRIMARY KEY (`block_num`,`transaction_num`,`operation_num`),
  KEY `ix_sbds_tx_votes_block_num` (`block_num`),
  KEY `ix_sbds_tx_votes_operation_type` (`operation_type`),
  KEY `ix_sbds_tx_votes_author` (`author`),
  KEY `ix_sbds_tx_votes_voter` (`voter`),
  KEY `ix_sbds_tx_votes_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle steem.sbds_tx_withdraw_vestings
CREATE TABLE IF NOT EXISTS `sbds_tx_withdraw_vestings` (
  `block_num` int(11) NOT NULL,
  `transaction_num` smallint(6) NOT NULL,
  `operation_num` smallint(6) NOT NULL,
  `timestamp` datetime DEFAULT NULL,
  `account` varchar(50) NOT NULL,
  `vesting_shares` decimal(25,6) NOT NULL,
  `operation_type` enum('withdraw_vesting') NOT NULL,
  PRIMARY KEY (`block_num`,`transaction_num`,`operation_num`),
  KEY `ix_sbds_tx_withdraw_vestings_operation_type` (`operation_type`),
  KEY `ix_sbds_tx_withdraw_vestings_timestamp` (`timestamp`),
  KEY `ix_sbds_tx_withdraw_vestings_block_num` (`block_num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle steem.sbds_tx_withdraw_vesting_routes
CREATE TABLE IF NOT EXISTS `sbds_tx_withdraw_vesting_routes` (
  `block_num` int(11) NOT NULL,
  `transaction_num` smallint(6) NOT NULL,
  `operation_num` smallint(6) NOT NULL,
  `timestamp` datetime DEFAULT NULL,
  `from_account` varchar(50) NOT NULL,
  `to_account` varchar(50) NOT NULL,
  `percent` smallint(6) NOT NULL,
  `auto_vest` tinyint(1) DEFAULT NULL,
  `operation_type` enum('set_withdraw_vesting_route') NOT NULL,
  PRIMARY KEY (`block_num`,`transaction_num`,`operation_num`),
  KEY `ix_sbds_tx_withdraw_vesting_routes_timestamp` (`timestamp`),
  KEY `ix_sbds_tx_withdraw_vesting_routes_operation_type` (`operation_type`),
  KEY `ix_sbds_tx_withdraw_vesting_routes_block_num` (`block_num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle steem.sbds_tx_witness_updates
CREATE TABLE IF NOT EXISTS `sbds_tx_witness_updates` (
  `block_num` int(11) NOT NULL,
  `transaction_num` smallint(6) NOT NULL,
  `operation_num` smallint(6) NOT NULL,
  `timestamp` datetime DEFAULT NULL,
  `owner` varchar(50) NOT NULL,
  `url` varchar(250) NOT NULL,
  `block_signing_key` varchar(64) NOT NULL,
  `props_account_creation_fee` decimal(15,6) NOT NULL,
  `props_maximum_block_size` int(11) NOT NULL,
  `props_sbd_interest_rate` int(11) NOT NULL,
  `fee` decimal(15,6) NOT NULL,
  `operation_type` enum('witness_update') NOT NULL,
  PRIMARY KEY (`block_num`,`transaction_num`,`operation_num`),
  KEY `ix_sbds_tx_witness_updates_block_num` (`block_num`),
  KEY `ix_sbds_tx_witness_updates_operation_type` (`operation_type`),
  KEY `ix_sbds_tx_witness_updates_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Daten Export vom Benutzer nicht ausgewählt
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
