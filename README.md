# Bugfish Framework

# Classes
## x_class_simplePerms
### Constructor
	__construct($mysql, $tablename, $section = "undefined")
### Functions
	flush($ref) : Flush a Ref from the Perms Table
	removePerm($ref, $permname) : Remove Permission Name from Ref
	hasPerm($ref, $permname) : Check if Ref has Perm Name
	addPerm($ref, $permname) : Add new Perm to Ref
	getPerm($ref) : Get Perms array for Ref
## x_class_users
### Constructor
	__construct($mysqlcon, $table_users, $table_sessions, $preecokie = "x_users_")
### Configuration
	multi_login($bool = false)
	save_ip_in_db($bool = false)
	relevant_reference_username($bool = false)
	cookies_use($bool = false)
	
	// Log Functions
		log_sessions($bool = false)
		log_recovers($bool = false)
		log_user_mailchange($bool = false)
		reset_token_login($bool = false)
				
	// Lifetime Functions
		cookies_use_expire_d($int = 7)
		dbsession_max_use_days($int = 7)
		recover_token_lifetime_hours($int = 24)
		recover_intervall_hours($int = 6)
		mailchange_intervall_hours($int = 6)
		usermailchange_token_lifetime_hours($int = 24)
### Initialization after Configuration
	init()
### User Operations
	disableSessionsFrom($userid) 
	deleteSessionsFrom($userid)
	deleteUser($id) - Delete a User and Keys with ID
	disableUser($id) - Block a User with ID
	enableUser($id) - Deblock User with ID
	getInfo($id = false) - Get Current User info or IDs
	changeUserRank($id, $new) - Change User Rank
	changeUserPass($id, $new) - Change User Pass (will be Crypted)
	isBlocked($id) -> True if User is Blocked
	deactivateUser($id) -> Deconfirm a User
	activateUser($id) -> Confirm a User
	isActivated($id) -> True if User is Confirmed
			changeUserName($id, $new)
			changeUserMail($id, $new)
			changeUserShadowMail($id, $new)
	addUser($name, $mail, $password = false, $rank = false, $activated = false)
	exists($id)
	usernameExists($username)
	usernameExistsActive($username)
	mailExists($mail)
	mailExistsActive($mail)
	refExists($ref)
	refExistsActive($ref)
			
### Parameters
	$rec_request_code
	$rec_confirm_code
	$login_request_code
	$user_mailchange_confirm_code
			
	$mail_ref_token
	$mail_ref_user
	$mail_ref_receiver
	$mail_ref_receiver_name

	$user
	$user_id
	$user_session
	$user_rank
	$user_name
	$user_mail
	$user_loggedIn
	$loggedIn
### Login Functions
	logout()
	login_request($ref, $password)
		// Request Codes: 6 - Blocked by SessioN Ban
		// Request Codes: 5 - User is not yet confirmed
		// Request Codes: 4 - User is Disabled / Blocked
		// Request Codes: 3 - Wrong Password
		// Request Codes: 2 - User-Ref not Existant
		// Request Codes: 1 - Login OK
### Password Reset and Activation
	rec_token_check($key, $userid) : Check if Recover/Activate Token is Valid
	rec_request_by_id($id) - Recover new Password without Limits
		// Request Codes: 2 - User-Ref not Existant
		// Request Codes: 1 - Req OK	
	rec_request($ref) - Recover new Password
		// Request Codes: 4 - User is Session Banned
		// Request Codes: 3 - Interval Hours not Expired
		// Request Codes: 2 - User-Ref not Existant
		// Request Codes: 1 - Req OK
	rec_confirm($userid, $token, $newpass) - Confirm new Pass with Tokens from a Mail
		// Request Codes: 4 - User is Session Banned
		// Request Codes: 3 - Expired Token
		// Request Codes: 2 - User-Ref not Existant
		// Request Codes: 1 - Login OK
	rec_confirm_activate($userid, $token) - Activate Account with Mail
		// Request Codes: 4 - User is Session Banned
		// Request Codes: 3 - Expired Token
		// Request Codes: 2 - User-Ref not Existant
		// Request Codes: 1 - Login OK	
### Mail Changing with Confirmation
	change_mail_with_confirmation($id, $newmail)
		// Request Codes: 4 - Interval not Reached
		// Request Codes: 3 - Existant Already as an User Mail
		// Request Codes: 2 - User-Ref not Existant
		// Request Codes: 1 - Req OK	
	change_mail_with_confirmation_execute($userid, $token)
		// Request Codes: 5 - Mail has been changed by another
		// Request Codes: 4 - SESSION BAN
		// Request Codes: 3 - EXPIRED TOKEN
		// Request Codes: 2 - NOT FOUND
		// Request Codes: 1 - OK
