# Class Documentation: `x_class_benchmark`

## Documentation

The `x_class_benchmark` class is designed for benchmarking various aspects of a web application's performance, such as load time, memory usage, and query count. It stores these metrics in a MySQL database for later analysis. The class also allows you to filter records by section and URL path.

- **Table Initialization:** The `create_table()` method ensures that the necessary table structure is created in the database, with columns for storing performance metrics and other relevant data.
- **URL Preparation:** The `prepareUrl()` method sanitizes and formats the URL path for consistent storage.

The class assumes that the MySQL connection object and `x_class_debug` instance are correctly implemented. Ensure proper error handling and logging are in place for production environments.

## Requirements

### PHP Modules
- `MySQLi`: Required for database operations.

### External Classes
- **x_class_debug**: This class should be implemented separately to provide performance metrics.
- **x_class_mysql**: Required for Database Logging Operations.


## Table Structure

This section describes the structure of the database table that the class automatically creates to log benchmarking data. This table tracks various performance metrics such as site loading time, memory usage, and query counts. The table will be automatically installed by the class when required by its functionality.


| Column Name     | Data Type      | Attributes                                                                                          | Description                                                                                           |
|-----------------|----------------|-----------------------------------------------------------------------------------------------------|-------------------------------------------------------------------------------------------------------|
| `id`            | `int(10)`      | `NOT NULL`, `AUTO_INCREMENT`, `PRIMARY KEY`                                                         | A unique identifier for each record in the table.                                                     |
| `full_url`      | `varchar(512)` | `NOT NULL`, `DEFAULT '0'`, `UNIQUE KEY`                                                             | The full URL of the related domain or resource being benchmarked. This is the primary reference.      |
| `value_time`    | `varchar(64)`  | `DEFAULT '0'`                                                                                       | The site loading time, representing the duration it took for the site to load during the benchmark.   |
| `value_memory`  | `varchar(64)`  | `DEFAULT '0'`                                                                                       | The amount of memory used during the site loading process, measured during the benchmark.             |
| `value_load`    | `varchar(64)`  | `DEFAULT '0'`                                                                                       | The overall load time for the site, which may include additional performance metrics.                 |
| `value_queries` | `varchar(64)`  | `DEFAULT '0'`                                                                                       | The number of database queries executed during the benchmarked request.                               |
| `section`       | `varchar(128)` | `NULL`, `DEFAULT ''`                                                                                | For Multi Site Purposes to split database data in categories.  |
| `creation`      | `datetime`     | `DEFAULT CURRENT_TIMESTAMP`                                                                         | The timestamp when the record was created. Automatically set when a new record is inserted.           |
| `modification`  | `datetime`     | `DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP`                                             | The timestamp of the last modification. Automatically updated whenever the record changes.            |


| Key Name            | Key Type   | Columns         | Usage                                                                                                  |
|---------------------|------------|-----------------|--------------------------------------------------------------------------------------------------------|
| `PRIMARY KEY`       | Primary    | `id`            | Ensures each record is uniquely identifiable.                                                          |
| `UNIQUE KEY`        | Unique     | `full_url`      | Prevents duplicate entries for the same `full_url`, ensuring each URL is logged only once.             |



## Class Usage

### Method Library

| Method                         | Description                                                                                      |
|--------------------------------|--------------------------------------------------------------------------------------------------|
| **`__construct($x_class_mysql, $table, $section = "")`** | Initializes the class with a x_class_mysql object, table name, and optional section filter.       |
| **`only200($bool = true)`**    | Sets whether to only log metrics for successful HTTP 200 responses.                            |
| **`get_array_full()`**         | Retrieves all benchmark records from the database.                                              |
| **`get_array_section($section)`** | Retrieves benchmark records filtered by a specific section.                                    |
| **`execute($querie_counter = 0)`** | Logs benchmark metrics for the current URL and section.                                         |

### Method Details

#### `__construct(...)`

| Parameter       | Type    | Default | Description                                        |
|-----------------|---------|---------|----------------------------------------------------|
| `$thecon`       | Object  |         | MySQLi connection object.                         |
| `$table`        | String  |         | The name of the table to store benchmark data.    |
| `$section`      | String  | `""`    | Optional section name to filter records.         |

**Description:**  
Initializes the `x_class_benchmark` object, sets up the database connection, and creates the benchmark table if it does not exist. It also prepares the current URL path for storage and calculates its MD5 hash.

#### `only200(...)`

| Parameter       | Type    | Default | Description                                    |
|-----------------|---------|---------|------------------------------------------------|
| `$bool`         | Boolean | `true`  | Whether to only log metrics for HTTP 200 responses. |

**Description:**  
Sets the flag to determine if only successful (HTTP 200) responses should be logged.

#### `get_array_full(...)`

| Return Type     | Description                                   |
|-----------------|-----------------------------------------------|
| Array           | Returns an array of all benchmark records.    |

**Description:**  
Retrieves all benchmark records from the database table.

#### `get_array_section(...)`

| Parameter       | Type    | Description                                    |
|-----------------|---------|------------------------------------------------|
| `$section`      | String  | The section to filter the benchmark records by. |

| Return Type     | Description                                   |
|-----------------|-----------------------------------------------|
| Array           | Returns an array of benchmark records for the specified section. |

**Description:**  
Retrieves benchmark records filtered by the specified section from the database table.

#### `execute(...)`

| Parameter           | Type    | Default | Description                                      |
|---------------------|---------|---------|--------------------------------------------------|
| `$querie_counter`   | Integer | `0`     | The number of queries executed (for logging).   |

**Description:**  
Logs benchmarking metrics for the current URL and section. It inserts a new record or updates an existing one with the current metrics such as load time, memory usage, CPU load, and query count. 

**Special Notes:**  
- Metrics are collected using the `x_class_debug` class, which must provide methods for `timer()`, `memory_usage()`, and `cpu_load()`.
- The class checks if the response code is 200 (if `only200` is set) before logging metrics.

