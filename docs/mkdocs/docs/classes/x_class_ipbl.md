# Class Documentation: `x_class_ipbl`

## Documentation

The `x_class_ipbl` class is used for managing IP-based blocking and failure counters using a MySQL database. It allows you to track IP addresses that have failed specific criteria and manage their block status accordingly. The class includes methods for checking if an IP is blocked, retrieving and updating counters, and unblocking IP addresses.

- **Error Handling:** The class uses error suppression (`@`) for database queries. Consider replacing this with proper exception handling in production code.
- **Prefix Handling:** The class does not support key prefixes; all table operations are based on the table name provided.
- **Blocking Logic:** The class uses a failure counter to determine if an IP should be blocked. The threshold is configurable via the `maxvalue` parameter.

## Requirements

### PHP Modules
- `MySQLi`: The PHP MySQLi extension must be installed and enabled.

### External Classes
- `x_class_mysql`: This class requires the x_class_mysql Class for database operations.


## Table Structure

This section describes the structure of the table used for logging IP addresses that have been blacklisted due to failure counts. The table will be automatically created by the class if required by its functionality. Below is a summary of the columns and keys in the table, along with their usage.


| Column Name  | Data Type     | Attributes                                  | Description                                                                                          |
|--------------|---------------|---------------------------------------------|------------------------------------------------------------------------------------------------------|
| `id`         | `int(10)`     | `NOT NULL`, `AUTO_INCREMENT`, `PRIMARY KEY` | A unique identifier for each blacklisted IP entry.                                                   |
| `fail`       | `int(10)`     | `DEFAULT '1'`                               | The count of failures associated with the IP address. This value increases with each failure.        |
| `ip_adr`     | `varchar(256)`| `NOT NULL`                                  | The IP address that is being blacklisted.                                                            |
| `creation`   | `datetime`    | `DEFAULT CURRENT_TIMESTAMP`                 | The date and time when the IP address was blacklisted. Automatically set upon insertion.             |


| Key Name      | Key Type  | Columns | Usage                                                                                                  |
|---------------|-----------|---------|--------------------------------------------------------------------------------------------------------|
| `PRIMARY KEY` | Primary   | `id`    | Ensures each blacklisted IP entry is uniquely identifiable.                                            |
| `x_class_ipbl`| Unique    | `ip_adr`| Ensures that each IP address is only recorded once in the table, preventing duplicate entries.         |



## Method Library

| Method                    | Description                                                                                       |
|---------------------------|---------------------------------------------------------------------------------------------------|
| **`__construct($x_class_mysql, $tablename, $maxvalue = 50000)`** | Initializes the class, connects to the database, and sets up the table if it does not exist.     |
| **`blocked($renew = false)`** | Checks if the current IP is blocked or renews the block status if `$renew` is `true`.             |
| **`banned($renew = false)`** | Alias for `blocked()`. Checks if the IP is banned or renews the status.                           |
| **`isbanned($renew = false)`** | Alias for `blocked()`. Checks if the IP is banned or renews the status.                           |
| **`isblocked($renew = false)`** | Alias for `blocked()`. Checks if the IP is blocked or renews the status.                          |
| **`get_array()`**         | Retrieves all records from the block table as an array.                                           |
| **`unblock($ip)`**        | Unblocks a specified IP address by removing it from the block table.                             |
| **`get_counter($renew = false)`** | Retrieves the failure counter for the current IP or renews the counter if `$renew` is `true`.    |
| **`counter($renew = false)`** | Alias for `get_counter()`. Retrieves the failure counter for the current IP.                     |
| **`ip_counter($ip)`**     | Retrieves the failure counter for a specified IP address.                                        |
| **`raise($value = 1)`**   | Increases the failure counter for the current IP by a specified value.                           |
| **`increase($value = 1)`** | Alias for `raise()`. Increases the failure counter for the current IP by a specified value.       |

## Method Details

#### `__construct(...)`

| Parameter          | Type     | Default | Description                                         |
|--------------------|----------|---------|-----------------------------------------------------|
| `$mysql`           | Object   |         | The MySQLi connection object.                      |
| `$tablename`       | String   |         | The name of the table to use for IP blocking.      |
| `$maxvalue`        | Integer  | `50000` | The maximum number of failures before blocking an IP. |

**Description:**  
Initializes the `x_class_ipbl` object by connecting to the MySQL database and creating the block table if it does not exist. Sets up the maximum failure threshold and retrieves the current IP address.

#### `blocked(...)`

| Parameter          | Type     | Default | Description                                         |
|--------------------|----------|---------|-----------------------------------------------------|
| `$renew`           | Boolean  | `false` | Whether to renew the block status.                 |

