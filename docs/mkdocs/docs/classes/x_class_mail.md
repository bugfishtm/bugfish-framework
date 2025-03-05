# Class Documentation: `x_class_mail` 


## Documentation
The `x_class_mail` class provides an interface for sending emails using the PHPMailer library. It offers various configuration options and logging capabilities to manage email sending effectively. This class allows you to set up SMTP details, manage email content, handle attachments, and log email activities to a database.

## Requirements

To use the `x_class_mail` class, ensure the following PHP modules and external classes are available:

`x_class_mail_phpmailer`: The PHPMailer library is required for sending emails.  
   - Install via Composer: `composer require phpmailer/phpmailer`  
`x_class_mysql`: Required for logging email activities if enabled.  


## Table Structure

This section describes the table structure used by the mail class to log email sending activities, including both successful and failed attempts. The table is automatically created by the class if required for its functionality. Below is a summary of the columns and keys used in the table, along with their purposes.


| Column Name | Data Type    | Attributes                                   | Description                                                                                         |
|-------------|--------------|----------------------------------------------|-----------------------------------------------------------------------------------------------------|
| `id`        | `int(10)`    | `NOT NULL`, `AUTO_INCREMENT`, `PRIMARY KEY` | A unique identifier for each email log entry, ensuring that each record can be individually tracked. |
| `receiver`  | `text`       | `DEFAULT NULL`                              | Stores the serialized list of email recipients.                                                     |
| `bcc`       | `text`       | `DEFAULT NULL`                              | Stores the serialized list of BCC (blind carbon copy) recipients.                                  |
| `cc`        | `text`       | `DEFAULT NULL`                              | Stores the serialized list of CC (carbon copy) recipients.                                          |
| `attach`    | `text`       | `DEFAULT NULL`                              | Contains the serialized list of attachments sent with the email.                                    |
| `subject`   | `varchar(512)`| `DEFAULT NULL`                              | The subject line of the email.                                                                      |
| `msgtext`   | `text`       |                                              | The main body text of the email.                                                                    |
| `creation`  | `datetime`   | `DEFAULT CURRENT_TIMESTAMP`                 | The timestamp when the email log entry was created. Automatically set when the record is added.    |
| `success`   | `tinyint(1)` | `DEFAULT NULL`                              | Indicates the result of the email sending attempt: `1` for success, `0` for failure, or `NULL` if not set. |
| `debugmsg`  | `text`       |                                              | Contains any debug messages related to the email sending process, useful for troubleshooting.      |
| `section`   | `varchar(128)`| `DEFAULT NULL`                              | For Multi Site Purposes to split database data in categories.                      |

| Key Name      | Key Type  | Columns | Usage                                                                                                  |
|---------------|-----------|---------|--------------------------------------------------------------------------------------------------------|
| `PRIMARY KEY` | Primary   | `id`    | Ensures that each email log entry is uniquely identifiable.                                            |

## Class Usage

#### Constructor

| Method      | Parameters | Description                                          |
|-------------|------------|------------------------------------------------------|
| `__construct` | `host` (string), `port` (int, default 25), `auth_type` (string, default false), `user` (string, default false), `pass` (string, default false), `from_mail` (string, default false), `from_name` (string, default false) | Initializes the mail settings including SMTP configuration and default sender information. |

#### Public Methods

