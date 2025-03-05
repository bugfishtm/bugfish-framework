# Class Documentation: `x_class_perm`

## Documentation
The `x_class_perm` class provides a comprehensive system for managing permissions associated with references in a database. It supports creating tables, retrieving, adding, and removing permissions for specific references.

## Requirements

### PHP Modules
| Module       | Description                                           |
|--------------------|-------------------------------------------------------|
| `mysqli`           | PHP extension for MySQL database interaction.        |

### External Classes
| Class       | Description                                           |
|--------------------|-------------------------------------------------------|
| `x_class_mysql`    | Custom class or wrapper for MySQL database operations (assumed). |
| `x_class_perm_item`| Custom class for managing permissions at a reference level (assumed). |



## Table Structure

This section describes the table structure used by the Permissions class to store permissions for various objects. The table is automatically created by the class if required for its functionality. Below is a summary of the columns and keys used in the table, along with their purposes.


| Column Name   | Data Type    | Attributes                                    | Description                                                                                         |
|---------------|--------------|-----------------------------------------------|-----------------------------------------------------------------------------------------------------|
| `id`          | `int(10)`    | `NOT NULL`, `AUTO_INCREMENT`, `PRIMARY KEY`  | A unique identifier for each permission entry, ensuring that each record can be individually tracked. |
| `ref`         | `int(10)`    | `NOT NULL`                                  | A reference number associated with the permission, used to link the permission to a specific object or entity. |
| `content`     | `text`       | `NOT NULL`                                  | Contains the permission data in serialized or structured format, defining the access rights.       |
| `section`     | `varchar(128)` | `DEFAULT NULL`                              | For Multi Site Purposes to split database data in categories.   |
| `creation`    | `datetime`   | `DEFAULT CURRENT_TIMESTAMP`                 | The timestamp when the permission entry was created. Automatically set upon insertion.            |
| `modification`| `datetime`   | `DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP` | The timestamp of the last modification to the permission entry. Automatically updated on changes. |



| Key Name      | Key Type  | Columns | Usage                                                                                                  |
|---------------|-----------|---------|--------------------------------------------------------------------------------------------------------|
| `PRIMARY KEY` | Primary   | `id`    | Ensures that each permission entry is uniquely identifiable.                                            |
| `x_class_perm` | Unique    | `ref`, `section` | Ensures that each combination of reference and section is unique, preventing duplicate permissions for the same section. |



## Class Usage

#### `__construct(...)`

Initializes an instance of the `x_class_perm` class and creates the table if it does not exist.

| Parameter    | Type     | Description                                               |
|--------------|----------|-----------------------------------------------------------|
| `$mysql`     | `object`  | An instance of the MySQL class used for database operations. |
| `$tablename` | `string`  | The name of the table where permissions are stored.       |
| `$section`   | `string`  | Optional section identifier for permissions. Default is an empty string. |

#### `create_table(...)`

Creates the permissions table if it does not exist.

| Parameter | Type   | Description                                           |
|-----------|--------|-------------------------------------------------------|
| None      | -      | Creates a table with columns for ID, reference, content, section, creation, and modification timestamps. |

#### `get_perm(...)`

Retrieves permissions for a specific reference.

| Parameter | Type   | Description                                           |
|-----------|--------|-------------------------------------------------------|
| `$ref`    | `int`  | The reference identifier to get permissions for.     |

**Returns**: `array` - An array of permissions associated with the reference.

#### `has_perm(...)`

Checks if a specific permission is assigned to a reference.

| Parameter  | Type    | Description                                             |
|------------|---------|---------------------------------------------------------|
| `$ref`     | `int`   | The reference identifier to check permissions for.     |
| `$permname`| `string`| The name of the permission to check.                   |

**Returns**: `bool` - `true` if the permission exists, `false` otherwise.

#### `add_perm(...)`

Adds a new permission to a reference.

| Parameter  | Type    | Description                                             |
|------------|---------|---------------------------------------------------------|
| `$ref`     | `int`   | The reference identifier to add a permission to.       |
| `$permname`| `string`| The name of the permission to add.                     |

**Returns**: `bool` - Always returns `true` if the operation is successful.

#### `check_perm(...)`

Checks if a reference has multiple permissions.

| Parameter | Type    | Description                                             |
|-----------|---------|---------------------------------------------------------|
| `$ref`    | `int`   | The reference identifier to check permissions for.     |
| `$array`  | `array` | Array of permission names to check.                    |
| `$or`     | `bool`  | Optional. If `true`, checks if any permission matches; if `false`, checks if all match. Default is `false`. |

**Returns**: `bool` - `true` if the condition is met based on the `$or` parameter.

#### `set_perm(...)`

Sets permissions for a specific reference. 

| Parameter | Type   | Description                                             |
|-----------|--------|---------------------------------------------------------|
| `$ref`    | `int`  | The reference identifier to set permissions for.       |
| `$array`  | `array`| The array of permissions to set.                       |

**Returns**: `bool` - `true` if the operation is successful.

#### `remove_perm(...)`

Removes a specific permission from a reference.

| Parameter  | Type    | Description                                             |
|------------|---------|---------------------------------------------------------|
| `$ref`     | `int`   | The reference identifier to remove a permission from.  |
| `$permname`| `string`| The name of the permission to remove.                  |

**Returns**: `bool` - `true` if the operation is successful.

#### `remove_perms(...)`

Removes all permissions for a specific reference.

| Parameter | Type   | Description                                             |
|-----------|--------|---------------------------------------------------------|
| `$ref`    | `int`  | The reference identifier to remove all permissions for. |

**Returns**: `bool` - `true` if the operation is successful.

#### `delete_ref(...)`

Deletes a reference and its associated permissions from the table.

| Parameter | Type   | Description                                             |
|-----------|--------|---------------------------------------------------------|
| `$ref`    | `int`  | The reference identifier to delete from the table.     |

**Returns**: `bool` - `true` if the operation is successful.

#### `item(...)`

Gets an instance of `x_class_perm_item` for a specific reference.

| Parameter | Type   | Description                                             |
|-----------|--------|---------------------------------------------------------|
| `$ref`    | `int`  | The reference identifier for which to get an item.     |

**Returns**: `x_class_perm_item` - An instance of the `x_class_perm_item` class with permissions for the specified reference.
