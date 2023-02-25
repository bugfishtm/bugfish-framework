# Classes Framework
	This is my personal framework, feel free to use it as you wish.  
	For help visit bugfish.eu!
	
	

## x_class_csrf
	Class to create and handle CSRF keys.
	No Mysql / No Tables / Sessions / No Cookies
|Function|Description|
| --|-- |
|__construct($cookie_extension = "", $second_valid = 300, $disableRenew = false)	| Constructor with Cookie Prestring, Valid time can be false and disable Renew to use in external Actions (created CSRF by Main Form then).|
|overrideValidTime($seconds_valid) |	Override Valid time for Check Functions |
|disableRenewal($bool = true)	|Disable Key Renewal on Session at end of script |
|isDisabled() | Check if renewal is disabled |
|get()	|Get new Generated Key for Forms|
|getField($name, $id = "")|Print hidden Form Field with name and id attribute|
|get_lkey() / get_lkey_time()	|Get key/time from last page if exists else “undef”|
||Get keytime from last page if exists else “undef”|
|check($code, $ovr_valid_time = false)	|Provide form code to check with current CSRF|
|check_lkey($code, $ovr_valid_time = false)	|Provide form code to check with last CSRF	|

