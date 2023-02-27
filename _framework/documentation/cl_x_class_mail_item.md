# Classes Framework
	This is my personal framework, feel free to use it as you wish.  
	For help visit bugfish.eu!
	
	
## x_class_mail_item [Mastered]
	Item to Handle Mail Send Operation.
	x_class_mail object needed for construction!
	
	All Sender and Receiver information will be array(mail, name)

|Construct Function|Description|
| --|-- |
|__construct($x_class_mail)| Construct with x_class_mail_object |
---------------------------------
|Setup Function|Description|
| --|-- |
|add_attachment($path, $name = false)| Add Attachment with Path and optional Name |
|get_attachment()| Get Attachment Array |
|clear_attachment()| Empty Attachment Array |
|add_receiver($mail, $name = false)|Add Receiver with Mail and optional Name |
|get_receiver()|Get Receiver Array |
|clear_receiver()|Empty Receiver Array |
|add_cc($mail, $name = false)|Add CC with Mail and optional Name |
|get_cc()|Get CC Array |
|clear_cc()|Empty CC Array |
|add_bcc($mail, $name = false)|Add BCC with Mail and optional Name |
|get_bcc()|Get BCC Array |
|clear_bcc()|Empty BCC Array |
|add_setting($name, $value)|Add Setting with Mail and optional Name |
|get_setting()|Get Setting Array |
|clear_setting()|Empty Setting Array |
---------------------------------
|Send Function|Description|
| --|-- |
|send($subject, $content)| Send the Mail with Subject and Content|