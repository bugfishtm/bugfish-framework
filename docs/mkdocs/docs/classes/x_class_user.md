# Class Documentation: `x_class_user`

## Documentation

The `x_class_user` PHP class is a versatile and robust solution designed for seamless integration of user management into web projects. As a core component of the Bugfish Framework, it offers essential features for managing user sessions, authentication, and profile customization.

## Key Features

### User Registration and Authentication
- **Secure Password Handling**: Implements secure password hashing and supports persistent authentication using cookies.
- **User Sessions**: Efficiently manages user sessions for a consistent user experience.

### Profile Customization
- **User Groups and Settings**: Supports the creation and management of user groups, additional profile fields, and user settings.

### Session Management
- **PHP Sessions and MySQL Integration**: Combines PHP sessions with MySQL for reliable session handling.

### Security Measures
- **SQL Injection Protection**: Includes mechanisms to protect against MySQL injection, though it does not guarantee complete security.

### User Activity Management
- **Account Activation and Recovery**: Manages email-based activation codes, password recovery, and secure login procedures.

### Multi-Login Control and Login Flexibility
- **Control Over Multi-Login**: Allows enabling or disabling multi-login for users.
- **Customizable Login Credentials**: Configures the login field to be either the username or email address.

### Reference Management
- **Internal Reference Handling**: Manages and resets internal references to ensure clean user management operations.

## Requirements

### PHP Modules
- `mysqli`: Required for data storage, using the `x_class_mysql` object.  
- `openssl`: Used for cryptographic functions, such as token generation.  
- `mbstring`: Required for handling multibyte character encodings.  

### External Classes
- `x_class_mysql`: Required for Database Operations.


## Table Structures
Tables will be installed automatically upon initialization.

### Users Table

| Column Name      | Data Type    | Nullable | Default Value                            | Comment                                   |
|------------------|--------------|----------|------------------------------------------|-------------------------------------------|
| id               | int          | No       | AUTO_INCREMENT                           | Unique ID                                 |
| user_name        | varchar(512) | Yes      | 'undefined'                              | User login name                           |
| user_initial     | int(1)       | Yes      | 0                                        | 1 if this user is the initial created user |
| user_pass        | varchar(512) | Yes      | NULL                                     | User password                             |
| user_mail        | varchar(512) | Yes      | NULL                                     | User email                                |
| user_2fa         | text         | Yes      | NULL                                     | User 2FA secret key                       |
| user_shadow      | varchar(512) | Yes      | NULL                                     | Store for email renewals                  |
| user_rank        | int(9)       | Yes      | NULL                                     | User rank                                 |
| user_confirmed   | tinyint(1)   | Yes      | 0                                        | User activation status                    |
| req_activation   | datetime     | Yes      | NULL                                     | Date of activation request                |
| last_activation  | datetime     | Yes      | NULL                                     | Date of last activation                   |
| user_disabled    | int(1)       | Yes      | 0                                        | 1 if user is disabled                     |
| last_login       | datetime     | Yes      | NULL                                     | Date of last login                        |
| user_blocked     | tinyint(1)   | Yes      | 0                                        | User blocked status                       |
| block_reset      | int(1)       | Yes      | NULL                                     | Number of block resets                    |
| block_auto       | int(1)       | Yes      | 0                                        | Automatic block status                    |
| block_activation | int(1)       | Yes      | NULL                                     | Block activation status                   |
| block_mail_edit  | datetime     | Yes      | NULL                                     | Date of last mail edit block              |
| fails_in_a_row   | int(10)      | Yes      | 1                                        | Failed login attempts                     |
| last_block       | datetime     | Yes      | NULL                                     | Date of last block                        |
| user_lang        | varchar(24)  | Yes      | NULL                                     | User default language                     |
| user_color       | varchar(24)  | Yes      | NULL                                     | User default color                        |
| user_theme       | varchar(24)  | Yes      | NULL                                     | User default theme                        |
| user_theme_sub   | varchar(24)  | Yes      | NULL                                     | User default sub-theme                    |
| extradata        | TEXT         | Yes      | NULL                                     | Additional data                           |
| hive_extradata   | TEXT         | Yes      | NULL                                     | Additional data for HIVE system           |
| req_reset        | datetime     | Yes      | NULL                                     | Date of reset request                     |
| last_reset       | datetime     | Yes      | NULL                                     | Date of last reset                        |
| req_mail_edit    | datetime     | Yes      | NULL                                     | Date of last mail edit request            |
| last_mail_edit   | datetime     | Yes      | NULL                                     | Date of last mail edit                    |
| last_activity    | datetime     | Yes      | NULL                                     | Last site activity                        |
| created_date     | datetime     | Yes      | CURRENT_TIMESTAMP                        | Creation date                             |
| modify_date      | datetime     | Yes      | CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP | Modification date                     |
| Primary Key      |              |          | (id)                                     |                                           |

