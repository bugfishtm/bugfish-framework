<?php 
	require_once DOL_DOCUMENT_ROOT.'/core/triggers/dolibarrtriggers.class.php';
	require_once DOL_DOCUMENT_ROOT . '/core/lib/admin.lib.php';
	class InterfaceXframeworkTriggers extends DolibarrTriggers {
		protected $db;
		public function __construct($db) {
			$this->db = $db;
			$this->name = preg_replace('/^Interface/i', '', get_class($this));
			$this->family = "demo";
			$this->description = "xframework triggers.";
			$this->version = 'development';
			$this->picto = 'xframework@xframework'; }

		/// Trigger for Commissions Calculating
		public function runTrigger($action, $object, User $user, Translate $langs, Conf $conf)	{
			if (empty($conf->xframework->enabled)) return 0;
			if(dolibarr_get_const($this->db, "XMOD_XF_TRGLOG", 1) == "on") { 
				d_trigger_triggers($this->db, @$action, @$object);
			
			}
			if(dolibarr_get_const($this->db, "XMOD_XF_CNGLOG", 1) == "on") { 
				d_trigger_changelog($this->db, @$action, @$object);
			}
			return 1;
		}
	}
