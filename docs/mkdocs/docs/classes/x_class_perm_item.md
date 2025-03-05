# Class Documentation: `x_class_perm_item`

## Documentation
The `x_class_perm_item` class provides functionality for managing permissions associated with a reference in a database table. It supports operations such as adding, removing, checking permissions, and managing the permissions of a specific reference.

## Requirements

### PHP Modules

| Module/Class | Description                                  |
|--------------|----------------------------------------------|
| `mysqli`     | PHP extension for MySQL database interaction.|

### External Classes

| Module/Class | Description                                  |
|--------------|----------------------------------------------|
| `x_class_mysql` | Custom class or wrapper for MySQL database operations (assumed). |


## Class Usage

#### `__construct(...)`

Initializes an instance of the `x_class_perm_item` class.

| Parameter       | Type       | Description                                                              |
|-----------------|------------|--------------------------------------------------------------------------|
| `$mysql`        | `object`    | An instance of the MySQL class used for database operations.             |
| `$tablename`    | `string`    | The name of the table where permissions are stored.                      |
| `$section`      | `string`    | The section identifier for permissions.                                  |
| `$ref`          | `string`    | The reference identifier for which permissions are managed.              |
| `$permissions`  | `array`     | Optional array of initial permissions. Default is an empty array.        |

#### `refresh(...)`

Updates the local permissions array by fetching data from the database.

| Parameter | Type   | Description                              |
|-----------|--------|------------------------------------------|
| None      | -      | Fetches permissions from the database and updates the local `permissions` array. |

#### `has_perm(...)`

Checks if a specific permission is present in the current permissions.

| Parameter  | Type    | Description                              |
|------------|---------|------------------------------------------|
| `$permname`| `string`| The name of the permission to check.     |

**Returns**: `bool` - `true` if the permission exists, `false` otherwise.

#### `add_perm(...)`

Adds a new permission to the current set of permissions.

| Parameter  | Type    | Description                              |
|------------|---------|------------------------------------------|
| `$permname`| `string`| The name of the permission to add.       |

**Returns**: `bool` - Always returns `true` if the operation is successful.

#### `check_perm(...)`

Checks if the current permissions satisfy a set of conditions.

| Parameter | Type    | Description                              |
|-----------|---------|------------------------------------------|
| `$array`  | `array` | Array of permission names to check.      |
| `$or`     | `bool`  | Optional. If `true`, checks if any permission matches; if `false`, checks if all match. Default is `false`. |

**Returns**: `bool` - `true` if the condition is met based on the `$or` parameter.

#### `remove_perm(...)`

Removes a specific permission from the current set of permissions.

| Parameter  | Type    | Description                              |
|------------|---------|------------------------------------------|
| `$permname`| `string`| The name of the permission to remove.    |

**Returns**: `bool` - `true` if the operation is successful.

#### `set_perm(...)`

Updates or inserts permissions for the reference in the database.

| Parameter | Type   | Description                              |
|-----------|--------|------------------------------------------|
| `$ref`    | `string`| The reference identifier.                |
| `$array`  | `array` | The array of permissions to set.         |

**Returns**: `bool` - `true` if the operation is successful.

#### `remove_perms(...)`

Removes all permissions associated with the reference.

| Parameter | Type   | Description                              |
|-----------|--------|------------------------------------------|
| None      | -      | Removes all permissions for the current reference. |

**Returns**: `bool` - `true` if the operation is successful.

#### `delete_ref(...)`

Deletes the reference and its associated permissions from the database.

| Parameter | Type   | Description                              |
|-----------|--------|------------------------------------------|
| None      | -      | Deletes the record for the current reference. |

**Returns**: `bool` - `true` if the operation is successful.
