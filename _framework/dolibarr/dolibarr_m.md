# Dolibarr Framework
	The following framework is meant to be an extension
	for the dolibarr database object to work with and more like
	table scripts and different usefull stuff.

## m_library 
|Function Name|Description|
|--|--|
|m\_month\_num\_to\_name($number) | Return Month Name or Error if Wrong (input number 1-12 to get german month name) |
|m\_isset($var)|  If var is Empty or "" than false |
|m\_login\_name\_from\_id ($db, $userid)| Get the current name of User by UserID, if error than false|
|m\_login\_id($db, \$tmp = false)| Get the current rowID of logged in User, if error than false |

## m_button 
|Function Name|Description|
|--|--|
|m\_button\_sql( $db, $name, $url, $query, $get, $break = false, \$style = "")|Add a Button to Execute a Simple SQL !  \$msgerr = "Fehler!", \$msgok = "Erfolgreich!",  Function |
|m\_button\_link($name, $url, $break = false, $style, $reacttourl = true)| Add a Default Button Linked to another Page |

## m_table 
|Function Name|Description|
|--|--|
|m\_table\_simple($title, \$array, $titlelist, $tableid, $alignarray = false, \$imgeforlist = 'generic')| Print a Simple Table|
|m\_table\_complex($title, \$array, \$titlelist,$formid = "", \$alignarray = false, \$imgeforlist ="generic")| Print a Complex Table with Search  |

## m_mysql 
|Function Name|Description|
|--|--|
|m\_db\_rowsbycleanresult(\$db, \$sql\_res)|   Get Array by provising a finished result |
|m\_db\_row($db, $query) |  Get a Single Array with $array["fieldname"] = \$value back  |
|m\_db\_row\_insert($db, \$table, \$array, \$filter =*true)| Insert into a Database with array ["fieldname"] =  \$value; |
|m\_db\_rows($db, $query)|  Get a Multiple Array with $array[COUNT]["fieldname"] = $value back |

## ! m_mastertable
	Not ready yet!