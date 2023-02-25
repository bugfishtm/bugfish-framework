# Classes Framework
	This is my personal framework, feel free to use it as you wish.  
	For help visit bugfish.eu!
	
	
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