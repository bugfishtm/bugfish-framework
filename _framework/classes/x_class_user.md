# Classes Framework
	This is my personal framework, feel free to use it as you wish.  
	For help visit bugfish.eu!
	
	
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
|createInitial($username, $mail, $pass, $rank)| Create Initial User if Not Exists|
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
|user_add_field($addstring)| Add a Field to Users Database |
|user_del_field($fieldname)| Del a Field from Users Table (CAUTION) |
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
