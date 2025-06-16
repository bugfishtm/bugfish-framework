# PHP Class: `x_class_2fa`

The `x_class_2fa` class enables secure two-factor authentication (2FA) using time-based one-time passwords (TOTPs). It relies on a **Base32-encoded** secret key (RFC 4648, no padding) to generate and verify short-lived codes, typically valid for 30 seconds. The default code length is 6 digits but can be customized via the `$codeLength` parameter. Accurate server time is crucial for successful code validation.

Use the class by including `/_framework/classes/x_class_2fa.php`.

!!! warning "Dependencies"
	- PHP 7.1–7.4
	- PHP 8.0–8.4

!!! warning "PHP Modules"
	* `session`: Required if you intend to associate 2FA codes with session data. Typically bundled in PHP by default.
	* `hashing`: Required for HMAC-SHA1 operations used in generating and verifying codes. Included by default in standard PHP installations.

## Methods

---

### `__construct`

Initializes the 2FA class with a Base32-encoded secret key and an optional code length.

| Parameter     | Type   | Description                                                                | Default |
| ------------- | ------ | -------------------------------------------------------------------------- | ------- |
| `$secretKey`  | string | The Base32-encoded secret key used for generating and verifying 2FA codes. | None    |
| `$codeLength` | int    | The length of the 2FA code to be generated.                                | 6       |

| Return Value | When does this return value occur?                 |
| ------------ | -------------------------------------------------- |
| `void`       | Always. This is a constructor and returns nothing. |

---

### `generateSecretKey`

Generates a cryptographically secure Base32-encoded secret key for 2FA.

| Parameter | Type | Description                                         | Default |
| --------- | ---- | --------------------------------------------------- | ------- |
| `$length` | int  | Number of random bytes to generate before encoding. | 16      |

| Return Value              | When does this return value occur?                           |
| ------------------------- | ------------------------------------------------------------ |
| `string` (Base32-encoded) | Always returns a Base32-encoded string representing the key. |

---

### `generateCode`

Generates a time-based one-time password (TOTP) using the secret key.

| Parameter  | Type | Description                                                               | Default |
| ---------- | ---- | ------------------------------------------------------------------------- | ------- |
| `$forTime` | int  | Optional Unix timestamp to generate the code for (for testing/debugging). | `null`  |

| Return Value | When does this return value occur?                                |
| ------------ | ----------------------------------------------------------------- |
| `string`     | Returns a numeric code that is valid for a 30-second time window. |

---

### `verifyCode`

Verifies whether the provided code is valid for the current or nearby time windows.

| Parameter | Type   | Description                                                      | Default |
| --------- | ------ | ---------------------------------------------------------------- | ------- |
| `$code`   | string | The 2FA code to verify.                                          | None    |
| `$window` | int    | Number of 30-second intervals to allow as drift (e.g. 1 = ±30s). | 1       |

| Return Value | When does this return value occur?                                  |
| ------------ | ------------------------------------------------------------------- |
| `true`       | If the provided code is valid within the allowed time window.       |
| `false`      | If the code does not match or is outside the acceptable time drift. |

---

## Example

```php
<?php
// Example: Using the x_class_2fa class for generating and verifying 2FA codes

// Step 1: Generate a new Base32 secret key
$secretKey = x_class_2fa::generateSecretKey();

// Step 2: Initialize the 2FA class
$twofa = new x_class_2fa($secretKey);

// Step 3: Generate a 2FA code
$generatedCode = $twofa->generateCode();
echo "Generated 2FA Code: " . $generatedCode . "\n";

// Step 4: Verify the 2FA code
$isCodeValid = $twofa->verifyCode($generatedCode);
if ($isCodeValid) {
    echo "The 2FA code is valid.\n";
} else {
    echo "The 2FA code is invalid.\n";
}

// Step 5: Simulate code expiration
sleep(30);
$newCode = $twofa->generateCode();
echo "New 2FA Code after 30 seconds: " . $newCode . "\n";
?>
```
