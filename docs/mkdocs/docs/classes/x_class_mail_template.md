# PHP Class: `x_class_mail_template`

## Introduction

The `x_class_mail_template` class manages email templates stored in a MySQL database. It supports creation, retrieval, modification, and deletion of email templates with multi-language and section support. Additionally, the class provides mechanisms for content and subject substitution, allowing dynamic customization of email content before sending. Templates can optionally include headers and footers, and the class can be integrated with mailing functionality (e.g., `x_class_mail`).

Use the class by including the file containing it in your project.

!!! warning "Dependencies"
	- PHP 7.0-8.x
	- PHP MySQLi or compatible DB wrapper for SQL execution

!!! warning "PHP-Modules"
	- A MySQL-compatible PHP DB handler (custom or like `x_class_mysql`)

## MySQL Table

This class automatically creates and manages a database table for storing email templates. Below is the description of the table structure.

!!! note "The table is automatically created in the constructor if it does not exist."

| Column Name | Data Type   | Attributes                                                       | Description                                  |
|-------------|-------------|-----------------------------------------------------------------|----------------------------------------------|
| `id`        | `int(10)`   | `NOT NULL`, `AUTO_INCREMENT`, `PRIMARY KEY`                    | Unique identifier for each template          |
| `name`      | `varchar(256)` | `NOT NULL`                                                    | Unique template identifier                    |
| `subject`   | `text`      | `NULL`                                                          | Template email subject                        |
| `description`| `text`     | `NULL`                                                          | Optional description of the template         |
| `content`   | `text`      | `DEFAULT NULL`                                                  | Email template body content                   |
| `lang`      | `varchar(32)` | `DEFAULT ''`                                                  | Language code key for template variation     |
| `section`   | `varchar(128)`| `DEFAULT NULL`                                                | Logical section or grouping for templates    |
| `creation`  | `datetime`  | `DEFAULT CURRENT_TIMESTAMP`                                     | Creation timestamp                            |
| `modification` | `datetime` | `DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP`      | Last modification timestamp, auto-updated    |

| Key Name              | Key Type | Columns                  | Usage                                             |
|-----------------------|----------|--------------------------|---------------------------------------------------|
| `PRIMARY KEY`          | Primary  | `id`                     | Unique primary key                                |
| `${table}_unique`      | Unique   | `name`, `lang`, `section`| Ensures template uniqueness per name/lang/section|

## Methods

***

### `__construct`

Initializes the class with DB connection, table name, section, and language settings.

| Parameter | Type   | Description                          | Default      |
|-----------|--------|------------------------------------|--------------|
| `$mysql`  | object | MySQL-compatible DB handler          | None         |
| `$table`  | string | Database table name for templates   | None         |
| `$section`| string | Section/grouping for template scope | `""`         |
| `$lang`   | string | Language code for templates          | `""`         |

| Return Value | When does this return value occur? |
|--------------|------------------------------------|
| `void`       | Class instance constructed          |

***

### `set_header`

Sets global header content for emails.

| Parameter | Type   | Description             |
|-----------|--------|-------------------------|
| `$header` | string | Header HTML/text content|

| Return Value | When does this return value occur? |
|--------------|------------------------------------|
| `void`       | Method does not return a value     |

***

### `set_footer`

Sets global footer content for emails.

| Parameter | Type   | Description             |
|-----------|--------|-------------------------|
| `$footer` | string | Footer HTML/text content|

| Return Value | When does this return value occur? |
|--------------|------------------------------------|
| `void`       | Method does not return a value     |

***

### `set_content`

Sets the full email content and subject, overwriting the current template content.

| Parameter | Type   | Description                |
|-----------|--------|----------------------------|
| `$content`| string | Email body content          |
| `$subject`| string | Email subject line          |

| Return Value | When does this return value occur? |
|--------------|------------------------------------|
| `void`       | Sets internal content and subject  |

***

### `set_template`

Loads a template by name from the database based on current section and language.

| Parameter | Type   | Description           |
|-----------|--------|-----------------------|
| `$name`   | string | Template identifier   |

| Return Value | When does this return value occur? |
|--------------|------------------------------------|
| `bool`       | `true` if template found and loaded; otherwise `false` |

***

### `setup`

Creates or updates a mail template in the database.

| Parameter  | Type    | Description                                 | Default       |
|------------|---------|---------------------------------------------|---------------|
| `$name`    | string  | Unique template name                         | None          |
| `$subject` | string  | Subject text                                | None          |
| `$content` | string  | Email content                               | None          |
| `$description`| string| Optional description of the template       | `""`          |
| `$overwrite`| bool   | Whether to overwrite existing template      | `false`       |
| `$lang`    | string  | Language override for this setup             | Current class language |

