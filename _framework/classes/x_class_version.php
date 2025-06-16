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
			$this->version = "3.38";
		}
	
		// Optional: Prevent modifications after instantiation (using a private setter)
		public function __set($name, $value) {
			// This will prevent setting any value to a class property
			throw new Exception("x_class_version: Cannot modify class property: $name");
		}
	}
