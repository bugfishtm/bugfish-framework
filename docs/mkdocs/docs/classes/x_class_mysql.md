# Class Documentation: `x_class_mysql` 

## Documentation
The `x_class_mysql` class provides an interface for interacting with a MySQL database. It encapsulates common database operations and includes additional features for error handling and logging.

- **Error Handling**: Errors are managed by the `handler` method which updates internal error states and logs errors if configured.  
- **Benchmarking**: Provides a simple benchmarking system to count operations.  
- **Logging**: Allows configuration of logging to both the database and log files, with options to control logging behavior.  
- **Parameter Binding**: When using prepared statements, ensure that `bindarray` is correctly formatted. The `type` key in each array element specifies the type of data being bound.  

## Requirements

### PHP Modules
- `MySQLi`: Required for database interactions.  
- **Exception Handling**: Required for handling errors.  

### External Classes
- `none`: None External Classes are Required.  



## Table Structure

This section describes the table structure used by the MySQL class to log failures if logging is activated. The table is automatically created by the class if necessary. Below is a summary of the columns and keys used in the table, along with their purposes.


| Column Name   | Data Type    | Attributes                                    | Description                                                                                         |
|---------------|--------------|-----------------------------------------------|-----------------------------------------------------------------------------------------------------|
| `id`          | `int(10)`    | `NOT NULL`, `AUTO_INCREMENT`, `PRIMARY KEY`  | A unique identifier for each log entry, ensuring that each record can be individually tracked.      |
| `url`         | `varchar(256)` | `DEFAULT NULL`                              | Stores the URL related to the log entry, providing context for where the failure occurred.          |
| `init`        | `text`       | `NULL`                                      | Contains initialization data, if available, that might provide additional context about the failure.|
| `exception`   | `text`       | `NULL`                                      | Logs the text of any exception that was thrown, useful for diagnosing issues.                      |
| `sqlerror`    | `text`       | `NULL`                                      | Records the MySQL error message if there was an SQL error, aiding in troubleshooting.               |
| `output`      | `text`       | `NULL`                                      | Stores the output related to the error, which can provide additional details about the failure.     |
| `success`     | `int(1)`     | `NULL`                                      | Indicates the result of the query: `1` for success, `2` for error, or `NULL` if not applicable.     |
| `creation`    | `datetime`   | `DEFAULT CURRENT_TIMESTAMP`                 | Records the timestamp when the log entry was created, allowing for chronological tracking.         |
| `section`     | `varchar(128)` | `DEFAULT NULL`                              | For Multi Site Purposes to split database data in categories.              |


| Key Name      | Key Type  | Columns | Usage                                                                                                  |
|---------------|-----------|---------|--------------------------------------------------------------------------------------------------------|
| `PRIMARY KEY` | Primary   | `id`    | Ensures that each log entry is uniquely identifiable.                                                  |



## Class Usage
### Constructors

| Method/Function       | Parameters                                             | Description                                              |
|-----------------------|--------------------------------------------------------|----------------------------------------------------------|
| `__construct`         | `($hostname, $username, $password, $database, $port)` | Initializes a new MySQL connection using the provided credentials and database information. |
| `construct`           | -                                                      | Returns a new instance of `x_class_mysql` with the same connection parameters. |
| `construct_copy`      | -                                                      | Returns the current instance of `x_class_mysql`. |

### Status and Errors

| Method/Function       | Parameters                                             | Description                                              |
|-----------------------|--------------------------------------------------------|----------------------------------------------------------|
| `status`              | -                                                      | Alias for `ping()`. Checks if the database connection is alive. |
| `con`                 | -                                                      | Returns the MySQLi connection object.                   |
| `lastError`           | -                                                      | Returns the last error that occurred during database operations. |
| `fullError`           | -                                                      | Returns detailed error information.                     |
| `ping`                | -                                                      | Checks if the MySQL server is reachable. Uses `mysqli_ping()`. |
| `inject`              | `$mysqli`                                              | Injects an external MySQLi connection object.            |
| `displayError`        | `$exit = true, $response_code = 503`                   | Displays an error message and optionally exits the script. |

### Benchmarking

| Method/Function       | Parameters                                             | Description                                              |
|-----------------------|--------------------------------------------------------|----------------------------------------------------------|
| `benchmark_get`       | -                                                      | Retrieves the current benchmark count.                  |
| `benchmark_raise`     | `$raise = 1`                                          | Increments the benchmark counter.                       |
| `benchmark_config`    | `$bool = false, $preecookie = ""`                      | Configures benchmarking and session cookie prefix.      |

