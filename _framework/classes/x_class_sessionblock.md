# Classes Framework
	This is my personal framework, feel free to use it as you wish.  
	For help visit bugfish.eu!
	
	
## x_class_sessionblock
	Block actions by session counters with this class.. (only sessions)
	No Mysql /No Tables / Sessions / No Cookies

| Function|Description|
| --|-- |
|__construct($key, $maxcount, $time_seconds_block = false)| Construct with max Count value, Time until reset and pre cookie String ($key) |
|blocked($expirable = false) | Check if Session is above Max if expirable = true check with Timing - Counter will be reseted if Timing Exceeded |
|increase() | Increase Session|
|decrease() | Decrease Session|
|reset() | 	Reset Session|