### Various Functions
	genKey($len = 12, $comb = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890')
	passCrypt($var)
	passCheck($cleartext, $crypted)
### Sessionban Configuration
	isBanned()
	sessionban_limit($int = 50)
	resetFailure()
	raiseFailure()
## x_class_activities
### Configuration
	sys_name($name = "System")
	sys_text($text = "Thanks for visiting my page and have a nice day!")
			
	endorse_param($method = "xcv_upvotes")
	endorse_param_code($method = "c")
	decomment_param_code($method = "d")
### Session Ban Functions
	sessionban_init($bool = false, $limit = 100) 
	sessionban_raise()
	sessionban_blocked()
	sessionban_reset()
### Primary Functions
	__construct($mysql, $table, $precookie, $module, $target)
	init($captcha_code_if_delivered)
		returns 1 = Missing Pieces
				2 = Captcha Err
				3 = ok
	show_votes()
	show_form($captchaurl)
	show_comments($hide_system_msg = false)
### Get Informations
	endorsed_by_user()
	endorsed_counter()
			
	comments_counter()
	commented_by_user()
## x_class_mail
### Primary
	__construct($host, $port = 25, $auth_type = false, $user = false, $pass = false) Construct with Connection data Auth Type can be ssl or tls
	initFrom($mail, $name) 				
	send($to, $toname, $title, $mailContent, $attachments = false, $ishtml = false, $FOOTER = false, $HEADER = false)	to can be array with $a["mail"], $a["name"]
				attachments can be array with filepath for upload
### Configuration
	CharSet($charset) : Set Charset
	initReplyTo($mail, $name) Set Reply To
	Encoding($encode) : Set Mail Enconding
	debugLevel($int) (1-3 3 is highest) : Set Debug Level for Mail Sending
	change_default_template($header, $footer) : Set all Mails to default Header and Footer if no Override by Function
	all_default_html($bool) : Set all Mails to default HTML if no Override by Function
	enableTestMode($val) : Override all Send Mails to another
	allow_insecure_ssl_connections($bool) : Allow Insecure TLS Connections
	keep_alive($bool = false) : Keep SMTP Connection Alive between Mails
### Logging
	logEnable($connection, $table, $mode = 1, $section = "") Enable Logging Mode 1  = ALL Mode 2 = Failed Mode 3 = Only OK Mails
	logDisable()
### Variables
	$this-> debugmessage	Last Debug Message From Last Mail Tried to Send or Sended
## x_class_mysql
### Public Variables
	$mysqlcon	Mysql Connection Object
	$lasterror	Last error
	$insert_id	 Last Insert ID
### Various Functions
	status()	Check if Current MySQL Object is true
	ping()	Ping the MySQL Server
	escape($val)	MySQLI Real Escape String a Value
	lastError()	Get last Error String
	
	__construct($hostname, $username, $password, $database, $ovrcon = false)
				Creates the Mysql Connection or Inits it if there is a mysql connection variable provided
	loggingSetup($bool, $table, $section = "")	Disable (false) or Enable (true) Logging Function with a Table Name to Log
### Primary Mysql Functions
	query($query, $bindarray = false) Do a query with bind array if needed
	select($query, $multiple = false, $bindarray = false) Do a select with bind array if needed
	insert($table, $array, $bindarray = false) Only Accepts One Insert Per Execution
### Misc
	increase($table, $nameidfield, $id, $increasefield, $increasevalue = 1)	Function to increase or decrease an int value
	decrease($table, $nameidfield, $id, $decreasefield, $decreasevalue = 1)	Function to increase or decrease an int value
	displayError($exit = false)	Display an Full Error Page which does look like a bluescreen if DB = Error
### Transactions
	transaction()	Start a transaction
	rollback()	Rollback a transaction
	transactionStatus()	Check if a Transaction has been started
	commit()	Commit the current transaction		
## x_class_vars
	__construct($mysql, $tablename, $descriptor = "descriptor", $value = "value")
	sections($field, $section_name)
	initAsConstant($strict = true)
	addVar($name, $value, $null_section = false)
	setVar($name, $value, $strict = true)
	getVar($name, $strict = true)
	delVar($name, $strict = true)
	increaseVar($name, $strict = true)
	decreaseVar($name, $strict = true)
## x_class_ipblacklist
	__construct($mysql, $tablename, $maxvalue = 50000)	
	isblocked() : Check if Current IP is Blocked
	raise() : Raise Current IPs Counter	
	counter($ip = false) : Get Value for Current or Optional entered IP
## x_class_hits
	onlyarrivals($bool = true) Only coutn arrivals to spare sessions storage  
	enabled($bool = true)	Disable or Enable the Hits Check for this Page
	show() : Show the Counters
	Destructor	If the Disable Function has not been triggered, the Hits URL will be written into the Database and decreased,or the count will be raised,!
		
	$current_switch ; $current_arrive ; $current_hits ;
	__construct($thecon, $table, $precookie = "" )	Create the Class and Create Table if not Exists
## x_class_referers
	__construct($mysqlvar, $table, $refurlnowww)	
	Create the Class and Create Table if not Exists
	enabled($bool = true)	
	Disable or Enable the Referer Check for this Page
## x_class_sessionblocking
	__construct($key, $maxcount)
	blocked() : Check if Session is above Max
	increase() : Increase Session
	decrease() : Decrease Session
	reset() : 	Reset Session
## x_class_csrf
	overrideValidTime($seconds_valid) 
	Override Valid time for Check Functions
	
	disableRenewal($bool = true)	
	Disable Key Renewal on Session at end of script
	
	isDisabled() Check if renewal is disabled
	
	__construct($cookie_extension = "", $second_valid = 300, $disableRenew = false)	
	Construct the Class
	
	get()	
	Get new Generated Key for Forms
	
	getField($name, $id = "")	
	Print hidden Form Field with name and id attribute
	
	get_lkey()	
	Get key from last page if exists else “undef”
	
	get_lkey_time()	
	Get keytime from last page if exists else “undef”
	
	check($code, $override_valid_time = false)	
	Provide form code to check with current CSRF
	
	check_lkey($code, $override_valid_time = false)	
	Provide form code to check with last CSRF	
 
# Functions 
## x_eventBox
	x_eventBoxPrep($text, $type = "x", $precookie = "", $morecss = "", $buttontext = "X")	: Prepare EventBox / Only one is Possible with this Function
			text = the message  
			type = error/warning/ok/[undefined] for different styles  
			precookie = prestring for cookie  
			morecss = tags direct inside style element of html element  
			$buttontext = Text of the button to Close
		
	x_eventBoxShow($precookie = "")	: Include at End or Start of the Page to display Eventbox Content
	x_eventBoxSet() : True if Event Box is Prepared, False if not (Set)
## x_function_set
	x_executionButton($db, $name, $url, $query, $get, $msgerr = "Fehler!", $msgok = "Erfolgreich!", $break = false, $style = "")
	x_button($name, $url, $break = false, $style = "", $reacttourl = true) 
	x_html_redirect($url, $seconds = 0)
	x_isset($val)  	equal to !empty
	x_datediff_before($d1, $d2, $length)	Check if date 1 differs with d2 outter length
	x_imgValid($url)	Is a valid image URL = True
	x_contains_cyrillic($val)	(True if Cyrillic in String)
	x_contains_bad_word($val)	(Simple Bad word Filter)
	x_contains_url($val)	(Check if String Contains URL)
	x_getint($val)	Get Parameter Get if Int
	x_postint($val)	Same for Post
	x_get($val)	Get GET Param
	x_post($val)	Get Post Param	
	x_hsc($string)
## x_function_rss
	x_rss_list($urltemp, $defaultcover, $limit = 25)	Get RSS As List printed with following CSS Classes:
	x_rss_item x_rss_title x_rss_date x_rss_image
	x_rss_array($urltemp)	GenerateArray from RSS with items - title - link - date - img
## x_function_tables
	x_table_simple($array, $titlelist, $tableid = "x_table_simple", $alignarray = false)	Print a Simple Table
	x_table_complex($array, $titlelist, $formid = "", $alignarray = false)	Print a Complex Table with Search Function and Ordering
	x_table_div($array, $titlelist, $alignarray = false, $percentarray = false, $title = false)	Build a Table with Divs for Responsive	
## x_function_cookieBanner
				
	x_cookieBanner($precookie = "", $method = 'post', $text = false)	
	  Cookie Banner Post Load Banner or Get depend on Post option!
	x_cookieBanner_Pre($precookie = "", $redirect = true)	
	  Redirect should be in Header, you can post this in Header for Redirect if someone clicks Ok Button, is optional only for post!

## x_function_captcha
	x_captcha($preecookie = "", $width = 550, $height = 250, $square_count = 5, $eclipse_count = 5, $color_ar = false, $font = "", $code = "")
	x_captcha_key($preecookie = "")	Get the last Captured Captcha Key
# Javascript
## xjs_set
	xjs_get(parameterName)	Function to get GET Parameters Value in current URL in Adress Bar
	xjs_inUrl(parameterName)	Search for A String in Current URL / True if Found / False if Not 
	xjs_hide_id(id) Hide Object with ID
	xjs_show_id(id) Show Object with ID
	xjs_isEmail(email) Check if a String is a Valid Mail Adr
	xjs_genkey(length = 12, charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789") Generates and Returns a Key
	xjs_popup(var_text, var_entrie = "Close") : Generate a Quick Popup which needs CSS Desiging with id = xjs_popup / xjs_popup_inner / xjs_popup_close

# Dolibarr

# License
Copyright 2022 www.bugfish.eu Jan-Maurice Dahlmanns (Bugfish)
This Product is running with MIT LICENSE

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