| Method                   | Parameters                                                                                  | Description                                                                                                                                                                               |
|--------------------------|---------------------------------------------------------------------------------------------|-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `keep_alive`             | `bool` (default false)                                                                      | Set whether to keep the SMTP connection alive.                                                                                                                                           |
| `encoding`               | `encode` (string, default 'base64')                                                         | Set the encoding type for the email.                                                                                                                                                       |
| `charset`                | `charset` (string, default 'UTF-8')                                                         | Set the character set for the email.                                                                                                                                                       |
| `allow_insecure_ssl_connections` | `bool` (default false)                                                               | Allow insecure SSL connections.                                                                                                                                                            |
| `smtpdebuglevel`         | `int` (default 0)                                                                          | Set the SMTP debug level (0 - no debugging, 1 - client/server communication, 2 - server responses, 3 - detailed debugging).                                                              |
| `all_default_html`       | `bool` (default false)                                                                      | Set whether all emails should default to HTML format.                                                                                                                                       |
| `change_default_template` | `header` (string), `footer` (string)                                                        | Set default header and footer templates for emails.                                                                                                                                       |
| `initFrom`               | `mail` (string), `name` (string, default false)                                              | Initialize the default 'From' address and name.                                                                                                                                           |
| `initReplyTo`            | `mail` (string), `name` (string, default false)                                              | Initialize the default 'Reply-To' address and name.                                                                                                                                       |
| `test_mode`              | `val` (string or bool)                                                                      | Set the test mode to a specific email address or disable it.                                                                                                                                 |
| `log_disable`            | -                                                                                           | Disable logging of email activities.                                                                                                                                                        |
| `log_enable`             | -                                                                                           | Enable logging of email activities.                                                                                                                                                        |
| `logging`                | `connection` (x_class_mysql object), `table` (string), `log_success_mail` (bool, default false), `section` (string, default "") | Configure and enable logging of email activities.                                                                                                                                        |
| `last_info`              | -                                                                                           | Retrieve the last recorded information or error message from the last email operation.                                                                                                       |
| `send`                   | `to` (string or array), `toname` (string), `title` (string), `mailContent` (string), `ishtml` (bool, default false), `FOOTER` (string, default false), `HEADER` (string, default false), `attachments` (string or array, default false) | Send an email with specified parameters including recipients, content, attachments, and optional HTML formatting.                                                                         |
| `mail`                   | `subject` (string), `content` (string), `receiver` (array), `cc` (array), `bcc` (array), `attachment` (array), `settings` (array, default empty array) | Send an email using the provided settings and parameters, allowing for advanced configuration and overriding of default settings.                                                            |
| `object`                 | -                                                                                           | Create and return a new instance of `x_class_mail_item`, allowing further adjustments and sending of emails.                                                                              |

#### Private Methods

| Method           | Parameters                                     | Description                                               |
|------------------|------------------------------------------------|-----------------------------------------------------------|
| `log_execute`    | `subject` (string), `content` (string), `receiver` (array), `attachments` (array), `cc` (array), `bcc` (array), `success` (bool), `debug_message` (string), `settings` (array) | Log the details of the email operation to the database if logging is enabled.                                                             |
| `create_table`   | -                                              | Create the logging table in the database if it does not already exist.                                                                         |

## Details about Transmission Methods
### `send` Method

The `send` method in the `x_class_mail` class is used to send an email with specified parameters. It utilizes PHPMailer for sending emails and includes options for handling attachments, HTML content, and default templates.

#### Method Signature

```php
public function send(
    $to, 
    $toname, 
    $title, 
    $mailContent, 
    $ishtml = false, 
    $FOOTER = false, 
    $HEADER = false, 
    $attachments = false
)
```

#### Parameters

| Parameter      | Type       | Description                                                                                                   |
|----------------|------------|---------------------------------------------------------------------------------------------------------------|
| `$to`           | `string` or `array` | The recipient's email address. If an array, it should contain multiple recipient email addresses.            |
| `$toname`       | `string`   | The name of the recipient.                                                                                   |
| `$title`        | `string`   | The subject line of the email.                                                                              |
| `$mailContent`  | `string`   | The body content of the email.                                                                              |
| `$ishtml`       | `bool`     | Indicates whether the email content is in HTML format. Defaults to `false` (plain text).                    |
| `$FOOTER`       | `string` or `bool` | Optional footer to append to the email content. If `false`, the class's default footer will be used.        |
| `$HEADER`       | `string` or `bool` | Optional header to prepend to the email content. If `false`, the class's default header will be used.        |
| `$attachments`  | `string`, `array`, or `bool` | Path(s) to file attachments. Can be a single path (string) or an array of paths. If `false`, no attachments are added. |

#### Functionality

1. **PHPMailer Initialization**:
   - Creates a new instance of `PHPMailer`.
   - Configures SMTP settings using the class properties.

2. **SMTP Configuration**:
   - Sets the SMTP server details (`Host`, `SMTPAuth`, `Username`, `Password`, `SMTPSecure`, `Port`).
   - Configures additional options like keeping the SMTP connection alive and setting debug levels.

