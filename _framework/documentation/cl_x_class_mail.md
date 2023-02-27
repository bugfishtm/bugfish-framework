# Classes Framework
	This is my personal framework, feel free to use it as you wish.  
	For help visit bugfish.eu!
	
	
## x_class_mail [Mastered]
	Class to handle mail Sending.
	For Logging a x_class_mysql object is needed!  
	Table will be auto-installed! [x_class_mail_smtp required]

|Construct Function|Description|
| --|-- |
|__construct($host, $port = 25, $auth_type = false, $user = false, $pass = false, $from_mail = false, $from_name = false)| Set up Mail Connection Information with Constructor|
-------------------------------------
|Config Logging Functions|Description|
| --|-- |
|log_disable()|Disable Logging|
|log_enable()|Enable Logging|
|logging($connection, $table, $log_success_mail = false, $section = "")|x_class_mysql object, table name for logging, log success mail? - section for multi-site|
-------------------------------------
|Config Functions|Description|
| --|-- |
|keep_alive($bool = false)|Keep SMTP Connection alive till All Send|
|encoding($encode = 'base64')|Change Encoding|
|charset($charset = "UTF-8")|Change Charset|
|allow_insecure_ssl_connections($bool = false)|Allow insecure ssl connections?|
|smtpdebuglevel($int = 0)|Change SMTP Debug Level 0 lowest - 3 highest|
|all_default_html($bool = false)|All Mail Outgoing default as HTML Type|
|change_default_template($header, $footer)| Change Default Header and Outgoing mail Footer|
|initFrom($mail, $name = false)| Set Sender Info for Outgoing (Mandatory)|
|initReplyTo($mail, $name = false)| Set Reply To Adr. for outgoing|
|test_mode($val)| Activate Test Mode - All Mails to This Adress|
|last_info()|Get Info from last Mail Sending (SMTP Message)|
-------------------------------------
|Send Functions|Description|
| --|-- |
|send($to, $toname, $title, $mailContent, $ishtml = false, $FOOTER = false, $HEADER = false, $attachments = false)| Old Function to send Mails!|
|mail($subject, $content, $receiver, $cc, $bcc, $attachment, $settings = array())| Updated Function to Send Mails <br /> $receiver, $cc, $bcc, $attachment, $settings = array() are arrays with parameters Arrays for Mail Info to Receiver are array(mail, name)|
-------------------------------------
|Misc Functions|Description|
| --|-- |
|object()| Return x_class_mail_item Object|