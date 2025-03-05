# Class Documentation: `x_class_log` 

## Documentation 

The `x_class_log` class provides functionality for logging messages to a database table. It supports various log levels (such as errors, warnings, and notifications) and includes methods for retrieving, posting, and managing log entries.

- **Table Management**: The class ensures that the log table exists and is created if necessary. This includes managing the table schema and auto-increment settings.
- **Alias Methods**: Methods like `post()`, `send()`, and `write()` are aliases for `message()`, providing various ways to log messages with different naming conventions.
- **Logging

 Levels**: The class supports different log levels (error, warning, notification) which are defined by integer values. The `type` parameter in `message()` and its aliases determines the log level.  
- **Error Handling**: The class does not explicitly handle errors or exceptions; it relies on the underlying MySQL connection to manage errors.  

This class manages log entries in a MySQL database, allowing you to create, retrieve, and delete log messages categorized by type.

## Requirements

### PHP Modules
- `MySQLi`: Required for database operations.
- `Session`: Used for managing sessions if needed (not directly used in this class but might be required by associated classes).

### External Classes
- **x_class_mysql**: x_class_mysql for Database Operations.


## Table Structure

This section details the structure of the table used by the logging class to record various activities, such as errors, warnings, and notifications. The table is automatically created by the class if needed for functionality. Below is a summary of the columns and keys in the table, along with their intended use.

| Column Name | Data Type    | Attributes                               | Description                                                                                         |
|-------------|--------------|------------------------------------------|-----------------------------------------------------------------------------------------------------|
| `id`        | `int(10)`    | `NOT NULL`, `AUTO_INCREMENT`, `PRIMARY KEY` | A unique identifier for each log entry, ensuring that each activity is individually trackable.      |
| `type`      | `int(10)`    | `DEFAULT '0'`                            | Indicates the type of log entry: `0` - Unspecified, `1` - Error, `2` - Warning, `3` - Notification. |
| `message`   | `text`       |                                          | Contains the main text of the log message, providing details about the logged activity.             |
| `ref`       | `text`       |                                          | Includes any reference related to the message, such as a file name or error code, for additional context. |
| `section`   | `varchar(128)` | `NULL`                                 | For Multi Site Purposes to split database data in categories.  |
| `creation`  | `datetime`   | `DEFAULT CURRENT_TIMESTAMP`              | Records the timestamp when the log entry was created, allowing for chronological tracking.         |

| Key Name      | Key Type  | Columns | Usage                                                                                                  |
|---------------|-----------|---------|--------------------------------------------------------------------------------------------------------|
| `PRIMARY KEY` | Primary   | `id`    | Ensures that each log entry is uniquely identifiable.                                                  |


## Class Properties

### `mysql`

| Property | Type   | Description                                 |
|----------|--------|---------------------------------------------|
| `x_class_mysql`  | object | An instance of a MySQL connection object, expected to have methods for querying and table management. |

### `table`

| Property | Type   | Description                      |
|----------|--------|----------------------------------|
| `table`  | string | The name of the table used for storing log entries. |

### `section`

| Property | Type   | Description                      |
|----------|--------|----------------------------------|
| `section`| string | The section or category of logs. |


## Class Methods

### `__construct(...)`

| Parameter    | Type   | Description                                |
|--------------|--------|--------------------------------------------|
| `$x_class_mysql`     | object | An instance of the x_class_mysql object.       |
| `$tablename` | string | The name of the table to store logs.       |
| `$section`   | string | Optional. The section or category for the logs. |

- **Description**: Initializes the `x_class_log` object, sets up the table if it does not exist.

### `create_table(...)`

| Parameter | Type  | Description                              |
|-----------|-------|------------------------------------------|
| None      | None  | Creates the log table in the database if it does not exist. |

- **Description**: This private method executes a SQL query to create the table schema.

### `get_array(...)`

| Parameter | Type  | Description                   |
|-----------|-------|-------------------------------|
| None      | None  | Retrieves all log entries as an array. |

- **Returns**: An array of log entries from the table.

### `post(...)`

| Parameter | Type   | Description                           |
|-----------|--------|---------------------------------------|
| `$message`| string | The log message to store.             |
| `$type`   | int    | Optional. Type of log (default is 3 - Notification). |
| `$ref`    | mixed  | Optional. A reference or additional info. |

- **Description**: Inserts a log entry with the given message and type. Calls the `message()` method.
- **Returns**: Result of the database query execution.

### `send(...)`

