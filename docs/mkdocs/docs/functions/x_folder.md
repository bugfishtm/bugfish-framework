# PHP Functions: Folders

Use functions described below by including `/_framework/functions/x_folder.php`.

!!! warning "Dependencies"
	- PHP 7.1-7.4
	- PHP 8.0-8.4
	
!!! warning "PHP-Modules"
	- `mbstring`: Required for preg_match functions.

| Function Name                | Description                                                             | Parameter                                                                                                                     |
|-------------------------------------|-------------------------------------------------------------------------|-------------------------------------------------------------------------------------------------------------------------------|
| `x_copy_directory($src, $dst)`       | Copy content of a folder recursively to another folder.                 | - `src`: Folder Path (FULL) to Copy.<br>- `dst`: Destination Folder Name to Copy to.                                         |
| `x_htaccess_secure($path)`           | Secure a folder by placing an `.htaccess` file to deny folder content.   | - `path`: Path where the `.htaccess` should be placed.                                                                       |
| `x_rmdir`                           | Recursively delete a folder.                                            | - `dir`: Directory path to be deleted recursively.                                                                          