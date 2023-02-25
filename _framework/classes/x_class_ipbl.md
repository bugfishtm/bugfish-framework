# Classes Framework
	This is my personal framework, feel free to use it as you wish.  
	For help visit bugfish.eu!
	
	
## x_class_ipbl
	Class to control IP Blacklistings
	Mysql / Tables (auto-installed) / No Sessions / No Cookies
|Function|Description|
| --|-- |
|__construct($x_class_mysql, $tablename, $maxvalue = 50000) | Construct with x_class_mysql object and corrosponding Table Name. Max Value for Blocking is default 50000 |
|blocked | True if Blocked without new Query to Check (faster)|
|isblocked() | Check if Current IP is Blocked|
|raise() | Raise Current IPs Counter	|
|counter($ip = false) | Get Value for Current or Optional current IP|