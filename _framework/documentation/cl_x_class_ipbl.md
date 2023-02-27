# Classes Framework
	This is my personal framework, feel free to use it as you wish.  
	For help visit bugfish.eu!
	
	
## x_class_ipbl [Mastered]
	Class to control IP Blacklistings
	Needs x_class_mysql object! Tables will be auto-installed upon first run.
	
	To reset the blacklist, you should add a cronjob which deletes all entries of
	the related created tables which has been specified in the constructor! 
|Function|Description|
| --|-- |
|__construct($x_class_mysql, $tablename, $maxvalue = 50000) | Construct with x_class_mysql object and corrosponding Table Name. Max Value for Blocking is default 50000 |
---------------
|Check Block Functions|Description|
| --|-- |
|blocked($renew = false) | Check for Current Block State and Renew from Database if needed! |
|banned($renew = false) | Alias |
|isbanned($renew = false)| Alias	|
|isblocked($renew = false) | Alias |
---------------
|Fail Counter Functions|Description|
| --|-- |
|get_counter($renew = false) | Check for Current Counter State and Renew from Database if needed! |
|counter($renew = false) | Alias |
---------------
|Fail Raise Functions|Description|
| --|-- |
|raise($value = 1) | Raise Block Counter for Current IP x Failure Points! |
|increase($value = 1) | Alias |