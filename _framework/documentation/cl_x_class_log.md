# Classes Framework
	This is my personal framework, feel free to use it as you wish.  
	For help visit bugfish.eu!
	
	
## x_class_log [Mastered]
	Class for Logging in Code
	Needs x_class_mysql object! Tables will be auto-installed upon first run.

|Constructor Function|Description|
| --|-- |
|__construct($x_class_mysql, $tablename, $section = "") | Construct with an x_class_mysql object! Tablename for Table Name which should be created and Section is optional for multi sites!|
---------------------------------------
|Misc Functions|Description|
| --|-- |
|list_get($limit = 50)| Get Log list as Array |
|list_clear()| Mass Delete Entries from Log Table |
---------------------------------------
|Message to Log Functions|Description|
| --|-- |
|message($message, $type = 3)| Write an Message to Log with own Type Number| 
|post($message, $type = 3)| Alias | 
|send($message, $type = 3)| Alias | 
|write($message, $type = 3)| Alias | 
---------------------------------------
|Notify Functions|Description|
| --|-- |
|notify($message)| Write an Type 3 Message to Log | 
|info($message)| Alias | 
---------------------------------------
|Warn Functions|Description|
| --|-- |
|warning($message)| Write an Type 2 Message to Log | 
|warn($message)| Alias | 
---------------------------------------
|Error Functions|Description|
| --|-- |
|error($message)| Write an Type 1 Message to Log | 
|failure($message)| Alias |
|err($message)| Alias |
|fail($message)| Alias |