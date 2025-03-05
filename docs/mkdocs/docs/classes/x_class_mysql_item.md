# Class Documentation: `x_class_mysql_item`

## Documentation

The `x_class_mysql_item` class is designed to manage database records efficiently. It provides a convenient way to interact with a single database item by abstracting common operations such as retrieving, updating, and deleting records based on a specified primary key. This class simplifies CRUD (Create, Read, Update, Delete) operations, especially when dealing with single-row queries in a MySQL database.

- **Parameter Binding:** The `update()` method uses parameter binding to prevent SQL injection, making it a secure option for dynamic queries.  
- **Flexible ID Field:** The class allows for the use of custom ID fields through the `$id_field` parameter, enabling interaction with tables that use non-standard primary keys.

## Requirements

### PHP Modules
- `MySQLi`: Required for executing database queries.

### External Classes
- `x_class_mysql`: Assumes a MySQL connection object that supports `select()` and `query()` methods.

## Method Library
| Method                                    | Description                                                                                  |
|-------------------------------------------|----------------------------------------------------------------------------------------------|
| **`__construct($x_class_mysql, $tablename, $id, $id_field = "id")`** | Initializes the class with a MySQL connection, table name, item ID, and optional ID field.    |
| **`get($field)`**                         | Retrieves the value of a specific field for the current item.                                 |
| **`get_array()`**                         | Returns an associative array of the current item’s fields and values.                         |
| **`update($field, $value)`**              | Updates a specific field of the current item with a new value.                                |
| **`update_null($field)`**                 | Sets a specific field of the current item to NULL.                                            |
| **`delete()`**                            | Deletes the current item from the database.                                                   |
| **`clone($id)`**                          | Creates a new `x_class_mysql_item` instance for another item using the same table structure.  |

## Method Details

#### `__construct(...)`

| Parameter   | Type   | Default | Description                                      |
|-------------|--------|---------|--------------------------------------------------|
| `$mysql`    | Object |         | MySQLi connection object.                       |
| `$tablename`| String |         | The name of the table to interact with.         |
| `$id`       | Mixed  |         | The ID of the current item (can be numeric or string). |
| `$id_field` | String | `"id"`  | The name of the ID field in the table.          |

**Description:**  
This constructor initializes the `x_class_mysql_item` object with a MySQL connection, the table name, the ID of the item, and the ID field name. The ID field defaults to `"id"` but can be customized as needed.

#### `get(...)`

| Parameter   | Type   | Description                                      |
|-------------|--------|--------------------------------------------------|
| `$field`    | String | The name of the field to retrieve.               |

| Return Type | Description                                      |
|-------------|--------------------------------------------------|
| Mixed       | Returns the value of the specified field or `false` if the field does not exist. |

**Description:**  
Fetches the value of a specific field for the current item based on the provided ID. If the item or field does not exist, it returns `false`.

#### `get_array(...)`

| Return Type | Description                                      |
|-------------|--------------------------------------------------|
| Array       | Returns an associative array of the current item's fields and values. |

**Description:**  
Retrieves the entire row for the current item as an associative array, with the field names as keys and their corresponding values as the array values. If the item is not found, it returns `false`.

#### `update(...)`

| Parameter   | Type   | Description                                      |
|-------------|--------|--------------------------------------------------|
| `$field`    | String | The field to update.                             |
| `$value`    | Mixed  | The new value to set for the field.              |

| Return Type | Description                                      |
|-------------|--------------------------------------------------|
| Bool        | Returns `true` on success, `false` on failure.   |

**Description:**  
Updates a specific field of the current item with a new value. This method uses parameter binding to protect against SQL injection.

#### `update_null(...)`

| Parameter   | Type   | Description                                      |
|-------------|--------|--------------------------------------------------|
| `$field`    | String | The field to set to `NULL`.                      |

| Return Type | Description                                      |
|-------------|--------------------------------------------------|
| Bool        | Returns `true` on success, `false` on failure.   |

**Description:**  
Sets a specific field of the current item to `NULL`. This operation is useful for resetting fields that may need to have their values removed.

#### `delete(...)`

| Return Type | Description                                      |
|-------------|--------------------------------------------------|
| Bool        | Returns `true` on success, `false` on failure.   |

**Description:**  
Deletes the current item from the database based on its ID. This method removes the row corresponding to the ID in the specified table.

#### `clone(...)`

| Parameter   | Type   | Description                                      |
|-------------|--------|--------------------------------------------------|
| `$id`       | Mixed  | The ID of the item to clone.                     |

| Return Type | Description                                      |
|-------------|--------------------------------------------------|
| Object      | Returns a new `x_class_mysql_item` instance for the specified ID. |

**Description:**  
Creates and returns a new `x_class_mysql_item` object that references another item in the same table but with a different ID. This allows for easy manipulation of different items without needing to reinitialize the class.



