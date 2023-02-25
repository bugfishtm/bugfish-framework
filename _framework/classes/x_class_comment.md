# Classes Framework
	This is my personal framework, feel free to use it as you wish.  
	For help visit bugfish.eu!
	
	
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