# Class Documentation: `x_class_2fa`  

## Documentation
The `x_class_2fa` class provides functionality for two-factor authentication (2FA). It generates and verifies time-based one-time passwords (TOTPs) using a secret key. This class is useful for implementing secure 2FA in applications to enhance user security. This class provides methods to generate and verify time-based one-time passwords (TOTPs) for two-factor authentication. It uses a shared secret key and generates a new code based on the current time, which is valid for a short period (30 seconds by default).


- **Time-based Code**: The generated code is based on the current time and is valid for a short period (30 seconds). Ensure that your server’s time is accurate to avoid synchronization issues.
- **Base64 Encoding**: The secret key is expected to be base64-encoded. Ensure that the key used for verification is properly encoded and decoded.
- **Code Length**: The length of the generated code can be adjusted by setting the `$codeLength` parameter in the constructor. The default length is 6 digits.


## Requirements

### PHP Modules
- `session`: Required if you plan to use sessions with 2FA. Ensure session support is enabled in your PHP configuration.  
- `hashing`: Required for cryptographic functions used in generating and verifying codes. Typically, PHP’s default installation includes this.

### External Classes
This class does not depend on any external classes.

## Properties

| Property   | Type   | Description                             |
|------------|--------|-----------------------------------------|
| `secretKey` | string | The base64-encoded secret key used for generating and verifying 2FA codes. |
| `codeLength` | int    | The length of the generated 2FA codes (default is 6). |

## Methods

### `__construct(...)`

| Parameter   | Type   | Description                                         |
|-------------|--------|-----------------------------------------------------|
| `$secretKey` | string | The base64-encoded secret key used for generating and verifying 2FA codes. |
| `$codeLength` | int    | Optional. The length of the generated 2FA codes (default is 6). |

- **Description**: Initializes the `x_class_2fa` object with a secret key and an optional code length. Sets up the properties for generating and verifying 2FA codes.
- **Returns**: None.

### `generateSecretKey(...)`

| Parameter | Type | Description                                |
|-----------|------|--------------------------------------------|
| `$length` | int  | Optional. The length of the generated secret key in bytes (default is 16). |

- **Description**: Generates a random secret key of the specified length. The key is encoded in base64 format.
- **Returns**: A base64-encoded string representing the generated secret key.

### `generateCode(...)`

| Parameter | Type  | Description                             |
|-----------|-------|-----------------------------------------|
| None      | None  | Generates a time-based one-time password (TOTP). |

- **Description**: Generates a 2FA code based on the current time. The code is valid for 30 seconds and is derived from the secret key and the current timestamp.
- **Returns**: A string representing the generated 2FA code, padded to the specified length.

### `verifyCode(...)`

| Parameter | Type   | Description                             |
|-----------|--------|-----------------------------------------|
| `$code`   | string | The 2FA code to verify.                 |

- **Description**: Verifies the provided 2FA code by comparing it with the generated code. The method returns `true` if the code matches the generated code, otherwise `false`.
- **Returns**: `true` if the provided code matches the generated code; `false` otherwise.
