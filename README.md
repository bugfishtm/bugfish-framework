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
	But watch out for the chabot script as it may tries to
	take over earth. For help visit bugfish.eu!

## x_class_curl
	Class to control a Curl Requests.
	No Mysql / No Tables / No Sessions / No Cookies
	  
|Function|Description|
| --|-- |
|last_info| last curl info out of last request|
|xml_to_array($xml)|xml_to_array conversion|
|xml_to_json($xml)|xml_to_json conversion|
|json_to_array($json)|json_to_array conversion|
|json_to_xml($json)|json_to_xml conversion|
|array_to_xml($array)|array_to_xml conversion|
|array_to_json($array)|array_to_json conversion|
|auth_request($urlextension, $type, $header = false, $body = false, $ext = false, $ovr_domain = false, $ovr_username = false, $ovr_password = false, $proxy = false, $cert = false)| Request with Basic Auth |
|request($urlextension, $type,$body = false, $header = false, $ext = false, $ovr_domain = false, $proxy = false, $cert = false)|Request without Basic Auth |
|download($url, $localfile, $header = false, $ext = false, $proxy = false, $cert = false)| Download File from URL to Localfile |

## x_class_chatbot
	Class to control a chatbot area.
	Mysql / Tables (auto-installed) 
	  / Sessions (optional) / No Cookies	

|Function|Description|
| --|-- |
|__construct($mysql, $table_question, $table_group_text, $table_group, $table_command, $table_workflow, $table_talk = false)| Construct with needed table names, will be installed automatically. Table talk is for mode 2 with sql tables and saved chats outside sessions|
|pre_cookie($string)| Pree Cookie String for Mode 1|
|conf_bot_name($string)| Bot Name in Chat|
|conf_user_name($string)| User Name in Chat|
|conf_user_ref($id)| Current User Chatting Ref|
|conf_help_text($string)| Help Text setup optional|
|conf_reset_after($int)|Limit for Message Array Output|
|conf_group_start($string)|Start Group if new Chat|
|conf_group_error($string)|Error Group if no Finding|
|conf_string_error($string)| Error Message if no Finding|
|section($string)| Section for Multi Chatbot |
|init($mode = 1)|Init after Config with Settings Mode 1 = sessions Mode 2 = SQL|
|spawn_admin_area()| Spawns a complete Administration Area to Setup the bot!|
|send($message)| Send a User Message |
|get()|Get array with all current Informations|

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
|__construct($x_class_mysql, $table_users, $table_sessions, $preecokie = "x_users_")| Construct with x_class_mysql object and Table names (will be auto-generated) |
------------
|Public Variables |Description|
| --|-- |
|ref| Array with References for Last Operation<br />Array with all Infos from corrosponding user - may "token" key with current useable token is existing. |
|mail_ref_user| Outdated Ref User ID to Send Mails To |
|mail_ref_token |Outdated Ref User Token to Send in Mails |
|mail_ref_receiver |Outdated Ref User Mail to Send Mails To |
|info/user| Array with Current User Informations from Table|
|perm|Variable to use for external scripts not by this class. Feel free to use.|
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
|login_request($ref, $pass, $cookies= false)|Return Code: 5 - User not confirmed<br /> Return Code: 4 - User Blocked<br /> Return Code: 3 - Wrong Password<br /> Return Code: 2 -Ref does not exist <br />Return Code: 1 - Login Successfull|
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
|send($to, $toname, $title, $mailContent, $attachments = false, $ishtml = false, $FOOTER = false, $HEADER = false)	|"to" / "attachments" can be array with $a["mail"], $a["name"] / attachments can be array with filepath for upload |

## x_class_var
	Class to control constants / setup variables and handling.
	Mysql / Tables (auto-installed) / No Sessions / No Cookies
|Function|Description|
| --|-- |
| __construct($mysql, $tablename, $descriptor = "descriptor", $value = "value") | Constructor with x_class_mysql object / tablename|
| const | If init function executed than the constants are in this array |
| sections($field, $section_name) | Set Sections for Constants|
|initAsConstant($strict = true)| Init Vars as Constant|
|initAsArray($strict = true)| Init Vars as Return Array|
|init($strict = true)| Init Local Const Variable |
|addVar($name, $value, $null_section = false)| Add a Variable|
|setVar($name, $value, $strict = true)| Set or Add Variable|
|getVar($name, $strict = true)| Get a Variable|
|delVar($name, $strict = true)| Del a Variable|
|increaseVar($name, $strict = true)| Increase a Variable|
|decreaseVar($name, $strict = true)| Decrease a Variable|
|existVar($name, $strict = true)| True if Var Exists|
|setupVar($name, $value, $descr, $section = false)| Setup Var if not Exists with description |

