# PHP Class: `x_class_api`

## Introduction

The `x_class_api` class provides a structured way to manage API keys stored in a MySQL database. It supports creation, validation, revocation, expiration, refreshing, referencing, and deletion of API keys while maintaining related metadata such as key status, expiration dates, and usage tracking. The class automatically ensures the table for storing API keys exists.

Use this class by including `/_framework/classes/x_class_api.php`.

!!! warning "Dependencies"
	- PHP 7.0-7.4
	- PHP 8.0-8.4

!!! warning "PHP-Modules"
	- `mysqli`: The PHP MySQLi extension must be installed and enabled.

!!! warning "PHP-Classes"
	- `x_class_mysql`: Required for database operations.

## MySQL Table

This section describes the structure of the table used for storing API keys and their metadata. The table will be created automatically by the class constructor if it does not already exist.

| Column Name  | Data Type          | Attributes                     | Description                                                   |
|--------------|--------------------|--------------------------------|----------------------------------------------------------------|
| `id`         | `INT UNSIGNED`     | `NOT NULL AUTO_INCREMENT PRIMARY KEY` | Unique identifier for each API key entry.                      |
| `api_key`    | `VARCHAR(128)`     | `NOT NULL UNIQUE`               | The generated API key (unique).                                |
| `reference`  | `VARCHAR(128)`     | `NULL`                         | Optional reference or label for the API key.                  |
| `section`    | `VARCHAR(128)`     | `NOT NULL`                     | Section or scope for which the API key is valid.              |
| `api_note`   | `TEXT`             | `NOT NULL`                     | User-defined note describing the API key purpose or comments. |
| `status`     | `ENUM`             | `'active','revoked','expired'`<br/>Default: `active` | Current status of the API key.                                 |
| `created_at` | `DATETIME`         | `DEFAULT CURRENT_TIMESTAMP`    | Timestamp when the API key was created.                        |
| `expires_at` | `DATETIME`         | `NULL`                         | Optional expiration date for the API key.                      |
| `last_used_at`| `DATETIME`        | `NULL`                         | Timestamp of the last time the API key was used.               |

| Key Name            | Key Type    | Columns    | Usage                             |
|---------------------|-------------|------------|----------------------------------|
| `PRIMARY KEY`       | Primary     | `id`       | Uniquely identifies each entry.  |
| `{$table}_unique`    | Unique      | `api_key`  | Ensures unique API keys.          |

## Methods

***

### `__construct`

Initializes the class with the database connection, table name, and optionally a section/scope name.

| Parameter  | Type    | Description                            | Default       |
|------------|---------|--------------------------------------|---------------|
| `$mysql`   | object  | MySQL-like DB handler instance       | None          |
| `$table`   | string  | Name of the table for API key storage| None          |
| `$section` | string  | Optional API section/scope for keys  | `""` (empty)  |

| Return Value | Description                |
|--------------|----------------------------|
| `void`      | Constructor does not return |

***

### `addKey`

Generates a new API key and stores it, optionally with expiration, note, and reference.

| Parameter        | Type             | Description                                | Default   |
|------------------|------------------|--------------------------------------------|-----------|
| `$expires_in_days`| integer/boolean  | Number of days until expiration or false for none | `false` |
| `$note`          | string/boolean   | Optional note for the API key              | `false`   |
| `$api_reference` | string/boolean   | Optional reference label for the key       | `false`   |

| Return Value | Description                  |
|--------------|------------------------------|
| `string`    | The newly created API key    |

***

### `validateKey`

Checks if a given API key and reference are valid and active, with expiration enforcement. Updates last used timestamp on success.

| Parameter      | Type   | Description                        | Default |
|----------------|--------|----------------------------------|---------|
| `$api_key`     | string | API key to validate              | None    |
| `$api_reference`| string | Reference to match                | None    |

| Return Value | Description                             |
|--------------|---------------------------------------|
| `int|false` | Returns the database record ID on success, or `false` if invalid |

***

### `referenceKey`

Sets or updates the reference (label) for a specified API key.

| Parameter     | Type   | Description                      | Default |
|---------------|--------|--------------------------------|---------|
| `$api_key`    | string | The API key to update           | None    |
| `$reference`  | string | The new reference to assign     | None    |

| Return Value | Description                      |
|--------------|---------------------------------|
| `boolean`    | Always returns `true`            |

***

### `refreshKey`

Generates a new unique API key to replace an existing one.

| Parameter  | Type   | Description                    | Default |
|------------|--------|--------------------------------|---------|
| `$api_key` | string | The current API key to refresh | None    |

| Return Value | Description                  |
|--------------|------------------------------|
| `string`    | The newly generated API key  |

***

### `revokeKey`

Marks an API key as revoked, disabling its usage.

| Parameter  | Type   | Description              | Default |
|------------|--------|--------------------------|---------|
| `$api_key` | string | The API key to revoke    | None    |

| Return Value | Description           |
|--------------|-----------------------|
| `boolean`    | Always returns `true`  |

***

### `expireKey`

Marks an API key as expired, disabling its usage.

| Parameter  | Type   | Description           | Default |
|------------|--------|-----------------------|---------|
| `$api_key` | string | The API key to expire | None    |

| Return Value | Description           |
|--------------|-----------------------|
| `boolean`    | Always returns `true`  |

***

### `deleteKey`

Deletes an API key and its record from the database entirely.

| Parameter  | Type   | Description                | Default |
|------------|--------|----------------------------|---------|
| `$api_key` | string | The API key to delete      | None    |

| Return Value | Description           |
|--------------|-----------------------|
| `boolean`    | Always returns `true`  |

***

## Example

```php
<?php
// Instantiate DB handler
$db = new x_class_mysql(...);
$apiManager = new x_class_api($db, 'api_keys', 'my_section');

// Create a new API key valid for 30 days with a note
$newKey = $apiManager->addKey(30, 'Key for project X');

// Validate the key when received from a client
$valid = $apiManager->validateKey($newKey, 'my_section');
if ($valid !== false) {
    echo "API key is valid, id: $valid";
} else {
    echo "Invalid or expired API key.";
}

// Revoke the key later if needed
$apiManager->revokeKey($newKey);
?>
```