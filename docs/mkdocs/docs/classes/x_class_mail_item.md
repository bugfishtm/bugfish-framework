# Class Documentation: `x_class_mail_item`

## Documentation

The `x_class_mail_item` class provides a structured way to prepare and send emails with customizable parameters such as recipients, attachments, and settings. It integrates with an external mail handling class (`x_class_mail`) to actually send the email.

## Requirements

### PHP Modules
  - None (relies on an external mail handling class)

### External Classes
  - `x_class_mail` (for sending emails)

## Class Methods

### `__construct(...)`

**Description:**  
Initializes the `x_class_mail_item` instance with an `x_class_mail` object, which is used to send emails.

| **Parameter**   | **Type**       | **Description**                              |
|-----------------|----------------|----------------------------------------------|
| `x_class_mail`  | `x_class_mail` | An instance of the `x_class_mail` class, responsible for sending the email. |

**Returns:**  
- `void`

---

### `add_attachment(...)`

**Description:**  
Adds an attachment to the email. The attachment is specified by its path and a name.

| **Parameter** | **Type** | **Description**                       |
|---------------|----------|---------------------------------------|
| `path`        | `string` | The file path to the attachment.       |
| `name`        | `string` | The name of the attachment as it will appear in the email. |

**Returns:**  
- `void`

**Example Usage:**
```php
$mailItem->add_attachment('/path/to/file.pdf', 'file.pdf');
```

---

### `get_attachment(...)`

**Description:**  
Returns an array of all attachments added to the email.

| **Returns**   | **Type**   | **Description**                    |
|---------------|------------|------------------------------------|
| `array`       | `array`    | An array of attachments, each with its path and name. |

**Example Usage:**
```php
$attachments = $mailItem->get_attachment();
```

---

### `clear_attachment(...)`

**Description:**  
Clears all attachments from the email.

| **Returns**   | **Type**   | **Description**                    |
|---------------|------------|------------------------------------|
| `void`        | `void`     | No return value.                   |

**Example Usage:**
```php
$mailItem->clear_attachment();
```

---

### `add_receiver(...)`

**Description:**  
Adds a recipient to the email.

| **Parameter** | **Type** | **Description**                   |
|---------------|----------|-----------------------------------|
| `mail`        | `string` | The recipient's email address.     |
| `name`        | `string` | The recipient's name.             |

**Returns:**  
- `void`

**Example Usage:**
```php
$mailItem->add_receiver('recipient@example.com', 'Recipient Name');
```

---

### `get_receiver(...)`

**Description:**  
Returns an array of all recipients added to the email.

| **Returns**   | **Type**   | **Description**                    |
|---------------|------------|------------------------------------|
| `array`       | `array`    | An array of recipients, each with their email and name. |

**Example Usage:**
```php
$receivers = $mailItem->get_receiver();
```

---

### `clear_receiver(...)`

**Description:**  
Clears all recipients from the email.

| **Returns**   | **Type**   | **Description**                    |
|---------------|------------|------------------------------------|
| `void`        | `void`     | No return value.                   |

**Example Usage:**
```php
$mailItem->clear_receiver();
```

---

### `add_cc(...)`

**Description:**  
Adds a recipient to the CC (carbon copy) list.

| **Parameter** | **Type** | **Description**                   |
|---------------|----------|-----------------------------------|
| `mail`        | `string` | The CC recipient's email address. |
| `name`        | `string` | The CC recipient's name.          |

**Returns:**  
- `void`

**Example Usage:**
```php
$mailItem->add_cc('cc@example.com', 'CC Name');
```

---

### `get_cc(...)`

**Description:**  
Returns an array of all CC recipients added to the email.

| **Returns**   | **Type**   | **Description**                    |
|---------------|------------|------------------------------------|
| `array`       | `array`    | An array of CC recipients, each with their email and name. |

**Example Usage:**
```php
$cc = $mailItem->get_cc();
```

---

### `clear_cc(...)`

**Description:**  
Clears all CC recipients from the email.

| **Returns**   | **Type**   | **Description**                    |
|---------------|------------|------------------------------------|
| `void`        | `void`     | No return value.                   |

**Example Usage:**
```php
$mailItem->clear_cc();
```

---

### `add_bcc(...)`

**Description:**  
Adds a recipient to the BCC (blind carbon copy) list.

| **Parameter** | **Type** | **Description**                   |
|---------------|----------|-----------------------------------|
| `mail`        | `string` | The BCC recipient's email address.|
| `name`        | `string` | The BCC recipient's name.         |

**Returns:**  
- `void`

**Example Usage:**
```php
$mailItem->add_bcc('bcc@example.com', 'BCC Name');
```

---

### `get_bcc(...)`

**Description:**  
Returns an array of all BCC recipients added to the email.

| **Returns**   | **Type**   | **Description**                    |
|---------------|------------|------------------------------------|
| `array`       | `array`    | An array of BCC recipients, each with their email and name. |

**Example Usage:**
```php
$bcc = $mailItem->get_bcc();
```

---

### `clear_bcc(...)`

**Description:**  
Clears all BCC recipients from the email.

| **Returns**   | **Type**   | **Description**                    |
|---------------|------------|------------------------------------|
| `void`        | `void`     | No return value.                   |

**Example Usage:**
```php
$mailItem->clear_bcc();
```

---

### `add_setting(...)`

**Description:**  
Adds a setting for the email, such as SMTP parameters or custom headers.

| **Parameter** | **Type** | **Description**                   |
|---------------|----------|-----------------------------------|
| `name`        | `string` | The name of the setting.          |
| `value`       | `mixed`  | The value of the setting.         |

**Returns:**  
- `void`

**Example Usage:**
```php
$mailItem->add_setting('smtp_server', 'smtp.example.com');
```

---

### `get_setting(...)`

**Description:**  
Returns an array of all settings added to the email.

| **Returns**   | **Type**   | **Description**                    |
|---------------|------------|------------------------------------|
| `array`       | `array`    | An array of settings, each with a name and value. |

**Example Usage:**
```php
$settings = $mailItem->get_setting();
```

---

### `clear_setting(...)`

**Description:**  
Clears all settings from the email.

| **Returns**   | **Type**   | **Description**                    |
|---------------|------------|------------------------------------|
| `void`        | `void`     | No return value.                   |

**Example Usage:**
```php
$mailItem->clear_setting();
```

---

### `send(...)`

**Description:**  
Sends the email with the configured parameters, including subject, content, recipients, CC, BCC, attachments, and settings.

| **Parameter** | **Type** | **Description**                   |
|---------------|----------|-----------------------------------|
| `subject`     | `string` | The subject of the email.         |
| `content`     | `string` | The content/body of the email.    |

**Returns:**  
- `mixed` - The return value depends on the `mail` method of the `x_class_mail` class. Typically, this might be a boolean indicating success or failure.

**Example Usage:**
```php
$mailItem->send('Subject Here', 'Email body content.');
```