| Parameter | Type   | Description                           |
|-----------|--------|---------------------------------------|
| `$message`| string | The log message to store.             |
| `$type`   | int    | Optional. Type of log (default is 3 - Notification). |
| `$ref`    | mixed  | Optional. A reference or additional info. |

- **Description**: Alias for `post()`. Inserts a log entry with the given message and type.
- **Returns**: Result of the database query execution.

### `write(...)`

| Parameter | Type   | Description                           |
|-----------|--------|---------------------------------------|
| `$message`| string | The log message to store.             |
| `$type`   | int    | Optional. Type of log (default is 3 - Notification). |
| `$ref`    | mixed  | Optional. A reference or additional info. |

- **Description**: Alias for `post()`. Inserts a log entry with the given message and type.
- **Returns**: Result of the database query execution.

### `message(...)`

| Parameter | Type   | Description                           |
|-----------|--------|---------------------------------------|
| `$message`| string | The log message to store.             |
| `$type`   | int    | Type of log (1 - Error, 2 - Warning, 3 - Notification). |
| `$ref`    | mixed  | Optional. A reference or additional info. |

- **Description**: Inserts a log entry into the table with the specified type and reference.
- **Returns**: Result of the database query execution.

### `info(...)`

| Parameter | Type   | Description                           |
|-----------|--------|---------------------------------------|
| `$message`| string | The log message to store.             |
| `$ref`    | mixed  | Optional. A reference or additional info. |

- **Description**: Alias for `notify()`. Inserts a notification log entry.
- **Returns**: Result of the database query execution.

### `notify(...)`

| Parameter | Type   | Description                           |
|-----------|--------|---------------------------------------|
| `$message`| string | The log message to store.             |
| `$ref`    | mixed  | Optional. A reference or additional info. |

- **Description**: Inserts a notification log entry.
- **Returns**: Result of the database query execution.

### `warn(...)`

| Parameter | Type   | Description                           |
|-----------|--------|---------------------------------------|
| `$message`| string | The log message to store.             |
| `$ref`    | mixed  | Optional. A reference or additional info. |

- **Description**: Alias for `warning()`. Inserts a warning log entry.
- **Returns**: Result of the database query execution.

### `warning(...)`

| Parameter | Type   | Description                           |
|-----------|--------|---------------------------------------|
| `$message`| string | The log message to store.             |
| `$ref`    | mixed  | Optional. A reference or additional info. |

- **Description**: Inserts a warning log entry.
- **Returns**: Result of the database query execution.

### `err(...)`

| Parameter | Type   | Description                           |
|-----------|--------|---------------------------------------|
| `$message`| string | The log message to store.             |
| `$ref`    | mixed  | Optional. A reference or additional info. |

- **Description**: Alias for `error()`. Inserts an error log entry.
- **Returns**: Result of the database query execution.

### `failure(...)`

| Parameter | Type   | Description                           |
|-----------|--------|---------------------------------------|
| `$message`| string | The log message to store.             |
| `$ref`    | mixed  | Optional. A reference or additional info. |

- **Description**: Alias for `error()`. Inserts an error log entry.
- **Returns**: Result of the database query execution.

### `fail(...)`

| Parameter | Type   | Description                           |
|-----------|--------|---------------------------------------|
| `$message`| string | The log message to store.             |
| `$ref`    | mixed  | Optional. A reference or additional info. |

- **Description**: Alias for `error()`. Inserts an error log entry.
- **Returns**: Result of the database query execution.

### `error(...)`

| Parameter | Type   | Description                           |
|-----------|--------|---------------------------------------|
| `$message`| string | The log message to store.             |
| `$ref`    | mixed  | Optional. A reference or additional info. |

- **Description**: Inserts an error log entry.
- **Returns**: Result of the database query execution.

### `list_get(...)`

| Parameter | Type   | Description                           |
|-----------|--------|---------------------------------------|
| `$limit`  | int    | Optional. The number of log entries to retrieve (default is 50). |

- **Description**: Retrieves the most recent log entries from the table, limited by the `$limit` parameter.
- **Returns**: An array of log entries.

### `list_flush_section(...)`

| Parameter | Type  | Description                              |
|-----------|-------|------------------------------------------|
| None      | None  | Deletes all log entries for the current section and resets the auto-increment value. |

- **Description**: Removes all entries for the current section and resets the table's auto-increment counter.
- **Returns**: `true` if successful.

### `list_flush(...)`

| Parameter | Type  | Description                              |
|-----------|-------|------------------------------------------|
| None      | None  | Deletes all log entries and resets the auto-increment value. |

- **Description**: Removes all entries from the table and resets the table's auto-increment counter.
- **Returns**: `true` if successful.

