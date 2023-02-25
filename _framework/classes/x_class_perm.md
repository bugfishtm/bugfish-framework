# Classes Framework
	This is my personal framework, feel free to use it as you wish.  
	For help visit bugfish.eu!
	
	
## x_class_perm
	Class to control simple Permissions
	Mysql / Tables (auto-installed) / No Sessions / No Cookies
|Function|Description|
| --|-- |
|__construct($mysql, $tablename, $section = "", $ref = false)| Constructor with x_class_mysql object and Tablename, Section for Multisite use if optional! If User Ref is set, perm array of class will be auto intialized on construction!|
|perm| Array with Current Perms (If Set by function initPerm)|
|flush($ref) | Flush a Ref from the Perms Table|
|removePerm($ref, $permname) | Remove Permission Name from Ref|
|hasPerm($ref, $permname) | Check if Ref has Perm Name|
|addPerm($ref, $permname) | Add new Perm to Ref|
|getPerm($ref)| Get Perms array for Ref|
|initPerm($ref)| Update Perm Var with Perms from Ref|
|checkPerm($ref, $array, $or = false)| Check for Multiple Perms OR/AND|
|setPerm($ref, $array)| Add Array with Perm names to User and Delete old Perms (Renew with Array)|
|removePerms($ref)| Remove all Perms from a User|



