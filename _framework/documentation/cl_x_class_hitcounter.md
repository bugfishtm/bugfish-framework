# Classes Framework
	This is my personal framework, feel free to use it as you wish.  
	For help visit bugfish.eu!
	
	
## x_class_hitcounter
	Class to count hits on pages!
	Needs x_class_mysql object! Tables will be auto-installed upon first run.
	This Class uses sessions (php)!

|Construct Function|Description|
| --|-- |
| __construct($x_class_mysql, $table, $precookie = "" )	 | Create the Class and Create Table if not Exists with x_class_mysql object and Precookie String is optional!|
----------------
|Execute Function|Description|
| --|-- |
|execute()| Executes the Counting Function for a Site if not Disabled by Config Function|
----------------
|Public Variables|Description|
| --|-- |
|switches |Current Switch Value|
|arrivals |Current Arrive Value|
|summarized | Current Hits (Both Sum) Value |
----------------
|Config Function|Description|
| --|-- |
|enabled($bool = true)|Disable or Enable the Hits Check for this Page|
|clearget($bool = true)| Clear Get Varibales in Logged URL | 