<?php
	/*
		__________              _____.__       .__     
		\______   \__ __  _____/ ____\__| _____|  |__  
		 |    |  _/  |  \/ ___\   __\|  |/  ___/  |  \ 
		 |    |   \  |  / /_/  >  |  |  |\___ \|   Y  \
		 |______  /____/\___  /|__|  |__/____  >___|  /
				\/     /_____/               \/     \/  Doliabrr Modules File Example */

// Include Dolibarr Modules File
include_once DOL_DOCUMENT_ROOT .'/core/modules/DolibarrModules.class.php';

// Include to get Constants (for above dolibarr_get_const() )
require_once DOL_DOCUMENT_ROOT.'/core/lib/admin.lib.php';

// Needed if you want to add or remove extrafields
include_once DOL_DOCUMENT_ROOT.'/core/class/extrafields.class.php';

// Class for the actual module
class modxframework extends DolibarrModules {
	// Contructor contains needed Module Informations
	public function __construct($db) {
        global $langs,$conf;
        $this->db = $db;
		// Id for module (must be unique).
		// Use here a free id (See in Home -> System information -> Dolibarr for list of used modules id).		
		$this->numero = 934285;
		// Key text used to identify module (for permissions, menus, etc...)		
		$this->rights_class = 'xframework';
		// Family can be 'base' (core modules),'crm','financial','hr','projects','products','ecm','technic' (transverse modules),'interface' (link with external tools),'other','...'
		// It is used to group modules by family in module setup page		
		$this->family = "base";
		// Module position in the family on 2 digits ('01', '10', '20', ...)	
		$this->module_position = '90';
		// Module label (no space allowed), used if translation string 'ModulexframeworkName' not found (xframework is name of module).			
		$this->name = preg_replace('/^mod/i','',get_class($this));		
		// Module description, used if translation string 'ModulexframeworkDesc' not found (xframework is name of module).		
		$this->description = "xframeworkDescription";
		// Used only if file README.md and README-LL.md not found.		
		$this->descriptionlong = "ModulexframeworkNameDesc";
		// Module Creator Informations
		$this->editor_name = 'Bugfish Industries';
		$this->editor_url = 'https://www.bugfish.eu';
		// Possible values for version are: 'development', 'experimental', 'dolibarr', 'dolibarr_deprecated' or a version string like 'x.y.z'
		$this->version = '2.1';
        // Url to the file with your last numberversion of this module
        // $this->url_last_version = 'http://www.example.com/versionmodule.txt';
		// Key used in llx_const table to save module status enabled/disabled (where xframework is value of property name of module in uppercase)		
		$this->const_name = 'MAIN_MODULE_'.strtoupper($this->rights_class);
		// Name of image file used for this module.
		// If file is in theme/yourtheme/img directory under name object_pictovalue.png, use this->picto='pictovalue'
		// If file is in module/img directory under name object_pictovalue.png, use this->picto='pictovalue@module'
		$this->picto='xframework@xframework';
		// Define some features supported by module (triggers, login, substitutions, menus, css, etc...)
		$this->module_parts = array( 
		    'triggers' => 1,                                 	// Set this to 1 if module has its own trigger directory (core/triggers)
			'login' => 0,                                    	// Set this to 1 if module has its own login method file (core/login)
			'substitutions' => 0,                            	// Set this to 1 if module has its own substitution function file (core/substitutions)
			'menus' => 0,                                    	// Set this to 1 if module has its own menus handler directory (core/menus)
			'theme' => 0,                                    	// Set this to 1 if module has its own theme directory (theme)
		    'tpl' => 0,                                      	// Set this to 1 if module overwrite template dir (core/tpl)
			'barcode' => 0,                                  	// Set this to 1 if module has its own barcode directory (core/modules/barcode)			
			'models' => 0,                                   	// Set this to 1 if module has its own models directory (core/modules/xxx)
			'css' => array("/custom/xframework/remote/css/xfpe_library.css"),	// Set this to relative path of css file if module has its own css file
	 		'js' => array("/custom/xframework/js/xframework.js.php"),      // Set this to relative path of js file if module must load a js on all pages
			'hooks' => array('all'),							// Set here all hooks context managed by module. To find available hook context, make a "grep -r '>initHooks(' *" on source code. You can also set hook context 'all'
			'moduleforexternal' => 0							// Set this to 1 if feature of module are opened to external users			
		);	
		// Data directories to create when module is enabled.
		$this->dirs = array();
		// Config Page for "Gear" in Module Overview
		$this->config_page_url = array(DOL_URL_ROOT."admin.php");
		// A condition to hide module
		$this->hidden = false;
		// Array with Module which depends this module [ MAY AUTO DISABLE OTHER MODULE IF THIS MODULES GETS DISABLES/ENABLED ]
		$this->depends = array();
		// Array with Module which require this module [ MAY AUTO DISABLE OTHER MODULE IF THIS MODULES GETS DISABLES/ENABLED ]
		$this->requiredby = array();
		// Array with Module Names which has conflict with this module [ MAY AUTO DISABLE OTHER MODULE IF THIS MODULES GETS DISABLES/ENABLED ]
		$this->conflictwith = array();
		// Load Lang files 
		$this->langfiles = array("xframework@xframework");
		// Minimum version of Dolibarr required by module
		$this->need_dolibarr_version = array(4,0);
		// Set Conf Enabled for this Module to 0 if not already is.
		if ( ! isset($conf->xframework ) || ! isset( $conf->xframework->enabled ) )
		{$conf->xframework=new stdClass();$conf->xframework->enabled=0;}
		// Warning to show when we activate module. array('always'='text') or array('FR'='textfr','ES'='textes'...)
		$this->warnings_activation = array();
		// Warning to show when we activate an external module. array('always'='text') or array('FR'='textfr','ES'='textes'...)
		$this->warnings_activation_ext = array();		

        // Where objecttype can be
		// 'categories_x'	  to add a tab in category view (replace 'x' by type of category (0=product, 1=supplier, 2=customer, 3=member)
		// 'contact'          to add a tab in contact view
		// 'contract'         to add a tab in contract view
		// 'group'            to add a tab in group view
		// 'intervention'     to add a tab in intervention view
		// 'invoice'          to add a tab in customer invoice view
		// 'invoice_supplier' to add a tab in supplier invoice view
		// 'member'           to add a tab in fundation member view
		// 'opensurveypoll'	  to add a tab in opensurvey poll view
		// 'order'            to add a tab in customer order view
		// 'order_supplier'   to add a tab in supplier order view
		// 'payment'		  to add a tab in payment view
		// 'payment_supplier' to add a tab in supplier payment view
		// 'product'          to add a tab in product view
		// 'propal'           to add a tab in propal view
		// 'project'          to add a tab in project view
		// 'stock'            to add a tab in stock view
		// 'thirdparty'       to add a tab in third party view
		// 'user'             to add a tab in user view
        $this->tabs = array();
		
		// This are not explained yet...
		$this->const = array();
		
		$this->dictionaries=array(
			/* Example:  $this->dictionaries=array(
				'langs'=>'mylangfile@xframework',
				'tabname'=>array(MAIN_DB_PREFIX."table1",MAIN_DB_PREFIX."table2",MAIN_DB_PREFIX."table3"),		// List of tables we want to see into dictonnary editor
				'tablib'=>array("Table1","Table2","Table3"),													// Label of tables
				'tabsql'=>array('SELECT f.rowid as rowid, f.code, f.label, f.active FROM '.MAIN_DB_PREFIX.'table1 as f','SELECT f.rowid as rowid, f.code, f.label, f.active FROM '.MAIN_DB_PREFIX.'table2 as f','SELECT f.rowid as rowid, f.code, f.label, f.active FROM '.MAIN_DB_PREFIX.'table3 as f'),	// Request to select fields
				'tabsqlsort'=>array("label ASC","label ASC","label ASC"),																					// Sort order
				'tabfield'=>array("code,label","code,label","code,label"),																					// List of fields (result of select to show dictionary)
				'tabfieldvalue'=>array("code,label","code,label","code,label"),																				// List of fields (list of fields to edit a record)
				'tabfieldinsert'=>array("code,label","code,label","code,label"),																			// List of fields (list of fields for insert)
				'tabrowid'=>array("rowid","rowid","rowid"),																									// Name of columns with primary key (try to always name it 'rowid')
				'tabcond'=>array($conf->xframework->enabled,$conf->xframework->enabled,$conf->xframework->enabled)												// Condition to show each dictionary
			);*/
		);

        $this->boxes = array(
			//0=>array('file'=>'testwidget1.php@xframework','note'=>'Widget provided by xFramework','enabledbydefaulton'=>'Home'),
			//1=>array('file'=>'testwidget2.php@xframework','note'=>'Widget provided by xFramework'),
			//2=>array('file'=>'testwidget3.php@xframework','note'=>'Widget provided by xFramework')
		);
		
		// Cronjobs (List of cron jobs entries to add when module is enabled)
		// unit_frequency must be 60 for minute, 3600 for hour, 86400 for day, 604800 for week
		$this->cronjobs = array(
			//0=>array('label'=>'MyJob label', 'jobtype'=>'method', 'class'=>'/xframework/class/myobject.class.php', 'objectname'=>'MyObject', 'method'=>'doScheduledJob', 'parameters'=>'', 'comment'=>'Comment', 'frequency'=>2, 'unitfrequency'=>3600, 'status'=>0, 'test'=>'$conf->xframework->enabled', 'priority'=>50)
		);
		// Example: $this->cronjobs=array(0=>array('label'=>'My label', 'jobtype'=>'method', 'class'=>'/dir/class/file.class.php', 'objectname'=>'MyClass', 'method'=>'myMethod', 'parameters'=>'param1, param2', 'comment'=>'Comment', 'frequency'=>2, 'unitfrequency'=>3600, 'status'=>0, 'test'=>'$conf->xframework->enabled', 'priority'=>50),
		//                                1=>array('label'=>'My label', 'jobtype'=>'command', 'command'=>'', 'parameters'=>'param1, param2', 'comment'=>'Comment', 'frequency'=>1, 'unitfrequency'=>3600*24, 'status'=>0, 'test'=>'$conf->xframework->enabled', 'priority'=>50)
		// );
		
		// Reset Counter for new Array
		$r = 0;		
		// Initialize Array for Rights
		$this->rights = array();
		// Declare a Right
		$this->rights[$r][0] = $this->numero + $r;					// Permission id (must not be already used)
		$this->rights[$r][1] = 'xFramework Changelogs';			    // Permission label
		$this->rights[$r][3] = 0;									// Permission by default for new user (0/1)
		$this->rights[$r][4] = 'readchangelogs';					// Permission Name for Variable
		$this->rights[$r++][5] = '';								// Permission Sub-Name for Variable
		// More Permissions for this Module
		$this->rights[$r][0] = $this->numero + $r;					// Permission id (must not be already used)
		$this->rights[$r][1] = 'xFramework Triggers';			    // Permission label
		$this->rights[$r][3] = 0;									// Permission by default for new user (0/1)
		$this->rights[$r][4] = 'readtriggers';	
		$this->rights[$r++][5] = '';		
		// More Permissions for this Module
		$this->rights[$r][0] = $this->numero + $r;					// Permission id (must not be already used)
		$this->rights[$r][1] = 'xFramework Javascript';			    // Permission label
		$this->rights[$r][3] = 0;									// Permission by default for new user (0/1)
		$this->rights[$r][4] = 'readjs';	
		$this->rights[$r++][5] = '';	
		// More Permissions for this Module
		$this->rights[$r][0] = $this->numero + $r;					// Permission id (must not be already used)
		$this->rights[$r][1] = 'xFramework MySQL';			    // Permission label
		$this->rights[$r][3] = 0;									// Permission by default for new user (0/1)
		$this->rights[$r][4] = 'readmysql';	
		$this->rights[$r++][5] = '';			
		// More Permissions for this Module
		$this->rights[$r][0] = $this->numero + $r;					// Permission id (must not be already used)
		$this->rights[$r][1] = 'xFramework Messages';			    // Permission label
		$this->rights[$r][3] = 0;									// Permission by default for new user (0/1)
		$this->rights[$r][4] = 'readmsg';	
		$this->rights[$r++][5] = '';				

		// Reset Counter for new Array
		$r = 0;		
		// Initialize Array for Menues
		$this->menu = array();
		/*
			// Main menu entries
			$this->menu = array(); // List of menus to add
			$r=0;
			// Add here entries to declare new menus
			// Example to declare the Top Menu entry:
			$this->menu[$r]=array( 'fk_menu'=>0, // Put 0 if this is a top menu
			'type'=>'top', // This is a Top menu entry
			'titre'=>'MyModule top menu',
			'mainmenu'=>'mymodule',
			'leftmenu'=>'mymodule',
			'url'=>'/mymodule/pagetop.php',
			'langs'=>'mylangfile', // Lang file to use (without .lang) by module. File must be in
			langs/code_CODE/ directory.
			'position'=>100,
			'enabled'=>'1', // Define condition to show or hide menu entry. Use
			'$conf->mymodule->enabled' if entry must be visible if module is enabled.
			'perms'=>'1', // Use 'perms'=>'$user->rights->mymodule->level1->level2' if you want
			your menu with a permission rules
			'target'=>'',
			'user'=>2); // 0=Menu for internal users, 1=external users, 2=both
			$r++;
			// Example to declare a Left Menu entry:
			$this->menu[$r]=array( 'fk_menu'=>'fk_mainmenu=xxx', // Use 'fk_mainmenu=xxx' or
			'fk_mainmenu=xxx,fk_leftmenu=yyy' where xxx is mainmenucode and yyy is a leftmenucode of parent menu
			'type'=>'left', // This is a Left menu entry
			'titre'=>'MyModule left menu 1',
			'mainmenu'=>'xxx',
			'leftmenu'=>'yyy',
			'url'=>'/mymodule/pagelevel1.php',
			'langs'=>'mylangfile', // Lang file to use (without .lang) by module. File must be in
			langs/code_CODE/ directory.
			'position'=>100,
			'enabled'=>'1', // Define condition to show or hide menu entry. Use
			'$conf->mymodule->enabled' if entry must be visible if module is enabled.
			'perms'=>'1', // Use 'perms'=>'$user->rights->mymodule->level1->level2' if you want
			your menu with a permission rules
			'target'=>'',
			'user'=>2); // 0=Menu for internal users,1=external users, 2=both
			$r++; 		
		*/
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
		// Another Module Related Tools-Page Sub-Menue
        $this->menu[$r++]=array('fk_menu'=>'fk_mainmenu=tools,fk_leftmenu=xframeworkmenu', 
								 'type'=>'left',
								 'titre'=>'Changelog',
								 'mainmenu'=>'tools',
								 'leftmenu'=>'xframeworkmenu1',
								 'url'=>'/custom/xframework/views/changes.php?mainmenu=tools&leftmenu=xframeworkmenu',
								 'position'=>52+$r,
								 'enabled'=>'$conf->xframework->enabled', 
								 'perms'=>'$user->rights->xframework->readchangelogs', 
								 'target'=>'',
								 'user'=>0); 
		// Another Module Related Tools-Page Sub-Menue
        $this->menu[$r++]=array('fk_menu'=>'fk_mainmenu=tools,fk_leftmenu=xframeworkmenu', 
								 'type'=>'left',
								 'titre'=>'Triggers',
								 'mainmenu'=>'tools',
								 'leftmenu'=>'xframeworkmenu2',
								 'url'=>'/custom/xframework/views/triggers.php?mainmenu=tools&leftmenu=xframeworkmenu',
								 'position'=>53+$r,
								 'enabled'=>'$conf->xframework->enabled', 
								 'perms'=>'$user->rights->xframework->readtriggers', 
								 'target'=>'',
								 'user'=>0); 	 
		// Another Module Related Tools-Page Sub-Menue
        $this->menu[$r++]=array('fk_menu'=>'fk_mainmenu=tools,fk_leftmenu=xframeworkmenu', 
								 'type'=>'left',
								 'titre'=>'Javascript Errors',
								 'mainmenu'=>'tools',
								 'leftmenu'=>'xframeworkmenu3',
								 'url'=>'/custom/xframework/views/js.php?mainmenu=tools&leftmenu=xframeworkmenu',
								 'position'=>54+$r,
								 'enabled'=>'$conf->xframework->enabled', 
								 'perms'=>'$user->rights->xframework->readjs', 
								 'target'=>'',
								 'user'=>0); 
		// Another Module Related Tools-Page Sub-Menue
        $this->menu[$r++]=array('fk_menu'=>'fk_mainmenu=tools,fk_leftmenu=xframeworkmenu', 
								 'type'=>'left',
								 'titre'=>'xMySQL Errors',
								 'mainmenu'=>'tools',
								 'leftmenu'=>'xframeworkmenu5',
								 'url'=>'/custom/xframework/views/mysql.php?mainmenu=tools&leftmenu=xframeworkmenu',
								 'position'=>56+$r,
								 'enabled'=>'$conf->xframework->enabled', 
								 'perms'=>'$user->rights->xframework->readmysql', 
								 'target'=>'',
								 'user'=>0); 
		// Another Module Related Tools-Page Sub-Menue
        $this->menu[$r++]=array('fk_menu'=>'fk_mainmenu=tools,fk_leftmenu=xframeworkmenu', 
								 'type'=>'left',
								 'titre'=>'Message System',
								 'mainmenu'=>'tools',
								 'leftmenu'=>'xframeworkmenu6',
								 'url'=>'/custom/xframework/views/messages.php?mainmenu=tools&leftmenu=xframeworkmenu',
								 'position'=>57+$r,
								 'enabled'=>'$conf->xframework->enabled', 
								 'perms'=>'$user->rights->xframework->readmsg', 
								 'target'=>'',
								 'user'=>0); 
	}

