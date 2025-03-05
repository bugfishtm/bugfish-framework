# Class Documentation: `x_class_debug`

## Documentation
The `x_class_debug` class is designed to aid in debugging and monitoring of PHP applications. It provides functionality to check for required PHP modules, display error screens, log errors, and gather system information. This class is useful for developers who need to ensure that their application has all necessary PHP extensions and to monitor the application’s resource usage and performance.

- **Error Screen Customization**: The `error_screen()` method provides a basic HTML template for displaying critical errors. Customize the HTML/CSS as needed for your application.
- **Database Logging**: The `js_error_action()` method requires a valid `x_class_mysql` instance. Ensure that the database connection and table creation logic aligns with your database schema.
- **System Resource Monitoring**: Methods like `memory_usage()`, `cpu_load()`, and `upload_max_filesize()` provide insights into system resource usage and configuration settings.



This class provides various debugging tools to help with monitoring and troubleshooting PHP applications. It includes methods for:  
- Displaying error screens.  
- Checking for required PHP modules.  
- Gathering system resource usage.  
- Logging JavaScript errors to a database.  


## Requirements

### PHP Modules
- **None Required**: The class utilizes built-in PHP functions and does not have external module dependencies beyond PHP itself.

### External Classes
- **x_class_mysql**: Required for methods that interact with MySQL databases for logging errors. Ensure that the `x_class_mysql` class is properly included and instantiated in your application.




## Table Structure

This section explains the table structure that will be automatically created by the debugging class to log JavaScript errors encountered by users. The table captures essential details such as the error message, user information, and the URL where the error occurred. Below is a summary of the columns and keys used in the table, along with their intended usage.


| Column Name | Data Type     | Attributes                                  | Description                                                                                         |
|-------------|---------------|---------------------------------------------|-----------------------------------------------------------------------------------------------------|
| `id`        | `int(11)`     | `NOT NULL`, `AUTO_INCREMENT`, `PRIMARY KEY` | A unique identifier for each error log entry.                                                       |
| `fk_user`   | `int(11)`     | `NOT NULL`, `DEFAULT 0`                     | The foreign key referencing the user who encountered the error. Defaults to `0` if user is unknown. |
| `creation`  | `datetime`    | `DEFAULT CURRENT_TIMESTAMP`                 | The timestamp when the error was logged. Automatically set when a new record is inserted.           |
| `errormsg`  | `longtext`    | `DEFAULT NULL`                              | The full error message captured from the JavaScript error.                                          |
| `urlstring` | `varchar(512)`| `DEFAULT NULL`                              | The URL where the error occurred, providing context for the source of the error.                    |
| `section`   | `varchar(128)`| `DEFAULT NULL`                              | For Multi Site Purposes to split database data in categories.  |


| Key Name      | Key Type  | Columns | Usage                                                                                                  |
|---------------|-----------|---------|--------------------------------------------------------------------------------------------------------|
| `PRIMARY KEY` | Primary   | `id`    | Ensures that each error log entry is uniquely identifiable.                                             |


## Class Properties

| Property       | Type   | Description                                               |
|----------------|--------|-----------------------------------------------------------|
| `microtime_start` | float  | The timestamp when the object was instantiated, used for measuring elapsed time. |

---

## Class Methods

### `__construct(...)`

| Parameter | Type  | Description                                   |
|-----------|-------|-----------------------------------------------|
| None      | None  | Initializes the `microtime_start` property with the current timestamp. |

- **Description**: Sets up the initial state of the object by recording the current time.
- **Returns**: None.

### `error_screen(...)`

| Parameter | Type   | Description                             |
|-----------|--------|-----------------------------------------|
| `$text`   | string | The error message to display on the error screen. |

- **Description**: Displays a styled error page with a critical error message. This method sets the HTTP response code to 503 (Service Unavailable).
- **Returns**: None. Exits the script execution.

### `required_php_modules(...)`

| Parameter     | Type   | Description                                                 |
|---------------|--------|-------------------------------------------------------------|
| `$array`      | array  | An array of PHP module names to check.                     |
| `$errorscreen` | bool   | Optional. If `true`, will display an error screen if any module is missing (default is `false`). |