### Logging

| Method/Function       | Parameters                                             | Description                                              |
|-----------------------|--------------------------------------------------------|----------------------------------------------------------|
| `logfile_messages`    | `$bool = false`                                       | Enables or disables logging of error messages to a file. |
| `log_disable`         | -                                                      | Disables logging.                                       |
| `log_status`          | -                                                      | Returns whether logging is active.                      |
| `log_enable`          | -                                                      | Enables logging if the logging table is configured.     |
| `log_config`          | `$table = "mysqllogging", $section = "", $logall = false` | Configures logging settings including table name, section, and whether to log all messages. |
| `stop_on_error`       | `$bool = false`                                       | Configures whether to stop execution on error.          |
| `display_on_error`    | `$bool = false`                                       | Configures whether to display errors.                  |

### Table Functions

| **Method Name**         | **Description**                                                                                           | **Parameters**                                                                                   | **Return Value**                                                                                                     |
|-------------------------|-----------------------------------------------------------------------------------------------------------|---------------------------------------------------------------------------------------------------|----------------------------------------------------------------------------------------------------------------------|
| `table_exists`          | Checks if a table exists in the database by trying to select from it.                                      | - `$tablename`: Name of the table to check.                                                       | Returns the result of the query. `true` if the table exists, `false` otherwise.                                      |
| `table_delete`          | Deletes (drops) a specified table from the database.                                                       | - `$tablename`: Name of the table to delete.                                                      | Executes the `DROP TABLE` query and returns the result of the operation.                                             |
| `table_create`          | Creates a table with the given name.                                                                      | - `$tablename`: Name of the table to create.                                                      | Executes the `CREATE TABLE` query and returns the result of the operation.                                           |
| `auto_increment`        | Sets the auto-increment value for a specified table.                                                       | - `$table`: Name of the table. <br> - `$value`: The new auto-increment value.                     | Executes the `ALTER TABLE` query to set auto-increment and returns the result of the operation.                      |
| `table_backup`          | Backs up the structure and optionally the data of a specified table, saving it to a file if provided.      | - `$table`: Name of the table to back up. <br> - `$filepath` (optional): Path to save the backup file. <br> - `$withdata` (optional): Boolean to include table data (default: `true`). <br> - `$dropstate` (optional): Boolean to include `DROP TABLE IF EXISTS` in backup (default: `false`). | Returns the table structure and data as a string. Optionally writes the backup to a file if `$filepath` is provided. |

### Database Functions


| **Method Name**         | **Description**                                                                                           | **Parameters**                                                                                   | **Return Value**                                                                                                     |
|-------------------------|-----------------------------------------------------------------------------------------------------------|---------------------------------------------------------------------------------------------------|----------------------------------------------------------------------------------------------------------------------|
| `database_delete`       | Deletes (drops) a specified database.                                                                     | - `$database`: The name of the database to delete.                                                | Executes the `DROP DATABASE` query and returns the result of the operation.                                          |
| `database_create`       | Creates a new database with the given name.                                                               | - `$database`: The name of the database to create.                                                | Executes the `CREATE DATABASE` query and returns the result of the operation.                                        |
| `database_select`       | Selects a specific database for subsequent queries.                                                       | - `$database`: The name of the database to select.                                                | Returns `true` if the database is selected successfully, or handles errors and returns `false` on failure.           |

### Transactions

| **Method Name**         | **Description**                                                                                           | **Parameters**                                                                                   | **Return Value**                                                                                                     |
|-------------------------|-----------------------------------------------------------------------------------------------------------|---------------------------------------------------------------------------------------------------|----------------------------------------------------------------------------------------------------------------------|
| `transaction`           | Starts a database transaction if none is already running. Optionally disables auto-commit.                | - `$autocommit`: Boolean flag to set whether auto-commit is enabled (default: `false`).            | Returns `true` if the transaction starts successfully, `false` if already running, or handles exceptions gracefully. |
| `rollback`              | Rolls back the current transaction if one is running.                                                     | N/A                                                                                               | Returns `true` if rollback is successful, `false` if no transaction is running, or handles exceptions.               |
| `transactionStatus`     | Checks whether a transaction is currently active.                                                         | N/A                                                                                               | Returns `true` if a transaction is running, `false` otherwise.                                                       |
| `commit`                | Commits the current transaction if one is running.                                                        | N/A                                                                                               | Returns `true` if commit is successful, `false` if no transaction is running, or handles exceptions.                 |

