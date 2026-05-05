# PHP Class: `x_class_var`

## Introduction

The `x_class_var` class provides a way to manage and persist configuration variables or constants in a MySQL database table. It supports automatic table creation and allows storing variables with descriptors, values, descriptions, and multi-site section identifiers. Variables can be loaded as PHP constants or retrieved as arrays. It also supports updating and deleting variables and includes helper methods for secure web form integration to edit values.

Use the class by including `/_framework/classes/x_class_var.php`.

!!! warning "Dependencies"
	- PHP 7.0-7.4
	- PHP 8.0-8.4

!!! warning "PHP-Modules"
	- `mysqli`: The PHP MySQLi extension must be installed and enabled.

!!! warning "PHP-Classes"
	- `x_class_mysql`: Required for database operations.


## MySQL Table

This section describes the structure of the table used for storing variables managed by `x_class_var`. The table will be automatically created by the class if it does not exist.

!!! note "The table will be automatically created upon constructor execution if it does not exist."

| Column Name | Data Type | Attributes | Description |
|--------------|---------------|-----------------------------------------------|----------------------------------------------------------------------------------------------------------|
| `id` | `int(9)` | `NOT NULL`, `AUTO_INCREMENT`, `PRIMARY KEY` | Unique identifier for each variable entry. |
| `descriptor` | `varchar(256)` | `NOT NULL` | The variable name or key descriptor. |
| `value` | `text` |  | The stored value for the variable. Serialized if array or object. |
| `description` | `text` |  | Optional descriptive text about the variable. |
| `section` | `varchar(128)` | `DEFAULT ''` | Section or namespace for the variable, suitable for multi-site or multi-context separation. |
| `creation` | `datetime` | `DEFAULT CURRENT_TIMESTAMP` | Timestamp when the entry was created. |
| `modification` | `datetime` | `DEFAULT CURRENT_TIMESTAMP` on update | Automatically updates timestamp when the entry is modified. |

| Key Name | Key Type | Columns | Usage |
|---------------|-----------|---------|------------------------------------------------------------|
| `PRIMARY` | Primary | `id` | Ensures each row is uniquely identifiable. |
| `unique_key` | Unique | `section, descriptor` | Enforces unique variable names per section, preventing duplicates. |


## Methods

***

### `__construct`

Initializes the class with the database connection, table name, and section (namespace) for variable segregation.

| Parameter | Type | Description | Default |
|--------------|---------|--------------------------------------------------------------|----------|
| `$mysql` | object | Database connection supporting typical query/select operations. | None |
| `$tablename` | string | Table name to store variables. | None |
| `$section` | string | Section name to scope variables (for multi-site or context). | None |
| `$descriptor` | string | Column name for descriptor (variable name/key). | `"descriptor"` |
| `$value` | string | Column name for variable value. | `"value"` |
| `$description` | string | Column name for descriptions. | `"description"` |
| `$sectionfield` | string | Column name for section. | `"section"` |
| `$idfield` | string | Column name for primary ID. | `"id"` |

| Return Value | When does this return value occur? |
|--------------|-------------------------------------------|
| `void` | Constructor does not return a value. It creates the table if it does not exist.|

***

### `init_constant`

Defines the stored variables as PHP constants in the current script for the current section.

| Parameter | Type | Description | Default |
|-----------|---------|-----------------------------------------------|---------|
| `$unserialize_arrays` | boolean | Automatically unserialize values if they are serializations of arrays or objects. | `true` |

| Return Value | When does this return value occur? |
|--------------|----------------------------------------------------|
| `true` | Always returns `true` after defining constants. |

***

### `get_array`

Retrieves all variables as an array of key-value pairs for the current section.

| Parameter | Type | Description | Default |
|-----------|------|-------------|---------|
| _None_ | — | — | — |

| Return Value | When does this return value occur? |
|--------------|-----------------------------------------------------|
| `array` | Array of variables with descriptor and value pairs. |

***

### `get_array_full`

Retrieves all variable records including metadata for the current section.

| Parameter | Type | Description | Default |
|-----------|------|-------------|---------|
| _None_ | — | — | — |

| Return Value | When does this return value occur? |
|--------------|-----------------------------------------------------|
| `array` | Array of full records including descriptor, value, description, section, creation date, modification date. |

***

### `get_full`

Retrieves full record details of a single variable by descriptor.

| Parameter | Type | Description | Default |
|-----------|-------|-------------------------------|---------|
| `$name` | string | Variable descriptor to fetch. | None |

| Return Value | When does this return value occur? |
|--------------|---------------------------------------------------|
| `array|false` | Full variable record array if found, otherwise `false`. |

***

### `exists`

Checks existence of a variable by descriptor in the current section.

| Parameter | Type | Description | Default |
|-----------|-------|---------------------------|---------|
| `$name` | string | Variable descriptor to check. | None |