### Users Session Table

| Column Name    | Data Type    | Nullable | Default Value                            | Comment                                |
|----------------|--------------|----------|------------------------------------------|----------------------------------------|
| id             | int(10)      | No       | AUTO_INCREMENT                           | Unique Session ID                      |
| fk_user        | int(10)      | No       |                                          | Related User ID                        |
| key_type       | tinyint(1)   | Yes      | 0                                        | Session type (1 - activate, 2 - session, etc.) |
| creation       | datetime     | Yes      | CURRENT_TIMESTAMP                        | Session creation date                  |
| modification   | datetime     | Yes      | CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP | Session modification date        |
| refresh_date   | datetime     | Yes      | NULL                                     | Last session use date                  |
| session_key    | varchar(128) | Yes      |                                          | Session authentication token           |
| is_active      | tinyint(1)   | Yes      | 0                                        | 1 - Active, 0 - Expired                |
| request_ip     | varchar(128) | Yes      | NULL                                     | IP at session creation (if enabled)    |
| execute_ip     | varchar(128) | Yes      | NULL                                     | IP at session invalidation (if enabled) |
| Primary Key    |              |          | (id)                                     |                                        |

### Group Table

| Column Name        | Data Type    | Nullable | Default Value                            | Comment             |
|--------------------|--------------|----------|------------------------------------------|---------------------|
| id                 | int(10)      | No       | AUTO_INCREMENT                           | Unique Group ID     |
| group_name         | varchar(255) | No       |                                          | Group name          |
| group_description  | TEXT         | Yes      | NULL                                     | Group description   |
| creation           | datetime     | Yes      | CURRENT_TIMESTAMP                        | Creation date       |
| modification       | datetime     | Yes      | CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP | Modification date |
| Primary Key        |              |          | (id)                                     |                     |

### Group Link Table


| Column Name  | Data Type    | Nullable | Default Value | Comment           |
|--------------|--------------|----------|---------------|-------------------|
| id           | int(10)      | No       | AUTO_INCREMENT| Unique Link ID    |
| fk_user      | int(10)      | No       |               | Related User ID   |
| fk_group     | int(10)      | No       |               | Related Group ID  |
| creation     | datetime     | Yes      | CURRENT_TIMESTAMP | Creation date |
| Primary Key  |              |          | (id)          |                   |
| Unique Constraint |          |          | UNIQUE (fk_user, fk_group) | Unique combination of user and group |

### Extrafield Table


| Column Name    | Data Type    | Nullable | Default Value | Comment             |
|----------------|--------------|----------|---------------|---------------------|
| id             | int(10)      | No       | AUTO_INCREMENT| Unique Extrafield ID |
| fk_user        | int(10)      | No       |               | Related User ID     |
| ...            | ...          | ...      | ...           | User-defined fields |
| creation       | datetime     | Yes      | CURRENT_TIMESTAMP | Creation date     |
| modification   | datetime     | Yes      | CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP | Modification date |
| Primary Key    |              |          | (id)          |                     |


## Class Parameters


### User Related

These parameters are only set if a user is logged in:

| Parameter Name         | Description                                                                                  |
|------------------------|----------------------------------------------------------------------------------------------|
| `user_name`, `name`    | Contains the user name as set in the database.                                               |
| `user_mail`, `mail`    | Contains the user email as set in the database.                                               |
| `theme`, `user_theme`  | Contains the user theme as set in the database.                                                |
| `lang`, `user_lang`    | Contains the user language as set in the database.                                             |
| `loggedIn`, `loggedin`, `user_loggedin`, `user_loggedIn` | Indicates if the user is logged in (true) or not (false). |
| `user()`               | Array with all fields from the database related to the user (excluding extra fields or group tables). |
| `user_id`, `id`        | Contains the user ID as set in the database.                                                   |
| `user_rank`, `rank`    | Contains the user rank as set in the database.                                                |

### Reference Returns

These variables are set if main operation functions (e.g., login, recover) are triggered, providing quick access to relevant data:

| Reference Return Variables | Description                                                              |
|-----------------------------|--------------------------------------------------------------------------|
| `$mail_ref_user`            | References the involved user ID after a major operation.                  |
| `$mail_ref_token`           | References the user token for activation after a major operation.         |
| `$mail_ref_receiver`        | References the involved user email after a major operation.               |
| `$ref`                      | References the involved user after a major operation.                      |

### Operation Returns

These variables are set after major functions (e.g., mail change, recovery) are triggered and reflect the result of these operations:

| Operation Functions Return Vars | Description                                      |
|--------------------------------|--------------------------------------------------|
| `$login_request_code`          | Return code from login functions.               |
| `$rec_request_code`            | Return code from recover functions.             |
| `$act_request_code`            | Return code from activation functions.          |
| `$mc_request_code`             | Return code from mail change functions.         |


## Class Constructor

