# PHP Functions: Cookiebanner

Use cookie-banner-related functions by including `/_framework/functions/x_cookiebanner.php`.



!!! warning "Dependencies"
	- PHP 7.1-7.4
	- PHP 8.0-8.4
	
!!! warning "PHP-Modules"
	- `session`: The code uses PHP sessions `session_start()` and `$_SESSION` to store the Cookiebanner Approval Boolean Value. 



| **Function**                                    | **Description**                                                                                                                                                                                                                                             | **Explanation**                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    |
|-------------------------------------------------|-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `x_cookieBanner_Pre($precookie = "", $redirect = true)` | Prepares the cookie banner by setting a session variable if the banner is acknowledged, and optionally redirects to the current page.                                                                                                                    | The function checks if a session is active; if not, it starts one. It then checks if the cookie banner has been acknowledged by looking for a specific session variable. If the banner is acknowledged (via POST or GET request), it sets this session variable and optionally redirects to the current page. This helps to prevent showing the banner repeatedly after acknowledgment.                                                                                                          |
| `x_cookieBanner($precookie = "", $use_post = false, $text = false, $url_cookies = "", $redirect_url = false, $button_text = "I Agree")` | Displays a cookie consent banner with options for custom text, a redirect URL, and POST/GET submission handling.                                                                                      | The function checks if a session is active; if not, it starts one. It determines whether to display the banner based on a session variable. If the banner is not acknowledged, it displays the banner with customizable text. The form can use GET or POST methods depending on the `$use_post` parameter. If a `$redirect_url` is provided, the form action will redirect to this URL upon submission. The `$button_text` parameter sets the button label.  |