3. **HTML Content Handling**:
   - Checks if `$ishtml` is `false` and `$this->html` is `true`. If so, it sets the email to be sent as HTML.
   - Uses `$ishtml` to decide if the email content is in HTML format or plain text.

4. **Insecure Connection Handling**:
   - If insecure SSL connections are allowed (`$this->allow_insecure_connection`), it configures SMTP options to ignore SSL certificate verification.

5. **Setting Sender and Reply-To**:
   - Sets the 'From' address and name using `setFrom()`.
   - Sets the 'Reply-To' address and name using `addReplyTo()`.

6. **Recipient and Address Handling**:
   - If `$this->test_mode` is set, it adds a test email address.
   - Adds recipients to the email using `addAddress()`. Handles both single and multiple recipients.

7. **Attachment Handling**:
   - Adds attachments if `$attachments` is provided. Supports both single and multiple attachments.

8. **Email Content Preparation**:
   - Prepares the email body by combining the `$HEADER`, `$mailContent`, and `$FOOTER`.
   - Sets the email body using `Body`.

9. **Sending the Email**:
   - Attempts to send the email using `send()`.
   - Logs the outcome and updates the last information if logging is enabled.

#### Return Value

- Returns `true` if the email is successfully sent.
- Returns `false` if there is an error sending the email.

### `mail` Method

The `mail` method provides more advanced email sending capabilities with the option to override default settings using a configuration array.

#### Method Signature

```php
public function mail(
    $subject, 
    $content, 
    $receiver, 
    $cc, 
    $bcc, 
    $attachment, 
    $settings = array()
)
```

#### Parameters

| Parameter       | Type       | Description                                                                                     |
|-----------------|------------|-------------------------------------------------------------------------------------------------|
| `$subject`      | `string`   | The subject line of the email.                                                                  |
| `$content`      | `string`   | The body content of the email.                                                                  |
| `$receiver`     | `array`    | Recipients of the email. Format: `array(array(email, name), ...)`.                             |
| `$cc`           | `array`    | CC recipients. Format: `array(array(email, name), ...)`.                                        |
| `$bcc`          | `array`    | BCC recipients. Format: `array(array(email, name), ...)`.                                       |
| `$attachment`   | `array`    | Attachments. Format: `array(array(path, name), ...)` or `array(path, ...)`.                     |
| `$settings`     | `array`    | Configuration array to override default settings.                                              |

#### Functionality

1. **PHPMailer Initialization**:
   - Creates a new instance of `PHPMailer`.
   - Configures SMTP settings based on the provided settings or defaults.

2. **SMTP Configuration**:
   - Overrides default SMTP settings if specified in `$settings`.

3. **HTML Content Handling**:
   - Configures HTML format based on `$settings` or defaults.

4. **Insecure Connection Handling**:
   - Configures SMTP options for insecure SSL connections based on `$settings`.

5. **Setting Sender and Reply-To**:
   - Sets 'From' address and name using `setFrom()` from `$settings` or defaults.
   - Sets 'Reply-To' address and name using `addReplyTo()` from `$settings` or defaults.

6. **Recipient and Address Handling**:
   - Adds recipients to the email using `addAddress()`, `addCC()`, and `addBCC()`.

7. **Attachment Handling**:
   - Adds attachments using `addAttachment()` from `$settings`.

8. **Email Content Preparation**:
   - Prepares the email body by combining the `$HEADER`, `$content`, and `$FOOTER` from `$settings`.

9. **Sending the Email**:
   - Attempts to send the email using `send()`.
   - Logs the outcome and updates the last information if logging is enabled.

#### Return Value

- Returns `true` if the email is successfully sent.
- Returns `false` if there is an error sending the email.

### Summary

- **`send` Method**: A straightforward method for sending emails with specific parameters and default settings. Ideal for most common email-sending scenarios.
- **`mail` Method**: Provides advanced email-sending capabilities with customizable settings through a configuration array. Useful for scenarios requiring detailed customization or different settings for individual emails.

Both methods leverage PHPMailer for email sending and include robust handling for various email features, ensuring flexibility and control over email dispatching.