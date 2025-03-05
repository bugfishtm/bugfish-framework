# Class Documentation: `x_class_lang`

## Documentation

The `x_class_lang` class is a PHP-based localization and translation management utility that helps manage multilingual content in applications. It supports database-backed translation, with optional file-based fallback. This class is designed to store, retrieve, add, and manage language-specific key-value pairs for different sections of an application, facilitating seamless translation and localization.

- **File-based vs Database-based Operation:** If a `$file_name` is provided in the constructor, the class operates in file mode and will not interact with the database.  
- **Table Creation:** If the table does not exist, it is automatically created.  
- **Substitutions:** Use `%repsub%` as a placeholder in translations to dynamically insert content.   

## Requirements

### PHP Modules
  - `PDO` or MySQLi (for database access)
  - `File handling functions` (e.g., `file_exists`, `file`, etc.)

### External Classes
- **x_class_mysql**: Required for database operations.



## Table Structure

This section describes the table structure used by the Translation class to store translation keys and their corresponding values. The table is automatically created by the class if needed. Below is a summary of the columns and keys used in the table, along with their purposes.

| Column Name     | Data Type    | Attributes                                    | Description                                                                                         |
|-----------------|--------------|-----------------------------------------------|-----------------------------------------------------------------------------------------------------|
| `id`            | `int(9)`     | `NOT NULL`, `AUTO_INCREMENT`, `PRIMARY KEY`  | A unique identifier for each translation entry, ensuring that each record can be uniquely tracked. |
| `identificator` | `varchar(512)` | `NOT NULL`                                  | A descriptor or key for the translation, used to identify the specific string or text to be translated. |
| `lang`          | `varchar(16)`  | `NOT NULL`                                  | Indicates the language code (e.g., 'en', 'fr') for the translation, specifying the language of the text. |
| `translation`   | `text`       | `NULL`                                      | Contains the translated text or description, providing the actual translation for the key.          |
| `section`       | `varchar(128)` | `DEFAULT ''`                                | For Multi Site Purposes to split database data in categories.  |
| `creation`      | `datetime`   | `DEFAULT CURRENT_TIMESTAMP`                 | Records the date and time when the translation entry was created. Automatically set upon insertion. |
| `modification`  | `datetime`   | `DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP` | Logs the date and time of the last modification to the translation entry. Automatically updated on changes. |

| Key Name      | Key Type  | Columns | Usage                                                                                                  |
|---------------|-----------|---------|--------------------------------------------------------------------------------------------------------|
| `PRIMARY KEY` | Primary   | `id`    | Ensures that each translation entry is uniquely identifiable, allowing for precise record management. |
| `x_class_lang` | Unique    | `identificator`, `lang`, `section` | Ensures that each combination of `identificator`, `lang`, and `section` is unique, preventing duplicate translations for the same key, language, and section. |



## Class Variables

| Variable Name | Type    | Access    | Description |
|---------------|---------|-----------|-------------|
| `$mysql`      | object  | private   | MySQL connection object for database interactions. |
| `$table`      | string  | private   | Database table name for storing translations. |
| `$section`    | string  | private   | The section or module within the application to which the translations belong. |
| `$lang`       | string  | private   | Current language code (e.g., 'en', 'fr'). |
| `$array`      | array   | public    | In-memory array to store translations for quick access. |
| `$filemode`   | boolean | private   | Flag to indicate if the class operates in file-based mode instead of database mode. |

## Constructor

```php
function __construct($x_class_mysql = false, $table = false, $lang = "none", $section = "none", $file_name = false)
```

- **Parameters:**

| Parameter | Type   | Description |
|-----------|--------|-------------|
| `$mysql`   | object | MySQL database object, required if using database mode. |
| `$table`   | string | Table name where translations are stored. |
| `$lang`    | string | Language code (e.g., 'en'). |
| `$section` | string | Section name to scope translations. |
| `$file_name` | string | Optional: Path to a file for file-based translations. |

- **Description:** Initializes the class either in database mode or file mode, depending on provided parameters.

## Class Methods

#### `create_table(..)`

```php
private function create_table()
```

- **Parameters:** None
- **Description:** Creates the translations table in the database if it doesn't already exist.
- **Returns:** Boolean (True on success, False on failure)

#### `init(..)`

```php
private function init()
```

- **Parameters:** None
- **Description:** Loads translations from the database into the `$array` variable for the current language and section.
- **Returns:** Void

#### `delete(..)`

```php
public function delete($key, $lang = false)
```

| Parameter | Type   | Description |
|-----------|--------|-------------|
| `$key`    | string | The translation key to delete. |
| `$lang`   | string | Optional: Language code to delete the key from, defaults to current language. |

- **Description:** Deletes a translation entry for a specific key from the database.
- **Returns:** Boolean (True on success, False on failure)

#### `add(..)`

```php
public function add($key, $text, $lang = false)
```

| Parameter | Type   | Description |
|-----------|--------|-------------|
| `$key`    | string | The translation key to add. |
| `$text`   | string | The translation text to add. |
| `$lang`   | string | Optional: Language code, defaults to the current language. |

- **Description:** Adds a new translation entry to the database for a specific key.
- **Returns:** Boolean (True on success, False on failure)

#### `translate(..)`

```php
public function translate($key, $substitution = false)
```

| Parameter      | Type         | Description |
|----------------|--------------|-------------|
| `$key`         | string       | The translation key to fetch. |
| `$substitution`| array        | Optional: Array of substitutions for placeholders in the translation text. |

- **Description:** Retrieves a translation for the current language. If substitutions are provided, they replace placeholders in the translation.
- **Returns:** String (Translation text)

#### `extend(..)`

```php
public function extend($key, $value, $overwrite = true)
```

| Parameter  | Type    | Description |
|------------|---------|-------------|
| `$key`     | string  | The translation key to extend. |
| `$value`   | string  | The translation text to associate with the key. |
| `$overwrite` | boolean | Whether to overwrite existing translation if the key already exists. |

- **Description:** Adds or updates an in-memory translation without affecting the database.
- **Returns:** Void

