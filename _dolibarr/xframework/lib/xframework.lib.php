<?php
	/*
		__________              _____.__       .__     
		\______   \__ __  _____/ ____\__| _____|  |__  
		 |    |  _/  |  \/ ___\   __\|  |/  ___/  |  \ 
		 |    |   \  |  / /_/  >  |  |  |\___ \|   Y  \
		 |______  /____/\___  /|__|  |__/____  >___|  /
				\/     /_____/               \/     \/  Doliabrr Lib File Example */
	
	// Prepare Head for Tabs and Make Adjustable by dolibarr Functions
	function xframeworkPrepareHead($object) {
		global $db, $langs, $conf;
		$langs->load("xframework@xframework");
		$h = 0;
		$head = array();
		//$head[$h][0] = dol_buildpath("/xframework/views/card.php", 1).'?id='.$object->id;
		//$head[$h][1] = $langs->trans("Card");
		//$head[$h++][2] = 'card';
		complete_head_from_modules($conf, $langs, $object, $head, $h, 'xframework');
		return $head;
}