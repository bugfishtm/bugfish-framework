# Dolibarr Module
	in Repository Folder[_dolimodule]
	A Module wich can be installed on dolibarr to make this framework
	available in code for Development. It has some additional
	extra functions like a changelog for different areas and more for
	debugging! 

## xframework [934285]
	This is a Dolibarr Module to include the Framework into Dolibarr
	with some additional Functions.
## General information
The classes and functions from the framework are always integrated, the module does not have to be active for this, only the adaptation of conf.php has to be made for this. However, the module should be active for logging and views to work.

## Installation
1. Upload and install the module in Dolibarr.
2. Adjust the Dolibarr config file (etc/dolibarr/conf.php) and add the following at the end:

		if(file_exists(“/usr/share/dolibarr/htdocs/custom/xframework/remote/loader.php”)) {
		require_once(“/usr/share/dolibarr/htdocs/custom/xframework/remote/loader.php”);
		}

## Module-Areas
### Trigger and Object Logging

Triggers and object information related to that trigger are intercepted and can be viewed in the Triggers section under Utilities in the xFramework menu item.

### Javascript Error Logging

Javascript errors caused by users can be viewed in the log under Utilities -> xFramework -> Javascript Loggin.

### MySQL Error Logging 
	Only logging querys used with x_class_mysql.

MySQL error messages that arose when using the x_class_mysql can be viewed in the section under Utilities in the menu item xFramework.

### Changelog for different Areas
The following areas are intercepted: facture bank_account facture_fourn commande propal user societe product orderpicking expedition supplier_proposal commande_fournisseur fichinter [These are the $ref] - Changes to the respective areas can be viewed under Utilities - xFramework - Process logs if you have the respective rights.

The following fields are ignored: tms rowid
Fields are marked with the following prefix for functions: mn_ [main table] xt_ [extrafield]

## Module-Functions

### Fast MySQL/Mail object and integration of JS functions

|Function | Description|
|-|-|
|x_c_mysql()|Create a Quick xMysql Object without Credentials|
|x_c_mail($host, $port, $auth, $user, $pass, $from_name, $from_mail)|Create a Quick xMailer Object, Host: example.de, port: 25/587/465, Auth: tls/ssl /false, User: username, Pass: pass, From_name: Sender Name, From_Mail: Sender Mail|
|x_l_js()|Load Content of Javascript Functions for JS Files |

### Function for Triggers to check for Changes

|Function | Description|
|-|-|
|d_get_change(\$db, $refid, $ref, $fieldname)|Get Array with x[from] x[to] else is false if error, maybe if this is a new process, Db -> doli db object, $refid -> id of current object, $ref -> table element, $fieldname -> database fieldname to check|
|d_is_change(\$db, $refid, $ref, $fieldname)|True if changed, False if not changed may error if this is first time this ref is added in database, Db -> doli db object, $refid -> id of current object, $ref -> table element, $fieldname -> database fieldname to check|

### Function to write Message to Module Messages Area
|Function | Description|
|-|-|
|d_message($db, $modulename, $message)|Write something to the modules message area, Db: db object from MITEC<br /><br />message: Message you want to provide (filter if needed with $db->escape())<br /><br /> modulename: the name under which section the message appears in the message overview|

## Permissions
| Name | Default Activated | Description|
|-|-|-|
| readchangelogs | No | View Change Logging |
| readtriggers | No | View Trigger Logging |
| readjs | No | View Javascript Logging |
| readmysql | No | View MySQL Logging |
| readmsg | No | View Messages Logging |

## Module settings
Module settings and initialization that should be performed on first start (once for each section) can be set in the module activation page at the xFramework module under the cogwheel. (Admin rights required!)

# Issues
If you encounter issues or have questions using this software, do not hesitate write us at our Forum on www.bugfish.eu !

# License
	For License Informations see License.md