| Constructor Function                                                                                                           | Description                                                                                                                                                                                                                                                                                                    |
|-------------------------------------------------------------------------------------------------------------------------------|----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `__construct($x_class_mysql, $table_users, $table_sessions, $preecokie = "xusers", $initial_ref = false, $initial_pass = false, $initial_rank = false)` | Initializes with `x_class_mysql` object and table names (auto-generated). Optional initial username, password, and rank can be set. Used for creating tables and initial user setup if required. <br />$mysqlcon -> `x_class_mysql` object<br />$table_users -> Table name for users<br />$table_sessions -> Table name for sessions<br />$preecokie -> Precookie for multi-login<br />$initial_ref -> Initial admin username/user email<br />$initial_pass -> Initial password<br />$initial_rank -> Initial user rank |


## Configuration Methods
Run these functions before `init()` to adjust login class settings for your site:

### Initial Configuration


| General Login Class Config Function | Description                                                                                           |
|-------------------------------------|-------------------------------------------------------------------------------------------------------|
| `multi_login($bool = false)`        | Allows multi-login. If `false`, users will be logged out in the first session if they log in elsewhere. If `true`, users can log in multiple times in different browsers. |
| `login_recover_drop($bool = false)` | Deactivates password reset tokens on successful login. If `true`, reset tokens will be disabled if the user logs in successfully. |
| `login_field_manual($string)`       | Specifies a custom login field that should be unique (e.g., "user_name", "user_mail").               |
| `login_field_user()`                | Sets the primary login field to `user_name` if `true`.                                               |
| `login_field_mail()`                | Sets the primary login field to `user_mail` if `true`.                                               |
| `mail_unique($bool = false)`        | Ensures emails are unique if `true`. If `false`, emails are not unique but may be overwritten if `user_mail` is the default login option. |
| `user_unique($bool = false)`        | Ensures usernames are unique if `true`. If `false`, usernames are not unique but may be overwritten if `user_name` is the default login option. |
| `ip_spoof_check(bool = true)` | Enables or disables IP spoofing checks during login. **Parameters**: `bool` - If true, IP spoofing checks are performed during login. |

### Logging Configuration

| Config: Log Functions | Description                                                               |
|-----------------------|---------------------------------------------------------------------------|
| `log_ip($bool = false)` | Logs IP addresses in the database for sessions. `true` to enable, `false` to disable. |
| `log_activation($bool = false)` | Logs activation sessions. If `false`, used keys will be deleted. If `true`, they will be preserved. |
| `log_session($bool = false)` | Logs session data. If `false`, used keys will be deleted. If `true`, they will be preserved. |
| `log_recover($bool = false)` | Logs recovery actions. If `false`, used keys will be deleted. If `true`, they will be preserved. |
| `log_mail_edit($bool = false)` | Logs email edits. If `false`, used keys will be deleted. If `true`, they will be preserved. |

### Interval Configuration

| Config: Operation Delay Interval Functions | Description                                                                                              |
|--------------------------------------------|----------------------------------------------------------------------------------------------------------|
| `wait_activation_min($int = 6)`            | Time in minutes that users need to wait between activation operations to prevent flooding.              |
| `wait_recover_min($int = 6)`                | Time in minutes that users need to wait between recovery operations to prevent flooding.                |
| `wait_mail_edit_min($int = 6)`             | Time in minutes that users need to wait between mail changes with activation operations to prevent flooding. |

### Expiry Configuration

| Config: Token Expire Functions | Description                                                        |
|--------------------------------|--------------------------------------------------------------------|
| `min_activation($int = 6)`      | Activation token expiry time in minutes.                          |
| `min_recover($int = 6)`         | Recovery token expiry time in minutes.                            |
| `min_mail_edit($int = 6)`       | Mail edit token expiry time in minutes.                           |

### Autoblock Configuration

| Config: Autoblock Functions | Description                                                   |
|-----------------------------|---------------------------------------------------------------|
| `autoblock($int = false)`   | Activates auto-blocking of users after X failed logins. `false` to deactivate. |

### Session Configuration

| Config: Session Functions | Description                                          |
|---------------------------|------------------------------------------------------|
| `sessions_days($int = 7)` | Defines the maximum number of days a session is valid. |

### Cookie Configuration

| Config: Cookie Functions | Description                                           |
|--------------------------|-------------------------------------------------------|
| `cookies_use($bool = true)` | Allows the use of cookies for "remember me" functionality. `false` to disable. |
| `cookies_days($int = 7)` | Defines the number of days cookies are valid if not refreshed. |

### Token Configuration

| Token Config Functions    | Description                          |
|---------------------------|--------------------------------------|
| `token_charset($charset = "0123456789")` | Sets the character set for generated tokens. |
| `token_length($length = 24)` | Sets the length of generated tokens. |
| `session_length($length = 24)` | Sets the length of generated session tokens. |
| `session_charset($charset = "0123456789")` | Sets the character set for session tokens. |


