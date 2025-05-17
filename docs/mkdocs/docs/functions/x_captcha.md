# PHP Functions: Captchas


Use captcha-related functions by including `/_framework/functions/x_captcha.php`.



!!! warning "Dependencies"
	- PHP 7.1-7.4
	- PHP 8.0-8.4
	
!!! warning "PHP-Modules"
	- `gd`: The function uses GD functions like `imagecreatetruecolor()`, `imagecolorallocate()`, `imagefilledrectangle()`, `imageellipse()`, `imagefttext()`, and `imagejpeg()`.
	- `session`: The code uses PHP sessions `session_start()` and `$_SESSION` to store the CAPTCHA code. 


| **Function**                         | **Description**                                                                                                 | **Explanation**                                                                                                                                                                                                                                                                                                                                                                                                                             |
|--------------------------------------|---------------------------------------------------------------------------------------------------------------|---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `x_captcha($preecookie = "", $width = 550, $height = 250, $square_count = 5, $eclipse_count = 5, $color_ar = false, $font = "", $code = "")` | Generates a CAPTCHA image with customizable dimensions, shapes, colors, and text.                                                                           | The function creates a CAPTCHA image for verification purposes. It initializes colors for squares, ellipses, background, and text. It then creates an image of specified dimensions and draws randomly placed squares and ellipses. The CAPTCHA code is stored in the session and rendered onto the image using a specified font. Headers are set to prevent caching of the image. The resulting image is output as JPEG. |
| `x_captcha_key($preecookie = "")`    | Retrieves the CAPTCHA code stored in the session.                                                            | This function returns the CAPTCHA code stored in the session variable specified by `$preecookie`. This allows for the comparison of user input against the generated CAPTCHA code to verify correctness.                                                                                                                                                                                                                          |

