# Class Documentation: `x_class_table` 

### Documentation
The `x_class_table` class is a PHP utility designed for easy manipulation and management of database tables. It facilitates creating, editing, deleting, and displaying records through a straightforward API. The class is intended for developers who need to handle these operations consistently and securely, incorporating CSRF protection.

- **CSRF Handling:** All `exec_*` methods incorporate CSRF protection using `x_class_csrf`.  
- **Array Configurations:** Fields must be configured properly in the `$create` and `$edit` arrays using `config_array()`.  


The `x_class_table` class provides methods to create, edit, delete, and display data from a MySQL table. It includes automatic CSRF protection and a flexible structure for handling different types of data inputs.

### Requirements
- **PHP Modules:**
  - `mysqli` (or compatible library for MySQL operations)
  - `HTML/Forms Handling` functions (if applicable)

- **External Classes:**
  - `x_class_csrf`: Handles CSRF protection.

## Constructor

```php
function __construct($mysql, $table_name, $id = false, $id_field = "id")
```

| Parameter  | Type   | Description                                               |
|------------|--------|-----------------------------------------------------------|
| `$mysql`   | object | MySQL connection object (e.g., MySQLi instance).          |
| `$table_name` | string | The name of the database table to operate on.             |
| `$id`      | mixed  | (Optional) The ID of the current record (default: `false`).|
| `$id_field`| string | (Optional) The name of the ID field in the table (default: `"id"`). |

**Special Notes:**
- If `$id` is provided, the class will load an existing record. Otherwise, it operates on new records.
- The CSRF protection is initialized for each instance with a unique identifier.

## Public Methods

#### `exec_delete(...)`

Deletes a record from the table based on the submitted form data.

| Parameter     | Type    | Description                                      |
|---------------|---------|--------------------------------------------------|
| `$ovr_csrf`   | boolean | Whether to override CSRF protection (default: `false`). |

**Returns:**  
`"deleted"` if the record is successfully deleted, `"csrf"` if CSRF validation fails.


#### `config_rel_url(...)`

Configures the relative URL used in forms for this instance.

| Parameter  | Type   | Description                                   |
|------------|--------|-----------------------------------------------|
| `$rel_url` | string | The URL to which forms will be submitted.     |


#### `config_array(...)`

Sets up the creation and editing arrays used in forms.

| Parameter  | Type    | Description                                           |
|------------|---------|-------------------------------------------------------|
| `$create`  | array   | The array defining the fields for creation.           |
| `$edit`    | array   | The array defining the fields for editing.            |


#### `exec_edit(...)`

Processes and updates a record based on the edit form submission.

**Returns:**  
`"edited"` if the record is successfully edited, `"csrf"` if CSRF validation fails.


#### `exec_create(...)`

Creates a new record based on the submitted form data.

**Returns:**  
`"created"` if the record is successfully created, `"csrf"` if CSRF validation fails.


#### `spawn_return(...)`

Displays a message box indicating the result of the last operation.

| Parameter  | Type   | Description                                    |
|------------|--------|------------------------------------------------|
| `$deleted` | string | Message to display if a record was deleted.    |
| `$csrf`    | string | Message to display if CSRF validation fails.   |
| `$edited`  | string | Message to display if a record was edited.     |
| `$created` | string | Message to display if a record was created.    |

#### `spawn_create(...)`

Generates a form for creating a new record.

| Parameter      | Type    | Description                                          |
|----------------|---------|------------------------------------------------------|
| `$button_name` | string  | Text for the submit button (default: `"Create Item"`). |
| `$button_class`| string  | CSS classes for the submit button (default: `""`).   |
| `$add_info`    | array   | Additional information for customizing the form.     |


#### `spawn_edit(...)`

Generates a form for editing an existing record.

| Parameter      | Type    | Description                                          |
|----------------|---------|------------------------------------------------------|
| `$button_name` | string  | Text for the submit button (default: `"Edit Item"`). |
| `$button_class`| string  | CSS classes for the submit button (default: `""`).   |
| `$add_info`    | array   | Additional information for customizing the form.     |


#### `spawn_table(...)`

Displays a table with data from the database.

| Parameter      | Type    | Description                                                |
|----------------|---------|------------------------------------------------------------|
| `$title_array` | array   | Column headers for the table.                              |
| `$value_array` | array   | Data rows to be displayed.                                 |
| `$editing`     | mixed   | Enables edit buttons if set (default: `false`).            |
| `$deleting`    | mixed   | Enables delete buttons if set (default: `false`).          |
| `$creating`    | mixed   | Displays a "Create New" button if set (default: `false`).  |
| `$action_column` | string | Text for the action column header (default: `"Action"`).   |
| `$classes`     | string  | CSS classes for styling the table.                         |
| `$add_info`    | array   | Additional information for customizing the table.          |