### Alias Functions


| **Method Name**         | **Description**                                                                                           | **Parameters**                                                                                   | **Return Value**                                                                                                     |
|-------------------------|-----------------------------------------------------------------------------------------------------------|---------------------------------------------------------------------------------------------------|----------------------------------------------------------------------------------------------------------------------|
| `__destruct`            | Destructor method that closes the connection or performs cleanup when the object is destroyed.             | N/A                                                                                               | No return value. The function doesn't perform any operations but is defined to properly destroy the object.           |
| `escape`                | Escapes a variable to make it safe for use in an SQL query. Handles both simple values and arrays/objects. | - `$val`: The value to escape. Can be a string, object, or array.                                 | Returns the escaped string using `mysqli_real_escape_string()` or serialized object/array (escaped).                  |
| `next_result`           | Advances the result pointer to the next result in a multi-query execution.                                 | N/A                                                                                               | Returns the result of `mysqli_next_result()`, or `false` if an error occurs.                                          |
| `store_result`          | Stores the result set from the last query in the multi-query execution.                                    | N/A                                                                                               | Returns the result set from `mysqli_store_result()`, or `false` on failure.                                           |
| `more_results`          | Checks if there are more results available in the multi-query execution.                                   | N/A                                                                                               | Returns the result of `mysqli_more_results()`, or `false` on failure.                                                 |
| `fetch_array`           | Fetches a result row as an associative array, numeric array, or both.                                      | - `$result`: The result set resource returned from a query.                                        | Returns the result row as an array, or `false` if an error occurs.                                                    |
| `fetch_object`          | Fetches a result row as an object.                                                                        | - `$result`: The result set resource returned from a query.                                        | Returns the result row as an object, or `false` on failure.                                                           |
| `free_result`           | Frees the memory associated with a result set.                                                             | - `$result`: The result set resource to free.                                                      | Returns `true` on success, or `false` on failure.                                                                     |
| `use_result`            | Initiates retrieval of a result set from a query that is to be retrieved row by row.                       | N/A                                                                                               | Returns the result of `mysqli_use_result()`, or `false` on failure.                                                   |
| `free_all`              | Frees all result sets and fetches the remaining results in a multi-query execution.                        | N/A                                                                                               | Returns an array of all results fetched from the multi-query execution.                                               |

### Multi Query

| **Method Name**         | **Description**                                                                                           | **Parameters**                                                                                   | **Return Value**                                                                                                     |
|-------------------------|-----------------------------------------------------------------------------------------------------------|---------------------------------------------------------------------------------------------------|----------------------------------------------------------------------------------------------------------------------|
| `multi_query`           | Executes a multi-query SQL string. Allows executing multiple SQL statements in a single query.             | - `$query`: The SQL query string containing multiple statements.                                  | Returns the result of `multi_query()` or, if an exception occurs, handles it and returns `false`.                    |
| `multi_query_file`      | Executes a multi-query SQL from a file. Reads an SQL file and runs the queries contained within it.        | - `$file`: The path to the file containing the SQL queries.                                       | Returns the result of the `multi_query()` operation on the SQL file's content or `false` if the file doesn't exist.   |


### Row Functions


