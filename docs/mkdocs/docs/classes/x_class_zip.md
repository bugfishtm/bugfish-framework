# Class Documentation: `x_class_zip`

## Documentation

The `x_class_zip` class provides methods for compressing files and directories into ZIP archives and extracting them. It supports optional encryption and decryption of ZIP files using a provided encryption class. 

## Requirements

### PHP Modules
  - `zip` (for ZIP file handling)  
  - `openssl` (for encryption and decryption, if used)

### External Classes
  - `x_class_crypt` (optional; required for encryption and decryption functionality)

## Class Methods

### `__construct(...)`

**Description:**  
Initializes an instance of the `x_class_zip` class.

| **Method**   | **Parameters** | **Description**                        |
|--------------|----------------|----------------------------------------|
| `__construct` | None           | Initializes the `x_class_zip` object.  |

### `zip(...)`

**Description:**  
Creates a ZIP archive from a file or directory. Optionally encrypts the ZIP file using an encryption class.

| **Parameter**        | **Type** | **Description**                                                                 |
|----------------------|----------|---------------------------------------------------------------------------------|
| `file_source`        | `string` | The path to the file or directory to be compressed.                             |
| `file_destination_zip` | `string` | The path where the ZIP file will be created.                                   |
| `x_class_crypt`      | `object` (optional) | An instance of an encryption class for encrypting the ZIP file.              |
| `cryptokey`          | `string` (optional) | The key used for encryption, if encryption is enabled.                       |
| `tempfile`           | `string` (optional) | The path for a temporary file used during encryption. Defaults to `{file_destination_zip}.cryptzip`. |

**Returns:**  
- `true` on success
- `false` on failure


The `zip()` method creates a ZIP archive from the specified file or directory. It supports optional encryption via an external encryption class.

**Example Usage:**
```php
$zipper = new x_class_zip();
$crypt = new x_class_crypt(); // Assuming x_class_crypt is properly defined
$cryptokey = 'your-encryption-key';
$zipper->zip('/path/to/source', '/path/to/destination.zip', $crypt, $cryptokey);
```



### `unzip(...)`

**Description:**  
Extracts a ZIP archive to a specified directory. Optionally decrypts the ZIP file using an encryption class.

| **Parameter**        | **Type** | **Description**                                                                 |
|----------------------|----------|---------------------------------------------------------------------------------|
| `from`               | `string` | The path to the ZIP file to be extracted.                                       |
| `to`                 | `string` | The directory where the files will be extracted.                                |
| `x_class_crypt`      | `object` (optional) | An instance of an encryption class for decrypting the ZIP file.              |
| `cryptokey`          | `string` (optional) | The key used for decryption, if decryption is enabled.                       |
| `tempfile`           | `string` (optional) | The path for a temporary file used during decryption. Defaults to `{to}.cryptzip`. |

**Returns:**  
- `true` on success
- `false` on failure


The `unzip()` method extracts a ZIP archive to a specified directory and supports optional decryption.

**Example Usage:**
```php
$zipper = new x_class_zip();
$crypt = new x_class_crypt(); // Assuming x_class_crypt is properly defined
$cryptokey = 'your-encryption-key';
$zipper->unzip('/path/to/source.zip', '/path/to/extract/directory', $crypt, $cryptokey);
```
