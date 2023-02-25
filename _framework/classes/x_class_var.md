# Classes Framework
	This is my personal framework, feel free to use it as you wish.  
	For help visit bugfish.eu!
	
	
## x_class_var
	Class to control constants / setup variables and handling.
	Mysql / Tables (auto-installed) 
	/ Sessions for Setup Admin Pages CSRF / No Cookies
	
	If Section is false default section of class will be used, for 
	multi site change that, cos it may interfere...
|Function|Description|
| --|-- |
| __construct($mysql, $tablename, $descriptor = "descriptor", $value = "value", $description = "description") | Constructor with x_class_mysql object / tablename|
| const | If init function executed than the constants are in this array |
| sections($field, $section_name) | Set Sections for Constants|
|initAsConstant($section = false)| Init Vars as Constant|
|initAsArray($section = false)| Init Vars as Return Array|
|init($section = false)| Init Local Const Variable |
|addVar($name, $value, $section = false, $description = "")| Add a Variable|
|setVar($name, $value, $section = false, $addifnotexist = true)| Set or Add Variable|
|getVarFull($name, $section = false)|  Get a Full Array from Row of Table with This name Found 1st Hit|
|getVar($name, $section = false)| Get a Variable|
|delVar($name, $section = false)| Del a Variable|
|increaseVar($name, $section = false)| Increase a Variable|
|decreaseVar($name, $section = false)| Decrease a Variable|
|existVar($name, $section = false)| True if Var Exists|
|setupVar($name, $value, $descr, $section = false)| Setup Var if not Exists with description |
---------------------
|Admin Display|Description|
| --|-- |
|setup_int($varname, $section = false, $description = true, $addifnotexists = true, $precookie = "")| Display INT Change Field|
|setup_string($varname, $section = false, $description = true, $addifnotexists = true, $precookie = "")| Display String Change Field|
|setup_text($varname, $section = false, $description = true, $addifnotexists = true, $precookie = "")| Display Text Change Field|
|setup_bool($varname, $section = false, $description = true, $addifnotexists = true, $precookie = "")|Display Bool Change Field|
|setup_radio($varname, $array, $section = false, $description = true, $addifnotexists = true, $precookie = "")| Radio Field to Change a Var to new Value, Set Array [x][0] = name and [x][1] = value|
|setup_select($varname, $array, $section = false, $description = true, $addifnotexists = true, $precookie = "")| Select (single option) Field to Change a Var to new Value, Set Array [x][0] = name and [x][1] = value|
|setup_show($varname, $section = false, $description = true)| Only show a variable on the admin page quick|