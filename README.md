


# Bugfish Framework
See www.bugfish.eu for informations (Forum or Wiki) Or in Readme Files inside Folders.  This is the Bugfish Framework, for easier Coding.  It Contains different Classes and Functions, see below for instructions and library. Languages are Javascript / Jquery / PHP / Html / CSS
# xfp-template
In this folder is a websites template to build up a website with different functions included in the framework. Its more for internal purpose, more focus in this framework is on the provided classes and functions.
# Classes Framework
## x_class_comment
	This Class does need tables!
	This Class does Session-Cookies!

### Constructor Functions
|Function|Description|
| --|-- |
|__construct($mysql, $table, $precookie, $module, $target)| Class Construction|

### Class Variables
|Function|Description|
| --|-- |
|upvote| Actual Upvote Counter |
|comment| Actual Comment Counter (Confirmed) |
|init_res| Returns Init Value if new Comment is Pushed for Notifications and more: // 1 - System Message Inserted// 2 - Vote OK// 3 - Comment Missing Fields// 4 - Comment Captcha Error// 5 - Comment OK |
### Adjustment Functions
|Function|Description|
| --|-- |
|sys_name($name = "System")| Name of System Message Autor|
|sys_text($text = "Thanks for visiting my page and have a nice day!")| Default Message Text |

### Show Functions
|Function|Description|
| --|-- |
|vote_show()| Show Vote Box|
|comment_show($hide_system_msg = false)| Show Comments Box|
|comment_get($hide_system_msg = false)| Get Comments Current to Array in Return|
|form_show($captchaurl)| Show Form for new Comments|
|init($captcha_code_if_delivered = false)| Init with Configs (Before Show of Form) Handles new Comments and Votes |

## x_class_user
	This Class does need tables!
	This Class does Session-Cookies!
	This Class may needs real Cookies!
### Constructor Functions
|Function|Description|
| --|-- |
|__construct($mysqlcon, $table_users, $table_sessions, $preecokie = "x_users_")| Construct |

### Public Variables
|Function|Description|
| --|-- |
|ref| Array with References for Last Operation|
|info| Array with Current User Informations from Table|
|user| Same as Info|
|user_rank| Users Rank |
|user_id| User ID |
|user_name| User Name |
|user_mail| User Mail|


### Adjustment Functions
|Function|Description|
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
|wait_activation_hours($int = 6)| Activate Request Interval|
|wait_recover_hours($int = 6)| Recover Request Interval|
|wait_mail_edit_hours($int = 6)| Mail Edit Request Interval |
|hours_activation($int = 6)|Activate Token Expire Hours |
|hours_recover($int = 6)|Recover Token Expire Hours |
|hours_mail_edit($int = 6)| Mail Edit Token Expire Hours |
|sessions_days($int = 7)| Session Valid for X Days|
|cookies_use($bool = false)| Allow Use of Cookies|
|cookies_days($int = 7)| Cookies valid for X Days|

### Token Pre-Config Functions
|Function|Description|
| --|-- |
|token_charset($charset = "0123456789")| Change Token Charset|
|token_length($length = 24)| Change Token Length |
|session_length($length = 24)| Change Session Length |
|session_charset($charset = "QAYXSWEDCVFRTGBNH ZUJMKIOLPabcdefghijklmno pqrstuvwxyz0123456789")|  Change Session Charset|

### Password Functions
|Function|Description|
| --|-- |
|password_gen($len = 12, $comb = "abcde12345")| Generate a Key with Charset[Comb String] and Length|
|password_crypt($var, $hash = PASSWORD_BCRYPT)| Crypt a Cleartext Password|
|password_check($cleartext, $crypted)| Check Crypted Password Validation|

### User Operations
|Function|Description|
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