| Return Value | When does this return value occur? |
|--------------|-------------------------------------------|
| `boolean` | `true` if variable exists, `false` otherwise. |

***

### `get`

Retrieves the value of a variable by descriptor.

| Parameter | Type | Description | Default |
|-----------|-------|------------------------------|---------|
| `$name` | string | Variable descriptor to retrieve. | None |

| Return Value | When does this return value occur? |
|--------------|-----------------------------------------------|
| `mixed|false` | Variable value if found, otherwise `false`. |

***

### `del`

Deletes a variable record by descriptor.

| Parameter | Type | Description | Default |
|-----------|-------|--------------------------|---------|
| `$name` | string | Variable descriptor to delete. | None |

| Return Value | When does this return value occur? |
|--------------|----------------------------------------------|
| `boolean` | `true` if deletion succeeded, `false` otherwise. |

***

### `setup`

Adds a new variable only if it does not already exist.

| Parameter | Type | Description | Default |
|-----------|-------|-----------------------------------------|---------|
| `$name` | string | Variable descriptor to add. | None |
| `$value` | mixed | Value of the variable. | None |
| `$description` | string | Optional description. | `""` |

| Return Value | When does this return value occur? |
|--------------|---------------------------------------------------------|
| `boolean` | `true` if added, `false` if variable already exists. |

***

### `add`

Adds or updates a variable.

| Parameter | Type | Description | Default |
|-----------|-------|------------------------------------|---------|
| `$name` | string | Variable descriptor to add/update. | None |
| `$value` | mixed | Value for the variable. | None |
| `$description` | string | Optional description. | `""` |
| `$overwrite` | boolean | Whether to overwrite existing variable. | `false` |

| Return Value | When does this return value occur? |
|--------------|----------------------------------------------|
| `boolean` | `true` if operation succeeded, otherwise `false`. |

***

### `set`

Internal method to add or update variables with control over overwrite behavior.

| Parameter | Type | Description | Default |
|-----------|-------|------------------------------------------|---------|
| `$name` | string | Variable descriptor. | None |
| `$value` | mixed | Value to set, serialized if array/object. | None |
| `$description` | string| Optional description. | `false` |
| `$add` | boolean | Whether to add new entry if not existing. | `true` |
| `$overwrite` | boolean | Whether to overwrite existing entry. | `true` |

| Return Value | When does this return value occur? |
|--------------|----------------------------------------------------------|
| `boolean` | `true` if successful, `false` otherwise. |

***

### `form_start`

Starts a web form session with CSRF token generation for secure editing.

| Parameter | Type | Description | Default |
|-----------|-------|--------------------------|---------|
| `$precookie` | string | Prefix for session variables to allow multiple form instances. | `""` |

| Return Value | When does this return value occur? |
|--------------|-------------------------------------------|
| `void` | Always. |

***

### `form_end`

Ends a web form session updating CSRF tokens.

| Parameter | Type | Description | Default |
|-----------|-------|--------------------------|---------|
| `$precookie` | string | Prefix for session variables. | `""` |

| Return Value | When does this return value occur? |
|--------------|-------------------------------------------|
| `void` | Always. |

***

### `form`

Generates and processes an HTML form to edit a stored variable with various input types and CSRF protection.

| Parameter | Type | Description | Default |
|-----------|-------|-------------------------------------------------------------------------------------------------------------------|---------|
| `$varname` | string | Variable descriptor to edit. | None |
| `$type` | string | Form input type (`int`, `text`, `string`, `select`). | `"int"` |
| `$selectarray` | array | For select inputs, list of options to show. | `array()` |
| `$precookie` | string | Prefix for session and form element names to isolate forms. | `""` |
| `$button_class` | string | CSS class for submit button styling. | `"btn btn-warning waves-effect waves-light"` |
| `$itemclass` | string | CSS class for form input styling. | `"form-control"` |
| `$editbuttonname` | string | Text for submit button. | `"Edit"` |

| Return Value | When does this return value occur? |
|--------------|-------------------------------------------------------------------------------------------------|
| `int` | Always returns `0`. |

***

## Example

```php
<?php
// Example usage:

// Use your MySQL DB connection object compatible with x_class_mysql
$db = new x_class_mysql(...);

// Initialize variable manager with section "SiteConfig"
$varManager = new x_class_var($db, 'configuration_table', 'SiteConfig');

// Add or update a variable
$varManager->add('MAX_USERS', 100, 'Maximum allowed users', true);

// Check if a variable exists
if ($varManager->exists('MAX_USERS')) {
    echo 'Max users: ' . $varManager->get('MAX_USERS');
}

// Define all variables in section as constants
$varManager->init_constant();

// Render a form to edit a variable on a web page
echo $varManager->form('MAX_USERS', 'int');

// Delete a variable
$varManager->del('MAX_USERS');
?>
```

