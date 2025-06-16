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
	class x_class_crypt {
		private $algo = 'aes-256-cbc'; 
		
		// Constructor and choose algorythm
		function __construct($algo = 'aes-256-cbc') { $this->algo = $algo; }
		
		// Encrypt Data and Return
		public function encrypt($data, $key) {
			$encryption_key = base64_decode($key);
			$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->algo));
			$encrypted = openssl_encrypt($data, $this->algo, $encryption_key, 0, $iv);
			return base64_encode($encrypted . '::' . $iv);
		}		
		// Decrypt Data and Return
		public function decrypt($data, $key) {
			$encryption_key = base64_decode($key);
			list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
			return openssl_decrypt($encrypted_data, $this->algo, $encryption_key, 0, $iv);
		}		
	}
