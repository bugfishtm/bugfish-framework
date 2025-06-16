# PHP Class: `x_class_api`

The `x_class_api` class is designed to manage secure API keys within a MySQL database. Each key can be scoped to a specific section, assigned a reference, and managed through status flags (`active`, `revoked`, `expired`). The class supports key generation, validation, revocation, expiration, refreshing, and deletion. Time-based expiration and usage tracking are also supported.

Use the class by including `/_framework/classes/x_class_api.php`.

!!! warning "Dependencies"
	* PHP 7.1–7.4
	* PHP 8.0–8.4
	* Requires a MySQL wrapper class (provided via the `$mysql` parameter) that supports `select()`, `query()`, `table_exists()`, and `free_all()`.

!!! warning "PHP Modules"
	* `pdo_mysql` or `mysqli`: Required for MySQL database interaction.
	* `openssl` or `random_bytes`: Required for secure API key generation.

---

## Database Table Structure

When initialized, this class automatically creates the table (if it doesn't already exist). The structure is as follows:

| Column         | Type                                 | Description                           |
| -------------- | ------------------------------------ | ------------------------------------- |
| `id`           | `INT UNSIGNED AUTO_INCREMENT`        | Primary key (auto-increment).         |
| `api_key`      | `VARCHAR(128)`                       | Unique API key.                       |
| `reference`    | `VARCHAR(128)` (nullable)            | Optional external identifier or note. |
| `section`      | `VARCHAR(128)`                       | Defines scope or logical group.       |
| `status`       | `ENUM('active','revoked','expired')` | Current status of the key.            |
| `created_at`   | `DATETIME`                           | Timestamp when the key was created.   |
| `expires_at`   | `DATETIME` (nullable)                | Optional expiration date.             |
| `last_used_at` | `DATETIME` (nullable)                | Timestamp of last use.                |

---

## Methods

---

### `__construct`

Initializes the API key manager with a MySQL instance and table name. Creates the table if it does not exist.

| Parameter  | Type   | Description                            | Default |
| ---------- | ------ | -------------------------------------- | ------- |
| `$mysql`   | object | An instance of a custom MySQL wrapper. | None    |
| `$table`   | string | Name of the table to store API keys.   | None    |
| `$section` | string | Logical scope of the key (optional).   | `""`    |

| Return Value | When does this return value occur? |
| ------------ | ---------------------------------- |
| `void`       | Always. This is a constructor.     |

---

### `addKey`

Adds a new API key with an optional expiration date.

| Parameter          | Type | Description                                      | Default |
| ------------------ | ---- | ------------------------------------------------ | ------- |
| `$expires_in_days` | int  | Number of days until the key expires (nullable). | `null`  |

| Return Value | When does this return value occur?    |
| ------------ | ------------------------------------- |
| `string`     | Always returns the generated API key. |

---

### `validateKey`

Checks whether an API key is active and not expired. Also updates the `last_used_at` timestamp.

| Parameter  | Type   | Description              | Default |
| ---------- | ------ | ------------------------ | ------- |
| `$api_key` | string | The API key to validate. | None    |

| Return Value | When does this return value occur?                   |
| ------------ | ---------------------------------------------------- |
| `true`       | If the key exists, is active, and not expired.       |
| `false`      | If the key is missing, revoked, expired, or invalid. |

---

### `revokeKey`

Marks an API key as "revoked" in the database.

| Parameter  | Type   | Description            | Default |
| ---------- | ------ | ---------------------- | ------- |
| `$api_key` | string | The API key to revoke. | None    |

| Return Value | When does this return value occur?  |
| ------------ | ----------------------------------- |
| `true`       | Always returns `true` after update. |

---

### `expireKey`

Marks an API key as "expired" in the database.

| Parameter  | Type   | Description            | Default |
| ---------- | ------ | ---------------------- | ------- |
| `$api_key` | string | The API key to expire. | None    |

| Return Value | When does this return value occur?  |
| ------------ | ----------------------------------- |
| `true`       | Always returns `true` after update. |

---

### `deleteKey`

Permanently removes an API key from the database.

| Parameter  | Type   | Description            | Default |
| ---------- | ------ | ---------------------- | ------- |
| `$api_key` | string | The API key to delete. | None    |

| Return Value | When does this return value occur?    |
| ------------ | ------------------------------------- |
| `true`       | Always returns `true` after deletion. |

---

### `refreshKey`

Replaces an existing API key with a new one.

| Parameter  | Type   | Description                     | Default |
| ---------- | ------ | ------------------------------- | ------- |
| `$api_key` | string | The old API key to be replaced. | None    |

| Return Value | When does this return value occur?   |
| ------------ | ------------------------------------ |
| `string`     | Returns the newly generated API key. |

---

### `referenceKey`

Associates a human-readable or system reference to an API key.

| Parameter    | Type   | Description                  | Default |
| ------------ | ------ | ---------------------------- | ------- |
| `$api_key`   | string | The API key to update.       | None    |
| `$reference` | string | A reference value to attach. | None    |

| Return Value | When does this return value occur?  |
| ------------ | ----------------------------------- |
| `true`       | Always returns `true` after update. |

---

## Example

```php
<?php
// Initialize MySQL wrapper and API manager
$mysql = new custom_mysql(); // assume this is your wrapper class
$api = new x_class_api($mysql, 'api_keys', 'internal-service');

// Add a new key (expires in 7 days)
$newKey = $api->addKey(7);
echo "Generated API Key: $newKey\n";

// Validate it
if ($api->validateKey($newKey)) {
	echo "API key is valid.\n";
} else {
	echo "API key is invalid or expired.\n";
}

// Revoke it
$api->revokeKey($newKey);

// Try validation again
echo $api->validateKey($newKey) ? "Still valid.\n" : "Now invalid.\n";
?>
```
