# PHP Class: `x_class_crypt`

## Introduction

The `x_class_crypt` class provides encryption and decryption methods using the AES-256-CBC algorithm by default. It allows for secure data handling by encrypting and decrypting data with a specified key.

Use the class by including `/_framework/classes/x_class_crypt.php`.

!!! warning "Dependencies"
	- PHP 7.0–7.4  
	- PHP 8.0–8.4  

!!! warning "PHP-Modules"
	- `openssl`: Required for encryption and decryption operations.

## Methods

---

### `__construct`

Contructor for the class.

| Parameter | Type   | Description                           | Default       |
|-----------|--------|---------------------------------------|---------------|
| `$algo`   | string | The encryption algorithm to use. Must be supported by OpenSSL. | `'aes-256-cbc'` |

| Return Value | When does this return value occur? |
|--------------|------------------------------------|
| `void`       | Always. Constructor initializes the class with selected algorithm. |

---

### `encrypt`

Encrypt Data and Return

| Parameter | Type   | Description                                                  | Default |
|-----------|--------|--------------------------------------------------------------|---------|
| `$data`   | string | The plaintext data to encrypt.                                | None    |
| `$key`    | string | Base64-encoded key used for encryption. Must match algorithm requirements. | None    |

| Return Value | When does this return value occur?                |
|--------------|---------------------------------------------------|
| `string`     | Returns base64-encoded encrypted data with IV included. |

---

### `decrypt`

Decrypt Data and Return

| Parameter | Type   | Description                                                   | Default |
|-----------|--------|---------------------------------------------------------------|---------|
| `$data`   | string | Base64-encoded string containing the encrypted data and IV.    | None    |
| `$key`    | string | Base64-encoded key used for decryption. Must match encryption key. | None    |

| Return Value | When does this return value occur?           |
|--------------|----------------------------------------------|
| `string`     | Returns decrypted plaintext if successful.   |

---

## Example

```php
$key = base64_encode(openssl_random_pseudo_bytes(32)); // generate secure key
$crypt = new x_class_crypt(); // defaults to aes-256-cbc

$original = "Secret Message!";
$encrypted = $crypt->encrypt($original, $key);
$decrypted = $crypt->decrypt($encrypted, $key);

echo "Original: $original\n";
echo "Encrypted: $encrypted\n";
echo "Decrypted: $decrypted\n";
```
