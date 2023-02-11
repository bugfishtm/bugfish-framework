# Bugfish Framework
	See www.bugfish.eu for informations (Forum or Wiki) 
	Or in Readme Files inside Folders.  This is 
	the Bugfish Framework, for easier Coding.  It Contains 
	different Classes and Functions, see below
	for instructions and library. Languages 
	are Javascript / Jquery / PHP / Html / CSS
	Classes should be all injection safe, as requests are
	made with sql-param-binds. But i do never guarantee! Peace out!

# Classes Framework
	This is my personal framework, feel free to use it as you wish.  
	For help visit bugfish.eu!

## x_class_curl
	Class to control a Curl Requests.
	No Mysql / No Tables / No Sessions / No Cookies
	  
|Function|Description|
| --|-- |
|last_info| last curl info out of last request|
|set_auth($username, $password)| Set Default Auth Basic|
|set_curldomain($path)| Set Default Curl Domain Pre-Extension|
|set_proxy($proxy_ip, $proxy_port, $proxy_pass = false, $proxy_prot = 'HTTP')| Set Proxy Settings|
|set_cert($cert_verifypeer, $cert_pemfile, $cert_pass = false)| Set SSL Cert Settings|
|xml_to_array($xml)|xml_to_array conversion|
|xml_to_json($xml)|xml_to_json conversion|
|json_to_array($json)|json_to_array conversion|
|json_to_xml($json)|json_to_xml conversion|
|array_to_xml($array)|array_to_xml conversion|
|array_to_json($array)|array_to_json conversion|
|auth_request($urlextension, $type, $header = false, $body = false, $ext = false, $ovr_domain = false, $ovr_username = false, $ovr_password = false, $proxy = false, $cert = false)| Request with Basic Auth |
|request($urlextension, $type,$body = false, $header = false, $ext = false, $ovr_domain = false, $proxy = false, $cert = false)|Request without Basic Auth |
|download($url, $localfile, $header = false, $ext = false, $proxy = false, $cert = false)| Download File from URL to Localfile |
|auth_upload($filepath, $header = false, $ext = false, $ovr_domain = false, $ovr_username = false, $ovr_password = false, $proxy = false, $cert = false)| Upload File with Authentication|
|upload($filepath, $type = "GET", $header = false, $ext = false, $ovr_domain = false, $proxy = false, $cert = false)| Upload File without Authentication|

## x_class_comment
	Class to control a commenting area.
	Mysql /Tables (auto-installed) / Sessions / No Cookies

|Function|Description|
| --|-- |
|__construct($x_class_mysql, $table, $precookie, $module, $target)| Class Construction with x_class_myqsl object, table name, pre cookie string, a module and target ID|
|upvote| Actual Upvote Counter |
|comment| Actual Comment Counter (Confirmed) |
|init_res| Returns Init Value if new Comment is Pushed for Notifications and more: // 1 - System Message Inserted// 2 - Vote OK// 3 - Comment Missing Fields// 4 - Comment Captcha Error// 5 - Comment OK |
|sys_name($name = "System")| Name of System Message Autor|
|sys_text($text = "Thanks for visiting my page and have a nice day!")| Default Message Text |
|vote_show()| Show Vote Box|
|comment_show($hide_system_msg = false)| Show Comments Box|
|comment_get($hide_system_msg = false)| Get Comments Current to Array in Return|
|form_show($captchaurl)| Show Form for new Comments|
|init($captcha_code_if_delivered = false)| Init with Configs (Before Show of Form) Handles new Comments and Votes |

## x_class_user
	Class to control users.
	Mysql /Tables (auto-installed) / Sessions / Cookies optional