| Return Value | When does this return value occur? |
|--------------|------------------------------------|
| `int|void`   | Insert ID on new record, or void when updating |

***

### `reset_substitution`

Clears all added text substitutions.

| Return Value | When does this return value occur? |
|--------------|------------------------------------|
| `void`       | Always                            |

***

### `add_substitution`

Adds a text substitution pair to be applied on email content or subject.

| Parameter | Type   | Description                   |
|-----------|--------|-------------------------------|
| `$name`   | string | Placeholder name or text to replace |
| `$replace`| string | Replacement text               |

| Return Value | When does this return value occur? |
|--------------|------------------------------------|
| `void`       | Always                            |

***

### `do_substitute`

Applies all substitutions on given text.

| Parameter | Type   | Description      |
|-----------|--------|------------------|
| `$text`   | string | Text to process  |

| Return Value | When does this return value occur? |
|--------------|------------------------------------|
| `string`     | Text after substitutions applied  |

***

### `get_content`

Returns the email content, optionally with substitutions applied.

| Parameter | Type   | Description               | Default |
|-----------|--------|---------------------------|---------|
| `$substitute` | bool| Whether to apply substitutions | `false` |

| Return Value | When does this return value occur? |
|--------------|------------------------------------|
| `string`     | Email content with or without substitutions |

***

### `get_subject`

Returns the email subject, optionally with substitutions applied.

| Parameter | Type   | Description               | Default |
|-----------|--------|---------------------------|---------|
| `$substitute` | bool| Whether to apply substitutions | `false` |

| Return Value | When does this return value occur? |
|--------------|------------------------------------|
| `string`     | Email subject with or without substitutions|

***

### `change`

Updates an existing template identified by ID.

| Parameter  | Type   | Description                  | Default        |
|------------|--------|------------------------------|----------------|
| `$id`      | int    | Template database ID          | None           |
| `$name`    | string | New name for the template     | None           |
| `$subject` | string | New subject text              | None           |
| `$content` | string | New email content             | None           |
| `$description` | string | Optional description        | `""`           |

| Return Value | When does this return value occur? |
|--------------|------------------------------------|
| `void|false` | `false` if invalid ID, else void   |

***

### `name_exists`

Checks if a template with given name exists in current section and language.

| Parameter | Type   | Description            |
|-----------|--------|------------------------|
| `$name`   | string | Template name          |

| Return Value | When does this return value occur? |
|--------------|------------------------------------|
| `int|false` | Returns template ID if exists, else `false` |

***

### `get_name_by_id`

Retrieves template name by ID.

| Parameter | Type   | Description           |
|-----------|--------|-----------------------|
| `$id`     | int    | Template ID           |

| Return Value | When does this return value occur? |
|--------------|------------------------------------|
| `string|false` | Template name or `false` if not found |

***

### `id_exists`

Checks if a template ID exists in current section and language.

| Parameter | Type   | Description             |
|-----------|--------|-------------------------|
| `$id`     | int    | Template ID             |

| Return Value | When does this return value occur? |
|--------------|------------------------------------|
| `bool`     | `true` if exists, else `false`      |

***

### `id_delete`

Deletes a template by ID.

| Parameter | Type   | Description             |
|-----------|--------|-------------------------|
| `$id`     | int    | Template ID             |

| Return Value | When does this return value occur? |
|--------------|------------------------------------|
| `bool|false`| Query success or `false` if invalid ID |

***

### `name_delete`

Deletes a template by name.

| Parameter | Type   | Description             |
|-----------|--------|-------------------------|
| `$name`   | string | Template name           |

| Return Value | When does this return value occur? |
|--------------|------------------------------------|
| `bool`      | Query success                    |

***

### `get_full`

Retrieves all information for a template by ID.

| Parameter | Type   | Description             |
|-----------|--------|-------------------------|
| `$id`     | int    | Template ID             |

| Return Value | When does this return value occur? |
|--------------|------------------------------------|
| `array|false`| Associative array of template data or `false` if not found |

***

## Example

```php
<?php
// Assuming $db is a MySQL DB wrapper instance
$mailTemplates = new x_class_mail_template($db, 'mail_templates', 'notifications', 'en');

// Create or update a template
$mailTemplates->setup('welcome_email', 'Welcome!', '<p>Hello {{name}}, welcome!</p>', 'Welcome email template', true);

// Load a template
if ($mailTemplates->set_template('welcome_email')) {
    // Add substitutions
    $mailTemplates->add_substitution('{{name}}', 'John Doe');

    // Get processed content
    $content = $mailTemplates->get_content(true);
    $subject = $mailTemplates->get_subject(true);

    // Use $content and $subject for sending email...
    echo $subject;
    echo $content;
} else {
    echo "Template not found.";
}
?>
```
