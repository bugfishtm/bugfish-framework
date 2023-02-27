# Classes Framework
	This is my personal framework, feel free to use it as you wish.  
	For help visit bugfish.eu!
	

## x_class_mail_template [Mastered]
	Class to handle mail templates and substitutions.
	A x_class_mysql object is needed!  
	Table will be auto-installed!
	
|Construct Functions|Description|
| --|-- |
|__construct($mysql, $table, $section = "")| Construct with x_class_mysql object, Table Name for Templates and Section name for Multi Site Use |
---------------------------------
|Substitution Functions|Description|
| --|-- |
|reset_substitution()| Reset Substitution Array|
|add_substitution($name, $replace)| Add Substitution to Array|
|do_substitute($text)| Enter Text and get back Substitutet|
---------------------------------
|Template Functions|Description|
| --|-- |
|set_template($name, $substitute = true, $header = false, $footer = false)| Set Template to Content from DB (overwrites set_content)|
|set_content($content)| Set Mail content (Overwrites set_template)|
|set_header($footer)| Set Mail Header|
|set_footer($footer)| Set Mail Footer|
|get($name, $substitute = true, $header = false, $footer = false)| Get a Template, if Footer is false than default header will be used, if true)
---------------------------------
|Send Functions|Description|
| --|-- |
|send($x_class_mail, $mail_subject, $receiver, $template, $cc = false, $bcc = false, $attach = false, $substitute = true, $header = false, $footer = false, $settings = array())| Send Mail with x_class_mail and Template Directly!|