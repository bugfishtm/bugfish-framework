# Class Documentation: `x_class_csrf`

### Documentation
This document provides an in-depth explanation of the `x_class_csrf` class, which is designed to manage Cross-Site Request Forgery (CSRF) tokens in a PHP application. It explains the class structure, required PHP modules, and provides detailed descriptions of the methods and their parameters. The documentation is aimed at developers who need to integrate this class into their applications and require clear guidance on how to use it effectively.

- The `norenewal` and `external_action` properties provide flexibility for different use cases, such as handling tokens across external systems or preventing token renewal.
- The `check_lkey` method is particularly important when validating tokens from a previous session, useful in scenarios involving persistent tokens.

This documentation ensures that developers can effectively integrate and use the `x_class_csrf` class in their PHP applications, maintaining security against CSRF attacks.

This class manages CSRF tokens, which are crucial for preventing unauthorized actions from being executed in web applications. It handles the generation, validation, and management of CSRF tokens across multiple sessions. Special functionalities include the ability to disable token renewal, handle external actions, and validate tokens with custom validity periods.

### Requirements

#### PHP Modules
  - `session`: For managing session data where CSRF tokens are stored.
#### External Classes
None required.

### Class Usage

#### Properties

| Property | Type    | Description                                                                                           |
|----------|---------|-------------------------------------------------------------------------------------------------------|
| `$extension`      | `string`  | Optional prefix for session keys, useful when using multiple instances of the class.     |
| `$valid_time`     | `int`     | The duration (in seconds) for which the CSRF token remains valid. Default is 300 seconds. |
| `$norenewal`      | `bool`    | Indicates whether the CSRF token should not be renewed.                                  |
| `$external_action`| `bool`    | Determines whether the CSRF token is being used for external actions.                    |
| `$c_key`          | `int`     | The current CSRF token value.                                                            |
| `$c_key_time`     | `int`     | The timestamp of the current CSRF token.                                                 |
| `$l_key`          | `int`     | The last session’s CSRF token, used for validation.                                      |
| `$l_key_time`     | `int`     | The timestamp of the last session’s CSRF token.                                          |

#### Methods

##### `__construct(...)`

| Parameter            | Type    | Description                                                                                               |
|----------------------|---------|-----------------------------------------------------------------------------------------------------------|
| `$cookie_extension`  | `string`  | Optional. Sets a prefix for session keys to avoid conflicts.                                              |
| `$second_valid`      | `int`   | Optional. Defines the validity time for the CSRF token in seconds. Default is 300 seconds.               |
| `$external_action`   | `bool`  | Optional. If true, disables token renewal and handles external actions. Default is `false`.             |

**Description**: Initializes the CSRF class, generates a new CSRF token, and manages the session keys and their timestamps. Handles special cases like external actions and token renewal.

##### `disableRenewal(...)`

| Parameter            | Type   | Description                                                       |
|----------------------|--------|-------------------------------------------------------------------|
| `$bool`              | `bool` | Optional. Disables the renewal of CSRF tokens if set to `true`.   |

**Description**: Allows disabling the automatic renewal of CSRF tokens, useful in specific cases like persistent sessions.

##### `norenewal(...)`

| Parameter            | Type   | Description                                                       |
|----------------------|--------|-------------------------------------------------------------------|
| `$bool`              | `bool` | Optional. Alias for `disableRenewal()`. Disables token renewal.   |

**Description**: Sets the `$norenewal` property, determining if tokens should not be renewed after validation.

##### `isDisabled(...)`

| Parameter | Type   | Description                        |
|-----------|--------|------------------------------------|
| None      | N/A    |                                    |

**Description**: Checks if the CSRF token renewal is disabled.

**Returns**: `bool` – Returns `true` if token renewal is disabled.

##### `external_action(...)`

| Parameter | Type   | Description                                           |
|-----------|--------|-------------------------------------------------------|
| `$bool`   | `bool` | Optional. Enables or disables external action mode.   |

**Description**: Sets the `$external_action` property, which modifies the behavior of token validation and renewal.

##### `get(...)`

| Parameter | Type   | Description              |
|-----------|--------|--------------------------|
| None      | N/A    |                          |

**Description**: Retrieves the current CSRF token.

**Returns**: `int` – The current CSRF token value.

##### `get_time(...)`

| Parameter | Type   | Description                          |
|-----------|--------|--------------------------------------|
| None      | N/A    |                                      |

**Description**: Retrieves the timestamp of the current CSRF token.

**Returns**: `int` – The timestamp when the current CSRF token was generated.

##### `get_lkey(...)`

| Parameter | Type   | Description                    |
|-----------|--------|--------------------------------|
| None      | N/A    |                                |

**Description**: Retrieves the last session’s CSRF token.

**Returns**: `int` – The last session's CSRF token value.

##### `get_lkey_time(...)`

| Parameter | Type   | Description                              |
|-----------|--------|------------------------------------------|
| None      | N/A    |                                          |

**Description**: Retrieves the timestamp of the last session’s CSRF token.

**Returns**: `int` – The timestamp of the last session's CSRF token.

##### `getField(...)`

| Parameter | Type    | Description                                                |
|-----------|---------|------------------------------------------------------------|
| `$name`   | `string` | The `name` attribute for the generated hidden input field. |
| `$id`     | `string` | Optional. The `id` attribute for the generated input field.|

**Description**: Outputs an HTML hidden input field containing the current CSRF token.

##### `crypto(...)`

| Parameter | Type   | Description                   |
|-----------|--------|-------------------------------|
| None      | N/A    |                               |

**Description**: Returns the CSRF token, either for external or current session based on the mode.

**Returns**: `int` – The relevant CSRF token value (current or last session).

##### `time(...)`

| Parameter | Type   | Description                               |
|-----------|--------|-------------------------------------------|
| None      | N/A    |                                           |

**Description**: Returns the timestamp of the CSRF token, either for external or current session based on the mode.

**Returns**: `int` – The relevant timestamp (current or last session).

##### `validate(...)`

| Parameter             | Type    | Description                                                   |
|-----------------------|---------|---------------------------------------------------------------|
| `$code`               | `int`   | The CSRF token value to validate.                             |
| `$override_valid_time`| `int`   | Optional. Custom validity duration for the token in seconds.  |

**Description**: Validates the provided CSRF token against the stored session token, checking the time validity as well.

**Returns**: `bool` – `true` if the token is valid, `false` otherwise.

##### `check(...)`

| Parameter             | Type    | Description                                                   |
|-----------------------|---------|---------------------------------------------------------------|
| `$code`               | `int`   | The CSRF token value to validate.                             |
| `$override_valid_time`| `int`   | Optional. Custom validity duration for the token in seconds.  |

**Description**: Internal method for validating the current CSRF token within the session.

**Returns**: `bool` – `true` if the token is valid, `false` otherwise.

##### `check_lkey(...)`

| Parameter             | Type    | Description                                                   |
|-----------------------|---------|---------------------------------------------------------------|
| `$code`               | `int`   | The CSRF token value to validate.                             |
| `$override_valid_time`| `int`   | Optional. Custom validity duration for the token in seconds.  |

**Description**: Internal method for validating the last session’s CSRF token, used for external actions.

**Returns**: `bool` – `true` if the token is valid, `false` otherwise.

##### `__destruct(...)`

| Parameter | Type   | Description                       |
|-----------|--------|-----------------------------------|
| None      | N/A    |                                   |

**Description**: Automatically called when the object is destroyed. It saves the current CSRF token and its timestamp in the session unless renewal is disabled.
