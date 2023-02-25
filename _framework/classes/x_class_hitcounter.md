# Classes Framework
	This is my personal framework, feel free to use it as you wish.  
	For help visit bugfish.eu!
	
	
## x_class_hitcounter
	Class to count hits on pages!
	Mysql / Tables (auto-installed) / Sessions / No Cookies

|Function|Description|
| --|-- |
| __construct($x_class_mysql, $table, $precookie = "" )	 | Create the Class and Create Table if not Exists with x_class_mysql object and Precookie String is optional!|
|current_switch |Current Switch Value|
|current_arrive |Current Arrive Value|
|current_hits | Current Hits (Both Sum) Value |
|onlyarrivals($bool = false) |Only coutn arrivals to spare sessions storage | 
|enabled($bool = true)|Disable or Enable the Hits Check for this Page|
|clearget($bool = true)| Clear Get Varibales in Logged URL | 
|no404($bool = true)| Do not count on 404 Error Pages | 
|only200($bool = true)| Only Count if HTTP Code = 200 |
|show() | Show the Counters|
	
	Destructor Raises Counter!
