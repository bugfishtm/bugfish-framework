# Class Documentation: `x_class_eventbox`


## Documentation
The `x_class_eventbox` class provides a mechanism for managing and displaying event messages within a web application. It utilizes PHP sessions to store messages temporarily and allows for various types of messages to be displayed or skipped.


- **Session Management**: The class uses PHP sessions to store and manage messages. Ensure that sessions are properly configured and started.
- **Message Types**: The class supports various types of messages such as "ok", "warning", "error", and "info". These types are used to style the messages differently when displayed.
- **Message Display**: The `show()` method can include an optional close button and HTML escaping for message text. This allows for customizable display options and security against XSS attacks.


This class manages messages in a web application, allowing you to add, display, and control various types of messages (e.g., error, warning, info). It uses PHP sessions to store message data.


## Requirements

### PHP Modules
- `Session`: Required for session management. Ensure session support is enabled in your PHP configuration.

### External Classes
- `None`: This class does not depend on any external classes.

## Class Properties

| Property | Type   | Description                                  |
|----------|--------|----------------------------------------------|
| `cookie` | string | A string used to prefix session variable names for isolation. |


## Class Methods

### `__construct(...)`

| Parameter | Type   | Description                                |
|-----------|--------|--------------------------------------------|
| `$cookie` | string | Optional. A prefix for session variables (default is an empty string). |

- **Description**: Initializes the `x_class_eventbox` object. Starts a PHP session if not already active and sets up session variables for storing messages.
- **Returns**: None.

### `ok(...)`

| Parameter | Type   | Description                           |
|-----------|--------|---------------------------------------|
| `$text`   | string | The message text to add.              |

- **Description**: Adds a message of type "ok" to the messages array. Calls the `add()` method.
- **Returns**: Result of the `add()` method.

### `warning(...)`

| Parameter | Type   | Description                           |
|-----------|--------|---------------------------------------|
| `$text`   | string | The message text to add.              |

- **Description**: Adds a message of type "warning" to the messages array. Calls the `add()` method.
- **Returns**: Result of the `add()` method.

### `error(...)`

| Parameter | Type   | Description                           |
|-----------|--------|---------------------------------------|
| `$text`   | string | The message text to add.              |

- **Description**: Adds a message of type "error" to the messages array. Calls the `add()` method.
- **Returns**: Result of the `add()` method.

### `info(...)`

| Parameter | Type   | Description                           |
|-----------|--------|---------------------------------------|
| `$text`   | string | The message text to add.              |

- **Description**: Adds a message of type "info" to the messages array. Calls the `add()` method.
- **Returns**: Result of the `add()` method.

### `add(...)`

| Parameter | Type   | Description                           |
|-----------|--------|---------------------------------------|
| `$text`   | string | The message text to add.              |
| `$type`   | string | The type of message (e.g., "ok", "warning", "error", "info"). |

- **Description**: Adds a message to the session's messages array with the specified type.
- **Returns**: None.

### `get(...)`

| Parameter | Type  | Description                   |
|-----------|-------|-------------------------------|
| None      | None  | Retrieves the current messages array from the session. |

- **Returns**: An array of messages from the session.

### `override(...)`

| Parameter | Type   | Description                           |
|-----------|--------|---------------------------------------|
| `$text`   | string | The message text to display.          |
| `$type`   | string | The type of message (e.g., "ok", "warning", "error", "info"). |

- **Description**: Clears all current messages and sets a single message with the specified type.
- **Returns**: None.

### `reset(...)`

| Parameter | Type  | Description                              |
|-----------|-------|------------------------------------------|
| None      | None  | Resets all messages and skips the event box. |

- **Description**: Clears all messages from the session and sets the skip flag to `false`.
- **Returns**: None.

### `skip(...)`

| Parameter | Type  | Description                              |
|-----------|-------|------------------------------------------|
| None      | None  | Sets the skip flag to `true`.            |

- **Description**: Sets a flag to skip displaying messages in the event box on the next show call.
- **Returns**: None.

### `noskip(...)`

| Parameter | Type  | Description                              |
|-----------|-------|------------------------------------------|
| None      | None  | Sets the skip flag to `false`.           |

- **Description**: Resets the skip flag to `false`, allowing messages to be displayed.
- **Returns**: None.

### `show(...)`

| Parameter    | Type   | Description                                             |
|--------------|--------|---------------------------------------------------------|
| `$closebutton` | mixed  | Optional. HTML content or text for a close button (default is `false`). |
| `$filter`     | bool   | Optional. If `true`, HTML special characters will be escaped (default is `false`). |

- **Description**: Displays the event box with the current messages. Optionally includes a close button and applies HTML escaping if required.
- **Returns**: `true` if messages are shown; otherwise, `false`.
