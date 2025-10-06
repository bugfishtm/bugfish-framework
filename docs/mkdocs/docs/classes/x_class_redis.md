# PHP Class: `x_class_redis` 

## Introduction

The `x_class_redis` class is a wrapper for working with a Redis database, providing methods to connect, check the connection, and perform operations like storing and retrieving strings and lists. It logs errors to the PHP error log if the connection fails and supports optional key prefixing with `$pre` to prevent collisions. Redis methods such as `set`, `get`, `lpush`, and `lrange` are called directly on the Redis instance, so the Redis extension must support them.

Use the class by including `/_framework/classes/x_class_redis.php`.

!!! warning "Dependencies"
	- PHP 7.1-7.4
	- PHP 8.0-8.4
	
!!! warning "PHP-Modules"
	- `Redis`: The PHP Redis extension must be installed and enabled.                     


## Methods

### `__construct`

Initializes a new Redis connection using the specified host and port, with an optional prefix for keys.

| Parameter   | Type   | Description                                         | Default |
|-------------|--------|-----------------------------------------------------|---------|
| `$host`     | string | The Redis server host address.                      | None    |
| `$port`     | int    | The Redis server port.                              | None    |
| `$pre`      | string | Optional prefix for Redis keys.                     | ""      |

| Return Value | When does this return value occur? |
|--------------|-------------------------------------|
| `void`       | This is a constructor and does not return a value. |

---

### `valid`

Checks if the Redis connection is valid.

| Parameter | Type   | Description                  | Default |
|-----------|--------|------------------------------|---------|
| _None_    | —      | This method takes no parameters. | —       |

| Return Value | When does this return value occur?                                         |
|--------------|----------------------------------------------------------------------------|
| `true`       | When the Redis connection is valid.                                         |
| `false`      | When the Redis connection is invalid.                                       |

---

### `redis`

Returns the Redis connection instance if valid, otherwise returns `false`.

| Parameter | Type   | Description                  | Default |
|-----------|--------|------------------------------|---------|
| _None_    | —      | This method takes no parameters. | —       |

| Return Value | When does this return value occur?                                         |
|--------------|----------------------------------------------------------------------------|
| `Redis`      | Returns the Redis connection instance when the connection is valid.       |
| `false`      | Returns `false` when the Redis connection is invalid.                      |

---

### `ping`

Pings the Redis server to check if the connection is still alive.

| Parameter | Type   | Description                  | Default |
|-----------|--------|------------------------------|---------|
| _None_    | —      | This method takes no parameters. | —       |

| Return Value | When does this return value occur?                                         |
|--------------|----------------------------------------------------------------------------|
| `string`     | Returns the server's response to the ping command when the connection is valid. |
| `false`      | Returns `false` when the Redis connection is invalid.                      |

---

### `keys`

Retrieves keys from Redis that match a given prefix and suffix.

| Parameter | Type   | Description                                            | Default |
|-----------|--------|--------------------------------------------------------|---------|
| `$pre`     | string | The prefix to filter keys.                             | `false` |
| `$after`   | string | The suffix to filter keys.                             | ""      |

| Return Value | When does this return value occur?                                         |
|--------------|----------------------------------------------------------------------------|
| `array`      | Returns an array of matching keys from Redis when the connection is valid. |
| `false`      | Returns `false` if the Redis connection is invalid or the parameters are incorrect. |

---

### `add_string`

Adds a string value to Redis with the specified name.

| Parameter | Type   | Description                                            | Default |
|-----------|--------|--------------------------------------------------------|---------|
| `$name`   | string | The name (key) of the string to be added to Redis.     | None    |
| `$value`  | string | The value (string) to be stored in Redis.              | None    |

| Return Value | When does this return value occur?                                         |
|--------------|----------------------------------------------------------------------------|
| `bool`       | Returns `true` if the string is successfully added to Redis.                |
| `false`      | Returns `false` if the Redis connection is invalid or the parameters are incorrect. |

---

### `add_list`

Adds a list of values to Redis under the specified name.

| Parameter | Type   | Description                                            | Default |
|-----------|--------|--------------------------------------------------------|---------|
| `$name`   | string | The name (key) of the list to be added to Redis.       | None    |
| `$value`  | array  | An array of values to be added to the list in Redis.   | None    |

| Return Value | When does this return value occur?                                         |
|--------------|----------------------------------------------------------------------------|
| `bool`       | Returns `true` if the values are successfully added to Redis.              |
| `false`      | Returns `false` if the Redis connection is invalid or the parameters are incorrect. |

---

### `get_string`

Retrieves a string value from Redis based on the given name.

| Parameter | Type   | Description                                            | Default |
|-----------|--------|--------------------------------------------------------|---------|
| `$name`   | string | The name (key) of the string to be retrieved from Redis. | None    |

| Return Value | When does this return value occur?                                         |
|--------------|----------------------------------------------------------------------------|
| `string`     | Returns the stored string value from Redis when the connection is valid.   |
| `false`      | Returns `false` if the Redis connection is invalid or the parameter is incorrect. |

---

### `get_list`

Retrieves a range of values from a Redis list based on the specified name, start, and end indexes.

| Parameter | Type   | Description                                            | Default |
|-----------|--------|--------------------------------------------------------|---------|
| `$name`   | string | The name (key) of the list to be retrieved from Redis. | None    |
| `$start`  | int    | The starting index of the range to retrieve.           | None    |
| `$end`    | int    | The ending index of the range to retrieve.             | None    |

| Return Value | When does this return value occur?                                         |
|--------------|----------------------------------------------------------------------------|
| `array`      | Returns an array of values from the specified range in the list if the connection is valid. |
| `false`      | Returns `false` if the Redis connection is invalid or the parameters are incorrect. |

## Example

```php
<?php
// Example usage of the x_class_redis class

// Step 1: Initialize the x_class_redis class with Redis server details
$host = '127.0.0.1'; // Redis server host
$port = 6379;         // Redis server port
$redisClient = new x_class_redis($host, $port);

// Step 2: Check if the Redis connection is valid
if ($redisClient->valid()) {
    echo "Redis connection is valid.\n";
} else {
    echo "Failed to connect to Redis.\n";
}

// Step 3: Add a string value to Redis
$redisClient->add_string('username', 'john_doe');
echo "Added string 'username' => 'john_doe' to Redis.\n";

// Step 4: Retrieve the string value from Redis
$username = $redisClient->get_string('username');
echo "Retrieved 'username' from Redis: " . $username . "\n";

// Step 5: Add a list of values to Redis
$redisClient->add_list('user_list', ['alice', 'bob', 'charlie']);
echo "Added values to the 'user_list' in Redis.\n";

// Step 6: Retrieve a range of values from the Redis list
$userList = $redisClient->get_list('user_list', 0, -1); // Get all values from the list
echo "Retrieved 'user_list' from Redis: " . implode(', ', $userList) . "\n";

// Step 7: Ping the Redis server to check if the connection is alive
$pingResponse = $redisClient->ping();
echo "Redis server ping response: " . $pingResponse . "\n";

// Step 8: Retrieve keys from Redis based on a prefix
$keys = $redisClient->keys('user_*'); // Get all keys starting with "user_"
echo "Keys with 'user_' prefix in Redis: " . implode(', ', $keys) . "\n";
?>
```
