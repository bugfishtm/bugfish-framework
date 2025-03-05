# Class Documentation: `x_class_comment`

## Documentation
The `x_class_comment` class is designed to manage a commenting system. It allows users to post comments, upvote comments, and manage the display and storage of comments in a MySQL database. This class integrates with a MySQL database and uses sessions to track user votes.

- **Session Management**: Ensure sessions are started before using the class.
- **Database Table Creation**: The class automatically creates a table if it does not exist.
- **Captcha Verification**: Validates captcha if provided; otherwise, expects no captcha.

The `x_class_comment` class is designed to be flexible and integrate easily with various MySQL-backed systems. Ensure that all dependencies are met and that the MySQL wrapper class methods (`query`, `update`, etc.) are compatible with the usage in this class.

## Requirements

### PHP Modules
- `MySQLi`: For database interactions.
- `Session`: For session management.

### External Classes
- `x_class_mysql`: External x_class_mysql Object (`$mysqlobj`).


## Table Structure

This section explains the structure of the database table that will be automatically created by the class to log activities. The table captures information such as the target entity, user details, activity text, and status. Below is a summary of the columns and keys used in the table, along with their purposes.


| Column Name    | Data Type     | Attributes                                                                                          | Description                                                                                          |
|----------------|---------------|-----------------------------------------------------------------------------------------------------|------------------------------------------------------------------------------------------------------|
| `id`           | `int`         | `NOT NULL`, `AUTO_INCREMENT`, `PRIMARY KEY`                                                         | A unique identifier for each record in the table.                                                    |
| `target`       | `varchar(256)`| `DEFAULT NULL`                                                                                      | The name of the target entity associated with the activity (e.g., post, user, product).              |
| `targetid`     | `varchar(256)`| `DEFAULT NULL`                                                                                      | The identifier of the target entity, allowing precise tracking of which entity the activity refers to.|
| `name`         | `varchar(256)`| `NOT NULL`                                                                                          | The name of the author who performed the activity.                                                   |
| `text`         | `text`        | `NOT NULL`                                                                                          | The description or content of the activity logged.                                                   |
| `creation`     | `datetime`    | `DEFAULT CURRENT_TIMESTAMP`                                                                         | The timestamp when the activity was created. This value is automatically set when a new record is added. |
| `modification` | `datetime`    | `DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP`                                             | The timestamp of the last modification. This value is automatically updated whenever the record is changed. |
| `status`       | `tinyint(1)`  | `DEFAULT NULL`                                                                                      | The status of the activity, represented by numerical codes: 0 for Waiting, 1 for OK, 2 for Internal, 3 for System. |
| `upvotes`      | `int(9)`      | `DEFAULT '0'`                                                                                       | The number of upvotes received by the activity, useful for assessing its popularity or relevance.    |
| `section`      | `varchar(128)`| `DEFAULT NULL`                                                                                      | For Multi Site Purposes to split database data in categories.  |


| Key Name       | Key Type      | Columns         | Usage                                                                                                  |
|----------------|---------------|-----------------|--------------------------------------------------------------------------------------------------------|
| `PRIMARY KEY`  | Primary       | `id`            | Ensures each record in the table is uniquely identifiable by its `id`.                                  |


## Methods and Functions

### `__construct(...)`

| Parameter   | Type   | Description                                      |
|-------------|--------|--------------------------------------------------|
| `$x_class_mysql`    | object | MySQL database connection object.                |
| `$table`    | string | Name of the table to use for storing comments.   |
| `$precookie`| string | Prefix for session cookies.                     |
| `$module`   | string | Identifier for the module (e.g., blog post ID).  |
| `$target`   | string | Target ID for comments (e.g., article ID).       |
| `$section`  | string | Section identifier (optional).                   |

**Description**: Initializes the class, sets up session management, and checks for table existence. Creates the table if it does not exist.

### `sys_name(...)`

| Parameter   | Type   | Description                |
|-------------|--------|----------------------------|
| `$name`     | string | System name for comments.  |

**Description**: Sets the system name for the comments.

### `sys_text(...)`

| Parameter   | Type   | Description                |
|-------------|--------|----------------------------|
| `$text`     | string | System initialization text. |

**Description**: Sets the default system text.

### `vote_show(...)`

**Description**: Displays the upvote button and current upvote count. Shows a message if the user has already voted.

### `form_show(...)`

| Parameter   | Type   | Description                          |
|-------------|--------|--------------------------------------|
| `$captchaurl`| string | URL to the captcha image.            |

**Description**: Displays the comment form including fields for name, comment, and captcha.

### `comment_show(...)`

| Parameter          | Type    | Description                                         |
|--------------------|---------|-----------------------------------------------------|
| `$hide_system_msg` | boolean | Whether to hide system messages (status = 3).      |
| `$hide_internal_msg`| boolean | Whether to hide internal messages (status = 2).    |
| `$hide_confirmed`  | boolean | Whether to hide confirmed comments (status = 1).   |
| `$hide_unconfirmed`| boolean | Whether to hide unconfirmed comments (status = 0). |
| `$sorting`         | string  | SQL sorting clause (default: " ORDER BY id DESC"). |

**Description**: Displays comments based on the provided filter options. Returns an array of comments.

### `comment_get(...)`

| Parameter          | Type    | Description                                         |
|--------------------|---------|-----------------------------------------------------|
| `$hide_system_msg` | boolean | Whether to hide system messages (status = 3).      |
| `$hide_internal_msg`| boolean | Whether to hide internal messages (status = 2).    |
| `$hide_confirmed`  | boolean | Whether to hide confirmed comments (status = 1).   |
| `$hide_unconfirmed`| boolean | Whether to hide unconfirmed comments (status = 0). |
| `$sorting`         | string  | SQL sorting clause (default: " ORDER BY id DESC"). |

**Description**: Retrieves comments based on the filter options. Returns an array of comments.

### `init(...)`

| Parameter               | Type   | Description                            |
|-------------------------|--------|----------------------------------------|
| `$captcha_code_if_delivered` | string | The expected captcha code for validation. |

**Description**: Initializes the commenting system by checking for system entries, handling votes, and processing new comments. Returns different status codes based on the outcome:  
- `1`: System message inserted.  
- `2`: Vote registered successfully.  
- `3`: Missing fields in the comment form.   
- `4`: Captcha validation error.  
- `5`: Comment added successfully.  
