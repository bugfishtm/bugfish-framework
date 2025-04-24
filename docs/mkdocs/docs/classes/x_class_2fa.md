# PHP Class: `x_class_2fa`  

The `x_class_2fa` class enables secure two-factor authentication (2FA) using time-based one-time passwords (TOTPs). It relies on a base64-encoded secret key to generate and verify short-lived codes, typically valid for 30 seconds. The default code length is 6 digits but can be adjusted using the `$codeLength` parameter. Accurate server time is essential to ensure proper code synchronization.

Use the class by including `/_framework/classes/x_class_2fa.php`.

!!! warning "Dependencies"
	- PHP 7.1-7.4
	- PHP 8.0-8.4
	
!!! warning "PHP-Modules"
	- `session`: Required if you plan to use sessions with 2FA. Ensure session support is enabled in your PHP configuration. Typically, PHP’s default installation includes this.  
	- `hashing`: Required for cryptographic functions used in generating and verifying codes. Typically, PHP’s default installation includes this.

## Methods

### `__construct`

Initializes the 2FA class with a secret key and an optional code length.

| Parameter     | Type   | Description                                                               | Default |
|---------------|--------|---------------------------------------------------------------------------|---------|
| `$secretKey`  | string | The base64-encoded secret key used for generating and verifying 2FA codes. | None    |
| `$codeLength` | int    | The length of the 2FA code to be generated.                                | 6       |

| Return Value | When does this return value occur? |
|--------------|-------------------------------------|
| `void`       | This is a constructor and does not return a value. |

---

### `generateSecretKey`

Generates a random secret key used for 2FA.

| Parameter | Type | Description                                      | Default |
|-----------|------|--------------------------------------------------|---------|
| `$length` | int  | The number of random bytes to generate before encoding. | 16      |

| Return Value           | When does this return value occur?                                     |
|------------------------|------------------------------------------------------------------------|
| `string` (base64-encoded) | Always returns a base64-encoded random string of the given byte length. |

---

### `generateCode`

Generates a time-based one-time password (TOTP) using the secret key.

| Parameter | Type | Description          | Default |
|-----------|------|----------------------|---------|
| _None_    | —    | This method takes no parameters. | —       |

| Return Value | When does this return value occur?                                |
|--------------|-------------------------------------------------------------------|
| `string`     | Returns a TOTP code that is valid for a 30-second time window. |

---

### `verifyCode`

Verifies whether the provided code matches the currently valid 2FA code.

| Parameter | Type   | Description                          | Default |
|-----------|--------|--------------------------------------|---------|
| `$code`   | string | The 2FA code to be verified.          | None    |

| Return Value | When does this return value occur?                                         |
|--------------|----------------------------------------------------------------------------|
| `true`       | If the provided code matches the generated code for the current time slot. |
| `false`      | If the code is incorrect or expired.                                       |

## Example

```php
<?php
// Example of using the x_class_2fa class for generating and verifying 2FA codes

// Step 1: Initialize the 2FA class with a secret key (base64 encoded)
$secretKey = x_class_2fa::generateSecretKey(); // Generate a random secret key
$twofa = new x_class_2fa($secretKey);

// Step 2: Generate a 2FA code
$generatedCode = $twofa->generateCode();
echo "Generated 2FA Code: " . $generatedCode . "\n";

// Step 3: Verify the 2FA code
$isCodeValid = $twofa->verifyCode($generatedCode);
if ($isCodeValid) {
    echo "The 2FA code is valid.\n";
} else {
    echo "The 2FA code is invalid.\n";
}

// Step 4: Example of code expiration (simulate by checking if the code has changed after a delay)
sleep(30); // Wait for the code to expire (assuming 30-second expiration window)
$newGeneratedCode = $twofa->generateCode();
echo "New Generated 2FA Code after 30 seconds: " . $newGeneratedCode . "\n";
?>
```