## x_class_mysql
	The one and only x_class_mysql by bugfish! For MySQL Handling.
	Mysql / Tables (auto-installed optional) / No Sessions / No Cookies

|Function|Description|
| --|-- |
| __construct($hostname, $username, $password, $database, $ovrcon = false)	 | Create the Class|
| mysqlcon		 | Connection Object |
| lasterror	| Last Error |
| insert_id	 | Last Insert ID |
| loggingSetup($bool, $table, $section = "")	| Disable (false) or Enable (true) Logging Function with a Table Name to Log and Creates Tables for Logging if not Exists |
| stoponexception($bool = false) | Exit Script on Exception Error|
|stoponerror($bool = false)| Stop on Error in Logerror? |
| status()| Check if Current MySQL Object is true |
| ping()| Ping the MySQL Server |
| escape($val)| MySQLI Real Escape String a Value |
| lastError()	| Get last Error String |
| get_row($table, $id, $row = "id")	| Get a Row |
| get_row_element($table, $id, $row = "id", $elementrow = "x", $fallback = false)| Get a Row Element with ID or Fallback |
| change_row_element($table, $id, $row = "id", $element = "x", $elementrow = "x")	| Change a Row Element with ID |
| exist_row($table, $id, $row = "id")	| Check if a Row with Ref Exits |
| get_rows($table, $id, $row = "id")	| Get Rows |
| del_row($table, $id, $row = "id")	| Delete a Row |
|auto_increment($table, $value)| Set Auto Increment Counter of a Table |
|query($query, $bindarray = false)| Do a query with bind array if needed , Output able to be fetched - If you await multiple values and are using |
|select($query, $multiple = false, $bindarray = false)| Do a select with bind array if needed|
|insert($table, $array, $bindarray = false)| Only Accepts One Insert Per Execution|
|transaction()	|Start a transaction|
|rollback()	|Rollback a transaction|
|transactionStatus()	|Check if a Transaction has been started|
|commit()	|Commit the current transaction	|
|backup_table($tablex, $filepath, $withdata = true, $dropstate = false)| Backup a Table to a File|
|multi_query($sql)| Multi Query String without Filtering|
|multi_query_file($filepath)| Load MySQL File |
|increase($table, $nameidfield, $id, $increasefield, $increasevalue = 1)	|Function to increase or decrease an int value|
|decrease($table, $nameidfield, $id, $decreasefield, $decreasevalue = 1)|	Function to increase or decrease an int value|
|displayError($exit = false)	|Display an Full Error Page which does look like a bluescreen if DB = Error|

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
|__construct($mysql, $tablename, $section = "")| Constructor with x_class_mysql object and Tablename, Section for Multisite use if optional!|
|perm| Array with Current Perms (If Set by function initPerm)|
|flush($ref) | Flush a Ref from the Perms Table|
|removePerm($ref, $permname) | Remove Permission Name from Ref|
|hasPerm($ref, $permname) | Check if Ref has Perm Name|
|addPerm($ref, $permname) | Add new Perm to Ref|
|getPerm($ref)| Get Perms array for Ref|
|initPerm($ref)| Update Perm Var with Perms from Ref|

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
|clear_entry($id) | Del Entrie with ID  |
|clear_table()| Clear Log Table Completely  |

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

# CSS Elements
	CSS Files for different purposes to include in your
	site if needed!
## x_library
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
	Not documented here...
	
# Fast Deployment Template
	Template to deploy fast backend or frontend webpages with   
	SEO URLs. Not much documented.
## xfp-template
In this folder is a websites template to build up a website with different functions included in the framework. Its more for internal purpose, more focus in this framework is on the provided classes and functions. This template should have the framework itself included to work properly. But you can kee this section it out of sight, im using it for fast deployment.

# Function Framework
	This is a set of functions to use when building a webpage.
## xfp_library
### Constants
|Runtime Variable|Description|
|--|--|
|\_XFP_MAIN_SEOVAR\_| Htaccess URL Get Variable |
| \_XFP_ADMIN_NAME\_ | Administrator Name for Meta |
| \_XFP_ADMIN_MAIL\_| Administrator Mail for Meta |
| \_XFP_LANG\_ | Language for Website (en, de) for Meta |
| \_XFP_META_ERROR_IMAGE\_ | Error Image for Meta Error|
| \_XFP_META_TITLE_PRE\_ | Before Meta Title |
| \_XFP_META_TITLE_POST\_ | After Meta Title|
| \_XFP_META_DESC_PRE\_ | Before Meta Title |
| \_XFP_META_DESC_POST\_ | After Meta Title|
| \_XFP_THEME\_ | Current Theme Name|
| \_XFP_COOKIES\_ | Cookies Prefix |
| \_XFP_THEMESPIN\_ | Random Themespin (yes/no) |
|\_XFP_META_FB_IMAGE\_ | Meta Fallback Image |

