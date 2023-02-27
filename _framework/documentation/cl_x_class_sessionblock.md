# Classes Framework
	This is my personal framework, feel free to use it as you wish.  
	For help visit bugfish.eu!
	
	
## x_class_block [Mastered]
	Block actions by session counters with this class.. (only sessions)
	Does use php-sessions!

| Function|Description|
| --|-- |
|__construct($key, $maxcount, $time_seconds_block = false)| Construct with max Count value, Time until reset and pre cookie String ($key) |
|blocked() | Check if Session is above Max, if time_seconds_clock is expired, it will be reseted to 0 |
|increase() | Increase Session|
|decrease() | Decrease Session|
|reset() | 	Reset Session|