| **Method Name**                | **Description**                                                                                     | **Parameters**                                                                                                                                                                                                                           | **Return Value**                                             |
|---------------------------------|-----------------------------------------------------------------------------------------------------|-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|--------------------------------------------------------------|
| `row_element_increase`          | Increases a numeric field in a specified table by a given value (defaults to 1).                                                         | - `$table`: The table name. <br> - `$nameidfield`: The column name used for identifying the row. <br> - `$id`: The identifier value for the row. <br> - `$increasefield`: The field to increase. <br> - `$increasevalue`: Amount to add. | Returns `false` if `$id` or `$increasevalue` is not numeric; otherwise, it returns the result of the SQL `UPDATE` query. |
| `row_element_decrease`          | Decreases a numeric field in a specified table by a given value (defaults to 1).                                                         | - `$table`: The table name. <br> - `$nameidfield`: The column name used for identifying the row. <br> - `$id`: The identifier value for the row. <br> - `$decreasefield`: The field to decrease. <br> - `$decreasevalue`: Amount to subtract. | Returns `false` if `$id` or `$decreasevalue` is not numeric; otherwise, it returns the result of the SQL `UPDATE` query. |
| `row_get`                       | Retrieves an entire row from a specified table based on the row ID.                                                                       | - `$table`: The table name. <br> - `$id`: The identifier value for the row. <br> - `$row`: The column name used to locate the row (default is `"id"`).                                                                                    | Returns the row data as an array.                                              |
| `row_element_get`               | Retrieves a specific element from a row in the table. If the element is not found, it returns a fallback value.                          | - `$table`: The table name. <br> - `$id`: The identifier value for the row. <br> - `$elementrow`: The column from which to fetch the value. <br> - `$fallback`: The value to return if the element isn't found. <br> - `$row`: Identifier column (default: `"id"`). | Returns the value of the specified column or `$fallback` if not found. |
| `row_element_change`            | Changes the value of a specific column in a row.                                                                                         | - `$table`: The table name. <br> - `$id`: The identifier value for the row. <br> - `$element`: The new value to set. <br> - `$elementrow`: The column to change. <br> - `$row`: Identifier column (default: `"id"`).                       | Returns the result of the SQL `UPDATE` query.                                  |
| `row_exist`                     | Checks if a row with a specific ID exists in the table.                                                                                   | - `$table`: The table name. <br> - `$id`: The identifier value for the row. <br> - `$row`: The column to match for existence (default: `"id"`).                                                                                           | Returns `true` if the row exists, otherwise `false`.                           |
| `rows_get`                      | Retrieves multiple rows from the table where the column matches the specified value.                                                     | - `$table`: The table name. <br> - `$id`: The identifier value for the rows. <br> - `$row`: The column name used for filtering rows (default: `"id"`).                                                                                     | Returns an array of rows that match the condition.                             |
| `row_del`                       | Deletes a row in the specified table based on the row's ID.                                                                               | - `$table`: The table name. <br> - `$id`: The identifier value for the row. <br> - `$row`: The column to identify the row (default: `"id"`).                                                                                              | Returns the result of the SQL `DELETE` query.                                  |

### Private Methods

| Method/Function       | Parameters                                             | Description                                              |
|-----------------------|--------------------------------------------------------|----------------------------------------------------------|
| `log`                 | `$output, $sqlerror, $exception, $init, $boolsuccess, $nolog = false` | Logs the error details to the database or file if logging is enabled. |
| `handler`             | `$excecution, $exception, $init, $nolog = false`       | Handles the execution and error logging.               |

### Primary

#### `select(...)`

Retrieves data from the database based on the provided query. It supports fetching single or multiple rows.

| Method          | `select` |
|-----------------|----------|
| **Parameters**  | `string $query` <br> SQL query to execute <br> `bool $multiple` <br> Whether to fetch multiple rows (default: `false`) <br> `mixed $bindarray` <br> Array of binding parameters or `false` for direct query <br> `int $fetch_type` <br> Type of result array (e.g., `MYSQLI_ASSOC`, `MYSQLI_NUM`) |
| **Return Value** | Returns an array of results if successful; `false` if failed |


#### `query(...)`

Executes a general query (e.g., INSERT, DELETE, etc.) and returns the result set.

| Method          | `query` |
|-----------------|---------|
| **Parameters**  | `string $query` <br> SQL query to execute <br> `mixed $bindarray` <br> Array of binding parameters or `false` for direct query |
| **Return Value** | Returns the result set object if successful; `false` if failed |

#### `update(...)`

Executes an update statement and returns the number of affected rows.

| Method          | `update` |
|-----------------|----------|
| **Parameters**  | `string $query` <br> SQL query to execute <br> `mixed $bindarray` <br> Array of binding parameters or `false` for direct query |
| **Return Value** | Number of affected rows if successful; `false` if failed |

#### `insert(...)`

Inserts a new record into a specified table and returns the ID of the inserted record.

| Method          | `insert` |
|-----------------|----------|
| **Parameters**  | `string $table` <br> Name of the table <br> `array $array` <br> Associative array of field names and values <br> `mixed $bindarray` <br> Array of binding parameters or `false` for direct query |
| **Return Value** | Inserted ID if successful; `false` if failed |


## Binding Information

If `$bindarray` is provided for secure data transmission via mysql buffer:

| `bindarray` Format | Description                                |
|--------------------|--------------------------------------------|
| `Array[X]["value"]` | Value to be bound to the query              |
| `Array[X]["type"]`  | Data type of the value (`s` = string, `i` = integer, `d` = double, `b` = blob) |