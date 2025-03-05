# Class Documentation: `x_class_referer` 

## Documentation

The `x_class_referer` class is designed to manage and track referer URLs for websites. It interacts with a MySQL database to store and update information about incoming traffic, including the referer URL, site URL, and associated metadata.


- **URL Preparation:** The method `prepareUrl()` is used internally to clean up the referer URL by removing query parameters, protocols (`http://`, `https://`), and `www.` prefix.  
- **Database Table:** The `create_table()` method ensures the database table structure is set up with columns for referer URL, site URL, hit count, and metadata.  

The class assumes that the `x_class_mysql` class handles errors related to database operations. Ensure that appropriate error handling is implemented in the `x_class_mysql` class.


## Requirements

### PHP Modules
- **MySQLi**: Required for database interactions.
- **PDO**: Optional, depending on how database interactions are handled.
- **URL Functions**: Built-in PHP functions like `parse_url`.

### External Classes
- **`x_class_mysql`**: Expected to handle MySQL operations such as querying, updating, and checking table existence.


## Table Structure

This section describes the table structure used by the Referer class to log referer information. The table is automatically created by the class if needed. Below is a summary of the columns and keys used in the table, along with their purposes.


| Column Name   | Data Type    | Attributes                                    | Description                                                                                         |
|---------------|--------------|-----------------------------------------------|-----------------------------------------------------------------------------------------------------|
| `id`          | `int(10)`    | `NOT NULL`, `AUTO_INCREMENT`, `PRIMARY KEY`  | A unique identifier for each referer log entry, ensuring that each record can be individually tracked. |
| `full_url`    | `varchar(256)` | `NOT NULL`, `DEFAULT '0'`                   | Stores the full URL of the referer, identifying the source of the traffic.                          |
| `site_url`    | `varchar(256)` | `NOT NULL`, `DEFAULT '0'`                   | Contains the URL of the site where the referer is located, providing context to the referer.        |
| `hits`        | `int(10)`    | `NOT NULL`, `DEFAULT '0'`                    | Records the number of hits or visits from the referer URL, useful for tracking traffic volume.      |
| `section`     | `varchar(128)` | `NOT NULL`, `DEFAULT ''`                    | For Multi Site Purposes to split database data in categories.    |
| `creation`    | `datetime`   | `DEFAULT CURRENT_TIMESTAMP`                 | Captures the date and time when the referer log entry was created. Automatically set upon insertion. |
| `modification`| `datetime`   | `DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP` | Logs the date and time of the last modification to the entry. Automatically updated on changes.   |


| Key Name      | Key Type  | Columns | Usage                                                                                                  |
|---------------|-----------|---------|--------------------------------------------------------------------------------------------------------|
| `PRIMARY KEY` | Primary   | `id`    | Ensures that each referer log entry is uniquely identifiable.                                            |
| `x_class_referer` | Unique    | `full_url`, `section`, `site_url` | Ensures that each combination of `full_url`, `section`, and `site_url` is unique, preventing duplicate entries for the same referer. |



## Method Library

| Method                    | Description                                                                                           |
|---------------------------|-------------------------------------------------------------------------------------------------------|
| **`__construct($mysql, $table, $refurlnowww)`** | Constructor to initialize the class. Requires an instance of the MySQL class, the table name, and the referer URL. |
| **`enabled($bool = true)`** | Sets whether the referer tracking is enabled.                                                        |
| **`get_array()`**         | Retrieves all records from the database table as an associative array.                               |
| **`execute($section = "")`** | Processes the current HTTP referer and updates the database with the referer URL information.         |

## Method Details

#### `__construct(...)`

| Parameter          | Type     | Description                                      |
|--------------------|----------|--------------------------------------------------|
| `$mysql`           | Object   | An instance of the MySQL class for database operations. |
| `$table`           | String   | The name of the MySQL table to use.             |
| `$refurlnowww`     | String   | The URL to exclude from tracking.                |

**Description:**  
Initializes the class with the given MySQL instance, table name, and referer URL. It also checks if the table exists and creates it if necessary.

#### `enabled(...)`

| Parameter          | Type   | Default | Description                                    |
|--------------------|--------|---------|------------------------------------------------|
| `$bool`            | Bool   | `true`  | Whether referer tracking is enabled or disabled. |

**Description:**  
Enables or disables the referer tracking based on the boolean value provided.

#### `get_array(...)`

| Return Type        | Description                                         |
|--------------------|-----------------------------------------------------|
| Array              | An associative array containing all rows from the database table. |

**Description:**  
Fetches all records from the MySQL table as an associative array.

#### `execute(...)`

| Parameter          | Type     | Default | Description                                      |
|--------------------|----------|---------|--------------------------------------------------|
| `$section`         | String   | `""`    | The section to categorize the referer URL.       |

**Description:**  
Processes the current HTTP referer. If the referer is not the same as the excluded URL and not empty, it updates the hit count or inserts a new record into the database. It also checks if the referer URL contains query parameters and cleans it before storing.

**Return Value:**  
Returns `true` upon successful execution.


