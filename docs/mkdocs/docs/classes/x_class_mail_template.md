# Class Documentation: `x_class_mail_template`

## Documentation

The `x_class_mail_template` class provides a powerful interface for managing email templates in PHP applications. It allows you to set up, modify, retrieve, and delete email templates stored in a MySQL database. Templates can be customized with content substitutions and dynamically generated, making it highly adaptable for various scenarios such as newsletters, notifications, and other email-based communications.

- **Substitutions:** The class uses an internal array to manage substitutions. These are key-value pairs where the keys represent placeholders within the template content that should be replaced by specific values when generating the email.
- **Table Management:** The class automatically creates the required table if it doesn’t exist, making it easier to integrate into new environments without requiring additional setup.

## Requirements

### PHP Modules
- **MySQLi**: Required for database operations.

### External Classes
- **`x_class_mysql` (MySQL Database Connection Class)**: The class expects a MySQL connection object that provides methods like `select`, `query`, and `table_exists`.


## Table Structure

This section describes the table structure used by the Mail Template class to store email templates. The table is automatically created by the class if necessary for its functionality. Below is a summary of the columns and keys used in the table, along with their purposes.


| Column Name   | Data Type    | Attributes                                    | Description                                                                                         |
|---------------|--------------|-----------------------------------------------|-----------------------------------------------------------------------------------------------------|
| `id`          | `int(10)`    | `NOT NULL`, `AUTO_INCREMENT`, `PRIMARY KEY`  | A unique identifier for each email template, ensuring that each template is individually trackable. |
| `name`        | `varchar(256)` | `NOT NULL`                                  | The name or identifier of the template.                                                             |
| `subject`     | `text`       | `NULL`                                      | The subject line for the email template, providing context for the email.                           |
| `description` | `text`       | `NULL`                                      | A description of the template's purpose or content, useful for understanding the template's use case.|
| `content`     | `text`       | `DEFAULT NULL`                              | The main content of the email template, including the body of the email.                           |
| `section`     | `varchar(128)` | `DEFAULT NULL`                              | For Multi Site Purposes to split database data in categories.                         |
| `creation`    | `datetime`   | `DEFAULT CURRENT_TIMESTAMP`                 | The timestamp when the template was created. Automatically set upon insertion.                    |
| `modification`| `datetime`   | `DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP` | The timestamp of the last modification to the template. Automatically updated on changes.         |


| Key Name      | Key Type  | Columns | Usage                                                                                                  |
|---------------|-----------|---------|--------------------------------------------------------------------------------------------------------|
| `PRIMARY KEY` | Primary   | `id`    | Ensures that each email template is uniquely identifiable.                                            |
| `x_class_mail_template` | Unique    | `name`, `section`    | Ensures that each combination of template name and section is unique, preventing duplicate entries for the same section. |




## Class Usage

| Method/Variable         | Description                                                                                     | Parameters                                                                                                                                                 | Return Type     |
|-------------------------|-------------------------------------------------------------------------------------------------|------------------------------------------------------------------------------------------------------------------------------------------------------------|-----------------|
| **`$x_class_mysql`**            | Stores the x_class_mysql object.                                                             | N/A                                                                                                                                                        | Object          |
| **`$table`**            | Stores the name of the table used for storing templates.                                        | N/A                                                                                                                                                        | String          |
| **`$section`**          | Section associated with templates, allowing categorization.                                     | N/A                                                                                                                                                        | String          |
| **`set_header`**        | Sets the header for the email content.                                                          | `string $header`: Header content.                                                                                                                          | void            |
| **`set_footer`**        | Sets the footer for the email content.                                                          | `string $footer`: Footer content.                                                                                                                          | void            |
| **`set_content`**       | Sets the email body content along with the subject.                                             | `string $content`: Main content of the email.<br>`string $subject`: Email subject.                                                                          | void            |
| **`set_template`**      | Loads a template from the database using the name and section.                                  | `string $name`: Template name.                                                                                                                             | `bool`          |
| **`create_table`**      | Creates the table structure for storing email templates if it doesn’t already exist.            | N/A                                                                                                                                                        | void            |
| **`reset_substitution`**| Resets all stored substitutions for template content.                                           | N/A                                                                                                                                                        | void            |
| **`add_substitution`**  | Adds a substitution pair for replacing placeholders in the content.                             | `string $name`: Placeholder text.<br>`string $replace`: Replacement text.                                                                                  | void            |
| **`do_substitute`**     | Applies the substitutions to a given text.                                                      | `string $text`: The content to process.                                                                                                                    | `string`        |
| **`get_content`**       | Retrieves the email content with optional substitution applied.                                 | `bool $substitute` (optional): Whether to apply substitutions. Default is `false`.                                                                         | `string`        |
| **`get_subject`**       | Retrieves the email subject with optional substitution applied.                                 | `bool $substitute` (optional): Whether to apply substitutions. Default is `false`.                                                                         | `string`        |
| **`setup`**             | Sets up a new template or overwrites an existing one.                                           | `string $name`: Template name.<br>`string $subject`: Subject.<br>`string $content`: Main content.<br>`string $description` (optional): Description.<br>`bool $overwrite` (optional): Whether to overwrite an existing template. | `mixed` (insert ID or void) |
| **`change`**            | Modifies an existing template by ID.                                                            | `int $id`: Template ID.<br>`string $name`: New name.<br>`string $subject`: New subject.<br>`string $content`: New content.<br>`string $description` (optional): New description. | void |
| **`name_exists`**       | Checks if a template with a specific name exists in the current section.                        | `string $name`: Name of the template.                                                                                                                      | `bool`          |
| **`get_name_by_id`**    | Retrieves the name of a template based on its ID.                                               | `int $id`: Template ID.                                                                                                                                    | `string|bool`   |
| **`id_exists`**         | Checks if a template with a specific ID exists in the current section.                          | `int $id`: Template ID.                                                                                                                                    | `bool`          |
| **`id_delete`**         | Deletes a template based on its ID.                                                             | `int $id`: Template ID.                                                                                                                                    | `bool`          |
| **`get_full`**          | Retrieves all details of a template based on its ID.                                            | `int $id`: Template ID.                                                                                                                                    | `array|bool`    |


## Return Values

- Functions that check for the existence of templates (`name_exists`, `id_exists`, etc.) return a boolean indicating success or failure.
- Functions like `setup` and `change` can return mixed values, such as insert IDs or boolean, depending on the context.
