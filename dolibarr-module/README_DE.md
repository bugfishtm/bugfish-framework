
# xframework [934285]

## Allgemeine Information
Die Klassen und Funktionen aus dem Framework werden immer eingebunden, dafür muss das Modul nicht aktiv sein, nur die Anpassung der conf.php muss hierfür vorgenommen werden. Damit das Logging und die Ansichten funktionieren sollte das Modul aber aktiv sein.

## Installation
1. Das Modul in Dolibarr hochladen und installieren.
2. Dolibarr Config Datei (etc/dolibarr/conf.php) anpassen und folgendes am ende hinzufügen:

		if(file_exists(“/usr/share/dolibarr/htdocs/custom/xframework/remote/loader.php”)) {
		require_once(“/usr/share/dolibarr/htdocs/custom/xframework/remote/loader.php”);
		}

## Modul-Systeme
### Trigger and Object Logging

Trigger und Objektinformationen im Bezug zu diesem Trigger werden abgefangen und können in der Trigger Sektion unter Hilfsprogramme im Menüpunkt xFramework angeschaut werden. 

### Javascript Error Login

Javascript Fehlern die bei Nutzern entstanden sind können im Protokoll unter Hilfsprogramme -> xFramework -> Javascript Loggin eingesehen werden.

### MySQL Error Logging (only for querys used with x_class_mysql)

MySQL Fehlermeldungen die in Nutzung mit der x_class_mysql entstanden sind können in der Sektion unter Hilfsprogramme im Menüpunkt xFramework angeschaut werden.

### Mail Class Logging

Wenn die Logging Funktion der Mail Klasse eingeschaltet wurde, können hier Informationen zu fehlerhaften oder versendeten Mails eingesehen werden.

### Changelog für different Areas

Folgende Bereiche werden abgefangen: facture bank_account facture_fourn commande propal user societe product orderpicking expedition supplier_proposal commande_fournisseur fichinter [Dies sind die $ref] – Änderungen zu jeweiligen Bereichen kann man unter Hilfsprogramme – xFramework – Vorgangs Logs einsehen, wenn man die jeweiligen Rechte besitzt.

Folgende Felder werden ignoriert: tms rowid  
Felder sind mit folgendem präfix für Funktionen gekennzeichnet: mn_ [main table] xt_ [extrafield]

## Modul-Funktionen

### Schnelles MySQL/Mail Objekt und Einbinden von JS Funktionen

|Funktion | Beschreibung|
|-|-|
|x_c_mysql()|Create a Quick xMysql Object without Credentials|
|x_c_mail($host, $port, $auth, $user, $pass, $from_name, $from_mail)|Create a Quick xMailer Object, Host: example.de, port: 25/587/465, Auth: tls/ssl /false, User: username, Pass: pass, From_name: Sender Name, From_Mail: Sender Mail|
|x_l_js()|Load Content of Javascript Functions for JS Files |

### Function for Triggers to check for Changes

|Funktion | Beschreibung|
|-|-|
|d_get_change(\$db, $refid, $ref, $fieldname)|Get Array with x[from] x[to] else is false if error, maybe if this is a new process, Db -> doli db object, $refid -> id of current object, $ref -> table element, $fieldname -> database fieldname to check|
|d_is_change(\$db, $refid, $ref, $fieldname)|True if changed, False if not changed may error if this is first time this ref is added in database, Db -> doli db object, $refid -> id of current object, $ref -> table element, $fieldname -> database fieldname to check|

### Function to write Message to Module Messages Area


|Funktion | Beschreibung|
|-|-|
|d_message($db, $modulename, $message)|Write something to the modules message area, Db: db object from MITEC|
|message: Message you want to provide (filter if needed with $db->escape())| modulename: the name under which section the message appears in the message overview|

## Berechtigungen
| Name | Standard Aktiviert| Beschreibung|
|-|-|-|
| readchangelogs | Nein | Change Logging ansehen |
| readtriggers | Nein | Trigger Logging ansehen |
| readjs | Nein | Javascript Logging ansehen |
| readmail | Nein | Mail Logging ansehen  |
| readmysql | Nein | MySQL Logging ansehen |
| readmsg | Nein | Messages Logging ansehen|


## Einstellungen
Modul-Einstellungen und die Initialisieren die beim ersten Start durchgeführt werden sollte (einmalig für jeden Bereich) können in auf der Modul-Aktivierungsseite bei dem xFramework Modul unter dem Zahnrad eingestellt werden. (Admin Rechte erforderlich!)