## Operation Methods
Internal used Methods for this class or additional categories of function which does not fit in any other category.

### User Table Functions

| User Extrafield Functions | Description                                                         |
|---------------------------|---------------------------------------------------------------------|
| `user_add_field($addstring)` | Adds a field to the users table. The field is added with the provided column string. |
| `user_del_field($fieldname)` | Deletes a field from the users table. **Note**: This action deletes data. |

### Usergroup Functions

| Group Functions          | Description                                                                      |
|--------------------------|----------------------------------------------------------------------------------|
| `groups($table_group, $table_group_link)` | Enables user groups functionality and sets the table names for groups and relations. |
| `group_add($name, $description = "")` | Creates a group with the specified name and optional description.                  |
| `group_del($id)`        | Deletes a group with the specified ID.                                           |
| `group_users($groupid)` | Retrieves all users in a group as an array representing the relations table fields. |
| `user_groups($userid)`  | Retrieves all groups for a user as an array representing the user group fields.    |
| `group_adduser($groupid, $userid)` | Adds a user to a group with the specified group and user IDs.                   |
| `group_deluser($groupid, $userid)` | Removes a user from a group with the specified group and user IDs.             |
| `groups_del_field($fieldname)` | Deletes a field from the group table by specifying the column name.             |
| `groups_add_field($fieldstring)` | Adds a field to the group table with the provided column string.                |

### Password Filtering Functions

| Password Filter Function          | Description                                                                                         |
|----------------------------------|-----------------------------------------------------------------------------------------------------|
| `passfilter($signs = 6, $capitals = 0, $small = 0, $special = 0, $number = 0)` | Setup Password Filter Check Variable; the parameters represent the required minimum of needed characters, such as numbers, special characters, and capital letters. |
| `passfilter_check($passclear)`    | Check if the string conforms to the password filters set by `passfilter()`.                        |

### Password Functions

| Password Functions                | Description                                                                                         |
|----------------------------------|-----------------------------------------------------------------------------------------------------|
| `password_gen($len = 12, $comb = "abcde12345")` | Generate a key with charset (combination string) and length. Useful for generating passwords or random strings. |
| `password_crypt($var, $hash = PASSWORD_BCRYPT)` | Encrypt a cleartext password into a hashed password. By default, all passwords are hashed using Bcrypt. |
| `password_check($cleartext, $crypted)` | Check the validity of a crypted password by comparing it with a cleartext password using Bcrypt. |

### Extrafield Functions

| Extrafield Functions             | Description                                                                                         |
|----------------------------------|-----------------------------------------------------------------------------------------------------|
| `extrafields($table_ext)`         | Activate extrafield functionality by providing a table name, which will be generated and installed automatically. |
| `extrafield_del_field($fieldname)`| Delete an extrafield table column by providing the column name.                                      |
| `extrafield_add_field($fieldstring)` | Add a column to the extrafield table with the specified column string.                              |
| `extrafield_get($id)`             | Get the extrafield array for a user.                                                                 |

### Token Validation Time Functions

| Get Expire Time for Request Functions in Seconds (Interval) | Description                                                         |
|-------------------------------------------------------------|---------------------------------------------------------------------|
| `activation_request_time($user)`                           | Get the time until the next activation request is possible with user ID. |
| `recover_request_time($user)`                              | Get the time until the next recovery request is possible with user ID.  |
| `mail_edit_request_time($user)`                            | Get the time until the next mail edit request is possible with user ID. |

### Token Validation Functions

| Check Token Validation Functions          | Description                                                                    |
|-------------------------------------------|--------------------------------------------------------------------------------|
| `activation_token_valid($user, $token)`   | Check if the activation token is valid by providing the user ID and the token. |
| `recover_token_valid($user, $token)`      | Check if the recovery token is valid by providing the user ID and the token.   |
| `mail_edit_token_valid($user, $token)`    | Check if the mail edit token is valid by providing the user ID and the token.  |
| `session_token_valid($user, $token)`      | Check if the session token is valid by providing the user ID and the token.    |


## User Operations

If you do not provide an ID here, the actual logged-in executing user will be handled as the ID. In cases where the ID is optional, this will be the handling for that kind of execution or trigger of the functions listed below.

### General Operations

| User Operation Functions               | Description                                                                                      |
|---------------------------------------|--------------------------------------------------------------------------------------------------|
| `get($id = false)`                    | Get user information from the table as an array.                                                 |
| `exists($id = false)`                 | Check if a user with the specified ID exists.                                                    |
| `delete($id = false)`                 | Delete a user.                                                                                  |
| `disable_user_session($id = false)`   | Disable a user's session.                                                                       |
| `delete_user_session($id = false)`    | Delete a user's session.                                                                        |
| `logout_all()`                        | Logout all users.                                                                             |

### Confirmation Functions

