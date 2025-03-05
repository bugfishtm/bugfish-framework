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
	class x_class_2fa {
		
		private $secretKey;
		private $codeLength;
		
		public function __construct($secretKey, $codeLength = 6) {
			$this->secretKey = $secretKey;
			$this->codeLength = $codeLength;
		}
		
		// Generate a random secret key
		public static function generateSecretKey($length = 16) {
			return base64_encode(random_bytes($length));
		}
		
		// Generate a 2FA code
		public function generateCode() {
			$time = floor(time() / 30); // Time-based code, expires every 30 seconds
			$secret = base64_decode($this->secretKey);
			$time = pack('N', $time);
			$hash = hash_hmac('sha1', $time, $secret, true);
			$offset = ord(substr($hash, -1)) & 0x0F;
			$hash = substr($hash, $offset, 4);
			$value = unpack('N', $hash);
			$value = $value[1];
			$value = $value & 0x7FFFFFFF; // Remove the most significant bit
			$modulo = pow(10, $this->codeLength);
			return str_pad($value % $modulo, $this->codeLength, '0', STR_PAD_LEFT);
		}
		
		// Verify a 2FA code
		public function verifyCode($code) {
			$generatedCode = $this->generateCode();
			return hash_equals($generatedCode, $code);
		}
	}
