# PHP Functions: RSS


Use rss-related functions by including `/_framework/functions/x_rss.php`.


!!! warning "Dependencies"
	- PHP 7.1-7.4
	- PHP 8.0-8.4
	
!!! warning "PHP-Modules"
	- `dom`: The DOMDocument class is used to parse and manipulate XML (RSS feeds in this case).
	- `mbstring`: Required for preg_match functions.





| **Function**                 | **Description**                                                                                                                                                                                                                                                                                                                                                                                                       | **Explanation**                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     |
|------------------------------|-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `x_rss_list($urltemp, $defaultcover, $limit = 25)` | Fetches RSS feed items from a given URL, processes them, and displays them with a default cover image if needed. Limits the number of items displayed.                                                                                                                                                                                                                                                               | The function loads the RSS feed from the provided URL (`$urltemp`) using `DOMDocument`. It extracts the title, link, publication date, and image URL from each feed item. It processes up to `$limit` items, ensuring that if no cover image is provided, a default image (`$defaultcover`) is used. It formats the date and displays each item as a clickable div with an image and title. If the image URL does not start with "http", it prepends "https://". |
| `x_rss_array($urltemp)`       | Fetches RSS feed items from a given URL and returns them as an array.                                                                                                                                                                                                                                                                                                                                                 | The function loads the RSS feed from the provided URL (`$urltemp`) using `DOMDocument`. It extracts the title, link, publication date, and image URL from each feed item and stores them in an associative array. The resulting array of feed items is returned. This array can be used for further processing or display.                                                                                                                                           |

