# PHP Class: `x_class_csrf`

This document provides an in-depth explanation of the `x_class_csrf` class, which is designed to manage Cross-Site Request Forgery (CSRF) tokens in a PHP application. It explains the class structure, required PHP modules, and provides detailed descriptions of the methods and their parameters. The documentation is aimed at developers who need to integrate this class into their applications and require clear guidance on how to use it effectively.

- The `norenewal` and `external_action` properties provide flexibility for different use cases, such as handling tokens across external systems or preventing token renewal.
- The `check_lkey` method is particularly important when validating tokens from a previous session, useful in scenarios involving persistent tokens.

This documentation ensures that developers can effectively integrate and use the `x_class_csrf` class in their PHP applications, maintaining security against CSRF attacks.

This class manages CSRF tokens, which are crucial for preventing unauthorized actions from being executed in web applications. It handles the generation, validation, and management of CSRF tokens across multiple sessions. Special functionalities include the ability to disable token renewal, handle external actions, and validate tokens with custom validity periods.

Use the class by including `/_framework/classes/x_class_csrf.php`.

!!! warning "Dependencies"
	- PHP 7.0–7.4  
	- PHP 8.0–8.4  

!!! warning "PHP-Modules"
	- `session`: PHP sessions must be enabled and started before CSRF protection can function correctly.


## Properties

| Parameter         | Type    | Description                                                  | Default |
|------------------|---------|--------------------------------------------------------------|---------|
| `$cookie_extension` | string  | A prefix for session keys to allow multiple tokens          | `""`    |
| `$second_valid`     | int     | Duration in seconds the CSRF token remains valid            | `300`   |
| `$external_action`  | bool    | If set to true, disables renewal and references last token  | `false` |
| `$bool`             | bool    | Used in `disableRenewal`, `norenewal`, and `external_action` to toggle states | `false` |
| `$name`             | string  | Field name for hidden CSRF input                            |         |
| `$id`               | string  | ID for the hidden CSRF input                                | `""`    |
| `$code`             | string  | Submitted CSRF token to validate                            |         |
| `$override_valid_time` | int/bool | Custom validity time override during validation          | `false` |

## Methods

### `__construct`

Initializes session and CSRF state, handles previous tokens, and configures settings.

| Parameter         | Type   | Description                                                  | Default |
|------------------|--------|--------------------------------------------------------------|---------|
| `$cookie_extension` | string | Prefix for session key names                                 | `""`    |
| `$second_valid`     | int    | Time (in seconds) for token validity                        | `300`   |
| `$external_action`  | bool   | Use last session key and disable renewal                    | `false` |

| Return Value | When does this return value occur?       |
|--------------|------------------------------------------|
| N/A          | Constructor does not return a value.     |

---

### `disableRenewal`

Disables automatic renewal of CSRF token at end of lifecycle.

| Return Value | When does this return value occur?       |
|--------------|------------------------------------------|
| `void`       | Always – sets internal flag.              |

---

### `norenewal`

Alias to `disableRenewal`, same behavior.

| Return Value | When does this return value occur?       |
|--------------|------------------------------------------|
| `void`       | Always.                                  |

---

### `isDisabled`

Checks if renewal has been disabled.

| Return Value | When does this return value occur?       |
|--------------|------------------------------------------|
| `true/false` | Returns true if renewal is disabled.     |

---

### `external_action`

Sets or unsets external action usage.

| Return Value | When does this return value occur?       |
|--------------|------------------------------------------|
| `void`       | Always.                                  |

---

### `get`

Returns the current session CSRF key.

| Return Value | When does this return value occur?       |
|--------------|------------------------------------------|
| `int`        | On call, returns current token.          |

---

### `get_time`

Returns the current session CSRF key's timestamp.

| Return Value | When does this return value occur?       |
|--------------|------------------------------------------|
| `int/bool`   | Timestamp or `false` if not set.         |

---

### `get_lkey`

Returns last session's CSRF key.

| Return Value | When does this return value occur?       |
|--------------|------------------------------------------|
| `int/bool`   | Previous session token or `false`.       |

---

### `get_lkey_time`

Returns last session's CSRF key timestamp.

| Return Value | When does this return value occur?       |
|--------------|------------------------------------------|
| `int/bool`   | Previous session time or `false`.        |

---

### `getField`

Echoes a hidden input field containing the current CSRF key.

| Return Value | When does this return value occur?       |
|--------------|------------------------------------------|
| `void`       | Always – HTML field is printed.          |

---

### `crypto`

Returns the relevant CSRF key based on mode (external/current).

| Return Value | When does this return value occur?       |
|--------------|------------------------------------------|
| `int`        | Either current or last token.            |

---

### `time`

Returns the relevant timestamp based on mode (external/current).

| Return Value | When does this return value occur?       |
|--------------|------------------------------------------|
| `int/bool`   | Token timestamp or `false`.              |

---

### `validate`

Validates submitted CSRF token against session values.

| Return Value | When does this return value occur?       |
|--------------|------------------------------------------|
| `true`       | When the token matches and is not expired. |
| `false`      | Otherwise.                               |

---

### `check`

Validates current session CSRF token.

| Return Value | When does this return value occur?       |
|--------------|------------------------------------------|
| `true`       | Token is valid and within time.          |
| `false`      | Otherwise.                               |

---

### `check_lkey`

Validates last session CSRF token.

| Return Value | When does this return value occur?       |
|--------------|------------------------------------------|
| `true`       | Token is valid and within time.          |
| `false`      | Otherwise.                               |

---

## Example

```php
$csrf = new x_class_csrf("user_", 300, false);

// Include hidden field in form
$csrf->getField("csrf_token");

// Validate on POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!$csrf->validate($_POST['csrf_token'])) {
        die("Invalid CSRF token.");
    } else {
        echo "Valid request.";
    }
}
```


