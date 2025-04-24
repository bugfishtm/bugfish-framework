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
	class x_class_mysql_item {
		// Class Variables
		private $mysql     				= false;
		private $tablename 				= false;
		private $id   					= false; 
		private $id_field   			= false; 
		
		// Constructor
		function __construct($mysql, $tablename, $id , $id_field = "id") {
			$this->mysql		= $mysql;
			$this->tablename 	= $tablename;
			$this->id 			= $id;
			$this->id_field 	= $id_field;}		

		// Get Field of Current Item
		public function get($field) {
			$x = $this->mysql->select("SELECT * FROM `".$this->tablename."` WHERE `".$this->id_field."` = ".$this->id.";", false);
			if(is_array($x)){ return @$x[$field]; } else { return false;}}
		
		// Get Array of Current Item
		public function get_array() { return $this->mysql->select("SELECT * FROM `".$this->tablename."` WHERE `".$this->id_field."` = ".$this->id.";", false); }

		// Update Current Item
		public function update($field, $value) {
			$bind[0]["value"] =	$value;
			$bind[0]["type"] =	"s";
			return $this->mysql->query("UPDATE `".$this->tablename."` SET `".$field."` = ? WHERE `".$this->id_field."` = ".$this->id.";", $bind);}

		// Update Current Item on NULL
		public function update_null($field) {return $this->mysql->query("UPDATE `".$this->tablename."` SET `".$field."` = NULL WHERE `".$this->id_field."` = ".$this->id.";");}		
		
		// Delete Current Item
		public function delete() {return $this->mysql->query("DELETE FROM `".$this->tablename."` WHERE `".$this->id_field."` = ".$this->id.";");}
		
		// Clone Item with another ID
		public function clone($id) {
			return new x_class_mysql_item($this->mysql, $this->tablename, $id, $this->id_field);
		}
	}