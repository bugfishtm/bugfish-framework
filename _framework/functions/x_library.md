# Function Framework
	This is a set of functions to use when building a webpage.

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