# Class Documentation: `x_class_crypt`

## Documentation

The `x_class_crypt` class provides encryption and decryption methods using the AES-256-CBC algorithm by default. It allows for secure data handling by encrypting and decrypting data with a specified key.

## Requirements

### PHP Modules
  - `openssl` (for encryption and decryption)

### External Classes
  - None

## Class Methods

### `__construct(...)`

**Description:**  
Initializes the `x_class_crypt` object and sets the encryption algorithm. The default algorithm is AES-256-CBC.

| **Parameter** | **Type** | **Description**                                          |
|---------------|----------|----------------------------------------------------------|
| `algo`        | `string` | The encryption algorithm to use (e.g., 'aes-256-cbc'). Default is 'aes-256-cbc'. |

**Returns:**  
- `void`

---

### `encrypt(...)`

**Description:**  
Encrypts the provided data using the specified encryption key and algorithm. Returns the encrypted data encoded in Base64.

| **Parameter** | **Type** | **Description**                                             |
|---------------|----------|-------------------------------------------------------------|
| `data`        | `string` | The data to be encrypted.                                  |
| `key`         | `string` | The encryption key, Base64 encoded.                        |

**Returns:**  
- `string` - The encrypted data, Base64 encoded, with an appended initialization vector (IV).

---

### `decrypt(...)`

**Description:**  
Decrypts the provided data using the specified encryption key and algorithm. Returns the decrypted data.

| **Parameter** | **Type** | **Description**                                             |
|---------------|----------|-------------------------------------------------------------|
| `data`        | `string` | The encrypted data, Base64 encoded, with an appended IV.   |
| `key`         | `string` | The decryption key, Base64 encoded.                        |

**Returns:**  
- `string` - The decrypted data.

## Method Examples

### `__construct()`

Initializes the `x_class_crypt` instance with a specified encryption algorithm.

**Example Usage:**
```php
$crypt = new x_class_crypt(); // Uses default 'aes-256-cbc' algorithm
$crypt = new x_class_crypt('aes-128-cbc'); // Uses 'aes-128-cbc' algorithm
```

### `encrypt()`

Encrypts data with the specified key and algorithm, returning it in a Base64 encoded format.

**Example Usage:**
```php
$crypt = new x_class_crypt();
$key = base64_encode('your-secret-key'); // Ensure key is Base64 encoded
$data = 'Sensitive data';
$encrypted = $crypt->encrypt($data, $key);
echo $encrypted;
```

### `decrypt()`

Decrypts Base64 encoded encrypted data using the specified key and algorithm.

**Example Usage:**
```php
$crypt = new x_class_crypt();
$key = base64_encode('your-secret-key'); // Ensure key is Base64 encoded
$decrypted = $crypt->decrypt($encrypted, $key);
echo $decrypted;
```
