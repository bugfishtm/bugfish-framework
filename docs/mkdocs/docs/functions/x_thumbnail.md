# PHP Functions: Thumbnail


Use thumbnail-related functions by including `/_framework/functions/x_thumbnail.php`.


!!! warning "Dependencies"
	- PHP 7.0-7.4
	- PHP 8.0-8.4

!!! warning "PHP-Modules"
	- `gd`: Required for image creation, resizing, and saving functions.
	- `file_get_contents`: Required to read image data from URLs (usually enabled by default).



| Function Name     | Description                                           | Parameters                                                                                      |
|-------------------|-------------------------------------------------------|------------------------------------------------------------------------------------------------|
| `x_thumbnail`     | Creates a JPEG thumbnail from an image URL and saves it to a file. Returns the image resource. | `$url` (string): Source image URL<br>`$filename` (string): Path to save the JPEG thumbnail<br>`$width` (int): Thumbnail width (default 600)<br>`$height` (int/bool): Thumbnail height. If `true`, height is auto-calculated to keep aspect ratio (default `true`) |
| `x_thumbnail_save`| Creates a PNG thumbnail from a PNG image file URL and saves it to a file (if given). Returns `true` after processing. | `$url` (string): Source PNG image file URL<br>`$save_path` (string/null): Path to save the PNG thumbnail (optional)<br>`$width` (int): Thumbnail width (default 600)<br>`$height` (int/bool): Thumbnail height passed directly; no auto-calculation (default `true`) |