| User Operation Functions               | Description                                                                                      |
|---------------------------------------|--------------------------------------------------------------------------------------------------|
| `confirmed_user($id = false)`         | Check if the user account is confirmed; returns "true" if confirmed.                            |
| `confirm_user($id = false)`         | Confirm the User if not confirmed, this will prevent auto-delete as the user is non-provisioned for primary functions till confirmation!      |

### Registration Functions

| User Operation Functions               | Description                                                                                      |
|---------------------------------------|--------------------------------------------------------------------------------------------------|
| `addUser($nameref, $mail, $password = false, $rank = false, $activated = false)` | Add a new user to the database. If `$activated` is true, the user will not need additional activation. You can define the user's rank, password, mail, and user reference. |
| add_user(`nameref`, `mail`, `password = false`, `rank = false`, `activated = false`) | Adds a new user to the system. **Parameters**: `nameref` - The username reference. `mail` - The user's email. `password` - The user's password (optional). `rank` - The user's rank (optional). `activated` - Whether the user is activated (optional). |


#### Function Purpose
The `addUser` function in the `x_class_user` class is designed to add a new user to the database while performing necessary checks, handling unconfirmed email changes, and preparing data. The function prevents duplicate accounts, manages email verification, and ensures proper user data is stored.

#### Function Parameters
1. **$nameref:** The username or another reference field, depending on the configuration.
2. **$mail:** The user's email address.
3. **$password:** The user's password (optional, defaults to `false`).
4. **$rank:** The user's rank or role (optional, defaults to `false`).
5. **$activated:** Whether the user is activated or not (optional, defaults to `false`).

#### Function Workflow

**Determine Reference Field:** The function decides whether to use the email (`$mail`) or the `nameref` (username) as the reference, based on the configuration (`$this->login_field`).

**Check for Existing Confirmed User:** The function checks if there is an existing confirmed user (`user_confirmed = 1`) in the database with the same reference (email or username). If a confirmed user is found, the function returns `false` to prevent duplicate confirmed accounts.

**Set Activation Status:** The `$activated` parameter is converted to either `1` (activated) or `0` (not activated).

**Set User Rank:** If a `$rank` is not provided, it defaults to `0`.

**Prepare Password:** If a password is not provided or is empty, the function sets the password to `"NULL"`. Otherwise, the password is encrypted using the `password_crypt` method.

**Insert the New User:** The function inserts the new user into the database with the provided `nameref`, `mail`, encrypted `password`, rank, and activation status.

**Return Success:**  
If the user is successfully added, the function returns `true`.


### Block Functions

| User Block Functions                  | Description                                                             |
|---------------------------------------|-------------------------------------------------------------------------|
| `blocked_user($id = false)`           | Check if the user is blocked; returns `true` if blocked, `false` otherwise. |
| `block_user($id = false)`             | Block a user.                                                             |
| `unblock_user($id = false)`           | Unblock a user.                                                           |

### Enable/Disable Functions

| User Disable Functions                | Description                                                                 |
|---------------------------------------|-----------------------------------------------------------------------------|
| `disabled_user($id = false)`          | Check if the user is disabled; returns `true` if disabled, `false` otherwise. |
| `disable_user($id = false)`           | Disable a user.                                                               |
| `enable_user($id = false)`            | Enable a user.                                                                |

### Change User Functions

| User Change Functions                | Description                                                                                   |
|--------------------------------------|-----------------------------------------------------------------------------------------------|
| `change_pass($id = false, $new = false)` | Change the user password.                                                                    |
| `change_password($id = false, $new = false)` | Change the user password.                                                                    |
| `changeUserPass($id = false, $new = false)` | Change the user password.                                                                    |
| `change_rank($id = false, $new = false)` | Change the user rank.                                                                       |
| `changeUserShadowMail($id = false, $new)` | Change a user's shadow mail (mail not activated yet but user registered and awaits activation). |
| change_shadow(`id`, `new = false`) |  Changes the shadow email of a specific user. **Parameters**: `id` - The user's ID. `new` - The new shadow email (optional). |
| changeUserShadowMail(id`, `new = false) | Alias for `change_shadow`. **Parameters**: Same as `change_shadow`. |

### Change User Mail Functions

| User Change Functions                | Description                                                                                   |
|--------------------------------------|-----------------------------------------------------------------------------------------------|
| `changeUserMail($id = false, $new)`   | Change a user's mail. If the mail is unique, this deletes never-used, registered accounts with that mail. |
| `change_mail($id = false, $new)`   | Change a user's mail. If the mail is unique, this deletes never-used, registered accounts with that mail. |

#### Function Purpose
The `changeUserMail` function in the `x_class_user` class is designed to update a user's email address in the database, handling both cases where email uniqueness must be enforced and where it does not. Here is a detailed explanation of its functionality:

#### Function Parameters
1. **$id:** The ID of the user whose email address is to be changed. Defaults to `"undefined_framework_var"`.
2. **$new:** The new email address to be set. Defaults to `false`.

