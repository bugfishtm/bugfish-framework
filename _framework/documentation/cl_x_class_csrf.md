# Classes Framework
	This is my personal framework, feel free to use it as you wish.  
	For help visit bugfish.eu!
	
	

## x_class_csrf [Mastered]
	Class to create and handle CSRF keys.
	This class uses php sessions!
|Construct Function|Description|
| --|-- |
|__construct($cookie_extension = "", $second_valid = 300, $external_action = false)	| Constructor with Cookie Prestring, Valid time can be false and external_action true  to use in external Actions (created CSRF by Main Form then).|
--------------------------------------
|Config Function|Description|
| --|-- |
|isDisabled() | Check if renewal is disabled |
|norenewal($bool = true)	|Disable Key Renewal on Session at end of script |
|disableRenewal($bool = false)	|Disable Key Renewal on Session at end of script |
|external_action($bool = false)	|Enable to Disable Renewal for External Actions (optional if set in constructor or renewal deactivated) but needed for dynamic key function! |
--------------------------------------
|Dynamic Key Function |Description|
| --|-- |
|crypto() | Get Current needed Key for Action or Current if Set in Constructor / external_action function (if not specified us related functions) |
|time() | Get Current needed Key Time for Action or Current [if Set in Constructor / external_action function (if not specified us related functions)] |
|validate($code, $override_valid_time = false) | Check Code with current needed CSRF [If set in Constructor for external action / external_action function (if not specified us related functions)] |
--------------------------------------
|Current Key Function |Description|
| --|-- |
|get()	|Get new Generated Key for Forms|
|get_time()	|Get new Generated Key Time for Forms|
|getField($name, $id = "")|Print hidden Form Field with name and id attribute|
|getfield($name, $id = "")|Print hidden Form Field with name and id attribute|
|check($code, $ovr_valid_time = false)	|Check provided Code with Current CSRF Key|
--------------------------------------
|Last Key [Actions] Functions|Description|
| --|-- |
|get_lkey() / get_lkey_time()	|Get key/time from last page if exists else “undef”|
|get_lkey_time()|Get keytime from last page if exists else “undef”|
|check_lkey($code, $ovr_valid_time = false)	|Check provided Code with last CSRF Key for actions in where this class did use constructor setup for action or disable renewal!|