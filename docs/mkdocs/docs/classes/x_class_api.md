# Class Documentation: `x_class_api`

## Documentation

The `x_class_api` class provides methods for handling API requests, managing API tokens (both incoming and outgoing), and interfacing with a MySQL database to store and verify token information. This class is useful for building secure API interactions, handling token-based authentication, and executing HTTP requests with token authentication.

- **Token Management:** The class provides robust methods for managing both incoming and outgoing API tokens, allowing for automated token generation, verification, and deletion.
- **Request Handling:** The `request()` method is versatile, handling various payload types and ensuring secure communication with external APIs using token authentication.

## Requirements

### PHP Modules
- `MySQLi`: Required for database operations.
- `cURL`: Required for making HTTP requests.

### External Classes
- `x_class_mysql`: Required for Logging purposes if activated.


## Table Structure

This section describes the structure of the database table that the class automatically creates when required to log API tokens. The table stores details about each API token, including its type, value, and usage metadata.

| Column Name   | Data Type      | Attributes                                                                                               | Description                                                                                                                                  |
|---------------|----------------|---------------------------------------------------------------------------------------------------------|----------------------------------------------------------------------------------------------------------------------------------------------|
| `id`          | `int(9)`       | `NOT NULL`, `AUTO_INCREMENT`, `PRIMARY KEY`                                                             | A unique identifier for each record in the table.                                                                                            |
| `direction`   | `varchar(12)`  | `NOT NULL`                                                                                              | Indicates the type or direction of the token (e.g., "incoming", "outgoing").                                                                 |
| `api_token`   | `varchar(512)` | `NOT NULL`                                                                                              | The actual API token used for requests. This is stored securely and used for authentication.                                                 |
| `section`     | `varchar(128)` | `NOT NULL`                                                                                              | For Multi Site Purposes to split database data in categories.                |
| `last_use`    | `datetime`     | `NULL`                                                                                                  | The timestamp of when the token was last used. This is updated whenever the token is validated or utilized.                                  |
| `creation`    | `datetime`     | `DEFAULT CURRENT_TIMESTAMP`                                                                             | The timestamp of when the record was created. This value is automatically set when a new record is inserted.                                 |
| `modification`| `datetime`     | `DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP`                                                 | The timestamp of when the record was last modified. This value is automatically updated whenever the record is changed.                      |
| `x_class_api` | `UNIQUE KEY`   | `direction`, `api_token`, `section` using `BTREE`                                                       | A unique index that ensures no duplicate entries exist with the same `direction`, `api_token`, and `section`. This prevents duplicate tokens.|


## Class Usage

### Method Library

| Method                                    | Description                                                                                  |
|-------------------------------------------|----------------------------------------------------------------------------------------------|
| **`__construct($x_class_mysql, $table, $section = "")`**  | Initializes the class with a x_class_mysql object, table name, and an optional section name.     |
| **`request($url, $payload, $token = false, $section = false)`** | Sends an HTTP POST request to the specified URL with token and payload.                       |
| **`token_add_incoming($token, $section = false)`** | Adds an incoming API token to the database.                                                   |
| **`token_add_outgoing($token, $section = false)`** | Adds an outgoing API token to the database.                                                   |
| **`token_generate_incoming($section = false, $len = 32, $comb = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890')`** | Generates and stores a new incoming API token.                                                |
| **`token_delete_incoming($token, $section = false)`** | Deletes an incoming API token from the database.                                              |
| **`token_delete_outgoing($token, $section = false)`** | Deletes an outgoing API token from the database.                                              |
| **`token_check_incoming($token, $section = false)`** | Verifies if an incoming API token exists and updates its last use timestamp.                  |

### Method Details

#### `__construct(...)`

| Parameter   | Type   | Default | Description                                      |
|-------------|--------|---------|--------------------------------------------------|
| `$mysql`    | Object |         | MySQLi connection object.                       |
| `$table`    | String |         | The name of the table to store API tokens.      |
| `$section`  | String | `""`    | Optional section name to categorize tokens.     |