#### Function Workflow

**Check for Valid New Email:** The function first checks if a new email address (`$new`) is provided. If not, it returns `false`, indicating that no change will occur.

**Prepare New Email for Database:** The new email address is trimmed of extra spaces and converted to lowercase. It is then prepared for binding in the SQL query.

**Validate User ID:** The function checks if the provided `$id` is valid using the `int_opid` method. If `int_opid` returns a false value, the function returns `false`, indicating an invalid ID. The `$id` is then processed by `int_opid` to ensure it is an integer.

**Check New Email Validity:** The function verifies that the new email address is not an empty string. If it is empty, the function returns `false`.

**Update Non-Unique Mail:** If `$this->mail_unique` is `false`, the function directly updates the email address in the database for the user with the specified ID. It uses a prepared statement to prevent SQL injection.

**Update Unique Mail:** If `$this->mail_unique` is `true`, the function performs additional checks:  

1. It queries the database to fetch the current email address of the user with the given ID.  
2. If the current email address is the same as the new email address (ignoring case), the function returns `true`, indicating no update is necessary.  
3. If the current email address is different, the function checks if the new email address already exists and is confirmed using the `mailExistsActive` method. If it does exist, the function returns `false` to avoid duplication.  
4. If the new email address does not already exist, the function:  
	- Deletes any unconfirmed user accounts (`user_confirmed = 0`) with the same email address from the database.  
	- Updates any accounts with `user_shadow` (representing unconfirmed email changes) to clear the shadow status.  
	- Updates the email address for the user with the specified ID.  
	- Returns `true` upon successful update.  

**Return Failure:**  
If none of the above conditions are met or if any checks fail, the function returns `false`.  


### Change User Name Functions

| User Change Functions                | Description                                                                                   |
|--------------------------------------|-----------------------------------------------------------------------------------------------|
| `change_name($id = false, $new)`   | Change the user name.                                                                       |
| `changeUserName($id = false, $new)`   | Change the user name.                                                                       |

#### Function Purpose
The `changeUserName` function in the `x_class_user` class is designed to update a user's username in the database. Here’s a detailed explanation of its workings:

#### Function Parameters
1. **$id:** The ID of the user whose username is to be changed. Defaults to `"undefined_framework_var"`.
2. **$new:** The new username to be set. Defaults to `false`.

#### Function Workflow

**Check for Valid New Username:** The function first checks if a new username is provided (`$new`). If not, it returns `false` immediately, indicating that no change will occur.  

**Prepare New Username for Database:** The new username is trimmed of extra spaces and prepared for binding in the SQL query.  

**Validate User ID:** The function checks if the provided `$id` is valid using the `int_opid` method. If `int_opid` returns a false value, the function returns `false`, indicating an invalid ID. The `$id` is then processed by `int_opid` to ensure it is an integer.  

**Check New Username Validity:** The function verifies that the new username is not an empty string. If it is empty, the function returns `false`.  


**Update Non-Unique Username**: If `$this->user_unique` is `false`, the function directly updates the username in the database for the user with the specified ID. It uses a prepared statement to prevent SQL injection.  

**Update Unique Username**: If `$this->user_unique` is `true`, the function performs the following additional steps:  

1. It queries the database to fetch the current username of the user with the given ID.  
2. If the current username is the same as the new username (ignoring case), the function returns `true` because no update is necessary.  
3. If the current username is different, the function checks if the new username already exists and is confirmed using the `usernameExistsActive` method. If it does exist, the function returns `false` to avoid duplication.  
4. If the new username does not already exist, the function proceeds to update the username in the database and returns `true` upon successful update.  

**Return Failure:**  
If none of the above conditions are met or if any checks fail, the function returns `false`.  


### Duplicate Check Functions

| Reference Existence Checks           | Description                                                                  |
|--------------------------------------|------------------------------------------------------------------------------|
| `refExists($ref)`                    | Check if the reference exists.                                                |
| `refExistsActive($ref)`              | Check if the reference exists for a confirmed user.                          |
| `usernameExists($ref)`               | Check if the username exists.                                                 |
| `usernameExistsActive($ref)`         | Check if the username exists for a confirmed user.                           |
| `mailExists($ref)`                   | Check if the mail exists.                                                      |
| `mailExistsActive($ref)`             | Check if the mail exists for a confirmed user.                                |

### Extra Data Functions

| Extra Data Functions                | Description                                                                                   |
|-------------------------------------|-----------------------------------------------------------------------------------------------|
| `get_extra($id= false)`             | Get extra data as an array from the user. (You can store your own data in an array if needed.) |
| `set_extra($id= false, $array)`     | Set extra data from an array for the user. (You can store your own data in an array if needed.) |

### Login As Functions

