# PHP Class: `x_class_zip`

## Introduction

The `x_class_zip` class provides methods for compressing files and directories into ZIP archives and extracting them. It supports optional encryption and decryption of ZIP files using a provided encryption class. 

Use the class by including `/_framework/classes/x_class_zip.php`.

!!! warning "Dependencies"
	- PHP 7.1-7.4
	- PHP 8.0-8.4
	
!!! warning "PHP-Modules"
	- `zip`: For ZIP file handling.  
	- `openssl`: For encryption and decryption, if x_class_crypt is used.

!!! warning "PHP-Classes"
	- `x_class_crypt`: Optional; Required for encryption and decryption functionality.

## Methods


### `zip`

This method zips the provided file or directory into a destination ZIP file, with optional encryption.

| Parameter         | Type     | Description                                                                                 | Default        |
|-------------------|----------|---------------------------------------------------------------------------------------------|----------------|
| `$file_source`    | string   | The path to the file or directory to zip.                                                   | None           |
| `$file_destination_zip` | string   | The path where the zip file should be saved.                                                 | None           |
| `$x_class_crypt`  | object   | An optional encryption object to encrypt the zip file.                                      | false          |
| `$cryptokey`      | string   | The encryption key if encryption is applied.                                                | false          |
| `$tempfile`       | string   | Temporary file path used to store the zip file before encryption (if applicable).            | false          |

| Return Value   | When does this return value occur?  | 
|----------------|-------------------------------------|
| `true`         | The zip operation is successful, and the file is created or encrypted.                    |
| `false`        | An error occurs (e.g., the file to zip doesn’t exist, destination already exists, etc.).   |

---

### `unzip`

This method extracts the contents of a ZIP file to the specified destination. It supports optional decryption.

| Parameter         | Type     | Description                                                                                 | Default        |
|-------------------|----------|---------------------------------------------------------------------------------------------|----------------|
| `$from`           | string   | The path to the zip file to unzip.                                                           | None           |
| `$to`             | string   | The destination path where the contents of the zip file will be extracted.                 | None           |
| `$x_class_crypt`  | object   | An optional encryption object to decrypt the zip file.                                      | false          |
| `$cryptokey`      | string   | The decryption key if the file is encrypted.                                                 | false          |
| `$tempfile`       | string   | Temporary file path used to store the decrypted content before extracting.                  | false          |

| Return Value   | When does this return value occur?  | 
|----------------|-------------------------------------|
| `true`         | The unzip operation is successful, and the contents are extracted.                         |
| `false`        | An error occurs (e.g., invalid file, destination exists, or decryption fails).             |

## Example

```php
<?php
// Include the x_class_zip class file
require_once 'x_class_zip.php';

// Create an instance of the x_class_zip class
$zipper = new x_class_zip();

// Example 1: Zipping a file without encryption
$file_source = 'path/to/your/file.txt';          // The file to zip
$file_destination_zip = 'path/to/destination.zip'; // The destination zip file

$zipper->zip($file_source, $file_destination_zip);

// Example 2: Zipping a directory with encryption
$file_source = 'path/to/your/directory';          // The directory to zip
$file_destination_zip = 'path/to/destination_encrypted.zip'; // The destination encrypted zip file

// Assuming you have a class for encryption like x_class_crypt
$x_class_crypt = new YourEncryptionClass();
$cryptokey = 'your-encryption-key';  // The encryption key

$zipper->zip($file_source, $file_destination_zip, $x_class_crypt, $cryptokey);

// Example 3: Unzipping a file with encryption
$zip_file = 'path/to/encrypted.zip'; // The encrypted zip file
$destination_folder = 'path/to/extracted_files'; // Destination folder to extract to

$zipper->unzip($zip_file, $destination_folder, $x_class_crypt, $cryptokey);

// Example 4: Unzipping a file without encryption
$zip_file = 'path/to/your/zipfile.zip'; // The zip file
$destination_folder = 'path/to/extracted_files'; // Destination folder to extract to

$zipper->unzip($zip_file, $destination_folder);
?>

```