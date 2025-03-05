# Class Documentation: `x_class_hitcounter`

## Documentation

The `x_class_hitcounter` class is designed to track and manage hits on specific URLs within a section of a website. It counts both unique "arrivals" (first visits by a user) and "switches" (subsequent hits to the same URL during a session). The class relies on MySQL for data storage and can dynamically create its own table if it doesn't exist.

- **Session Management:** The class relies on PHP sessions to track arrivals and switches, ensuring unique hits within a session.
- **URL Cleaning:** The `prepareUrl` method ensures URLs are stored consistently by removing protocol, subdomain, and GET parameters when configured to do so.
- **Switches vs. Arrivals:** Switches refer to repeated hits on the same URL during a session, while arrivals count the first visit.

This class handles the counting and tracking of page hits and switches in a web application, storing the data in a MySQL database.

## Requirements

### PHP Modules
  - `mysqli` or equivalent for database interaction.
  - `session` module for tracking user sessions.

### External Classes
  - A MySQL wrapper class or object that provides methods such as `select`, `query`, `update`, `table_exists`, and `free_all`.



## Table Structure

This section explains the table structure that will be automatically created by the hit counter class to log site visits. The table captures detailed information about each visit, including the URL, visit counts, and associated sections. Below is a summary of the columns and keys used in the table, along with their intended purpose.


| Column Name   | Data Type     | Attributes                                  | Description                                                                                          |
|---------------|---------------|---------------------------------------------|------------------------------------------------------------------------------------------------------|
| `id`          | `int(10)`     | `NOT NULL`, `AUTO_INCREMENT`, `PRIMARY KEY` | A unique identifier for each visit log entry.                                                        |
| `full_url`    | `varchar(512)`| `NOT NULL`, `DEFAULT '0'`                   | The full URL of the site being tracked, associated with the visit.                                   |
| `switches`    | `int(10)`     | `DEFAULT '0'`                               | The number of changes or switches made to the site during the session.                               |
| `arrivals`    | `int(10)`     | `NOT NULL`, `DEFAULT '0'`                   | The number of arrivals at the site for the given URL.                                                |
| `section`     | `varchar(128)`| `NOT NULL`, `DEFAULT ''`                    | For Multi Site Purposes to split database data in categories.                        |
| `summarized`  | `int(10)`     | `NOT NULL`, `DEFAULT '0'`                   | The total number of hits for the specific URL, summarizing all visits.                               |
| `creation`    | `datetime`    | `DEFAULT CURRENT_TIMESTAMP`                 | The timestamp when the visit record was created. Automatically set when a new entry is added.        |
| `modification`| `datetime`    | `DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP` | The timestamp of the last modification to the visit record. Automatically updated on changes.  |



| Key Name       | Key Type  | Columns                    | Usage                                                                                                  |
|----------------|-----------|----------------------------|--------------------------------------------------------------------------------------------------------|
| `PRIMARY KEY`  | Primary   | `id`                       | Ensures each log entry is uniquely identifiable.                                                       |
| `x_class_hitcounter`  | Unique    | `full_url`, `section`| Ensures that each unique URL and section combination is only logged once, avoiding duplicate entries.  |


## Method Library

| Method             | Parameters                                                                                   | Description                                                                                                            |
|--------------------|----------------------------------------------------------------------------------------------|------------------------------------------------------------------------------------------------------------------------|
| `__construct`      | `$x_class_mysql`, `$table`, `$precookie = ""`, `$section = ""`                                       | Initializes the class, setting up the database connection and ensuring the table exists.                               |
| `enabled`          | `$bool = true`                                                                               | Enables or disables hit counting.                                                                                      |
| `clearget`         | `$bool = true`                                                                               | Configures whether to clean GET parameters from URLs.                                                                  |
| `get_array`        | None                                                                                         | Returns all records from the hit counter table as an array.                                                            |
| `refresh_counters` | None                                                                                         | Refreshes the internal counters based on the current URL and section.                                                  |
| `prepareUrl`       | `$tmpcode`                                                                                   | Prepares and cleans the URL for consistent storage and comparison.                                                     |
| `execute`          | None                                                                                         | Main method to track a hit or switch, updating the database accordingly.                                               |

## Method Details

### `__construct(...)`

Initializes the hit counter instance. This method starts the session, stores key information, and ensures the MySQL table exists.

| Parameter   | Type   | Description                                     |
|-------------|--------|-------------------------------------------------|
| `$thecon`   | Object | The MySQL connection object.                    |
| `$table`    | String | Name of the table to store hit counter data.    |
| `$precookie`| String | Prefix for session cookies to avoid collisions. |
| `$section`  | String | Section name to differentiate URLs by context.  |

### `enabled(...)`

Enables or disables the hit counter. If disabled, no hits or switches are counted.

| Parameter | Type    | Description                     |
|-----------|---------|---------------------------------|
| `$bool`   | Boolean | Whether to enable the counter.  |

### `clearget(...)`

Configures the behavior to remove GET parameters from the URL before processing. If enabled, the URL is cleaned for consistent storage and comparison.

| Parameter | Type    | Description                                                      |
|-----------|---------|------------------------------------------------------------------|
| `$bool`   | Boolean | Whether to clean GET parameters from the URL before processing.  |

### `get_array(...)`

Returns all records in the hit counter table as an array.

| Parameter | Type | Description              |
|-----------|------|--------------------------|
| None      | N/A  | Returns an array of data. |

### `refresh_counters(...)`

Refreshes the internal counters (`$switches`, `$arrivals`, `$summarized`) for the current URL and section. It queries the database for existing records and updates the class properties.

| Parameter | Type | Description              |
|-----------|------|--------------------------|
| None      | N/A  | Updates internal counters.|

### `prepareUrl(...)`

Cleans and standardizes a URL for consistent storage in the database.

| Parameter | Type   | Description                                             |
|-----------|--------|---------------------------------------------------------|
| `$tmpcode`| String | The raw URL to be cleaned and standardized.             |

### `execute(...)`

Performs the main hit counting and updating operations. This method manages session-based hit counting and ensures accurate tracking of unique arrivals and switches.

| Parameter | Type | Description |
|-----------|------|-------------|
| None      | N/A  | Tracks the hit or switch for the current session. |


## Example Usage

```php
// Initialize the MySQL connection and table
$mysql = new MySQLWrapper();
$hitcounter = new x_class_hitcounter($mysql, 'hitcounter_table');

// Enable the counter and clean GET parameters from URLs
$hitcounter->enabled(true);
$hitcounter->clearget(true);

// Execute the hit counting process
$hitcounter->execute();

// Retrieve the summarized data
$switches = $hitcounter->switches;
$arrivals = $hitcounter->arrivals;
$totalHits = $hitcounter->summarized;
```

