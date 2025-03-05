# Class Documentation: `x_class_var` 

## Documentation

The `x_class_var` class is designed for managing configuration variables stored in a MySQL database. It allows you to create, read, update, and delete configuration values, as well as manage them via a form interface with built-in CSRF protection. This class is particularly useful for handling application settings that may need to be modified dynamically.

## Requirements

### PHP Modules
- **MySQLi**: For database interactions.

### External Classes
- **`x_class_mysql`**: A custom class or interface to handle MySQL database connections and queries.


## Table Structure

This section details the table structure used by the Variables class to store variables and their associated values. The table is automatically created by the class if needed. The column names can be customized through class properties. Below is a summary of the table's columns, keys, and their usage.


| Column Name       | Data Type       | Attributes                                           | Description                                                                                         |
|-------------------|-----------------|------------------------------------------------------|-----------------------------------------------------------------------------------------------------|
| `id`              | `int(9)`        | `NOT NULL`, `AUTO_INCREMENT`, `PRIMARY KEY`         | Unique identifier for each entry, ensuring that each record can be individually accessed and managed. |
| `descriptor`      | `varchar(256)`  | `NOT NULL`                                          | Descriptor for the constant or variable, serving as the key or name for the stored value.          |
| `value`           | `text`          | `NULL`                                              | Holds the value associated with the descriptor, which can be any text-based content.               |
| `description`     | `text`          | `NULL`                                              | Provides a description or additional details about the constant or variable.                      |
| `section`         | `varchar(128)`  | `DEFAULT ''`                                        | For Multi Site Purposes to split database data in categories.  |
| `creation`        | `datetime`      | `DEFAULT CURRENT_TIMESTAMP`                        | Records the date and time when the entry was created. Automatically set upon insertion.            |
| `modification`    | `datetime`      | `DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP` | Logs the date and time of the last modification to the entry. Automatically updated on changes.   |


| Key Name      | Key Type  | Columns | Usage                                                                                                  |
|---------------|-----------|---------|--------------------------------------------------------------------------------------------------------|
| `PRIMARY KEY` | Primary   | `id`    | Ensures that each entry has a unique identifier, allowing for precise record management and retrieval. |
| `x_class_var_unique`  | Unique    | `section`, `descriptor` | Ensures that each combination of `section` and `descriptor` is unique, preventing duplicate entries for the same section and descriptor. |



## Methods and Functions

The following tables provide detailed information about each method and function in the `x_class_var` class, including their parameters and descriptions.

### Constructor

| Method       | Parameters                                                                                                        | Description                                                                                                                                                      |
|--------------|-------------------------------------------------------------------------------------------------------------------|------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `__construct`| `$mysql` (x_class_mysql object), `$tablename` (string), `$section` (string), `$descriptor` (string, optional), `$value` (string, optional), `$description` (string, optional), `$sectionfield` (string, optional), `$idfield` (string, optional) | Initializes the class with database connection and table configuration. Creates the table if it does not exist. |

### Private Methods

| Method           | Parameters | Description                                             |
|------------------|------------|---------------------------------------------------------|
| `create_table`   | None       | Creates the table in the database if it does not exist. |

### Public Methods

| Method              | Parameters                                                                                           | Description                                                                                          |
|---------------------|------------------------------------------------------------------------------------------------------|------------------------------------------------------------------------------------------------------|
| `init_constant`     | `$unserialize_arrays` (bool)                                                                         | Initializes constants from the database. Defines PHP constants for each entry.                       |
| `get_array`         | None                                                                                                 | Retrieves an array of variable names and their values.                                               |
| `get_array_full`    | None                                                                                                 | Retrieves an array of all variables with full details from the database.                            |
| `get_full`          | `$name` (string)                                                                                    | Retrieves the full details of a specific variable by name.                                          |
| `exists`            | `$name` (string)                                                                                    | Checks if a variable exists in the database.                                                        |
| `get`               | `$name` (string)                                                                                    | Retrieves the value of a specific variable by name.                                                 |
| `del`               | `$name` (string)                                                                                    | Deletes a variable from the database by name.                                                        |
| `setup`             | `$name` (string), `$value` (mixed), `$description` (string, optional)                               | Sets up a new variable if it does not exist.                                                        |
| `add`               | `$name` (string), `$value` (mixed), `$description` (string, optional), `$overwrite` (bool, optional) | Adds a new variable or updates it if it already exists, based on the `$overwrite` flag.              |
| `set`               | `$name` (string), `$value` (mixed), `$description` (string, optional), `$add` (bool, optional), `$overwrite` (bool, optional) | Internal method to handle adding or updating variables.                                             |
| `form_start`        | `$precookie` (string, optional)                                                                      | Starts a new form for variable management with CSRF protection.                                       |
| `form_end`          | `$precookie` (string, optional)                                                                      | Ends the form and sets a CSRF token in the session.                                                  |
| `form`              | `$varname` (string), `$type` (string, optional), `$selectarray` (array, optional), `$precookie` (string, optional), `$button_class` (string, optional), `$itemclass` (string, optional), `$editbuttonname` (string, optional) | Generates and handles a form for editing a variable. Supports different input types.                  |

## Example Usage

### Constructing the Class

```php
$mysql = new x_class_mysql(...); // Assumes mysql_con is a valid class
$var = new x_class_var($mysql, 'my_table', 'my_section');
```

### Initializing Constants

```php
$var->init_constant();
```

### Adding a New Variable

```php
$var->add('MY_VAR', 'value', 'Description of MY_VAR');
```

### Updating an Existing Variable

```php
$var->setup('MY_VAR', 'new_value', 'Updated description');
```

### Deleting a Variable

```php
$var->del('MY_VAR');
```

### Generating a Form

```php
echo $var->form('MY_VAR', 'text', [], '', 'btn-primary', 'form-control');
```

