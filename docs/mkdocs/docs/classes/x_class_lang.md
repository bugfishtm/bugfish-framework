# PHP Class: `x_class_lang`

## Introduction

The `x_class_lang` class manages language translations for a multi-language system using either a MySQL database table or a flat file. It provides methods to add, delete, and retrieve translation strings keyed by identifiers, supporting language-specific and section-specific translations. The class can load translations from a database or from a file and allows translation string substitution and extension at runtime.

Use the class by including `/_framework/classes/x_class_lang.php`.

!!! warning "Dependencies"
	- PHP 7.0-8.4
	- PHP `mysqli` or compatible MySQL handler extension
	- Requires an instance of a MySQL-like database class (`x_class_mysql` or similar) for DB operations

## MySQL Table

The class uses a MySQL table to store translation entries. This table will be automatically created if missing.

| Column Name   | Data Type     | Attributes                                                        | Description                                            |
|---------------|---------------|------------------------------------------------------------------|--------------------------------------------------------|
| `id`          | `int(9)`      | `NOT NULL`, `AUTO_INCREMENT`, `PRIMARY KEY`                      | Unique identifier for each translation entry          |
| `identificator`| `varchar(512)`| `NOT NULL`                                                       | Unique key or identifier for the translation string   |
| `lang`        | `varchar(16)` | `NOT NULL`                                                       | Language code of the translation                        |
| `translation` | `text`        |                                                                  | Translated text corresponding to the identifier       |
| `section`     | `varchar(128)`| `DEFAULT ''`                                                     | Section or context this translation belongs to         |
| `creation`    | `datetime`    | `DEFAULT CURRENT_TIMESTAMP`                                     | Timestamp when the entry was created                    |
| `modification`| `datetime`    | `DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP`         | Timestamp updated when the entry is modified           |

| Key Name                 | Key Type | Columns                        | Usage                                     |
|--------------------------|----------|--------------------------------|-------------------------------------------|
| `PRIMARY KEY`            | Primary  | `id`                           | Unique identifier primary key             |
| `x_class_lang_unique`    | Unique   | `identificator`, `lang`, `section` | Ensures a unique translation per identifier/language/section |

## Methods

***

### `__construct`

Initializes the class for translations with MySQL or file mode.

| Parameter  | Type    | Description                                                     | Default       |
|------------|---------|-----------------------------------------------------------------|---------------|
| `$mysql`   | object  | MySQL handler instance for DB operations                        | `false`       |
| `$table`   | string  | Table name for storing translations                             | `false`       |
| `$lang`    | string  | Language code to load/manage translations                       | `"none"`      |
| `$section` | string  | Section identifier to scope translations                        | `"none"`      |
| `$file_name`| string | Optional filename to load translations from a flat file        | `false`       |

| Return Value | When does this occur?               |
|--------------|------------------------------------|
| `int` 0      | If initialized with no DB operations needed |

***

### `create_table`

Creates the translation table if not existing.

| Parameters | None |
|------------|------|
| Return Value | `boolean` true on successful table creation, false otherwise |

***

### `init`

Loads all translations for the current language and section into an array for fast access.

| Parameters | None |
|------------|-------|
| Return Value | `void` or `false` if in file mode |

***

### `delete`

Deletes a translation key from the current or specified language and section.

| Parameter | Type     | Description                                   | Default    |
|-----------|----------|-----------------------------------------------|------------|
| `$key`    | string   | Translation key to delete                      | None       |
| `$lang`   | string   | Optional language code, defaults to loaded language | `false` |
| Return Value | `boolean` success or failure of deletion |

***

### `add`

Adds a new translation entry or overrides existing for the current or specified language and section.

| Parameter | Type   | Description                       | Default   |
|-----------|--------|---------------------------------|-----------|
| `$key`    | string | Translation key                  | None      |
| `$text`   | string | Translation text                 | None      |
| `$lang`   | string | Optional language code           | `false`   |
| Return Value | `boolean` success or failure of insert |

***

### `translate`

Retrieves the translation for a given key for the loaded language and substitutes placeholders if provided.

| Parameter      | Type       | Description                                   | Default   |
|----------------|------------|-----------------------------------------------|-----------|
| `$key`         | string     | Translation key to fetch                       | None      |
| `$substitution`| array|null | Optional array of substitution values          | `false`   |
| Return Value | `string` Translated and substituted string or key if not found |

***

### `extend`

Modifies or adds a key/value pair in the loaded translation array at runtime.

| Parameter   | Type      | Description                                | Default  |
|-------------|-----------|--------------------------------------------|----------|
| `$key`      | string    | Translation key                            | None     |
| `$value`    | string    | Translation value                          | None     |
| `$overwrite`| boolean   | Overwrite existing value if `true`        | `true`   |
| Return Value | `void` |

***

## Example

```php
<?php
// Using MySQL instance for DB-backed translations
$db = new x_class_mysql(...);
$lang = new x_class_lang($db, 'translations', 'en', 'website');

// Add a translation
$lang->add('greeting', 'Hello, world!');

// Retrieve a translation
echo $lang->translate('greeting'); // Outputs: Hello, world!

// Substitute placeholders in translations
$lang->add('welcome_user', 'Welcome, %repsub%!');
echo $lang->translate('welcome_user', ['Alice']); // Outputs: Welcome, Alice!

// Delete a translation entry
$lang->delete('greeting');

// Extend translation dynamically
$lang->extend('farewell', 'Goodbye!', true);
echo $lang->translate('farewell'); // Outputs: Goodbye!
?>
```