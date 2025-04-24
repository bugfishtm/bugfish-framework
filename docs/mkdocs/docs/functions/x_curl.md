# PHP Functions: Curl

Use curl-related functions by including `/_framework/functions/x_curl.php`.


!!! warning "Dependencies"
	- PHP 7.1-7.4
	- PHP 8.0-8.4
	
!!! warning "PHP-Modules"
	- `curl`: The code heavily relies on the cURL library for making HTTP requests.




| CURL Function Name                 | Description                                 |
|-----------------------------------|---------------------------------------------|
| `x_curl_getfile($file, $newFileName)` | Download a file with Curl and save to `NewFileName`. |
| `x_curl_gettext($url)`              | Get text content of a Curl request to URL. |
