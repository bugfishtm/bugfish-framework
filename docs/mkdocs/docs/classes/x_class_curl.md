# PHP Class: `x_class_curl` 

The `x_class_curl` class is designed to facilitate various types of HTTP requests, including file downloads and uploads, while optionally logging requests and responses to a database. It provides a straightforward interface for making `GET`, `POST`, or custom requests and converting between XML and JSON formats.

1. **Logging**: The class supports logging, which can be enabled using the `logging()` method. The log data is stored in a specified MySQL table. Ensure the MySQL table exists, or the class will automatically create it.
2. **Curl Settings**: The `settings` array passed to the `request()`, `download()`, and `upload()` methods allows customization of the `curl` request by using `CURLOPT_*` options.

The `x_class_curl` class provides several methods to make HTTP requests, log interactions, and convert data formats. Below is a detailed explanation of each method and its parameters.

Use the class by including `/_framework/classes/x_class_curl.php`.

!!! warning "Dependencies"
	- PHP 7.0-7.4
	- PHP 8.0-8.4

!!! warning "Required PHP Modules"
	- **`curl`** — Required for `curl_init()`, `curl_setopt()`, `curl_exec()`, and `curl_close()`.
	- **`mysqli`** — Required by the `x_class_mysql` dependency for database operations.
	- **`json`** — For all JSON operations (`json_encode`, `json_decode`).
	- **`libxml` / `simplexml`** — For XML to array/JSON conversions via `simplexml_load_string`.
	- **`fileinfo`** — Needed for `mime_content_type()` in file uploads.
	- **`mbstring`** — Recommended for string handling reliability in serialized output/logs (not directly used but can affect behavior in some edge cases).

!!! warning "Required Classes"
	- **`x_class_mysql`** — This class is required for all logging operations. 

## Table

This section describes the table structure that the cURL class will automatically create to log HTTP requests made using cURL. The table is designed to store detailed information about each request, such as the URL, request type, and response data. Below is an overview of the columns and keys used in the table, along with their intended purpose.

!!! note "The table will be automatically installed upon constructor execution."

| Column Name  | Data Type     | Attributes                                  | Description                                                                                          |
|--------------|---------------|---------------------------------------------|------------------------------------------------------------------------------------------------------|
| `id`         | `int(10)`     | `NOT NULL`, `AUTO_INCREMENT`, `PRIMARY KEY` | A unique identifier for each logged request.                                                         |
| `url`        | `text`        |                                             | The remote URL to which the cURL request was made.                                                   |
| `request`    | `varchar(64)` |                                             | The type of request or function name used (e.g., `GET`, `POST`, `PUT`).                              |
| `filename`   | `text`        |                                             | The filename involved if the request was related to file uploads.                                    |
| `settings`   | `text`        |                                             | The configuration settings or parameters used for the cURL request.                                  |
| `output`     | `text`        |                                             | The response or output returned by the cURL request.                                                 |
| `section`    | `varchar(128)`| `DEFAULT ''`                                | For Multi Site Purposes to split database data in categories.                    |
| `type`       | `varchar(64)` |                                             | The type of cURL request made, providing further context (e.g., `API`, `File Transfer`).             |
| `creation`   | `datetime`    | `DEFAULT CURRENT_TIMESTAMP`                 | The timestamp when the request was logged, automatically set when the record is created.             |


| Key Name      | Key Type   | Columns | Usage                                                                                                  |
|---------------|------------|---------|--------------------------------------------------------------------------------------------------------|
| `PRIMARY KEY` | Primary    | `id`    | Ensures that each log entry is uniquely identifiable.                                                  |

## Methods

### `logging`

Configures logging for the requests made using this class.

| Parameter          | Type   | Description                                                                                                      |
|--------------------|--------|------------------------------------------------------------------------------------------------------------------|
| `mysql`            | object | MySQL connection object.                                                                                         |
| `logging`          | bool   | Enable or disable logging.                                                                                       |
| `logging_settings` | bool   | Determines if the request settings should be logged.                                                             |
| `logging_table`    | string | Name of the MySQL table where logs are stored.                                                                   |
| `section`          | string | Optional. A string identifier for the section of the application related to the request.                         |

### `request`

Executes an HTTP request and returns the response.

| Parameter   | Type   | Description                                                                                                      |
|-------------|--------|------------------------------------------------------------------------------------------------------------------|
| `url`       | string | The URL to which the request is made.                                                                            |
| `request`   | string | The HTTP request method (default is `GET`).                                                                      |
| `settings`  | array  | Optional. An associative array of additional `curl` options (`CURLOPT_*`) to customize the request.              |

**Returns:** The response from the server as a string.

### `download`

Downloads a file from a remote server to a local path.

| Parameter   | Type   | Description                                                                                                      |
|-------------|--------|------------------------------------------------------------------------------------------------------------------|
| `remote`    | string | The URL of the remote file to be downloaded.                                                                     |
| `local`     | string | The local path where the file should be saved.                                                                   |
| `request`   | string | The HTTP request method (default is `GET`).                                                                      |
| `settings`  | array  | Optional. An associative array of additional `curl` options (`CURLOPT_*`) to customize the request.              |

**Returns:** The response from the server as a string.

### `upload`

Uploads a local file to a remote server.

| Parameter   | Type   | Description                                                                                                      |
|-------------|--------|------------------------------------------------------------------------------------------------------------------|
| `remote`    | string | The URL where the file should be uploaded.                                                                       |
| `local`     | string | The local path of the file to be uploaded.                                                                       |
| `request`   | string | The HTTP request method (default is `POST`).                                                                     |
| `settings`  | array  | Optional. An associative array of additional `curl` options (`CURLOPT_*`) to customize the request.              |

**Returns:** The response from the server as a string.

### `xml_to_array` 
- `xml_to_array($xml)`: Converts XML to an array.

### `xml_to_json` 
- `xml_to_json($xml)`: Converts XML to JSON.

### `json_to_array` 
- `json_to_array($json)`: Converts JSON to an array.

### `json_to_xml` 
- `json_to_xml($json)`: Converts JSON to XML.

### `array_to_xml` 
- `array_to_xml($array)`: Converts an array to XML.

### `array_to_json` 
- `array_to_json($array)`: Converts an array to JSON.






