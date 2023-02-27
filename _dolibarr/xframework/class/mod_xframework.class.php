<?php
	/*
		__________              _____.__       .__     
		\______   \__ __  _____/ ____\__| _____|  |__  
		 |    |  _/  |  \/ ___\   __\|  |/  ___/  |  \ 
		 |    |   \  |  / /_/  >  |  |  |\___ \|   Y  \
		 |______  /____/\___  /|__|  |__/____  >___|  /
				\/     /_____/               \/     \/  Doliabrr Class File Example */
// Include File for Class
require_once DOL_DOCUMENT_ROOT . '/core/class/commonobject.class.php';
// Write the Class and Functions belong to it!
class mod_xframework extends CommonObject {
	public function __construct(DoliDB $db) { global $conf, $langs, $user; $this->db = $db; }
}