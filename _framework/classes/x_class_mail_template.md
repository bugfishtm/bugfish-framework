# Classes Framework
	This is my personal framework, feel free to use it as you wish.  
	For help visit bugfish.eu!
	
	
## x_class_mail_template
	Class to handle mail templates and substitutions.
	Mysql / Tables (auto-installed) / No Sessions / No Cookies

|Function|Description|
| --|-- |
|__construct($x_class_mysql, $table, $section = "") | Constructor Section optional for multi site|
|set_header($header)| Set Header for all Templates in get Function|
|set_footer($footer)| Set Footer for all Templates in get Function|
|set_footer_substitute($substitute)| substitute current footer with array[0]["key"] / array[0]["replace"]|
|set_header_substitute($substitute)| substitute current header with array[0]["key"] / array[0]["replace"]|
|get($name, $substitute = false, $noheaders = false)| Get Template as String Variable |
|header| Current Header Saved Variable|
|footer| Current Footer Saved Variable|
|set_free_substitute($substitute, $text)| Subsitute a Free Variable|

