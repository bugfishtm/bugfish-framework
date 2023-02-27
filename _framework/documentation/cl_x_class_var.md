# Classes Framework
	This is my personal framework, feel free to use it as you wish.  
	For help visit bugfish.eu!
	
	
## x_class_var
	Class to control constants / setup variables and handling.
	Needs x_class_mysql object!
	/ Sessions for Setup Admin Pages CSRF
	
	
|Construct Function|Description|
| --|-- |	
| __construct($mysql, $tablename, $section = "", $descriptor = "descriptor", $value = "value", $description = "description", $sectionfield = "section", $idfield = "id")| Construct the Class with x_class_mysql_object|
------------------------------------------	
|Init Functions|Description|
| --|-- |	
|init_constant()|Init all Constants as Array|
|get_array()|Get Array with all Constants|
------------------------------------------	
|Vars Functions|Description|
| --|-- |	
|add($name, $value, $description = false, $overwrite = false)| Add Constant|
|setup($name, $value, $description = false)|Setup Constant|
|exists($name)| Exist Constant|
|get($name)|Get Constant|
|del($name)|Delete Constant|
|set($name, $value, $description = false, $add = true, $overwrite = true)| Set Constant|
|get_full($name)| Get Full Array of Constant|
------------------------------------------	
|Form Functions|Description|
| --|-- |
|form($varname, $type = "int", $selectarray = array())| Get a Form to Change a Setup Variable <br />int/string/bool/array/select/text / For SELECT Type you can Provide Select array with array(array(name, value))|