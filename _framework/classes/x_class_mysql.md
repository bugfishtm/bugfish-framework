# Classes Framework
	This is my personal framework, feel free to use it as you wish.  
	For help visit bugfish.eu!
	
## x_class_mysql
	The one and only x_class_mysql by bugfish! For MySQL Handling.
	Mysql / Tables (auto-installed optional) / Sessions for qt() / No Cookies

|Function|Description|
| --|-- |
| __construct($hostname, $username, $password, $database, $ovrcon = false)	 | Create the Class|
| mysqlcon		 | Connection Object |
| lasterror	| Last Error |
| insert_id	 | Last Insert ID |
| status()| Check if Current MySQL Object is true |
| ping()| Ping the MySQL Server |
| escape($val)| MySQLI Real Escape String a Value |
|backup_table($tablex, $filepath, $withdata = true, $dropstate = false)| Backup a Table to a File|
|displayError($exit = false)	|Display an Full Error Page which does look like a bluescreen if DB = Error|
---------------------
|Config Functions|Description|
|-|-|
| loggingSetup($bool, $table, $section = "")	| Disable (false) or Enable (true) Logging Function with a Table Name to Log and Creates Tables for Logging if not Exists |
|stoponexception($bool = false) | Exit Script on Exception Error|
|stoponerror($bool = false)| Stop on Error in Logerror? |
|printerror($bool = false)| Print MySQL Errors to Page if present|
---------------------
|Main Functions|Description|
|-|-|
|query($query, $bindarray = false)| Do a query with bind array if needed , Output able to be fetched - If you await multiple values and are using |
|select($query, $multiple = false, $bindarray = false, $fetch_type = MYSQLI_ASSOC| Do a select with bind array if needed|
|insert($table, $array, $bindarray = false)| Only Accepts One Insert Per Execution|
---------------------
|Result Query Functions|Description|
| --|-- |
|next_result()| Get Next Result Ressource in MySQL Connection|
|store_result()| Store Current Result Ressource|
|more_results() | Check if More Results|
|fetch_array($result) | Fetch array from Result |
|fetch_object($result) | Fetch Result as Object |
|free_result($result)| Free a Result |
|free_all($save = false)| Save can be "object" or "array" and will be returned as (all results which have been freed) this includes current result and next (all)|
---------------------
|Multi Query Functions|Description|
| --|-- |
|multi_query($sql)| Multi Query String without Filtering|
|multi_query_file($filepath)| Load MySQL File |
---------------------
|Values Functions|Description|
| --|-- |
|increase($table, $nameidfield, $id, $increasefield, $increasevalue = 1)	|Function to increase or decrease an int value|
|decrease($table, $nameidfield, $id, $decreasefield, $decreasevalue = 1)|	Function to increase or decrease an int value|
| get_row($table, $id, $row = "id")	| Get a Row |
| get_row_element($table, $id, $row = "id", $elementrow = "x", $fallback = false)| Get a Row Element with ID or Fallback |
| change_row_element($table, $id, $row = "id", $element = "x", $elementrow = "x")	| Change a Row Element with ID |
| exist_row($table, $id, $row = "id")	| Check if a Row with Ref Exits |
| get_rows($table, $id, $row = "id")	| Get Rows |
| del_row($table, $id, $row = "id")	| Delete a Row |
---------------------
|Counter Functions|Description|
| --|-- |
|qt($bool = false, $tablename = "querytimer", $section = "", $preecookie = "", $nodestruct = false)|Activate Query Timer will be saved in table with url. If you copy MySQL Connections with functions here, they will copy the config and also have a count on them, which does not interfere if the mysql class has been created out of another mysql-x class. Never start 2 different connections, if you need another connection, get one from a function (mysql connection to another database, server whatever)|
|qtc_get_cur()| Get Current Session Value|
|qtc_get($url = false)| Get UTC Counter for an URL (REQUEST-URI)|
|qtc_update()| At the End of Main Page to Update Counter in Database!|
---------------------
|Database Functions|Description|
| --|-- |
|database_delete($database)| Delete a database|
|database_create($database)| Create a database|
|database_object($database)| Get a New Object with another Database connected to|
|database_use($database)| Use Database with another Name |
|database_exists($database)| Check if database with name exists |
---------------------
|Table Functions|Description|
| --|-- |
|table_exists($tablename)| Check if Table Exists|
|table_delete($tablename)| Delete a Table|
|table_create($tablename)| Create a Table|
|auto_increment($table, $value)| Set Auto Increment Counter of a Table |
---------------------
|Transaction Functions|Description|
| --|-- |
|transaction($autocommit = false)	|Start a transaction|
|rollback()	|Rollback a transaction|
|transactionStatus()	|Check if a Transaction has been started|
|commit()	|Commit the current transaction	|
