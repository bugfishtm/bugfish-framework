# Classes Framework
	This is my personal framework, feel free to use it as you wish.  
	For help visit bugfish.eu!
	
	
## x_class_debug [Mastered]
	Class for some PHP Benchmarks and Checks!
	
	If Section is false default section of class will be used, for 
	multi site change that, cos it may interfere...
|Function|Description|
| --|-- |
|error_screen($text)|Display Error Screen with Text|
|required_php_modules($array = array(), $errorscreen = false)|Check if Array is active all modules, if not return array with inactive modules|
|required_php_module($name, $errorscreen = false)|Check if required PHP Module is active|
|php_modules()|Get Current Loaded PHP Modules in Array|
|memory_usage()|Get Current Script Memory Usage|
|memory_limit()|Get Current Value of ini Setting|
|cpu_load()|Get Current CPU Load|
|timer()|Get Current Timer for Site Loading Time|
|upload_max_filesize()|Get Current Value of ini Setting|