| Return Type        | Description                                         |
|--------------------|-----------------------------------------------------|
| Boolean            | Returns `true` if the current IP is blocked; otherwise, `false`. |

**Description:**  
Checks if the current IP is blocked. If `$renew` is `true`, it updates the block status.

#### `banned(...)`

| Parameter          | Type     | Default | Description                                         |
|--------------------|----------|---------|-----------------------------------------------------|
| `$renew`           | Boolean  | `false` | Whether to renew the banned status.                |

| Return Type        | Description                                         |
|--------------------|-----------------------------------------------------|
| Boolean            | Returns `true` if the current IP is banned; otherwise, `false`. |

**Description:**  
Alias for `blocked()`. Checks if the IP is banned or renews the status if `$renew` is `true`.

#### `isbanned(...)`

| Parameter          | Type     | Default | Description                                         |
|--------------------|----------|---------|-----------------------------------------------------|
| `$renew`           | Boolean  | `false` | Whether to renew the banned status.                |

| Return Type        | Description                                         |
|--------------------|-----------------------------------------------------|
| Boolean            | Returns `true` if the current IP is banned; otherwise, `false`. |

**Description:**  
Alias for `blocked()`. Checks if the IP is banned or renews the status if `$renew` is `true`.

#### `isblocked(...)`

| Parameter          | Type     | Default | Description                                         |
|--------------------|----------|---------|-----------------------------------------------------|
| `$renew`           | Boolean  | `false` | Whether to renew the blocked status.               |

| Return Type        | Description                                         |
|--------------------|-----------------------------------------------------|
| Boolean            | Returns `true` if the current IP is blocked; otherwise, `false`. |

**Description:**  
Alias for `blocked()`. Checks if the IP is blocked or renews the status if `$renew` is `true`.

#### `get_array(...)`

| Return Type        | Description                                         |
|--------------------|-----------------------------------------------------|
| Array              | Returns an array of all records from the block table. |

**Description:**  
Retrieves all records from the IP block table as an array.

#### `unblock(...)`

| Parameter          | Type     | Description                                          |
|--------------------|----------|------------------------------------------------------|
| `$ip`              | String   | The IP address to unblock.                          |

| Return Type        | Description                                         |
|--------------------|-----------------------------------------------------|
| Void               | The function does not return a value.               |

**Description:**  
Unblocks the specified IP address by deleting it from the block table.

#### `get_counter(...)`

| Parameter          | Type     | Default | Description                                         |
|--------------------|----------|---------|-----------------------------------------------------|
| `$renew`           | Boolean  | `false` | Whether to renew the counter.                      |

| Return Type        | Description                                         |
|--------------------|-----------------------------------------------------|
| Integer            | Returns the failure counter for the current IP.    |

**Description:**  
Retrieves the failure counter for the current IP address. If `$renew` is `true`, it updates the counter.

#### `counter(...)`

| Parameter          | Type     | Default | Description                                         |
|--------------------|----------|---------|-----------------------------------------------------|
| `$renew`           | Boolean  | `false` | Whether to renew the counter.                      |

| Return Type        | Description                                         |
|--------------------|-----------------------------------------------------|
| Integer            | Returns the failure counter for the current IP.    |

**Description:**  
Alias for `get_counter()`. Retrieves the failure counter for the current IP address.

#### `ip_counter(...)`

| Parameter          | Type     | Description                                          |
|--------------------|----------|------------------------------------------------------|
| `$ip`              | String   | The IP address for which to get the counter.        |

| Return Type        | Description                                         |
|--------------------|-----------------------------------------------------|
| Integer            | Returns the failure counter for the specified IP.  |

**Description:**  
Retrieves the failure counter for a specified IP address.

#### `raise(...)`

| Parameter          | Type     | Default | Description                                          |
|--------------------|----------|---------|------------------------------------------------------|
| `$value`           | Integer  | `1`     | The amount to increase the failure counter by.      |

| Return Type        | Description                                         |
|--------------------|-----------------------------------------------------|
| Integer            | Returns the updated failure counter for the current IP. |

**Description:**  
Increases the failure counter for the current IP by the specified value.

#### `increase(...)`

| Parameter          | Type     | Default | Description                                          |
|--------------------|----------|---------|------------------------------------------------------|
| `$value`           | Integer  | `1`     | The amount to increase the failure counter by.      |

| Return Type        | Description                                         |
|--------------------|-----------------------------------------------------|
| Integer            | Returns the updated failure counter for the current IP. |

**Description:**  
Alias for `raise()`. Increases the failure counter for the current IP by the specified value.

