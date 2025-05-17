# PHP Class: `x_class_ipbl`

The `x_class_ipbl` class is used for managing IP-based blocking and failure counters using a MySQL database. It allows you to track IP addresses that have failed specific criteria and manage their block status accordingly. The class includes methods for checking if an IP is blocked, retrieving and updating counters, and unblocking IP addresses.

Use the class by including `/_framework/classes/x_class_ipbl.php`.

!!! warning "Dependencies"
	- PHP 7.0-7.4
	- PHP 8.0-8.4
	
!!! warning "PHP-Modules"
	- `mysqli`: The PHP MySQLi extension must be installed and enabled.  

!!! warning "PHP-Classes"
	- `x_class_mysql`: Required for database operations.


## Table

This section describes the structure of the table used for logging IP addresses that have been blacklisted due to failure counts. The table will be automatically created by the class if required by its functionality. Below is a summary of the columns and keys in the table, along with their usage.

!!! note "The table will be automatically installed upon constructor execution."

| Column Name  | Data Type     | Attributes                                  | Description                                                                                          |
|--------------|---------------|---------------------------------------------|------------------------------------------------------------------------------------------------------|
| `id`         | `int(10)`     | `NOT NULL`, `AUTO_INCREMENT`, `PRIMARY KEY` | A unique identifier for each blacklisted IP entry.                                                   |
| `fail`       | `int(10)`     | `DEFAULT '1'`                               | The count of failures associated with the IP address. This value increases with each failure.        |
| `ip_adr`     | `varchar(256)`| `NOT NULL`                                  | The IP address that is being blacklisted.                                                            |
| `creation`   | `datetime`    | `DEFAULT CURRENT_TIMESTAMP`                 | The date and time when the IP address was blacklisted. Automatically set upon insertion.             |


| Key Name      | Key Type  | Columns | Usage                                                                                                  |
|---------------|-----------|---------|--------------------------------------------------------------------------------------------------------|
| `PRIMARY KEY` | Primary   | `id`    | Ensures each blacklisted IP entry is uniquely identifiable.                                            |
| `x_class_ipbl`| Unique    | `ip_adr`| Ensures that each IP address is only recorded once in the table, preventing duplicate entries.         |


## Methods

---

### `__construct`

Initializes the class with database connection, table name, and maximum allowed failures before IP is considered blocked.

| Parameter    | Type    | Description                                              | Default  |
|--------------|---------|----------------------------------------------------------|----------|
| `$mysql`     | object  | MySQL-like DB handler instance supporting `select`, `query`, etc. | None     |
| `$tablename` | string  | Name of the table used to store IP data                 | None     |
| `$maxvalue`  | int     | Maximum allowed failure count before block              | `50000`  |

| Return Value | When does this return value occur?       |
|--------------|-------------------------------------------|
| `void`       | Constructor does not return a value.      |

---

### `blocked`, `banned`, `isbanned`, `isblocked`

Checks if the current IP is blocked. All four methods behave identically.

| Parameter | Type    | Description                                | Default |
|-----------|---------|--------------------------------------------|---------|
| `$renew`  | boolean | If `true`, re-checks DB to refresh status. | `false` |

| Return Value | When does this return value occur?                  |
|--------------|------------------------------------------------------|
| `true`       | If the current IP's failure count exceeds threshold. |
| `false`      | If not blocked.                                      |

---

### `get_array`

Returns the entire contents of the IP block table as an array.

| Parameter | Type | Description | Default |
|-----------|------|-------------|---------|
| _None_    | —    | —           | —       |

| Return Value | When does this return value occur?                 |
|--------------|---------------------------------------------------|
| `array`      | Always returns array of all IPs in the block list |

---

### `unblock`

Removes an IP address from the block list.

| Parameter | Type   | Description                     | Default |
|-----------|--------|---------------------------------|---------|
| `$ip`     | string | IP address to be unblocked.     | None    |

| Return Value | When does this return value occur? |
|--------------|------------------------------------|
| `void`       | Always                            |

---

### `get_counter`, `counter`

Returns the failure counter for the current IP. If `$renew` is `true`, the value is refreshed from the database.

| Parameter | Type    | Description                                | Default |
|-----------|---------|--------------------------------------------|---------|
| `$renew`  | boolean | If `true`, updates the local counter.      | `false` |

| Return Value | When does this return value occur?                            |
|--------------|---------------------------------------------------------------|
| `int`        | Failure count of current IP, 0 if not found.                  |

---

### `ip_counter`

Gets the failure counter for the specified IP address.

| Parameter | Type   | Description                         | Default |
|-----------|--------|-------------------------------------|---------|
| `$ip`     | string | IP address to fetch failure count for | None    |

| Return Value | When does this return value occur?              |
|--------------|-------------------------------------------------|
| `int`        | Number of failures for the specified IP.        |

---

### `raise`, `increase`

Increments the failure counter for the current IP by a given value.

| Parameter | Type | Description                           | Default |
|-----------|------|---------------------------------------|---------|
| `$value`  | int  | Amount to increase failure counter by | `1`     |

| Return Value | When does this return value occur?                |
|--------------|---------------------------------------------------|
| `int`        | New failure counter after the increase.           |

---

## Example

```php
<?php
// Mock DB class or your real DB connection instance
$db = new x_class_mysql(...); 
$ipBlocker = new x_class_ipbl($db, 'blocked_ips', 10);

// Raise the counter
$ipBlocker->raise(); 

// Check if the current IP is blocked
if ($ipBlocker->blocked()) {
    echo "Your IP is currently blocked.";
} else {
    echo "You're safe... for now.";
}

// Get all blocked entries
$allBlocked = $ipBlocker->get_array();
print_r($allBlocked);

// Unblock a specific IP
$ipBlocker->unblock('192.168.1.100');

// Check counter for a given IP
echo "Failures for IP: " . $ipBlocker->ip_counter('192.168.1.100');
?>
```