| Login As Functions                  | Description                                                                                                 |
|-------------------------------------|-------------------------------------------------------------------------------------------------------------|
| `login_as($id)`                     | Login as a user with the specified ID. Multi-login with the user logged in at the same time is normally possible. |
| `login_as_return()`                | Return to normal state after `login_as()` has been successfully executed.                                 |
| `login_as_is()`                    | Returns `true` if the current user is logged in as another user with `login_as()`; otherwise, returns `false`. |


## Primary Functions

### Init Functions

| Primary Functions                    | Description                                                                                          |
|--------------------------------------|------------------------------------------------------------------------------------------------------|
| `logout()`                          | Logout the current logged-in user.                                                                   |
| `init()`                            | Initialize the login with all configurations. Have to run once after configuration changes. Creates all needed sessions and restores login if already logged in. |


### Login Functions

| Primary Functions                    | Description                                                                                          |
|--------------------------------------|------------------------------------------------------------------------------------------------------|
| `login_request($ref, $pass, $cookies = false)` | Request login with reference, password, and an option to stay online with cookies. Returns codes for login success or failure. |

#### Function Purpose
The `login_request` function in the `x_class_user` class handles the user login process, including authentication, session management, and handling various login errors. Here’s a detailed breakdown of its functionality and the return codes it uses:

#### Function Parameters
1. **$ref:** The username or email address of the user attempting to log in.
2. **$password:** The password provided by the user.
3. **$stayLoggedIn:** A boolean indicating whether the user wants to stay logged in across sessions (optional, defaults to `false`).

#### Return Codes
- **1:** Successful login.
- **2:** User not found (invalid reference).
- **3:** Incorrect password.
- **4:** User is blocked.
- **5:** User is not confirmed.
- **6:** User is auto-blocked due to multiple failed login attempts.
- **7:** User is disabled.

### Activation Functions

| Activation Functions                 | Description                                                                                     |
|--------------------------------------|-------------------------------------------------------------------------------------------------|
| `activation_request_id($id)`         | Request activation for a user by ID without interval limits. Returns success or error codes.     |
| `activation_request($ref)`           | Request activation for an account with a reference. Returns success or error codes based on various conditions. |
| `activation_confirm($userid, $token, $newpass = false)` | Confirm activation with user ID and a valid token. Returns success or error codes based on various conditions. |

#### Activation Request ID 
Here you can see return values of the function: `activation_request_id`
Requests an activation token for a user by their user ID if the user is not already confirmed.


| **Return Code** | **Meaning**                                           |
|-----------------|-------------------------------------------------------|
| 1               | Activation request successful.                       |
| 2               | User ID is not numeric or user not found.            |
| 3               | User is already confirmed.                           |

#### Activation Request
Here you can see return values of the function: `activation_request`
Requests a new activation token for a user by their username or email, checking various conditions such as user status and request timing.


| **Return Code** | **Meaning**                                               |
|-----------------|-----------------------------------------------------------|
| 1               | Activation request successful.                           |
| 2               | User not found.                                          |
| 3               | Activation request too soon (interval not reached).      |
| 4               | User is already confirmed.                               |
| 5               | Activation is blocked for this user.                     |
| 6               | User is disabled.                                        |

#### Activation Confirm
Here you can see return values of the function: `activation_confirm`
Confirms the activation for a user using a provided token and optionally updates the user’s password.

| **Return Code** | **Meaning**                                               |
|-----------------|-----------------------------------------------------------|
| 1               | Activation confirmed successfully.                       |
| 2               | User ID is not numeric or token not found.               |
| 3               | Activation token is invalid or expired.                  |
| 4               | Activation is blocked for this user.                     |


### Recover Functions

| Reset Functions                      | Description                                                                                      |
|--------------------------------------|--------------------------------------------------------------------------------------------------|
| `recover_request_id($id)`            | Request account recovery by ID. Returns success or error codes.                                  |
| `recover_request($ref)`              | Request account recovery by reference. Returns success or error codes based on various conditions. |
| `recover_confirm($userid, $token, $newpass)` | Confirm account recovery with user ID, token, and new password. Returns success or error codes.  |


#### Recover Request ID
Here you can see return values of the function: `recover_request_id`
Requests a password recovery token for a user identified by their user ID.

| Return Code | Description                           |
|-------------|---------------------------------------|
| **1**       | Token creation successful.            |
| **2**       | Invalid user ID or user not found.    |


#### Recover Request
Here you can see return values of the function: `recover_request`
Requests a password recovery token for a user identified by their username or email.


| Return Code | Description                                       |
|-------------|---------------------------------------------------|
| **1**       | Token creation successful.                      |
| **2**       | User not found.                                 |
| **3**       | Recovery request made too soon (interval not reached). |
| **4**       | Recovery is blocked for this user.              |
| **5**       | User is disabled.                               |

#### Recover Confirm
Here you can see return values of the function: `recover_confirm`
Confirms a password recovery request using a token and updates the user’s password.