- **Description**: Checks if the specified PHP modules are loaded. If some modules are missing and `$errorscreen` is `true`, it will display an error screen.
- **Returns**: An array of missing module names if any; otherwise, an empty array.

### `required_php_module(...)`

| Parameter     | Type   | Description                                             |
|---------------|--------|---------------------------------------------------------|
| `$name`       | string | The name of the PHP module to check.                   |
| `$errorscreen` | bool   | Optional. If `true`, will display an error screen if the module is missing (default is `false`). |

- **Description**: Checks if a specific PHP module is loaded. If the module is missing and `$errorscreen` is `true`, it will display an error screen.
- **Returns**: `true` if the module is loaded; `false` otherwise.

### `php_modules(...)`

| Parameter | Type  | Description           |
|-----------|-------|-----------------------|
| None      | None  | Returns the list of currently loaded PHP extensions. |

- **Description**: Retrieves the list of PHP modules currently loaded in the environment.
- **Returns**: An array of loaded PHP module names.

### `memory_usage(...)`

| Parameter | Type  | Description                             |
|-----------|-------|-----------------------------------------|
| None      | None  | Returns the current memory usage.       |

- **Description**: Retrieves the current memory usage of the script.
- **Returns**: A string representing the memory usage in kilobytes (e.g., `"1024KB"`).

### `memory_limit(...)`

| Parameter | Type  | Description                           |
|-----------|-------|---------------------------------------|
| None      | None  | Returns the maximum memory limit.     |

- **Description**: Retrieves the memory limit set for the PHP script.
- **Returns**: A string representing the memory limit (e.g., `"128M"`).

### `cpu_load(...)`

| Parameter | Type  | Description                             |
|-----------|-------|-----------------------------------------|
| None      | None  | Returns the current CPU load average.   |

- **Description**: Retrieves the system’s average CPU load. Uses `sys_getloadavg()` if available.
- **Returns**: A float representing the average CPU load; `"intl-mod-missing"` if the function is not available.

### `upload_max_filesize(...)`

| Parameter | Type  | Description                              |
|-----------|-------|------------------------------------------|
| None      | None  | Returns the maximum file upload size.    |

- **Description**: Retrieves the maximum file upload size allowed by the PHP configuration.
- **Returns**: A string representing the maximum upload size (e.g., `"2M"`).

### `timer(...)`

| Parameter | Type  | Description                     |
|-----------|-------|---------------------------------|
| None      | None  | Returns the elapsed time.       |

- **Description**: Calculates and returns the elapsed time since the object was instantiated.
- **Returns**: A float representing the elapsed time in seconds, rounded to three decimal places.

### `js_error_script(...)`

| Parameter   | Type   | Description                                      |
|-------------|--------|--------------------------------------------------|
| `$action_url` | string | The URL where JavaScript errors should be sent. |

- **Description**: Outputs JavaScript code to capture JavaScript errors and send them to the specified URL via a POST request.
- **Returns**: None. The JavaScript code is output directly.

### `js_error_action(...)`

| Parameter         | Type          | Description                                          |
|-------------------|---------------|------------------------------------------------------|
| `$x_class_mysql`  | object         | An instance of the `x_class_mysql` class.           |
| `$table`          | string         | The name of the table where errors should be logged.|
| `$current_user_id` | int           | Optional. The ID of the current user (default is `0`).|
| `$section`        | string         | Optional. Additional context or section name (default is `""`). |

- **Description**: Logs JavaScript error details into a MySQL database. Creates the error table if it does not exist.
- **Returns**: None.

### `js_error_create_db(...)`

| Parameter        | Type   | Description                                        |
|------------------|--------|----------------------------------------------------|
| `$x_class_mysql` | object | An instance of the `x_class_mysql` class.         |
| `$table`         | string | The name of the table to create if it does not exist. |

- **Description**: Creates a MySQL table for logging JavaScript errors if it does not already exist.
- **Returns**: None.
