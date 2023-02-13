<?php
include_once DOL_DOCUMENT_ROOT .'/core/modules/DolibarrModules.class.php';
require_once DOL_DOCUMENT_ROOT.'/core/lib/admin.lib.php';
class modxframework extends DolibarrModules {
	public function __construct($db) {
        global $langs,$conf;
        $this->db = $db;
		$this->numero = 934285;
		$this->rights_class = 'xframework';
		$this->family = "base";
		$this->module_position = '90';
		$this->name = preg_replace('/^mod/i','',get_class($this));
		$this->description = "xFramework Library and Logging Functions";
		$this->descriptionlong = "xFramework Library and Logging Functions";
		$this->editor_name = 'Bugfish Industries';
		$this->editor_url = 'https://www.bugfish.eu';
		$this->version = '2.0';
		$this->const_name = 'MAIN_MODULE_'.strtoupper($this->rights_class);
		$this->picto='xframework@xframework';

		$this->module_parts = array( 'triggers' => 1, 'login' => 0, 'substitutions' => 0, 'menus' => 0, 'theme' => 0, 'tpl' => 0, 'barcode' => 0, 'models' => 0, 'css' => array(), 'js' => array("/custom/xframework/js/xframework.js.php"), 'hooks' => array('main'), 'moduleforexternal' => 0 );

		// Data directories to create when module is enabled.
		$this->dirs = array();
		$this->config_page_url = array(DOL_URL_ROOT."/custom/xframework/admin/admin.php?mainmenu=home&leftmenu=");
		$this->hidden = false;
		$this->depends = array();
		$this->requiredby = array();
		$this->conflictwith = array();
		$this->langfiles = array();
		$this->need_dolibarr_version = array(4,0);
		$this->warnings_activation = array();
		$this->warnings_activation_ext = array();
		$this->const = array();

		if ( ! isset($conf->xframework ) || ! isset( $conf->xframework->enabled ) )
		{$conf->xframework=new stdClass();$conf->xframework->enabled=0;}

        $this->tabs = array();
		$this->dictionaries=array();
        $this->boxes = array();
		$this->cronjobs = array();
		$this->rights = array();	
		$r=0;
		$this->rights[$r][0] = $this->numero + $r;					// Permission id (must not be already used)
		$this->rights[$r][1] = 'xFramework Changelogs';			    // Permission label
		$this->rights[$r][3] = 0;									// Permission by default for new user (0/1)
		$this->rights[$r][4] = 'readchangelogs';	
		$this->rights[$r++][5] = '';						

		$this->rights[$r][0] = $this->numero + $r;					// Permission id (must not be already used)
		$this->rights[$r][1] = 'xFramework Triggers';			    // Permission label
		$this->rights[$r][3] = 0;									// Permission by default for new user (0/1)
		$this->rights[$r][4] = 'readtriggers';	
		$this->rights[$r++][5] = '';		

		$this->rights[$r][0] = $this->numero + $r;					// Permission id (must not be already used)
		$this->rights[$r][1] = 'xFramework Javascript';			    // Permission label
		$this->rights[$r][3] = 0;									// Permission by default for new user (0/1)
		$this->rights[$r][4] = 'readjs';	
		$this->rights[$r++][5] = '';	

		$this->rights[$r][0] = $this->numero + $r;					// Permission id (must not be already used)
		$this->rights[$r][1] = 'xFramework MySQL';			    // Permission label
		$this->rights[$r][3] = 0;									// Permission by default for new user (0/1)
		$this->rights[$r][4] = 'readmysql';	
		$this->rights[$r++][5] = '';			
		
		$this->rights[$r][0] = $this->numero + $r;					// Permission id (must not be already used)
		$this->rights[$r][1] = 'xFramework Messages';			    // Permission label
		$this->rights[$r][3] = 0;									// Permission by default for new user (0/1)
		$this->rights[$r][4] = 'readmsg';	
		$this->rights[$r++][5] = '';				

		
		$this->menu = array();
		$r = 0;
        $this->menu[$r++]=array('fk_menu'=>'fk_mainmenu=tools', 
								 'type'=>'left',
								 'titre'=>'xFramework',
								 'mainmenu'=>'tools',
								 'leftmenu'=>'xframeworkmenu',
								 'url'=>'/core/tools.php?mainmenu=tools&leftmenu=',
								 'position'=>50+$r,
								 'enabled'=>'$conf->xframework->enabled', 
								 'perms'=>1, 
								 'target'=>'',
								 'user'=>0); 
        $this->menu[$r++]=array('fk_menu'=>'fk_mainmenu=tools,fk_leftmenu=xframeworkmenu', 
								 'type'=>'left',
								 'titre'=>'xFramework Changes',
								 'mainmenu'=>'tools',
								 'leftmenu'=>'xframeworkmenu1',
								 'url'=>'/custom/xframework/views/changes.php?mainmenu=tools&leftmenu=xframeworkmenu',
								 'position'=>52+$r,
								 'enabled'=>'$conf->xframework->enabled', 
								 'perms'=>'$user->rights->xframework->readchangelogs', 
								 'target'=>'',
								 'user'=>0); 	 
        $this->menu[$r++]=array('fk_menu'=>'fk_mainmenu=tools,fk_leftmenu=xframeworkmenu', 
								 'type'=>'left',
								 'titre'=>'x-Framework Triggers',
								 'mainmenu'=>'tools',
								 'leftmenu'=>'xframeworkmenu2',
								 'url'=>'/custom/xframework/views/triggers.php?mainmenu=tools&leftmenu=xframeworkmenu',
								 'position'=>53+$r,
								 'enabled'=>'$conf->xframework->enabled', 
								 'perms'=>'$user->rights->xframework->readtriggers', 
								 'target'=>'',
								 'user'=>0); 	 
        $this->menu[$r++]=array('fk_menu'=>'fk_mainmenu=tools,fk_leftmenu=xframeworkmenu', 
								 'type'=>'left',
								 'titre'=>'x-Framework JS',
								 'mainmenu'=>'tools',
								 'leftmenu'=>'xframeworkmenu3',
								 'url'=>'/custom/xframework/views/js.php?mainmenu=tools&leftmenu=xframeworkmenu',
								 'position'=>54+$r,
								 'enabled'=>'$conf->xframework->enabled', 
								 'perms'=>'$user->rights->xframework->readjs', 
								 'target'=>'',
								 'user'=>0); 	  
        $this->menu[$r++]=array('fk_menu'=>'fk_mainmenu=tools,fk_leftmenu=xframeworkmenu', 
								 'type'=>'left',
								 'titre'=>'x-Framework MySQL',
								 'mainmenu'=>'tools',
								 'leftmenu'=>'xframeworkmenu5',
								 'url'=>'/custom/xframework/views/mysql.php?mainmenu=tools&leftmenu=xframeworkmenu',
								 'position'=>56+$r,
								 'enabled'=>'$conf->xframework->enabled', 
								 'perms'=>'$user->rights->xframework->readmysql', 
								 'target'=>'',
								 'user'=>0); 	 
        $this->menu[$r++]=array('fk_menu'=>'fk_mainmenu=tools,fk_leftmenu=xframeworkmenu', 
								 'type'=>'left',
								 'titre'=>'x-Framework Messages',
								 'mainmenu'=>'tools',
								 'leftmenu'=>'xframeworkmenu6',
								 'url'=>'/custom/xframework/views/messages.php?mainmenu=tools&leftmenu=xframeworkmenu',
								 'position'=>57+$r,
								 'enabled'=>'$conf->xframework->enabled', 
								 'perms'=>'$user->rights->xframework->readmsg', 
								 'target'=>'',
								 'user'=>0); 
							
	}

	public function init($options='') { $result = $this->_load_tables('/xframework/sql/'); 
	
	if(!dolibarr_get_const($this->db, "XMOD_XF_JSLOG", 1)){dolibarr_set_const($this->db,  "XMOD_XF_JSLOG", "off", 'chaine', 0, 'Log JS Errors - on/off', 1);}	
	if(!dolibarr_get_const($this->db, "XMOD_XF_TRGLOG", 1)){dolibarr_set_const($this->db, "XMOD_XF_TRGLOG", "off", 'chaine', 0, 'Log Triggers - on/off', 1);}	
	if(!dolibarr_get_const($this->db, "XMOD_XF_CNGLOG", 1)){dolibarr_set_const($this->db, "XMOD_XF_CNGLOG", "off", 'chaine', 0, 'Log Changes on Factures and Others - on/off', 1);}	
		
	$sql = array(); return $this->_init($sql, $options);}
	public function remove($options = '') { $sql = array(); return $this->_remove($sql, $options); }
}
