<?php
	/*
		__________              _____.__       .__     
		\______   \__ __  _____/ ____\__| _____|  |__  
		 |    |  _/  |  \/ ___\   __\|  |/  ___/  |  \ 
		 |    |   \  |  / /_/  >  |  |  |\___ \|   Y  \
		 |______  /____/\___  /|__|  |__/____  >___|  /
				\/     /_____/               \/     \/  Doliabrr Trigger File Example */
	// Required Files
	require_once DOL_DOCUMENT_ROOT.'/core/triggers/dolibarrtriggers.class.php';
	require_once DOL_DOCUMENT_ROOT . '/core/lib/admin.lib.php';
	
	// The Actual Trigger Function
	// The Integer in the Files Name 10-99 Determines the Priotity - 99 is last trigger file to run!
	class InterfaceXframeworkTriggers extends DolibarrTriggers {
		/// Class Creation
		protected $db;
		public function __construct($db) {
			$this->db = $db;
			$this->name = preg_replace('/^Interface/i', '', get_class($this));
			$this->family = "demo";
			$this->description = "xframework triggers.";
			$this->version = 'development';
			$this->picto = 'xframework@xframework'; }

		/// Actual Trigger Function and Work
		public function runTrigger($action, $object, User $user, Translate $langs, Conf $conf)	{
			// Stop is Mod not Enabled
			if (empty($conf->xframework->enabled)) return 0;
			
			// If Activated, log Triggers
			if(dolibarr_get_const($this->db, "XMOD_XF_TRGLOG", 1) == "on") { 
				d_trigger_triggers($this->db, @$action, @$object);
			}
			
			// If Activated, log Changes
			if(dolibarr_get_const($this->db, "XMOD_XF_CNGLOG", 1) == "on") { 
				d_trigger_changelog($this->db, @$action, @$object);
			}
			return 1;
		}
	}