### Check Token Valid Functions
|Function|Description|
| --|-- |
|actication_token_valid($user, $token)| Check if Act Token Valid|
|recover_token_valid($user, $token)| Check if Recover Token Valid|
|mail_edit_token_valid($user, $token)| Check if Mail Edit Token Valid|
|session_token_valid($user, $token)| Check if Session Token Valid|


### General Functions
|Function|Description|
| --|-- |
|init()|Init the Login with all Configs (Should run once after Configuration has been changed with adjustment functions|
|logout()|Logout the Current Logged In User|
|login_request($ref, $pass, $cookies= false)|	// Login Request to Get a User Logged in with REF and PASSWORD and Cookies Stayloggedin = True?// Request Codes: 5 - User is not yet confirmed// Request Codes: 4 - User is Disabled / Blocked// Request Codes: 3 - Wrong Password// Request Codes: 2 - User-Ref not Existant// Request Codes: 1 - Login OK|

### Activation Functions
|Function|Description|
| --|-- |
|activation_request_id($id)| Request Activation for Account with ID (fills Ref for example Mail Sending) // 1 - Successfull // 2 - Not Found // 3 - Already Active User ID|
|activation_request($ref)| Request Activation for Account with ID from User // 1 - Successfull // 2 - Not Found // 3 - Cant Activate - Interval not Reached between new Activation Requests // 4 - Already Active User ID|
|activation_confirm($userid, $token)| Activate with Userid and Valid Token 	// 1 - Successfull Created// 2 - Reference not Found// 3 - Token Invalid |


### Reset Functions
|Function|Description|
| --|-- |
|recover_request_id($id)| Recover Request for Account ID and Data stored in "ref"// 1 - Successfull Created // 2 - Reference not Found|
|recover_request($ref)| Recover Request for User by Ref|
|recover_confirm($userid, $token, $newpass)| Confirm Recover with new Password, Token and UseriD // 1 - Successfull Created// 2 - Reference not Found// 3 - Token Interval Error|

### Mail Edit Functions
|Function|Description|
| --|-- |
|mail_edit($id, $newmail, $nointervall = false)| Create New Shadow Mail // 1 - Success // 2 - Reference Not Found// 3 - Interval for new Request not Reached // 4 - Mail Exists|
|mail_edit_confirm($userid, $token)| Confirm Mail Edit|

## x_class_sessionblock
	This Class does not need tables!
	This Class does need Session-Cookies!
### Constructor Function
|Constructor Function|Description|
| --|-- |
|__construct($key, $maxcount, $time_seconds_block = 12000)| Construct|

### Class Function
|Class Function|Description|
| --|-- |
|blocked($expirable = false) | Check if Session is above Max if expirable = true check with Timing - Counter will be reseted if Timing Exceeded |
|increase() | Increase Session|
|decrease() | Decrease Session|
|reset() | 	Reset Session|

## x_class_mail
	This Class installs its tables itself!
	This Class does not need Session-Cookies!
	This Class needs phpMailer Class incuded before otherwhise php error!!
### Constructor Function
|Constructor Function|Description|
| --|-- |
| __construct($host, $port = 25, $auth_type = false, $user = false, $pass = false) | Construct with Connection data Auth Type can be ssl or tls|

### Logging Functions
|Variable |Description|
| --|-- |
|logEnable($connection, $table, $mode = 1, $section = "") |Enable Logging Mode 1  = ALL Mode 2 = Failed Mode 3 = Only OK Mails|
|logDisable($bool = false)| Disable Log |

### Class Variables
|Variable |Description|
| --|-- |
| debugmessage	|Last Debug Message From Last Mail Tried to Send or Sended|

### Configuration Functions
|Config Function|Description|
| --|-- |
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

### Mail Sending
|Function|Description|
| --|-- |
|send($to, $toname, $title, $mailContent, $attachments = false, $ishtml = false, $FOOTER = false, $HEADER = false)	|"to" / "attachments" can be array with $a["mail"], $a["name"] / attachments can be array with filepath for upload |

## x_class_var
	This Class installs its tables itself!
	This Class does not need Session-Cookies!
### Constructor Function
|Constructor Function|Description|
| --|-- |
| __construct($mysql, $tablename, $descriptor = "descriptor", $value = "value") | Constructor |

### Class Variables
|Variable |Description|
| --|-- |
| const | If init function executed than the constants are in this array |

### Configuration Functions
|Config Function|Description|
| --|-- |
| sections($field, $section_name) | Set Sections for Constants|

### General Functions 
|General Function|Description|
| --|-- |
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

## x_class_mysql
	This Class installs its tables itself!
	This Class does not need Session-Cookies!
### Constructor Function
|Function|Description|
| --|-- |
| __construct($hostname, $username, $password, $database, $ovrcon = false)	 | Create the Class|

### Public Variables 
|Variables|Description|
| --|-- |
| mysqlcon		 | Connection Object |
| lasterror	| Last Error |
| insert_id	 | Last Insert ID |

### Logging Functions 
|Config Functions|Description|
| --|-- |
| loggingSetup($bool, $table, $section = "")	| Disable (false) or Enable (true) Logging Function with a Table Name to Log and Creates Tables for Logging if not Exists |
| stoponexception($bool = false) | Exit Script on Exception Error|
|stoponerror($bool = false)| Stop on Error in Logerror? |
### Operations Functions 
|Operations Functions|Description|
| --|-- |
| status()| Check if Current MySQL Object is true |
| ping()| Ping the MySQL Server |
| escape($val)| MySQLI Real Escape String a Value |
| lastError()	| Get last Error String |
| get_row($table, $id, $row = "id")	| Get a Row |
| exist_row($table, $id, $row = "id")	| Check if a Row with Ref Exits |
| get_rows($table, $id, $row = "id")	| Get Rows |
| del_row($table, $id, $row = "id")	| Delete a Row |
|auto_increment($table, $value)| Set Auto Increment Counter of a Table |

### Primary Functions 
|Primary Functions|Description|
| --|-- |
|query($query, $bindarray = false)| Do a query with bind array if needed , Output able to be fetched|
|select($query, $multiple = false, $bindarray = false)| Do a select with bind array if needed|
|insert($table, $array, $bindarray = false)| Only Accepts One Insert Per Execution|

### Transaction Functions 
|Transaction Functions|Description|
| --|-- |
|transaction()	|Start a transaction|
|rollback()	|Rollback a transaction|
|transactionStatus()	|Check if a Transaction has been started|
|commit()	|Commit the current transaction	|
	
### Misc Functions 
|MiscFunctions|Description|
| --|-- |
|increase($table, $nameidfield, $id, $increasefield, $increasevalue = 1)	|Function to increase or decrease an int value|
|decrease($table, $nameidfield, $id, $decreasefield, $decreasevalue = 1)|	Function to increase or decrease an int value|
|displayError($exit = false)	|Display an Full Error Page which does look like a bluescreen if DB = Error|

## x_class_hitcounter
	This Class installs its tables itself!
	This Class does need Session-Cookies!
### Constructor Function
|Function|Description|
| --|-- |
| __construct($thecon, $table, $precookie = "" )	 | Create the Class and Create Table if not Exists|

### Class Variables
Variables|Description|
| --|-- |
|current_switch |Current Switch Value|
|current_arrive |Current Arrive Value|
|current_hits | Current Hits (Both Sum) Value |
### Adjustment Functions
Config Function|Description|
| --|-- |
|onlyarrivals($bool = false) |Only coutn arrivals to spare sessions storage | 
|enabled($bool = true)|Disable or Enable the Hits Check for this Page|
|clearget($bool = true)| CLer Get Varibales in Logged URL | 
### Class Functions
|GeneralFunction|Description|
| --|-- |
|show() | Show the Counters|
	
	Destructor Raises Counter!
## x_class_referer
	This Class installs its tables itself!
	This Class does not need Session-Cookies!
### Constructor Function
|Function|Description|
| --|-- |
|__construct($mysqlvar, $table, $refurlnowww)| Constructor|
### Adjustment Functions
|Config Function|Description|
| --|-- |
|enabled($bool = true) | Disable / Enable for this Page |

## x_class_perm
	This Class installs its tables itself!
	This Class does not need Session-Cookies!
### Constructor Function
|Function|Description|
| --|-- |
|__construct($mysql, $tablename, $section = "")| Constructor|

### Class Variables
|Variable|Description|
| --|-- |
|perm| Array with Current Perms (True if Set)|

### Class Functions
|Function|Description|
| --|-- |
|flush($ref) | Flush a Ref from the Perms Table|
|removePerm($ref, $permname) | Remove Permission Name from Ref|
|hasPerm($ref, $permname) | Check if Ref has Perm Name|
|addPerm($ref, $permname) | Add new Perm to Ref|
|getPerm($ref) | Get Perms array for Ref|
| initPerm($ref) | Update Perm Var with Perms from Ref|

## x_class_log  
	This Class installs its tables itself!
	This Class does not need Session-Cookies!
### Constructor Function
|Function|Description|
| --|-- |
|__construct($mysql, $tablename, $section = "") | Construct |

### Class Functions
|Function|Description|
| --|-- |
|message($message, $type = 3) | Write Message Notification or other Type  |
|notify($message)| Write Type 3 Notify | 
|warning($message)| Write Type 2 Warning | 
|error($message)| Write Type 1 Error  |
|clear_entry($id) | Del Entrie with ID  |
|clear_table()| Clear Log Table Completely  |

## x_class_ipbl
	This Class installs its tables itself!
	This Class does not need Session-Cookies!
### Constructor Function
|Function|Description|
| --|-- |
|__construct($mysql, $tablename, $maxvalue = 50000) | Construct |
### Class Variables
|Variable|Description|
| --|-- |
|blocked | True if Blocked without new Query to Check (faster)|
### Class Functions
|Function|Description|
| --|-- |
|isblocked() | Check if Current IP is Blocked|
|raise() | Raise Current IPs Counter	|
|counter($ip = false) | Get Value for Current or Optional current IP|

## x_class_csrf
	This Class does not need any Tables!
	This Class does need Session-Cookies!
### Constructor Functions
|Function|Description|
| --|-- |
|__construct($cookie_extension = "", $second_valid = 300, $disableRenew = false)	| Constructor |

### Adjustment Functions
|Function|Description|
| --|-- |
|overrideValidTime($seconds_valid) |	Override Valid time for Check Functions |
|disableRenewal($bool = true)	|Disable Key Renewal on Session at end of script |
|isDisabled() | Check if renewal is disabled |

### Class Functions
|Function|Description|
| --|-- |
|get()	|Get new Generated Key for Forms|
|getField($name, $id = "")|Print hidden Form Field with name and id attribute|
|get_lkey() / get_lkey_time()	|Get key/time from last page if exists else “undef”|
||Get keytime from last page if exists else “undef”|
|check($code, $override_valid_time = false)	|Provide form code to check with current CSRF|
|check_lkey($code, $override_valid_time = false)	|Provide form code to check with last CSRF	|

# CSS Elements
	Add _f to end of a class to make it important!
## xfpe_library
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

# Function Framework
## xfp_library
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

|Meta Function Name|Description|
|--|--|
|xfp_meta_error($code = 404)| Print Meta Error|
|xfp_meta_prep($val)| Prepare Text for Meta |
| xfp_meta($mysql, $title, $description, $keywords = false, $robots = false, $cssarray = false, $img = false, $formexpire =  false, $fallbackimage = false, $nocache = true)| Write Meta Content |

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

## x_library
|Function Name|Description|
|--|--|
| x_thumbnail($url, $filename, $width = 600, $height = true) | Create Thumbnail from URL to Local JPG |
| x_connection_check($host, $port, $timeout = 1) | Check a Connection with fsockopeny|
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

|Struct Data Function Name|Description|
|--|--|
| x_structdata_article($publisher_name, $publisher_logo, $publisher_website, $image, $url, $title, $published_date, $modified_date) |Struct Data for Article |
|x_structdata_websoftware($publisher_name, $publisher_logo, $publisher_website, $image, $url, $title, $published_date, $modified_date)| Struct Data for Websoftware|

|Table Data Function Name|Description|
|--|--|
|x_table_simple($array, $titlelist, $tableid = "x_table_simple", $alignarray = false)	|Print a Simple Table|
|x_table_complex($array, $titlelist, $formid = "", $alignarray = false)	|Print a Complex Table with Search Function and Ordering|
|x_table_div($array, $titlelist, $alignarray = false, $percentarray = false, $title = false)	|Build a Table with Divs for Responsive	|

|Button Function Name|Description|
|--|--|
|x_executionButton($db, $name, $url, $query, $get, $msgerr = "Fehler!", $msgok = "Erfolgreich!", $break = false, $style = "")| Button with Execution |
|x_button($name, $url, $break = false, $style = "", $reacttourl = true) | Button Without Execution

|Eventbox Function Name|Description|
|--|--|
|x_eventBoxPrep($text, $type = "x", $precookie = "", $morecss = "", $buttontext = "X")	| Prepare EventBox / Only one is Possible with this Function - text = the message   - type = error/warning/ok/[undefined] for different styles   - precookie = prestring for cookie   - morecss = tags direct inside style element of html element  -$buttontext = Text of the button to Close|
|x_eventBoxShow($precookie = "")	| Include at End or Start of the Page to display Eventbox Content|
|x_eventBoxSet() |True if Event Box is Prepared, False if not (Set)|

|Cookie Banner Function Name|Description|
|--|--|
|x_cookieBanner($precookie = "", $method = 'post', $text = false)	| Cookie Banner Post Load Banner or Get depend on Post option!|
|x_cookieBanner_Pre($precookie = "", $redirect = true)|Redirect should be in Header, you can post this in Header for Redirect if someone clicks Ok Button, is optional only for post!|

|Captcha Function Name|Description|
|--|--|
|x_captcha($preecookie = "", $width = 550, $height = 250, $square_count = 5, $eclipse_count = 5, $color_ar = false, $font = "", $code = "")| Generate Captcha Image |
|x_captcha_key($preecookie = "")	|Get the last Captured Captcha Key|

|RSS Function Name|Description|
|--|--|
|x_rss_list($urltemp, $defaultcover, $limit = 25)	|Get RSS As List printed with following CSS Classes - x_rss_item x_rss_title x_rss_date x_rss_image|
|x_rss_array($urltemp)	|GenerateArray from RSS with items - title - link - date - img|

# Javascript Framework
## xjs_library
|Function Name|Description|
|--|--|
| xjs_get(parameterName) [x_get]	|	Function to get GET Parameters Value in current URL in Adress Bar | 
|xjs_inUrl(parameterName) [x_inUrl] |	Search for A String in Current URL / True if Found / False if Not |
|xjs_hide_id(id) | Hide Object with ID |
|xjs_show_id(id) | Show Object with ID |
|xjs_isEmail(email)| Check if a String is a Valid Mail Adr |
|xjs_genkey(length = 12, charset = "abcdefghijk lmnopqrstuvwxyzABCDEFGHIJ KLMNOPQRSTUVWXYZ0123456789") |Generates and Returns a Key |
|xjs_popup(var_text, var_entrie = "Close") | Generate a Quick Popup which needs CSS Desiging with id = xjs_popup / xjs_popup_inner / xjs_popup_close |

# Dolibarr Framework
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

