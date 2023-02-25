# Classes Framework
	This is my personal framework, feel free to use it as you wish.  
	For help visit bugfish.eu!
	
	
## x_class_log  
	Class for Logging in Code
	Mysql / Tables (auto-installed) / No Sessions / No Cookies
|Function|Description|
| --|-- |
|__construct($x_class_mysql, $tablename, $section = "") | Construct with an x_class_mysql object! Tablename for Table Name which should be created and Section is optional for multi sites!|
|message($message, $type = 3) | Write Message Notification or other Type  |
|notify($message)| Write Type 3 Notify | 
|warning($message)| Write Type 2 Warning | 
|error($message)| Write Type 1 Error  |
|reset($onlysection = false, $section_ovr = false)| Mass Delete Entries from Log Table  |