| Return Code | Description                                       |
|-------------|---------------------------------------------------|
| **1**       | Recovery confirmed and password updated.        |
| **2**       | Invalid user ID or token not found.              |
| **3**       | Recovery token is invalid or expired.            |
| **4**       | Password recovery is blocked for this user.     |



### Mail Change Functions

| Mail Edit Functions                  | Description                                                                                      |
|--------------------------------------|--------------------------------------------------------------------------------------------------|
| `mail_edit($id, $newmail, $nointervall = false)` | Create a new shadow mail. Returns success or error codes.                                         |
| `mail_edit_confirm($userid, $token, $run = true)` | Confirm mail edit with user ID, token, and an optional flag to run the mail edit process. Returns success or error codes. |


#### Mail Edit Returns
Here you can see return values of the function: `mail_edit`
Initiates a request to change a user's email address. The function first validates the user ID and new email address, checks whether the user is disabled or if email changes are blocked. If an interval is specified, it ensures the required wait time has passed. It then generates a token for confirming the email change and stores the new email in a "shadow" state until confirmed. The function also handles logging and cleanup tasks related to the email change process.

| Return Code | Description                                                    |
|-------------|----------------------------------------------------------------|
| **1**       | Email change request processed successfully.                  |
| **2**       | User ID is invalid or user not found.                         |
| **3**       | Email change request made too soon (interval not reached).    |
| **4**       | New email already exists for another active user.             |
| **5**       | Email change blocked for this user.                           |
| **6**       | User is disabled.                                             |


#### Mail Edit Confirm
Here you can see return values of the function: `mail_edit_confirm`
Confirms the email change request by verifying the provided token. It checks whether the token is valid and whether the user is allowed to make the change. If valid, it updates the user's email address, handles any conflicts with existing emails (e.g., if the new email is already in use by another account), and logs the changes. If the email address was previously set as a shadow (temporary), it ensures proper cleanup or handling based on the email uniqueness settings.

| Return Code | Description                                                     |
|-------------|-----------------------------------------------------------------|
| **1**       | Email change confirmed successfully.                           |
| **2**       | User ID is invalid or token not found.                         |
| **3**       | Email change token is invalid or expired.                      |
| **4**       | New email address is already in use.                           |
| **5**       | Email change blocked for this user.                           |
| **6**       | Failure to change the user’s email.                            |



### Display Login Function

| **Function** | **Description** |
|--------------|-----------------|
| `display_login` | This function displays a login form with various customizable options such as registration and password reset buttons, captcha validation, and CSRF protection. It processes the login request and handles errors related to captcha and CSRF tokens. |

#### Parameters

| **Parameter** | **Type** | **Description** | **Default Value** |
|---------------|----------|-----------------|-------------------|
| `spawn_register_button` | `array` | Configures the "Register Now" button with `url` and `label` options. | `array("url" => "", "label" => "Register Now")` |
| `spawn_cookie_checkbox` | `string` | Label for the "Stay Logged In?" checkbox. | `"Stay Logged In?"` |
| `spawn_reset_button` | `array` | Configures the "Reset Account" button with `url` and `label` options. | `array("url" => "", "label" => "Reset Account")` |
| `login_button_label` | `string` | Label for the login button. | `"Login"` |
| `label` | `array` | Labels and placeholders for email and password fields. Options: `ref_placeholder`, `ref_label`, `pass_label`, `pass_placeholder`. | `array("ref_placeholder" => "Please enter your E-Mail", "ref_label" => "E-Mail", "pass_label" => "Password", "pass_placeholder" => "Please enter your password!")` |
| `captcha` | `array` | Configures captcha image and expected code for validation. | `array("url" => "captcha.jpg", "code" => "243fsdfsfds")` |

#### Functionality

| **Step** | **Description** |
|----------|-----------------|
| 1. **CSRF Token Generation** | Generates a CSRF token and stores it in the session for validation. |
| 2. **Form Submission Check** | Checks if the login form has been submitted. |
| 3. **CSRF Validation** | Validates the submitted CSRF token against the one stored in the session. |
| 4. **Captcha Validation** | Validates the captcha code if captcha is enabled. |
| 5. **Login Request** | Processes the login request by calling the `login_request` method with the submitted credentials. |
| 6. **Error Handling** | Sets `display_return_code` based on the result of the login request or encountered errors (captcha or CSRF error). |
| 7. **HTML Output** | Outputs the login form with all configured options, including the captcha image, labels, and buttons. |

#### Return Values

| **Value** | **Description** |
|-----------|-----------------|
| `display_return_code` | Stores the result of the login process or error codes (`captcha_error`, `csrf_error`). |

The function sets the display_return_code property based on the outcome of the login process. This property can hold various values, including the result of a successful login or specific error codes such as captcha_error or csrf_error. These return codes are used to inform the user or the system about the status of the login attempt, enabling appropriate responses or error handling










