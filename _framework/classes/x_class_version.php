<?php
	/* 
		 ______  _     _ _______ _______ _  ______ _     _ 
		(____  \(_)   (_|_______|_______) |/ _____|_)   (_)
		 ____)  )_     _ _   ___ _____  | ( (____  _______ 
		|  __  (| |   | | | (_  |  ___) | |\____ \|  ___  |
		| |__)  ) |___| | |___) | |     | |_____) ) |   | |
		|______/ \_____/ \_____/|_|     |_(______/|_|   |_|
		Copyright (C) 2024 Jan Maurice Dahlmanns [Bugfish]

		This program is free software; you can redistribute it and/or
		modify it under the terms of the GNU Lesser General Public License
		as published by the Free Software Foundation; either version 2.1
		of the License, or (at your option) any later version.

		This program is distributed in the hope that it will be useful,
		but WITHOUT ANY WARRANTY; without even the implied warranty of
		MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
		GNU Lesser General Public License for more details.

		You should have received a copy of the GNU Lesser General Public License
		along with this program; if not, see <https://www.gnu.org/licenses/>.
	*/
	
	class x_class_version {
		// Public Variables
		public $autor;
		public $contact;
		public $website;
		public $github;
		public $version;
		
		// Constructor to set values during instantiation
		public function __construct() {
			$this->autor   = "Bugfish (Jan-Maurice Dahlmanns)";
			$this->contact = "request@bugfish.eu";
			$this->website = "https://www.bugfish.eu";
			$this->github  = "https://github.com/bugfishtm/bugfish-framework";
			$this->version = "3.39";
		}
	
		// Optional: Prevent modifications after instantiation (using a private setter)
		public function __set($name, $value) {
			// This will prevent setting any value to a class property
			throw new Exception("x_class_version: Cannot modify class property: $name");
		}
		
	}
