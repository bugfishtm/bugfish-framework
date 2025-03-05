# Class Documentation: `x_class_redis` 

## Documentation

The `x_class_redis` class provides a wrapper for interacting with a Redis database. It includes methods for connecting to Redis, checking connection status, and performing various operations such as adding and retrieving strings and lists.

- **Error Logging:** The class logs errors to the PHP error log if the Redis connection fails.  
- **Prefix Handling:** The optional prefix (`$pre`) is prepended to all Redis keys to avoid key collisions.  
- **Redis Methods:** Methods like `set`, `get`, `lpush`, and `lrange` are directly invoked on the Redis instance. Ensure that these methods are supported by the Redis extension.  

## Requirements

### PHP Modules
- **Redis**: The PHP Redis extension must be installed and enabled.

### External Classes
None external classes required.

## Method Library

| Method                    | Description                                                                                           |
|---------------------------|-------------------------------------------------------------------------------------------------------|
| **`__construct($host, $port, $pre = "")`** | Constructor for initializing the Redis connection. Requires Redis server host, port, and an optional prefix. |
| **`valid()`**            | Checks if the Redis connection is valid.                                                             |
| **`redis()`**            | Returns the Redis instance if connected; otherwise, returns `false`.                                 |
| **`ping()`**             | Sends a ping command to the Redis server to check if it is responsive.                                |
| **`keys($pre = false, $after = "")`** | Retrieves keys from Redis matching the specified prefix and suffix.                                 |
| **`add_string($name, $value)`** | Adds a string value to Redis with a specified key.                                                   |
| **`add_list($name, $value)`** | Adds multiple values to a Redis list with a specified key.                                            |
| **`get_string($name)`**  | Retrieves a string value from Redis by key.                                                          |
| **`get_list($name, $start, $end)`** | Retrieves a range of values from a Redis list by key.                                                |

## Method Details

#### `__construct(...)`

| Parameter          | Type     | Default | Description                                          |
|--------------------|----------|---------|------------------------------------------------------|
| `$host`            | String   |         | The hostname or IP address of the Redis server.     |
| `$port`            | Integer  |         | The port number on which the Redis server is listening. |
| `$pre`             | String   | `""`    | Optional prefix to be prepended to Redis keys.      |

**Description:**  
Initializes the Redis client, attempts to connect to the specified Redis server, and sets an optional prefix for keys. Logs an error if the connection fails.

#### `valid(...)`

| Return Type        | Description                                        |
|--------------------|----------------------------------------------------|
| Boolean            | Returns `true` if the Redis connection is valid; otherwise, `false`. |

**Description:**  
Checks if the Redis connection was successfully established.

#### `redis(...)`

| Return Type        | Description                                        |
|--------------------|----------------------------------------------------|
| Redis / Boolean    | Returns the Redis instance if connected; otherwise, `false`. |

**Description:**  
Provides access to the Redis instance if the connection is valid.

#### `ping(...)`

| Return Type        | Description                                        |
|--------------------|----------------------------------------------------|
| String / Boolean   | Returns the response from the Redis server to the ping command, or `false` if not connected. |

**Description:**  
Sends a ping command to the Redis server and returns the server's response to verify connectivity.

#### `keys(...)`

| Parameter          | Type     | Default | Description                                          |
|--------------------|----------|---------|------------------------------------------------------|
| `$pre`             | String   | `false` | Optional prefix to filter keys. If not provided, uses the class-level prefix. |
| `$after`           | String   | `""`    | Optional suffix to append to the prefix for filtering keys. |

| Return Type        | Description                                        |
|--------------------|----------------------------------------------------|
| Array / Boolean    | Returns an array of keys matching the specified pattern, or `false` if not connected. |

**Description:**  
Retrieves keys from Redis that match the specified prefix and suffix.

#### `add_string(...)`

| Parameter          | Type     | Description                                          |
|--------------------|----------|------------------------------------------------------|
| `$name`            | String   | The key under which to store the string value.      |
| `$value`           | String   | The string value to be stored.                      |

| Return Type        | Description                                        |
|--------------------|----------------------------------------------------|
| Boolean            | Returns `true` if the string was successfully added, `false` otherwise. |

**Description:**  
Adds a string value to Redis with the specified key. Returns `false` if the parameters are invalid or if the Redis connection is not established.

#### `add_list(...)`

| Parameter          | Type     | Description                                          |
|--------------------|----------|------------------------------------------------------|
| `$name`            | String   | The key under which to store the list.              |
| `$value`           | Array    | An array of values to be added to the list.         |

| Return Type        | Description                                        |
|--------------------|----------------------------------------------------|
| Boolean            | Returns `true` if the list was successfully updated, `false` otherwise. |

**Description:**  
Adds multiple values to a Redis list with the specified key. Each value is pushed to the beginning of the list.

#### `get_string(...)`

| Parameter          | Type     | Description                                          |
|--------------------|----------|------------------------------------------------------|
| `$name`            | String   | The key of the string value to retrieve.            |

| Return Type        | Description                                        |
|--------------------|----------------------------------------------------|
| String / Boolean   | Returns the string value stored under the specified key, or `false` if not connected or key does not exist. |

**Description:**  
Retrieves a string value from Redis by key.

#### `get_list(...)`

| Parameter          | Type     | Description                                          |
|--------------------|----------|------------------------------------------------------|
| `$name`            | String   | The key of the list to retrieve.                    |
| `$start`           | Integer  | The starting index of the range to retrieve.        |
| `$end`             | Integer  | The ending index of the range to retrieve.          |

| Return Type        | Description                                        |
|--------------------|----------------------------------------------------|
| Array / Boolean    | Returns an array of values from the list within the specified range, or `false` if not connected or key does not exist. |

**Description:**  
Retrieves a range of values from a Redis list by key. The range is defined by the `start` and `end` indices.