**Description:**  
Initializes the `x_class_api` object, sets up the database connection, and creates the API token table if it does not exist. The optional `$section` parameter allows categorizing tokens under different sections.

#### `request(...)`

| Parameter   | Type          | Default | Description                                      |
|-------------|---------------|---------|--------------------------------------------------|
| `$url`      | String        |         | The URL to send the HTTP POST request to.        |
| `$payload`  | String/Array  |         | The data to send in the request body.            |
| `$token`    | String/Bool   | `false` | The API token for authentication (optional).     |
| `$section`  | String/Bool   | `false` | The section name to filter the token (optional). |

| Return Type | Description                                      |
|-------------|--------------------------------------------------|
| String      | Returns the result of the HTTP POST request.     |

**Description:**  
Sends an HTTP POST request to the specified URL with the given payload. If no token is provided, the method attempts to fetch one from the database based on the section. The payload can be a string, numeric, array, or object. If the request is successful, it returns the server's response.

**Special Considerations:**  
- If the payload is an array or object, it is serialized before sending.
- Handles cURL operations with timeouts and SSL settings.

#### `token_add_incoming(...)`

| Parameter   | Type    | Default | Description                                      |
|-------------|---------|---------|--------------------------------------------------|
| `$token`    | String  |         | The incoming API token to store.                |
| `$section`  | String  | `false` | The section name under which to store the token.|

| Return Type | Description                                      |
|-------------|--------------------------------------------------|
| Bool        | Returns `true` on success, `false` on failure.   |

**Description:**  
Stores a new incoming API token in the database, categorized by section if provided.

#### `token_add_outgoing(...)`

| Parameter   | Type    | Default | Description                                      |
|-------------|---------|---------|--------------------------------------------------|
| `$token`    | String  |         | The outgoing API token to store.                |
| `$section`  | String  | `false` | The section name under which to store the token.|

| Return Type | Description                                      |
|-------------|--------------------------------------------------|
| Bool        | Returns `true` on success, `false` on failure.   |

**Description:**  
Stores a new outgoing API token in the database, categorized by section if provided.

#### `token_generate_incoming(...)`

| Parameter   | Type    | Default | Description                                      |
|-------------|---------|---------|--------------------------------------------------|
| `$section`  | String  | `false` | The section name under which to store the token. |
| `$len`      | Integer | `32`    | Length of the generated token.                   |
| `$comb`     | String  | `'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'` | Characters used to generate the token. |

| Return Type | Description                                      |
|-------------|--------------------------------------------------|
| String      | Returns the generated API token.                 |

**Description:**  
Generates a random API token and stores it in the database as an incoming token. The token is created using the specified character set and length.

#### `token_delete_incoming(...)`

| Parameter   | Type    | Default | Description                                      |
|-------------|---------|---------|--------------------------------------------------|
| `$token`    | String  |         | The incoming API token to delete.               |
| `$section`  | String  | `false` | The section under which the token is stored.    |

| Return Type | Description                                      |
|-------------|--------------------------------------------------|
| Bool        | Returns `true` on success, `false` on failure.   |

**Description:**  
Deletes an incoming API token from the database based on the token value and section.

#### `token_delete_outgoing(...)`

| Parameter   | Type    | Default | Description                                      |
|-------------|---------|---------|--------------------------------------------------|
| `$token`    | String  |         | The outgoing API token to delete.               |
| `$section`  | String  | `false` | The section under which the token is stored.    |

| Return Type | Description                                      |
|-------------|--------------------------------------------------|
| Bool        | Returns `true` on success, `false` on failure.   |

**Description:**  
Deletes an outgoing API token from the database based on the token value and section.

#### `token_check_incoming(...)`

| Parameter   | Type    | Default | Description                                      |
|-------------|---------|---------|--------------------------------------------------|
| `$token`    | String  |         | The incoming API token to verify.               |
| `$section`  | String  | `false` | The section under which the token is stored.    |

| Return Type | Description                                      |
|-------------|--------------------------------------------------|
| Bool        | Returns `true` if the token is valid, `false` otherwise. |

**Description:**  
Verifies if an incoming API token exists in the database and updates its `last_use` timestamp if valid.