|Constructor Function|Description|
| --|-- |
|__construct($x_class_mysql, $table_users, $table_sessions, $preecokie = "x_users_")| Construct with x_class_mysql object and Table names (will be auto-generated) Tables are for Users, Sessions|
------------
|Public Variables |Description|
| --|-- |
|ref| Array with References for Last Operation<br />Array with all Infos from corrosponding user - may "token" key with current useable token is existing. |
|mail_ref_user| Outdated Ref User ID to Send Mails To |
|mail_ref_token |Outdated Ref User Token to Send in Mails |
|mail_ref_receiver |Outdated Ref User Mail to Send Mails To |
|info/user| Array with Current User Informations from Table|
|perm|Variable for Perm Class when set up in config! perm_config($table, $section) |
|misc|Variable to use for external scripts not by this class. Feel free to use.|
|user_rank/rank| Users Rank |
|user_id/id| User ID |
|user_name/name| User Name |
|user_mail/mail| User Mail|
|loggedin/loggedIn/user_loggedIn/user_loggedin| True if user logged in|
------------
|Reference Return Variables (outdated)|Description|
| --|-- |
|$login_request_code|Return Code out of Login Functions|
|$rec_request_code|Return Code out of Recover Functions|
|$act_request_code|Return Code out of Activation Functions|
|$mc_request_code|Return Code out of Mail Change Functions|
------------
|Password Filter Function|Description|
| --|-- |
|pass_filter_setup($signs = 6, $capitals = true, $small = true, $special = true, $number = true)|Setup Password Filter Check Variable|
|pass_filter_check($passclear)||
------------
|Ajustment Function|Description|
| --|-- |
|multi_login($bool = false)| Allow Multi Login|
|login_recover_drop($bool = false)|Deactivate Password Reset Token on Successfull Login|
|login_field_manual($string)|Choose Custom Login Field which should be unique!|
|login_field_user()|User is for Login Primary(Unique)|
|login_field_mail()|Mail is for Login Primary(Unique)|
|mail_unique($bool = false)| Mails are unique |
|user_unique($bool = false)| Usernames are unique |
|log_ip($bool=false)| Log IPs in Session Table for All Keys |
|log_activation($bool=false)| Log Activation Session Table |
|log_session($bool=false)| Log Session Session Table|
|log_recover($bool=false)| Log Recover in Session Table|
|log_mail_edit($bool=false)| Log Mail Edits in Session Table |
|wait_activation_min($int = 6)| Activate Request Interval Minutes|
|wait_recover_min($int = 6)| Recover Request Interval Minutes|
|wait_mail_edit_min($int = 6)| Mail Edit Request Interval Minutes |
|min_activation($int = 6)|Activate Token Expire Minutes |
|min_recover($int = 6)|Recover Token Expire Minutes |
|min_mail_edit($int = 6)| Mail Edit Token Expire Minutes |
|perm_config($table, $section)| Set up Permissions Inits by Class itself (x_class_perm)|
|autoblock($int = false)| Activate Auto Block of User after X failed Logins, false for deactivate|
|sessions_days($int = 7)| Session Valid for X Days|
|cookies_use($bool = true)| Allow Use of Cookies|
|cookies_days($int = 7)| Cookies valid for X Days|
------------
|Token Config Functions|Description|
| --|-- |
|token_charset($charset = "0123456789")| Change Token Charset|
|token_length($length = 24)| Change Token Length |
|session_length($length = 24)| Change Session Length |
|session_charset($charset = "0123456789")|  Change Session Charset|
------------
|Password Functions|Description|
| --|-- |
|password_gen($len = 12, $comb = "abcde12345")| Generate a Key with Charset[Comb String] and Length|
|password_crypt($var, $hash = PASSWORD_BCRYPT)| Crypt a Cleartext Password|
|password_check($cleartext, $crypted)| Check Crypted Password Validation|
------------
|User Operation Functions|Description|
| --|-- |
|get($id)|Get User informations From ID|
|exists($id)|Check if user with id exists|
|usernameExists($ref)|Check if username exists|
|usernameExistsActive($ref)|Check if Username Exists confirmed User|
|refExists($ref)|Check if ref Exists|
|refExistsActive($ref)|Check if Ref Exists confirmed User|
| mailExists($ref)|Check if Mail Exists|
|mailExistsActive($ref)|Check if Mail Exists Confirmed User|
|delete($id)|Delete a User|
|logout_all()|Logout all Users|
|disable_user_session($id)|Disable a Users Session|
|delete_user_session($id)|Delete a Users Session|
|blocked_user($id)|Is User Blocked?|
|block_user($id)|Block User|
|unblock_user($id)|Unblock User|
|confirmed_user($id)|Check User Confirmation State|
|confirm_user($id)|Confirm User|
|unconfirm_user($id)|Unconfirm User|
|change_rank($id, $new)|Change User Rank|
|change_pass($id, $new)| Change User Pass |
|changeUserName($id, $new)| Change User Name|
|changeUserRef($id, $new)|Change User Ref|
|changeUserShadowMail($id, $new)|Change a Users Shadow Mail (Mail which is not activated Yet|
|changeUserMail($id, $new)| Change a Users Mail |
|addUser($name, $mail, $password = false, $rank = false, $activated = false, $delunconfirmedwhennew = false)| Add a New User|
|get_extra($id)| Get extradata as array from user (You can store your own data for user here in an array if needed, there is an extradata field in users table) |
|set_extra($id, $array)| Set extra data from array for user (You can store your own data for user here in an array if needed, there is an extradata field in users table) |
------------
|User Extrafield Functions|Description|
| --|-- |
|user_add_field| Add a Field to Users Database |
|user_del_field| Del a Field from Users Table (CAUTION) |
------------
|Check Token Functions|Description|
| --|-- |
|activation_token_valid($user, $token)| Check if Act Token Valid|
|recover_token_valid($user, $token)| Check if Recover Token Valid|
|mail_edit_token_valid($user, $token)| Check if Mail Edit Token Valid|
|session_token_valid($user, $token)| Check if Session Token Valid|
|activation_token_time($user, $token)| Get Time Token is still valid |
|recover_token_time($user, $token)| Get Time Token is still valid|
|mail_edit_token_time($user, $token)| Get Time Token is still valid|
|activation_request_time($user)| Get Time till next Request Possible |
|recover_request_time($user)| Get Time till next Request Possible|
|mail_edit_request_time($user)| Get Time till next Request Possible|
------------
|General Functions|Description|
| --|-- |
|init()|Init the Login with all Configs (Should run once after Configuration has been changed with adjustment functions|
|logout()|Logout the Current Logged In User|
|login_request($ref, $pass, $cookies= false)|Return Code: 5 - User not confirmed<br /> Return Code: 4 - User Blocked<br /> Return Code: 3 - Wrong Password<br /> Return Code: 2 -Ref does not exist <br />Return Code: 1 - Login Successfull <br /> 6- Pass Wrong and User Auto-Blocked after X tries (if activated)|
------------
|Activation Functions|Description|
| --|-- |
|activation_request_id($id)| Request Activation for Account with ID (fills Ref for example Mail Sending) <br /> 1 - Successfull <br /> 2 - Ref Not Found <br /> 3 - Already Active User ID|
|activation_request($ref)| Request Activation for Account with Ref from User  (fills Ref for example Mail Sending) <br /> 1 - Successfull <br /> 2 - Ref Not Found <br /> 3 - Interval not Reached between new Activation Requests <br /> 4 - Already Active User ID <br /> 5 - Activation for this user is blocked|
|activation_confirm($userid, $token)| Activate with Userid and Valid Token 	<br /> 1 - Successfull Created<br /> 2 - Reference not Found<br /> 3 - Token Invalid<br /> 4 - Activation Blocked for this user |
------------
|Reset Functions|Description|
| --|-- |
|recover_request_id($id)| Recover Request for Account ID (fills Ref for example Mail Sending) <br /> 1 - Successfull Created <br /> 2 - Reference not Found|
|recover_request($ref)| Recover Request for User by Ref (fills Ref for example Mail Sending) <br /> 1 - Successfull <br /> 2 - Reference not found <br /> 3 - Interval not Reached <br /> 4 - User Blocked for Resets <br /> |
|recover_confirm($userid, $token, $newpass)| Confirm Recover with new Password, Token and UseriD (fills Ref for example Mail Sending) <br /> 1 - Successfull <br /> 2 - Reference not found <br /> 3 - Token Error <br /> 4 - User Blocked for Resets|
------------
|Mail Edit Functions|Description|
| --|-- |
|mail_edit($id, $newmail, $nointervall = false)| Create New Shadow Mail <br /> 1 - Success <br /> 2 - Reference Not Found <br /> 3 - Interval for new Request not Reached <br /> 4 - Mail Exists <br /> 5 - User Blocked for Mail Change <br /> |
|mail_edit_confirm($userid, $token, $run = true, $runifdata = false)| Confirm Mail Edit <br /> 1 - Success <br /> 2 - Reference Not Found <br /> 3 - Token Expired <br /> 4 - Mail Exists Shadow Removed in Meantime <br /> 5 - User Blocked for Mail Change <br /> |
------------
|Display Function (optional)|Description|
| --|-- |
|display_return_code | Contains Return Codes<br />empty - Missing Fields <br >expired - CSRF Error <br >blocked - user blocked for operation <br >interval - interval time not reached <br >unknown - user ref unknown <br> ok - done success |
|display_return_type | Contains Return Type (error, warning, info, ok)|
|display_recover($title, $backbuttonurl = false,<br /> $reference = "Mail", $buttonstring = "Reset Password", $buttonbackstring = "Back to Login")| Display Recover Password with Ref Form|
| display_login($registerbuttonurl = false,<br /> $registerbuttonstring = "Register",<br /> $cookiecheckbox = false, $resetbuttonurl = false,<br /> $resetbuttonstring = "Reset",  $title = "Login",<br /> $label = "E-Mail") | Display Login Form <br> ok - Success <br /> expired - CSRF Error <br > blocked - User blocked  <br > unconfirmed - user not confirmed <br > unknown - user ref unknown <br> wrongpass - wrong password|
|display_reset($title = "Reset", <br />$backbuttonurl = false, <br />$buttonbackstring = "Back to Login")| Reset Password <br /> ok - success <br />unknown - ref Unknown <br />interval - Token Not Valid <br /> blocked - user blocked for reset <br />passmatch - Passwords do not match <br /> expired - CSRF error|
|display_register_unique_mail($title = "Reset",<br /> $backbuttonurl = false,<br /> $buttonbackstring = "Back to Login",<br /> $needusername = false, $captchaurl = false,<br /> $captchakey = false, $rank = 0,<br /> $confirmed = 0)| Display Register Form <br /> ok - success <br /> empty - missing fields <br /> expired - csrf error <br />error - user mail already registered

## x_class_sessionblock
	Block actions by session counters with this class.. (only sessions)
	No Mysql /No Tables / Sessions / No Cookies

| Function|Description|
| --|-- |
|__construct($key, $maxcount, $time_seconds_block = false)| Construct with max Count value, Time until reset and pre cookie String ($key) |
|blocked($expirable = false) | Check if Session is above Max if expirable = true check with Timing - Counter will be reseted if Timing Exceeded |
|increase() | Increase Session|
|decrease() | Decrease Session|
|reset() | 	Reset Session|

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

## x_class_mail
	Class to handle mail Sending.
	Mysql optional / optional Tables (auto-installed)
	 / No Sessions / No Cookies

	 PHPMAILER CLASS HAS BEEN USED FOR THIS CLASS.
	 PHPMailer - PHP email creation and transport class.
	 PHP Version 5.5.
	 @see https://github.com/PHPMailer/PHPMailer/ The PHPMailer GitHub project
	 @author    Marcus Bointon (Synchro/coolbru) <phpmailer@synchromedia.co.uk>
	 @author    Jim Jagielski (jimjag) <jimjag@gmail.com>
	 @author    Andy Prevost (codeworxtech) <codeworxtech@users.sourceforge.net>
	 @author    Brent R. Matzelle (original founder)
	 @copyright 2012 - 2020 Marcus Bointon
	 @copyright 2010 - 2012 Jim Jagielski
	 @copyright 2004 - 2009 Andy Prevost
	 @license   http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
	  @note      This program is distributed in the hope that it will be useful - WITHOUT
	 ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
	 FITNESS FOR A PARTICULAR PURPOSE.
	
|Function|Description|
| --|-- |
| __construct($host, $port = 25, $auth_type = false, $user = false, $pass = false) | Construct with Connection data Auth Type can be ssl or tls|
|logEnable($x_class_mysql, $table, $mode = 1, $section = "") |Enable Logging Mode 1  = ALL Mode 2 = Failed Mode 3 = Only OK Mails|
|logDisable($bool = false)| Disable Log |
| debugmessage	|Last Debug Message From Last Mail Tried to Send or Sended|
|initFrom($mail, $name)| Init From Sender Mail |			
|CharSet($charset) | Set Charset|
|initReplyTo($mail, $name) |Set Reply To|
|Encoding($encode) | Set Mail Enconding|
|debugLevel($int) |(1-3 3 is highest) Set Debug Level for Mail Sending|
|change_default_template($header, $footer) | Set all Mails to default Header and Footer if no Override by Function|
|all_default_html($bool) | Set all Mails to default HTML if no Override by Function|
|enableTestMode($val) | Override all Send Mails to another|
|allow_insecure_ssl_connections($bool) | Allow Insecure TLS Connections|
|keep_alive($bool = false) | Keep SMTP Connection Alive between Mails|
|send($to, $toname, $title, $mailContent, $attachments = false, $ishtml = false, $FOOTER = false, $HEADER = false)	|"to" / "attachments" can be array with $a["mail"], $a["name"] / attachments can be array with filepath for upload OUTDATED|
|execute($receiver, $subject, $content, $bcc = false, $cc = false, $addAttachment = false, $settings = false)| New updated Function to send Mail (See Row Below)|
|execute_templated($x_class_mysql, $template_table, $template_name, $receiver, $subject, $substitute = false, $template_section = "", $content = "", $bcc = false, $cc = false, $addAttachment = false, $settings = false)| Settings Values may be in array as key: <br />replyto  / replyto_name / sender  / sender_name  / header  / footer  / AllowInsecureConnection / isHTML  /  Encoding  / CharSet  /  SMTPDebug / SMTPKeepAlive / Port  /  SMTPSecure / Password / Username / SMTPAuth / Host <br /> <br />$receiver/bcc/css/attachments are handled as follow: <br /> - Can be String with Mail / Filepath <br /> - Can be Array [0] - Mail [1] - Name <br />- Can be Multi Array  [0][0] Mail [0][1] Name<br />This does not send multiple mails, only one mail per function. See Mass Mail Function for Mass Mail Template Send below.<br /><br />In this Function for "templated" you can provide an x_mysql object, template name and template table as optional template section to send a mail directly with an x_class_mail_template object without initizalizing it!<br /><br /> Substitutions will be done on all data but name and Mail of users.<br />array[0]["key"] / array[0]["replace"] <br />|
|execute_templated_mass($x_class_mysql, $template_table, $template_name, $receiver, $subject, $substitute = false, $template_section = "", $content = "", $bcc = false, $cc = false, $addAttachment = false, $settings = false)| Same function as one row above, but here ONLY the receiver variable has one more level, so multi mail sending with a template is possible to preserve loading time. KEEP IN MIND. Only Receivers are Multi Mail here. BCC / CSS / Attachments will stay the same on all mails! Just Receivers cant see each other, its they are not in the same Level 0 Array

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
## x_class_mysql
	The one and only x_class_mysql by bugfish! For MySQL Handling.
	Mysql / Tables (auto-installed optional) / Sessions for qt() / No Cookies

|Function|Description|
| --|-- |
| __construct($hostname, $username, $password, $database, $ovrcon = false)	 | Create the Class|
| mysqlcon		 | Connection Object |
| lasterror	| Last Error |
| insert_id	 | Last Insert ID |
| status()| Check if Current MySQL Object is true |
| ping()| Ping the MySQL Server |
| escape($val)| MySQLI Real Escape String a Value |
|backup_table($tablex, $filepath, $withdata = true, $dropstate = false)| Backup a Table to a File|
|displayError($exit = false)	|Display an Full Error Page which does look like a bluescreen if DB = Error|
---------------------
|Config Functions|Description|
|-|-|
| loggingSetup($bool, $table, $section = "")	| Disable (false) or Enable (true) Logging Function with a Table Name to Log and Creates Tables for Logging if not Exists |
|stoponexception($bool = false) | Exit Script on Exception Error|
|stoponerror($bool = false)| Stop on Error in Logerror? |
|printerror($bool = false)| Print MySQL Errors to Page if present|
---------------------
|Main Functions|Description|
|-|-|
|query($query, $bindarray = false)| Do a query with bind array if needed , Output able to be fetched - If you await multiple values and are using |
|select($query, $multiple = false, $bindarray = false, $fetch_type = MYSQLI_ASSOC| Do a select with bind array if needed|
|insert($table, $array, $bindarray = false)| Only Accepts One Insert Per Execution|
---------------------
|Result Query Functions|Description|
| --|-- |
|next_result()| Get Next Result Ressource in MySQL Connection|
|store_result()| Store Current Result Ressource|
|more_results() | Check if More Results|
|fetch_array($result) | Fetch array from Result |
|fetch_object($result) | Fetch Result as Object |
|free_result($result)| Free a Result |
|free_all($save = false)| Save can be "object" or "array" and will be returned as (all results which have been freed) this includes current result and next (all)|
---------------------
|Multi Query Functions|Description|
| --|-- |
|multi_query($sql)| Multi Query String without Filtering|
|multi_query_file($filepath)| Load MySQL File |
---------------------
|Values Functions|Description|
| --|-- |
|increase($table, $nameidfield, $id, $increasefield, $increasevalue = 1)	|Function to increase or decrease an int value|
|decrease($table, $nameidfield, $id, $decreasefield, $decreasevalue = 1)|	Function to increase or decrease an int value|
| get_row($table, $id, $row = "id")	| Get a Row |
| get_row_element($table, $id, $row = "id", $elementrow = "x", $fallback = false)| Get a Row Element with ID or Fallback |
| change_row_element($table, $id, $row = "id", $element = "x", $elementrow = "x")	| Change a Row Element with ID |
| exist_row($table, $id, $row = "id")	| Check if a Row with Ref Exits |
| get_rows($table, $id, $row = "id")	| Get Rows |
| del_row($table, $id, $row = "id")	| Delete a Row |
---------------------
|Counter Functions|Description|
| --|-- |
|qt($bool = false, $tablename = "querytimer", $section = "", $preecookie = "", $nodestruct = false)|Activate Query Timer will be saved in table with url. If you copy MySQL Connections with functions here, they will copy the config and also have a count on them, which does not interfere if the mysql class has been created out of another mysql-x class. Never start 2 different connections, if you need another connection, get one from a function (mysql connection to another database, server whatever)|
|qtc_get_cur()| Get Current Session Value|
|qtc_get($url = false)| Get UTC Counter for an URL (REQUEST-URI)|
|qtc_update()| At the End of Main Page to Update Counter in Database!|
---------------------
|Database Functions|Description|
| --|-- |
|database_delete($database)| Delete a database|
|database_create($database)| Create a database|
|database_object($database)| Get a New Object with another Database connected to|
|database_use($database)| Use Database with another Name |
|database_exists($database)| Check if database with name exists |
---------------------
|Table Functions|Description|
| --|-- |
|table_exists($tablename)| Check if Table Exists|
|table_delete($tablename)| Delete a Table|
|table_create($tablename)| Create a Table|
|auto_increment($table, $value)| Set Auto Increment Counter of a Table |
---------------------
|Transaction Functions|Description|
| --|-- |
|transaction($autocommit = false)	|Start a transaction|
|rollback()	|Rollback a transaction|
|transactionStatus()	|Check if a Transaction has been started|
|commit()	|Commit the current transaction	|

## x_class_hitcounter
	Class to count hits on pages!
	Mysql / Tables (auto-installed) / Sessions / No Cookies

|Function|Description|
| --|-- |
| __construct($x_class_mysql, $table, $precookie = "" )	 | Create the Class and Create Table if not Exists with x_class_mysql object and Precookie String is optional!|
|current_switch |Current Switch Value|
|current_arrive |Current Arrive Value|
|current_hits | Current Hits (Both Sum) Value |
|onlyarrivals($bool = false) |Only coutn arrivals to spare sessions storage | 
|enabled($bool = true)|Disable or Enable the Hits Check for this Page|
|clearget($bool = true)| Clear Get Varibales in Logged URL | 
|no404($bool = true)| Do not count on 404 Error Pages | 
|only200($bool = true)| Only Count if HTTP Code = 200 |
|show() | Show the Counters|
	
	Destructor Raises Counter!
## x_class_referer
	Class to catch referers!	
	Mysql / Tables (auto-installed) / Sessions / No Cookies

|Function|Description|
| --|-- |
|__construct($x_class_mysqlvar, $table, $refurlnowww)| Constructor with x_mysql_class object and table name and URL without WWW and HTTP/S|
|enabled($bool = true) | Disable / Enable for this Page |

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
## x_class_log  
	Class for Logging in Code
	Mysql / Tables (auto-installed) / No Sessions / No Cookies
|Function|Description|
| --|-- |
|__construct($x_class_mysql, $tablename, $section = "") | Construct with an x_class_mysql object! Tablename for Table Name which should be created and Section is optional for multi sites!|
|message($message, $type = 3) | Write Message Notification or other Type  |
|notify($message)| Write Type 3 Notify | 
|warning($message)| Write Type 2 Warning | 
|error($message)| Write Type 1 Error  |
|reset($onlysection = false, $section_ovr = false)| Mass Delete Entries from Log Table  |

## x_class_ipbl
	Class to control IP Blacklistings
	Mysql / Tables (auto-installed) / No Sessions / No Cookies
|Function|Description|
| --|-- |
|__construct($x_class_mysql, $tablename, $maxvalue = 50000) | Construct with x_class_mysql object and corrosponding Table Name. Max Value for Blocking is default 50000 |
|blocked | True if Blocked without new Query to Check (faster)|
|isblocked() | Check if Current IP is Blocked|
|raise() | Raise Current IPs Counter	|
|counter($ip = false) | Get Value for Current or Optional current IP|

## x_class_csrf
	Class to create and handle CSRF keys.
	No Mysql / No Tables / Sessions / No Cookies
|Function|Description|
| --|-- |
|__construct($cookie_extension = "", $second_valid = 300, $disableRenew = false)	| Constructor with Cookie Prestring, Valid time can be false and disable Renew to use in external Actions (created CSRF by Main Form then).|
|overrideValidTime($seconds_valid) |	Override Valid time for Check Functions |
|disableRenewal($bool = true)	|Disable Key Renewal on Session at end of script |
|isDisabled() | Check if renewal is disabled |
|get()	|Get new Generated Key for Forms|
|getField($name, $id = "")|Print hidden Form Field with name and id attribute|
|get_lkey() / get_lkey_time()	|Get key/time from last page if exists else “undef”|
||Get keytime from last page if exists else “undef”|
|check($code, $ovr_valid_time = false)	|Provide form code to check with current CSRF|
|check_lkey($code, $ovr_valid_time = false)	|Provide form code to check with last CSRF	|


# Function Framework
	This is a set of functions to use when building a webpage.
## xfp_library
|Runtime Variable|Description|
|--|--|
|\_XFP_MAIN_SEOVAR\_| Htaccess URL Get Variable |
| \_XFP_ADMIN_NAME\_ | Administrator Name for Meta |
| \_XFP_ADMIN_MAIL\_| Administrator Mail for Meta |
| \_XFP_LANG\_ | Language for Website (en, de) for Meta |
| \_XFP_META_TITLE_PRE\_ | Before Meta Title |
| \_XFP_META_TITLE_POST\_ | After Meta Title|
| \_XFP_META_DESC_PRE\_ | Before Meta Title |
| \_XFP_META_DESC_POST\_ | After Meta Title|
| \_XFP_THEME\_ | Current Theme Name|
| \_XFP_COOKIES\_ | Cookies Prefix |
| \_XFP_PATH\_ | Path to File Document Root Folder |
| \_XFP_THEMESPIN\_ | Random Themespin (yes/no) |
-------------------------
|Meta Function Name|Description|
|--|--|
|xfp_meta_error($object = false, $code = 404, $image = false, $cssarray = false, $setcode = true, $ext = "", $docstart = true)| Print Meta Error|
|xfp_meta_prep($val, $maxlength = 350)| Prepare Text for Meta |
| xfp_meta($object, $title, $description, $keywords = false, $robots = false, $cssarray = false, $img = false, $formexpire =  false, $fallbackimage = false, $nocache = true, $canonical = false, $docstart = true, $ext = "", $favicon = false)| Write Meta Content |
-------------------------
|Message Function Name|Description|
|--|--|
|xfp_etb_ok($text)| Event Box |
|xfp_etb_warning($text) (warn possitble)|Event Box Function|
|xfp_etb_error($text)|Event Box Function |
|xfp_etb_info($text)|Event Box Function |
-------------------------
|Build Function Name|Description|
|--|--|
|xfp_footer($text) | Build Footer |
|xfp_entry($var, $x, $level = 0) | Check Location for Case in Index |
|xfp_headline($title, $titlesec) | Build Headline |
| xfp_top_button($cssclasses = "") | Build Top Button below Headline |
|xfp_return_button($cssclasses = "") | Build Top Back Button below Headline|
| xfp_top_button_print($url, $cssclasses = "") | Print Button on Top|
|xfp_theme()| Get Current Theme Name|
-------------------------
|Navigation Function Name|Description|
|--|--|
|xfp_navi_end() |End of Navigation |
|xfp_navi_start($searchpage = false", $searchparam_sc = "", $navi_image = false)|Start of Navigation |
|xfp_navi_item($navname, $url, $titlealt, $level = 0, $isonempty = false) | Spawn Navigation Item |
|xfp_navi_location_seo($param = \_XFP_MAIN_SEOVAR\_) | Get Location |
-------------------------
|Website Function Name|Description|
|--|--|
|xfp_website_create_table($mysql, $tablename, $query)| Create Table if not Exists|
|xfp_website_init($title, $meta_ext, $section)| Get Object for use in settings.php of xfp-template|

## x_library
	This is a set of usefull functions for different purposes.
|Function Name|Description|
|--|--|
| x_firstimagetext($text, $all = false) | Get first Image URL from Text |
| x_thumbnail($url, $filename, $width = 600, $height = true) | Create Thumbnail from URL to Local JPG |
| x_connection_check($host, $port, $timeout = 1) | Check a Connection with fsockopeny|
|x_inCLI()| True if current script runs in CLI|
| x_rmdir($dir) | Recursive Delete Directory|
|x_html_redirect($url, $seconds = 0)| HTML Redirect|
|x_isset($val)|  	equal to !empty|
|x_imgValid($url)	|Is a valid image URL = True|
|x_contains_cyrillic($val)	|(True if Cyrillic in String)|
|x_contains_bad_word($val)	|(Simple Bad word Filter)|
|x_contains_url($val)	|(Check if String Contains URL)|
|x_getint($val)	|Get Parameter Get if Int|
|x_postint($val)	|Same for Post|
|x_get($val)	|Get GET Param|
|x_post($val)	|Get Post Param	|
|x_hsc($string)| htmlspecialchars alias |
| x_structdata_article($publisher_name, $publisher_logo, $publisher_website, $image, $url, $title, $published_date, $modified_date) |Struct Data for Article |
|x_structdata_websoftware($publisher_name, $publisher_logo, $publisher_website, $image, $url, $title, $published_date, $modified_date)| Struct Data for Websoftware|
|x_table_simple($array, $titlelist, $tableid = "x_table_simple", $alignarray = false)	|Print a Simple Table|
|x_table_complex($array, $titlelist, $formid = "", $alignarray = false)	|Print a Complex Table with Search Function and Ordering|
|x_table_div($array, $titlelist, $alignarray = false, $percentarray = false, $title = false)	|Build a Table with Divs for Responsive	|
|x_executionButton($db, $name, $url, $query, $get, $msgerr = "Fehler!", $msgok = "Erfolgreich!", $break = false, $style = "")| Button with Execution |
|x_button($name, $url, $break = false, $style = "", $reacttourl = true) | Button Without Execution
|x_eventBoxPrep($text, $type = "x", $precookie = "", $morecss = "", $buttontext = "X", $imgok = false, $imgfail = false, $imgwarn = false, $imgelse = false)	| Prepare EventBox / Only one is Possible with this Function - text = the message   - type = error/warning/ok/[undefined] for different styles   - precookie = prestring for cookie   - morecss = tags direct inside style element of html element  -$buttontext = Text of the button to Close|
|x_eventBoxShow($precookie = "")	| Include at End or Start of the Page to display Eventbox Content|
|x_eventBoxSet() |True if Event Box is Prepared, False if not (Set)|
|x_cookieBanner($precookie = "", $method = 'post', $text = false)	| Cookie Banner Post Load Banner or Get depend on Post option!|
|x_cookieBanner_Pre($precookie = "", $redirect = true)|Redirect should be in Header, you can post this in Header for Redirect if someone clicks Ok Button, is optional only for post!|
|x_captcha($preecookie = "", $width = 550, $height = 250, $square_count = 5, $eclipse_count = 5, $color_ar = false, $font = "", $code = "")| Generate Captcha Image |
|x_captcha_key($preecookie = "")	|Get the last Captured Captcha Key|
|x_rss_list($urltemp, $defaultcover, $limit = 25)	|Get RSS As List printed with following CSS Classes - x_rss_item x_rss_title x_rss_date x_rss_image|
|x_rss_array($urltemp)	|GenerateArray from RSS with items - title - link - date - img|
|x_search($mysql (x_mysql), $table (to search), $search_fields = array(), $get_fields = array(), $search_string, $uniqueref = "id")| Do a Database Search with Metascore!<br />Search Fields Array Key 0 = Fieldname Array Key 1 = Hit score <br /> Get Fields will be available in Output Array <br />|

# Javascript Framework
	This files can be included in javascript files
	to make theire function set available! This is meant for 
	easier and faster javascript development with help of this 
	functions.
## xjs_library
|Function Name|Description|
|--|--|
| xjs_get(parameterName) [x_get]	|	Function to get GET Parameters Value in current URL in Adress Bar | 
|xjs_in_url(parameterName) [x_inUrl] |	Search for A String in Current URL / True if Found / False if Not |
|xjs_hide_id(id) | Hide Object with ID |
|xjs_show_id(id) | Show Object with ID |
|xjs_is_email(email)| Check if a String is a Valid Mail Adr |
|xjs_genkey(length = 12, charset = "abcdefghijk lmnopqrstuvwxyzABCDEFGHIJ KLMNOPQRSTUVWXYZ0123456789") |Generates and Returns a Key |
|xjs_popup(var_text, var_entrie = "Close") | Generate a Quick Popup which needs CSS Desiging with id = xjs_popup / xjs_popup_inner / xjs_popup_close |

# CSS Elements
	CSS Files for different purposes to include in your
	site if needed!
## xfpe_library
	This is a set of different css classes to make working on design
	fast and efficient.
	Add _f to end of a class to make it important!
|Class|Description|
|--|--|
| xfpe_nopadding | No padding |
|xfpe_nopaddingtop  | No Padding Top |
|xfpe_nopaddingbottom  | No Padding Bottom |
|xfpe_nopaddingright  | No Padding Right|
|xfpe_nopaddingleft | No Padding Left |
| xfpe_paddingtop10px | Goes to 50px [5 steps] Padding Top|
| xfpe_paddingtopm10px | Goes to 50px [5 steps] Padding Top MINUS|
| xfpe_paddingbottom10px | Goes to 50px [5 steps] Padding Bottom|
| xfpe_paddingbottomm10px | Goes to 50px [5 steps] Padding Bottom MINUS|
|xfpe_marginauto | Margin Auto |
|xfpe_nomargin | Margin Off |
|xfpe_nomargintop | Margin Top Off |
|xfpe_nomarginbottom | Margin Bottom Off |
|xfpe_nomarginleft | Margin Left Off |
|xfpe_nomarginright  | Margin Right Off |
| xfpe_margintop10px | Goes to 50px [5 steps] Margin Top|
| xfpe_margintopm10px | Goes to 50px [5 steps] Margin Top MINUS|
| xfpe_marginbottom10px | Goes to 50px [5 steps] Margin Bottom|
| xfpe_marginbottomm10px | Goes to 50px [5 steps] Margin Bottom MINUS|
|xfpe_floatright | Float Right |
| xfpe_floatleft | Float Left |
| xfpe_width100px | Goes up to 800px [100 Steps] Width |
| xfpe_maxwidth100px| Goes up to 800px [100 Steps] Max Width |
|xfpe_width25pct| Width Percent [25/50/100]|
| xfpe_maxwidth25pct | Max Width Percent [25/50/100]|
|xfpe_alignright| Text Align Right|
|xfpe_alignleft| Text Align Left|
|xfpe_aligncenter| Text Align Center|
|xfpe_textbreakall | Break Text Completely for Long Text|
|xfpe_overflowhidden| Overflow Hidden|
|xfpe_overflowscroll|Overflow Scroll|
|xfpe_cursorpointer| Cursor Pointer |
| xfpe_bordernone | No border |
| xfpe_outlinenone| No Outline |
| xfpe_font8px | Goes up to 24px / Font Size |
|xfpe_t3d | Translate for zIndex Compatibility|
|xfpe_borderbox | Border-Box No Padding Margin Inner |
|xfpe_relative | position relative |
|xfpe_fixed | position fixed |
|xfpe_absolute | position absolute |

## xfp_library
	Default CSS Classes for XFP-Template and   
	Cookiebanner / Eventboxes
	Mostly the IDs and Classes are used in the xfp-template file, if 
	you do not use the template, this file is a good place
	to get some style inspirations for eventboxes or cookiebanners
	(for example) For details study the file itself. You should not
	work with this css file if you are not using the xfp_library
	Functions.


# Fast Deployment Site
## xfp-template 
	Template to deploy fast 
	backend or frontend webpages with   
	SEO URLs. Not much documented. See the Files and use my classes
	and functions. In this folder is a websites template to build
	up a website with different functions 
	included in the framework. Its more for 
	internal purpose, more focus in this framework 
	is on the provided classes and functions. This 
	template should have the framework itself included 
	to work properly. But you can kee this section it 
	out of sight, im using it for fast deployment.

# Dolibarr Module
	A Module wich can be installed on dolibarr to make this framework
	available in code for Development. It has some additional
	extra functions like a changelog for different areas and more for
	debugging! (See Readme File in Module Folder)


## xframework [934285]
### General information
The classes and functions from the framework are always integrated, the module does not have to be active for this, only the adaptation of conf.php has to be made for this. However, the module should be active for logging and views to work.

### Installation
1. Upload and install the module in Dolibarr.
2. Adjust the Dolibarr config file (etc/dolibarr/conf.php) and add the following at the end:

		if(file_exists(“/usr/share/dolibarr/htdocs/custom/xframework/remote/loader.php”)) {
		require_once(“/usr/share/dolibarr/htdocs/custom/xframework/remote/loader.php”);
		}

### Module-Areas
#### Trigger and Object Logging

Triggers and object information related to that trigger are intercepted and can be viewed in the Triggers section under Utilities in the xFramework menu item.

#### Javascript Error Logging

Javascript errors caused by users can be viewed in the log under Utilities -> xFramework -> Javascript Loggin.

#### MySQL Error Logging (only for querys used with x_class_mysql)

MySQL error messages that arose when using the x_class_mysql can be viewed in the section under Utilities in the menu item xFramework.

#### Mail Class Logging

If the logging function of the mail class has been switched on, information about incorrect or sent mails can be viewed here.

#### Changelog for different Areas
The following areas are intercepted: facture bank_account facture_fourn commande propal user societe product orderpicking expedition supplier_proposal commande_fournisseur fichinter [These are the $ref] - Changes to the respective areas can be viewed under Utilities - xFramework - Process logs if you have the respective rights.

The following fields are ignored: tms rowid
Fields are marked with the following prefix for functions: mn_ [main table] xt_ [extrafield]

### Module-Functions

#### Fast MySQL/Mail object and integration of JS functions

|Function | Description|
|-|-|
|x_c_mysql()|Create a Quick xMysql Object without Credentials|
|x_c_mail($host, $port, $auth, $user, $pass, $from_name, $from_mail)|Create a Quick xMailer Object, Host: example.de, port: 25/587/465, Auth: tls/ssl /false, User: username, Pass: pass, From_name: Sender Name, From_Mail: Sender Mail|
|x_l_js()|Load Content of Javascript Functions for JS Files |

#### Function for Triggers to check for Changes

|Function | Description|
|-|-|
|d_get_change(\$db, $refid, $ref, $fieldname)|Get Array with x[from] x[to] else is false if error, maybe if this is a new process, Db -> doli db object, $refid -> id of current object, $ref -> table element, $fieldname -> database fieldname to check|
|d_is_change(\$db, $refid, $ref, $fieldname)|True if changed, False if not changed may error if this is first time this ref is added in database, Db -> doli db object, $refid -> id of current object, $ref -> table element, $fieldname -> database fieldname to check|
|d_log(\$filename, $string)|Log something to see it in PHP Errors Logfile Window|

#### Function to write Message to Module Messages Area


|Function | Beschreibung|
|-|-|
|d_message($db, $modulename, $message)|Write something to the modules message area, Db: db object from MITEC|
|message: Message you want to provide (filter if needed with $db->escape())| modulename: the name under which section the message appears in the message overview|

### Berechtigungen
| Name | Default Activated | Description|
|-|-|-|
| readchangelogs | Nein | View Change Logging |
| readtriggers | Nein | View Trigger Logging |
| readjs | Nein | View Javascript Logging |
| readmail | Nein | View Mail Logging |
| readmysql | Nein | View MySQL Logging |
| readmsg | Nein | View Messages Logging |
| readphp | Nein | View PHP Error Logging |

### Module settings
Module settings and initialization that should be performed on first start (once for each section) can be set in the module activation page at the xFramework module under the cogwheel. (Admin rights required!)

# Dolibarr Framework
	The following framework is meant to be an extension
	for the dolibarr database object to work with and more like
	table scripts and different usefull stuff.
## m_mastertable
	Function still needs to be documented!
## m_library 
|Function Name|Description|
|--|--|
|m\_month\_num\_to\_name($number) | Return Month Name or Error if Wrong (input number 1-12 to get german month name) |
|m\_button\_sql( $db, $name, $url, $query, $get, $break = false, \$style = "")|Add a Button to Execute a Simple SQL !  \$msgerr = "Fehler!", \$msgok = "Erfolgreich!",  Function |
|m\_button\_link($name, $url, $break = false, $style, $reacttourl = true)| Add a Default Button Linked to another Page |
|m\_db\_rowsbycleanresult(\$db, \$sql\_res)|   Get Array by provising a finished result |
|m\_db\_row($db, $query) |  Get a Single Array with $array["fieldname"] = \$value back  |
|m\_db\_row\_insert($db, \$table, \$array, \$filter =*true)| Insert into a Database with array ["fieldname"] =  \$value; |
|m\_db\_rows($db, $query)|  Get a Multiple Array with $array[COUNT]["fieldname"] = $value back |
|m\_isset($var)|  If var is Empty or "" than false |
|m\_table\_simple($title, \$array, $titlelist, $tableid, $alignarray = false, \$imgeforlist = 'generic')| Print a Simple Table|
|m\_table\_complex($title, \$array, \$titlelist,$formid = "", \$alignarray = false, \$imgeforlist ="generic")| Print a Complex Table with Search  |
|m\_login\_id($db, \$tmp = false)| Get the current rowID of logged in User, if error than false |
|m\_login\_name\_from\_id ($db, $userid)| Get the current name of User by UserID, if error than false|
  
# Issues
If you encounter issues or have questions using this software, do not hesitate write us at our Forum on www.bugfish.eu !

# License
	For License Informations see License.md