	// Will be Executed when Module is Activated on Administrator Page
	public function init($options='') { 
		// Load MySQL Files from sql Folder and Execute
		$result = $this->_load_tables('/xframework/sql/'); 
	
		// Initialize some Constants
		// dolibarr_get_const ($db, $name, $entity=1) //  dolibarr_set_const ($db, $name, $value, $type= 'chaine', $visible=0, $note= '', $entity=1)
		if(!dolibarr_get_const($this->db, "XMOD_XF_JSLOG", 1)){dolibarr_set_const($this->db,  "XMOD_XF_JSLOG", "off", 'chaine', 0, 'Log JS Errors - on/off', 1);}	
		if(!dolibarr_get_const($this->db, "XMOD_XF_TRGLOG", 1)){dolibarr_set_const($this->db, "XMOD_XF_TRGLOG", "off", 'chaine', 0, 'Log Triggers - on/off', 1);}	
		if(!dolibarr_get_const($this->db, "XMOD_XF_CNGLOG", 1)){dolibarr_set_const($this->db, "XMOD_XF_CNGLOG", "off", 'chaine', 0, 'Log Changes on Factures and Others - on/off', 1);}	
		
		// In case we need Extrafields
		$extrafields = new ExtraFields($this->db);
		// Now we can Add Some // Example Extrafield for Societe (will be added in societe_extrafields)
		/*	addExtraField ( $attrname,$label, $type, $pos,$size,$elementtype,$unique = 0,$required = 0,$default_value = '',
			$param = '',$alwayseditable = 0,$perms = '',$list = '-1',$help = '',$computed = '',$entity = '',$langfile = '',$enabled = '1',$totalizable = 0,$printable = 0)
			---------------------------------------------------------------------------------------------------------------------------------------------------------------
			Add a new extra field parameter.
			string $attrname Code of attribute
			string $label label of attribute
			string $type Type of attribute
			('boolean' ,'int','varchar','text','html','date','datehour','price','phone','mail','password','url','select','checkbox','separate',...)
			int $pos Position of attribute
			string $size Size/length definition of attribute ('5', '24,8', ...). For float, it contains 2 numeric separated with a comma.
			string $elementtype Element type. Same value than object->table_element (Example 'member', 'product', 'thirdparty', ...)
			int $unique Is field unique or not
			int $required Is field required or not
			string $default_value Defaulted value (In database. use the default_value feature for default value on screen. Example: '', '0', 'null',
			'avalue')
			array | string $param Params for field (ex for select list : array('options' => array(value'=>'label of option')) )
			int $alwayseditable Is attribute always editable regardless of the document status
			string $perms Permission to check
			string $list Visibilty ('0'=never visible, '1'=visible on list+forms, '2'=list only, '3'=form only or 'eval string')
			string $help Text with help tooltip
			string $computed Computed value
			string $entity Entity of extrafields (for multicompany modules)
			string $langfile Language file
			string $enabled Condition to have the field enabled or not
			int $totalizable Is a measure. Must show a total on lists
			int $printable Is extrafield displayed on PDF */
		//$extrafields->addExtraField('extrafieldnameindb', "TextLabelOrLangLabel", 'sellist', 1, 10, 'societe', 0, 0, '', 'a:1:{s:7:"a:1:{s:7:"options";a:1:{s:47:"tablename:name:id::";N;}}', 1, '', 1, 0, '', '', 'xframework@xframework', '$conf->xframework->enabled');
		// $extrafields-> delete('extrafieldnameindb', 'societe'); 
		// Close this Function
		return $this->_init(array(), $options);
	}
	
	// Will be executed if a module gets removed!
	public function remove($options = '') { 
		// Close this Function
		return $this->_remove(array(), $options);
	}
}
