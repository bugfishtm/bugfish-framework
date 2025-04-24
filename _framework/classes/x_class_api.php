<?php
	/* 
		 ____  __  __  ___  ____  ____  ___  _   _ 
		(  _ \(  )(  )/ __)( ___)(_  _)/ __)( )_( )
		 ) _ < )(__)(( (_-. )__)  _)(_ \__ \ ) _ ( 
		(____/(______)\___/(__)  (____)(___/(_) (_) www.bugfish.eu
			  ___                                         _     
			 / __)                                       | |    
			| |__ ____ ____ ____   ____ _ _ _  ___   ____| |  _ 
			|  __) ___) _  |    \ / _  ) | | |/ _ \ / ___) | / )
			| | | |  ( ( | | | | ( (/ /| | | | |_| | |   | |< ( 
			|_| |_|   \_||_|_|_|_|\____)\____|\___/|_|   |_| \_)
		Copyright (C) 2024 Jan Maurice Dahlmanns [Bugfish]

		This program is free software: you can redistribute it and/or modify
		it under the terms of the GNU General Public License as published by
		the Free Software Foundation, either version 3 of the License, or
		(at your option) any later version.

		This program is distributed in the hope that it will be useful,
		but WITHOUT ANY WARRANTY; without even the implied warranty of
		MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
		GNU General Public License for more details.

		You should have received a copy of the GNU General Public License
		along with this program.  If not, see <https://www.gnu.org/licenses/>.
	*/
	class x_class_api {
		# Class Properties
		private $mysql;
		private $table;
		private $section;

		# Create Table Function
		private function create_table() {
			return $this->mysql->query("
				CREATE TABLE IF NOT EXISTS `{$this->table}` (
					`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
					`api_key` VARCHAR(128) NOT NULL UNIQUE COMMENT 'API Key (unique)',
					`reference` VARCHAR(128) NULL COMMENT 'Reference (user, app, etc.)',
					`section` VARCHAR(128) NOT NULL COMMENT 'Section/Scope',
					`status` ENUM('active','revoked','expired') DEFAULT 'active' COMMENT 'Key Status',
					`created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
					`expires_at` DATETIME NULL COMMENT 'Expiration Date',
					`last_used_at` DATETIME NULL COMMENT 'Last Usage',
					`meta` JSON NULL COMMENT 'Optional Metadata',
					UNIQUE KEY `ref_section_unique` (`reference`, `section`)
				) ENGINE=InnoDB;");
		}

		# Constructor
		function __construct($mysql, $table, $section = "") {
			$this->mysql = $mysql;
			$this->table = $table;
			$this->section = $section ?: "";
			if(!$this->mysql->table_exists($table)) {
				$this->create_table();
				$this->mysql->free_all();
			}
		}

		// Generate a secure, unique API key
		private function generateUniqueKey($max_attempts = 5) {
			for ($i = 0; $i < $max_attempts; $i++) {
				$key = bin2hex(random_bytes(64));
				$bind = [['type' => 's', 'value' => $key]];
				$res = $this->mysql->select(
					"SELECT id FROM `{$this->table}` WHERE api_key = ? LIMIT 1",
					false,
					$bind
				);
				if (!$res) return $key;
			}
			return false;
		}

		// Add a new API key (one per reference/section)
		public function addKey($reference = null, $section = false, $expires_in_days = null, $meta = null) {
			$section = $section ?: $this->section;
			// Check if a key for this (reference, section) already exists and is active
			$bind = [
				['type' => 's', 'value' => $reference],
				['type' => 's', 'value' => $section]
			];
			$existing = $this->mysql->select(
				"SELECT api_key FROM `{$this->table}` WHERE reference = ? AND section = ? AND status = 'active' LIMIT 1",
				false,
				$bind
			);
			if ($existing) {
				return false;
			}

			$api_key = $this->generateUniqueKey();
			$expires_at = $expires_in_days ? date('Y-m-d H:i:s', strtotime("+$expires_in_days days")) : null;
			$meta_json = $meta ? json_encode($meta) : null;

			$bind = [
				['type' => 's', 'value' => $api_key],
				['type' => 's', 'value' => $reference],
				['type' => 's', 'value' => $section],
				['type' => 's', 'value' => $expires_at],
				['type' => 's', 'value' => $meta_json]
			];

			$this->mysql->query(
				"INSERT INTO `{$this->table}` (api_key, reference, section, expires_at, meta) VALUES (?, ?, ?, ?, ?)",
				$bind
			);
			return $api_key;
		}

		// Refresh (regenerate) an API key for a given reference/section
		public function refreshKey($reference, $section = false) {
			$section = $section ?: $this->section;
			$new_key = $this->generateUniqueKey();
			$bind = [
				['type' => 's', 'value' => $new_key],
				['type' => 's', 'value' => $reference],
				['type' => 's', 'value' => $section]
			];
			$updated = $this->mysql->query(
				"UPDATE `{$this->table}` SET api_key = ?, status = 'active', last_used_at = NULL WHERE reference = ? AND section = ? AND status = 'active'",
				$bind
			);
			if (!$updated) {
				return false;
			}
			return $new_key;
		}

		// Revoke an API key
		public function revokeKey($api_key) {
			$bind = [['type' => 's', 'value' => $api_key]];
			$updated = $this->mysql->query(
				"UPDATE `{$this->table}` SET status = 'revoked' WHERE api_key = ? AND status = 'active'",
				$bind
			);
			if (!$updated) {
				return false;
			}
			return true;
		}

		// Validate an API key (check status, expiration, etc.)
		public function validateKey($api_key, $section = false) {
			$section = $section ?: $this->section;
			$bind = [
				['type' => 's', 'value' => $api_key],
				['type' => 's', 'value' => $section]
			];
			$res = $this->mysql->select(
				"SELECT * FROM `{$this->table}` WHERE api_key = ? AND section = ? AND status = 'active' LIMIT 1",
				false,
				$bind
			);
			if (is_array($res) && 
				(!isset($res['expires_at']) || $res['expires_at'] === null || strtotime($res['expires_at']) > time())) {
				// Update last used timestamp
				$this->mysql->query(
					"UPDATE `{$this->table}` SET last_used_at = NOW() WHERE id = ?",
					[['type' => 'i', 'value' => $res['id']]]
				);
				return true;
			}
			return false;
		}

		// Get metadata for a key
		public function getKeyMeta($api_key) {
			$bind = [['type' => 's', 'value' => $api_key]];
			$res = $this->mysql->select(
				"SELECT meta FROM `{$this->table}` WHERE api_key = ? LIMIT 1",
				false,
				$bind
			);
			return $res && isset($res['meta']) ? json_decode($res['meta'], true) : null;
		}
	}
