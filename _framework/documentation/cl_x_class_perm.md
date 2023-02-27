# Classes Framework
	This is my personal framework, feel free to use it as you wish.  
	For help visit bugfish.eu!
	
	
## x_class_perm [Mastered]
	Class to control simple Permissions
	Needs x_class_mysql object! Tables will be auto-installed upon first run.
|Construct Function|Description|
| --|-- |
|__construct($mysql, $tablename, $section = "")| Constructor with x_class_mysql object and Tablename, Section for Multisite use if optional!|
---------------------------------
|Config Functions|Description|
| --|-- |	
|section($section) | Optional: Change Current Section in Table for Perms |
|permission_set($array = false)
|permission_set_get()| Optional: Get the Current Permission Set |
---------------------------------
|Perm Functions|Description|
| --|-- |	
|get_perm($ref)<br />getPerm($ref)| Get Perms array for Ref |
|has_perm($ref, $name) <br /> hasPerm($ref, $name)|Check if Ref has Perm Name|
|add_perm($ref, $name) <br /> addPerm($ref, $name)|Add new Perm to Ref|
|check_perm($ref, $array, $or = false) <br />checkPerm($ref, $array, $or = false)|Check for Multiple Perms OR/AND| 
|remove_perm($ref, $permname) <br />removePerm($ref, $permname)|Remove Single Perm from a User|
|removePerms($ref)<br />remove_perms($ref)<br />clear_perms($ref)|Remove all Perms from a User |
|delete_ref($ref)|Flush a Ref from the Perms Table|
|item($ref, $permission_set = false)|Get Item Permission Object for Red (see Below)|

## x_class_perm_item [Mastered]
	This object can not be created by itself.  
	It needs to be obtained by getting it from the x_class_perm function:
	item($ref, $permission_set = false) [See above class description]
	
|Function |Description|
| --|-- |
|refresh()| Refresh the Item with Database Table Permissions |
|has_perm($permname)|Check if this item has a Permission Name Granted |
|add_perm($permname)| Add a Permission with Name to Ref |
|check_perm($array, $or = false)||
|remove_perm($permname)| Remove a Single perm with Name from Ref|
|remove_perms()| Remove all Permissions from this Ref |
|delete_ref()| Delete this Ref completely from Permission Table |
