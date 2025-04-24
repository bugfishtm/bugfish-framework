# PHP Class: `x_class_api`

A PHP class for managing API keys, including generation, validation, revocation, and metadata. Automatically handles table creation and enforces uniqueness by `(reference, section)`.

Use the class by including `/_framework/classes/x_class_api.php`.

!!! warning "Dependencies"
	- PHP 7.0-7.4
	- PHP 8.0-8.4
	
!!! warning "PHP-Modules"
	- `mysqli`: The PHP MySQLi extension must be installed and enabled.  

!!! warning "PHP-Classes"
	- `x_class_mysql`: Required for database operations.

## Table

This table stores API keys, enforcing uniqueness on `(reference, section)` pairs. Keys have a status lifecycle (`active`, `revoked`, `expired`), timestamps for creation and usage, optional expiration, and metadata stored as JSON for extensibility. Ideal for managing scoped API access per user, app, or module.

!!! note "The table will be automatically installed upon constructor execution."

| Column        | Type           | Description                          |
|---------------|----------------|--------------------------------------|
| id            | INT UNSIGNED   | Primary key, auto-increment          |
| api_key       | VARCHAR(128)   | Unique API key                       |
| reference     | VARCHAR(128)   | Optional user/app reference          |
| section       | VARCHAR(128)   | Section or scope of API key          |
| status        | ENUM           | 'active', 'revoked', 'expired'       |
| created_at    | DATETIME       | Timestamp of creation                |
| expires_at    | DATETIME       | Optional expiration date             |
| last_used_at  | DATETIME       | Last usage timestamp                 |
| meta          | JSON           | Optional JSON metadata               |
| UNIQUE        | (reference, section) | Prevents duplicate active keys |

## Methods

---

### `__construct`

Initializes the class and ensures the API key table exists.

| Parameter   | Type   | Description                                         | Default |
|-------------|--------|-----------------------------------------------------|---------|
| `$mysql`    | object | MySQL handler object with query/select methods.     | None    |
| `$table`    | string | Name of the table to store API keys.                | None    |
| `$section`  | string | Default section or scope for API keys.              | ""      |

| Return Value | When does this return value occur? |
|--------------|------------------------------------|
| `true`       | When the table is created or already exists. |

---

### `addKey`

Adds a new API key for a given reference and section if one doesn't already exist.

| Parameter   | Type   | Description                                           | Default |
|-------------|--------|-------------------------------------------------------|---------|
| `$reference`| string | Optional identifier for the key (e.g. user ID).       | null    |
| `$section`  | string | Optional scope of the key. Uses default if not set.   | false   |
| `$expires_in_days`| int | Optional number of days until key expiration.    | null    |
| `$meta`     | array  | Optional associative array of metadata.               | null    |

| Return Value | When does this return value occur? |
|--------------|------------------------------------|
| `string` (key) | When the API key is successfully created. |
| `false`        | If a valid key already exists for the reference/section. |

---

### `refreshKey`

Regenerates the API key for a given reference/section.

| Parameter   | Type   | Description                         | Default |
|-------------|--------|-------------------------------------|---------|
| `$reference`| string | Identifier of the key to refresh.   | None    |
| `$section`  | string | Optional section of the key.        | false   |

| Return Value | When does this return value occur? |
|--------------|------------------------------------|
| `string` (new key) | If the key was updated successfully. |
| `false`            | If the update failed. |

---

###  `revokeKey`

Revokes an active API key.

| Parameter   | Type   | Description                 | Default |
|-------------|--------|-----------------------------|---------|
| `$api_key`  | string | The API key to revoke.      | None    |

| Return Value | When does this return value occur? |
|--------------|------------------------------------|
| `true`       | When the key is successfully revoked. |
| `false`      | If the key doesn't exist or is inactive. |

---

### `validateKey`

Validates the API key's status, section, and expiration.

| Parameter   | Type   | Description                         | Default |
|-------------|--------|-------------------------------------|---------|
| `$api_key`  | string | The API key to validate.            | None    |
| `$section`  | string | Optional section scope.             | false   |

| Return Value | When does this return value occur? |
|--------------|------------------------------------|
| `true`       | If the key is valid and active.    |
| `false`      | If invalid, revoked, or expired.   |

---

### `getKeyMeta`

Returns the decoded JSON metadata of a key.

| Parameter   | Type   | Description                 | Default |
|-------------|--------|-----------------------------|---------|
| `$api_key`  | string | The API key to look up.     | None    |

| Return Value | When does this return value occur? |
|--------------|------------------------------------|
| `array|null` | Returns metadata as array or null if absent. |

---

## Example

```php
$api = new x_class_api($mysql, 'api_keys', 'user');
$key = $api->addKey('user_123', null, 30, ['role' => 'admin']);
if ($api->validateKey($key)) {
    echo "Key is valid!";
}
$meta = $api->getKeyMeta($key);
$refreshed = $api->refreshKey('user_123');
$api->revokeKey($key);
```


