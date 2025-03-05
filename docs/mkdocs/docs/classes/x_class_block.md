# Class Documentation: `x_class_block`

## Documentation
The `x_class_block` class is designed to manage access control based on a counter mechanism. It uses PHP sessions to track and limit actions, blocking further attempts if a predefined limit is exceeded within a specified time frame. This class is useful for implementing rate limiting or blocking mechanisms.

- **Dummy Mode**: When `dummy` mode is enabled, the class bypasses all blocking logic. This mode is useful for testing purposes or when you want to disable blocking temporarily.  
- **Session Management**: The class relies on PHP sessions to store the count and block state. Ensure sessions are properly configured and started to avoid issues with state persistence.  
- **Time Calculation**: The `block_time` is handled in seconds. The block state will be cleared after the specified duration if a time limit is set.  

This class provides functionality to track and block actions based on a counter and a time limit. It uses PHP sessions to store state information, including the current count and block timestamps.


## Requirements

### PHP Modules
- **Session**: Required for session management. Ensure session support is enabled in your PHP configuration.

### External Classes
- **None**: This class does not depend on any external classes.

## Class Properties

### `key`

| Property | Type   | Description                            |
|----------|--------|----------------------------------------|
| `key`    | string | A unique session key for tracking block state. |

### `dummy`

| Property | Type   | Description                            |
|----------|--------|----------------------------------------|
| `dummy`  | bool   | A flag indicating if the class is in dummy mode (for testing or bypassing functionality). |

### `maxcount`

| Property | Type   | Description                            |
|----------|--------|----------------------------------------|
| `maxcount` | int    | The maximum number of attempts allowed before blocking occurs. |

### `block_time`

| Property | Type   | Description                            |
|----------|--------|----------------------------------------|
| `block_time` | int    | The time (in seconds) for which blocking remains active. If `false`, blocking is permanent until reset. |

### `blocked`

| Property | Type   | Description                            |
|----------|--------|----------------------------------------|
| `blocked` | bool   | True if currently blocked, false otherwise. |


## Class Methods

### `__construct(...)`

| Parameter   | Type   | Description                                 |
|-------------|--------|---------------------------------------------|
| `$pre_key`  | string | Prefix for session key to avoid conflicts.  |
| `$maxcount` | int    | The maximum number of attempts allowed.     |
| `$block_time` | int    | Optional. The duration (in seconds) to remain blocked. Defaults to `false` (no time limit). |
| `$dummy`    | bool   | Optional. If `true`, the class operates in dummy mode (bypassing actual functionality). Defaults to `false`. |

- **Description**: Initializes the `x_class_block` object, starts a session if necessary, and sets up the session variables for tracking block state.
- **Returns**: None.

### `blocked(...)`

| Parameter | Type  | Description                                 |
|-----------|-------|---------------------------------------------|
| None      | None  | Checks if the current state is blocked based on the count and time limit. |

- **Returns**: `true` if blocked; `false` otherwise.

- **Description**: Determines whether the current action is blocked based on the count and the block time. Updates the `blocked` property accordingly.

### `increase(...)`

| Parameter | Type   | Description                              |
|-----------|--------|------------------------------------------|
| `$int`    | int    | The number of attempts to increment (default is `1`). |

- **Description**: Increases the attempt count by the specified amount and checks if the block condition is met.
- **Returns**: `false` if in dummy mode; otherwise, `true`.

### `decrease(...)`

| Parameter | Type   | Description                              |
|-----------|--------|------------------------------------------|
| `$int`    | int    | The number of attempts to decrement (default is `1`). |

- **Description**: Decreases the attempt count by the specified amount and checks if the block condition is met.
- **Returns**: `true` if in normal mode; otherwise, `false`.

### `reset(...)`

| Parameter | Type  | Description                              |
|-----------|-------|------------------------------------------|
| None      | None  | Resets the attempt count and clears the block state. |

- **Description**: Resets the attempt count to zero and clears any block timestamp, effectively removing any active block.
- **Returns**: `true` if in normal mode; otherwise, `false`.