### Meta Handling
|Meta Function Name|Description|
|--|--|
|xfp_meta_error($code = 404)| Print Meta Error|
|xfp_meta_prep($val)| Prepare Text for Meta |
| xfp_meta($mysql, $title, $description, $keywords = false, $robots = false, $cssarray = false, $img = false, $formexpire =  false, $fallbackimage = false, $nocache = true)| Write Meta Content |

### Message Handling
|Message Function Name|Description|
|--|--|
|xfp_msg_box_error($title, $text) | Box with Title |
|xfp_msg_box_warning($title, $text)| Box with Title |
|xfp_msg_box_notify($title, $text)| Box with Title |
|xfp_msg_box($title, $text)| Box with Title |
|xfp_msg_boxnt_error($text)| Box without Title |
|xfp_msg_boxnt_warning($text)| Box without Title |
|xfp_msg_boxnt_notify($text)| Box without Title |
|xfp_msg_boxnt($text)| Box without Title |
|xfp_msg_notify_ok($cookie, $text)| Event Box |
|xfp_msg_notify_warning($cookie, $text)|Event Box |
|xfp_msg_notify_error($cookie, $text)|Event Box |

### Site Buildup
|Build Function Name|Description|
|--|--|
|xfp_footer($text) | Build Footer |
|xfp_entry($var, $x, $level = 1) | Check Location for Case in Index |
|xfp_headline($title, $titlesec) | Build Headline |
| xfp_top_button() | Build Top Button below Headline |
|xfp_top_button_sec() | Build Top Button no Margin Top |
|xfp_return_button() | Build Top Back Button below Headline|
|xfp_return_button_sec() |Build Top Back Button no Margin Top|
| xfp_top_button_print($url) | Print Button on Top|
| xfp_top_button_print_sec($url) | Print Button on Top No Margin Top|
|xfp_theme()| Get Current Theme Name|
|Navigation Function Name|Description|
|--|--|
|xfp_navi_end() |End of Navigation |
|xfp_navi_start($searchpage = "/search", $searchparam_sc = "", $navi_image = "", $search = true)|Start of Navigation |
|xfp_navi_item($navname, $url, $titlealt, $level = 0, $isonempty = false) | Spawn Navigation Item |
|xfp_navi_location_seo($param = \_XFP_MAIN_SEOVAR\_) | Get Location |

### Misc Functions
|Misc Function Name|Description|
|--|--|
|xfp_search($mysql, $table, $search_fields = array(), $get_fields = array(), $search_string, $uniqueref = "id")| Do a Database Search with Metascore!|

## x_library
	This is a set of usefull functions for different purposes.
|Function Name|Description|
|--|--|
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
|x_eventBoxPrep($text, $type = "x", $precookie = "", $morecss = "", $buttontext = "X")	| Prepare EventBox / Only one is Possible with this Function - text = the message   - type = error/warning/ok/[undefined] for different styles   - precookie = prestring for cookie   - morecss = tags direct inside style element of html element  -$buttontext = Text of the button to Close|
|x_eventBoxShow($precookie = "")	| Include at End or Start of the Page to display Eventbox Content|
|x_eventBoxSet() |True if Event Box is Prepared, False if not (Set)|
|x_cookieBanner($precookie = "", $method = 'post', $text = false)	| Cookie Banner Post Load Banner or Get depend on Post option!|
|x_cookieBanner_Pre($precookie = "", $redirect = true)|Redirect should be in Header, you can post this in Header for Redirect if someone clicks Ok Button, is optional only for post!|
|x_captcha($preecookie = "", $width = 550, $height = 250, $square_count = 5, $eclipse_count = 5, $color_ar = false, $font = "", $code = "")| Generate Captcha Image |
|x_captcha_key($preecookie = "")	|Get the last Captured Captcha Key|
|x_rss_list($urltemp, $defaultcover, $limit = 25)	|Get RSS As List printed with following CSS Classes - x_rss_item x_rss_title x_rss_date x_rss_image|
|x_rss_array($urltemp)	|GenerateArray from RSS with items - title - link - date - img|

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

# Dolibarr Module
	A Module wich can be installed on dolibarr to make this framework
	available in code for Development. It has some additional
	extra functions like a changelog for different areas and more for
	debugging! (See Readme File in Module Folder)

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
Copyright 2022 www.bugfish.eu Jan-Maurice Dahlmanns (Bugfish)
This Product is running with MIT LICENSE

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

