# Bugfish Framework


Powerful, flexible, and secure—elevate your web development with Bugfish PHP Framework.

-----------

## Introduction

Introducing the Bugfish PHP Framework: a robust toolkit designed to empower web developers with extensive functionality, flexibility, and top-notch security standards. With Bugfish, you gain access to a suite of classes and functions that not only streamline development but also enhance performance, ensuring your web applications operate at peak efficiency. Join the Bugfish PHP Framework community today and unleash the full potential of your web development projects.

## Requirements

### PHP Version

- PHP 8.4/8.3 is recommended.
- You can find specific requirements in the different documentation sections of our libraries.

### PHP Modules

- **`mysqli`** – MySQL database connectivity using improved extension.
- **`gd`** – Image processing and manipulation (e.g., thumbnails).
- **`session`** – Manages user sessions across page requests.
- **`curl`** – Allows sending HTTP requests to external servers/APIs.
- **`sockets`** – Enables low-level network communication (TCP/UDP).
- **`mbstring`** – Multibyte string support (for UTF-8 and international text).
- **`exif`** – Reads metadata from images (e.g., orientation, camera info).
- **`dom`** – XML and HTML document parsing using DOM API.
- **`hash`** – Provides hashing algorithms (e.g., SHA, MD5).
- **`zip`** – Read/write ZIP compressed archives.
- **`openssl`** – Secure data encryption, decryption, and SSL/TLS support.
- **`redis`** – Redis client extension for caching and message brokering.
- **`libxml` / `simplexml`** – Core XML parsing library and simplified interface.
- **`fileinfo`** – Detects file types based on content.
- **`json`** – Parses and encodes JSON data.
- You can find specific requirements in the different documentation sections of our libraries.

## PHP Library

Discover a collection of indispensable PHP functions crafted for seamless integration across various projects. Witness how these functions expedite and refine coding processes within web development. Comprehensive documentation for each function is provided below. To incorporate these functions seamlessly, include the PHP files within the designated `_functions` subfolder in the overarching `_framework` folder. This strategic approach optimizes coding efficiency and enhances web project performance.

| Name | License |
|------|---------|
| [PHP Function Library](./functions/index.html) | GPLv3 |

## PHP Classes

These classes, located in `/_framework/classes/x_*`, are crucial for their functionality, efficiency, and thorough testing across various websites. They enhance development and save time. 

Note: Some classes require a database connection. They will install necessary tables automatically if configured correctly. Not all classes require MySQL; refer to the documentation for specific requirements. If MySQL is needed, provide a valid `x_class_mysql` object to the class.

| Name | Description | License |
|------|-------------|---------|
| [x_class_2fa](./classes/x_class_2fa.html) | The TwoFactorAuthenticator class in PHP generates and verifies Time-Based One-Time Password (TOTP) codes for two-factor authentication (2FA). It offers methods for generating random secret keys, creating 2FA codes, and validating them, enhancing security in PHP applications. | GPLv3 |
| [x_class_api](./classes/x_class_api.html) | Facilitates the creation of simple and secure API requests. This class needs PHP Module CURL to work properly. It supports token-authentication on API Requests and more. | GPLv3 |
| [x_class_benchmark](./classes/x_class_benchmark.html) | Lets you benchmark resource consumption for sites on your website. PHP values related to benchmarking will be saved in a database per URL and overwritten if the URL is refreshed to monitor consumption even after changes. | GPLv3 |
| [x_class_block](./classes/x_class_block.html) | Facilitates session-based user counting and block operations. Easily block users from various areas if they make bad decisions and raise their counter. | GPLv3 |
| [x_class_comment](./classes/x_class_comment.html) | Enables commenting functionality, suitable for guestbooks or website comment sections. Can also act as a simple chat or logging tool. | GPLv3 |
| [x_class_csrf](./classes/x_class_csrf.html) | Provides robust CSRF protection for web forms, supporting external actions. Includes functions to control everything related to CSRF keys, saving you time and adding basic security to your website. | GPLv3 |
| [x_class_curl](./classes/x_class_curl.html) | Efficiently handles Curl requests and logs them for web operations. This class makes it easier to build PHP Curl requests. PHP Module CURL is needed to run this class. | GPLv3 |
| [x_class_crypt](./classes/x_class_crypt.html) | Provides file and string encryption capabilities. Encrypt and decrypt strings/files using a simple encryption method. | GPLv3 |
| [x_class_debug](./classes/x_class_debug.html) | Aids in debugging and offers development notifications and functions. Check if PHP modules are enabled or get benchmarks for your website. | GPLv3 |
| [x_class_eventbox](./classes/x_class_eventbox.html) | Simplifies the display of user notifications and messages on a web page. | GPLv3 |
| [x_class_hitcounter](./classes/x_class_hitcounter.html) | Counts website visitors per page URL with configurable options to handle various cases. | GPLv3 |
| [x_class_ipbl](./classes/x_class_ipbl.html) | Implements IP blacklisting. Allows you to raise counters for IPs and block certain areas if an IP is acting suspiciously. Can help prevent brute-force attacks if implemented correctly. | GPLv3 |
| [x_class_log](./classes/x_class_log.html) | Provides a class for logging operations, allowing you to make log entries for almost every possibility. | GPLv3 |
| [x_class_lang](./classes/x_class_lang.html) | Manages language translation for multi-language websites with functions and parameters for adding and managing translation keys. | GPLv3 |
| [x_class_mail](./classes/x_class_mail.html) | Handles mail sending operations with a subclass for sending operation items. Depends on `x_class_phpmailer`. | GPLv3 |
| [x_class_mail_item](./classes/x_class_mail_item.html) | Together with x_class_mail simplifies single object transmissions. Depends on `x_class_phpmailer`. | GPLv3 |
| [x_class_mail_template](./classes/x_class_mail_template.html) | Creates mail templates with substitutions and footer/header options, compatible with `x_class_mail`. Simplifies the preparation of email templates. | GPLv3 |
| [x_class_mysql](./classes/x_class_mysql.html) | Provides MySQL database handling capabilities with additional features. Most classes need an `x_class_mysql` object to run properly. Includes a database logging system to store errors and more. | GPLv3 |
| [x_class_mysql_item](./classes/x_class_mysql_item.html) | Provides MySQL database handling capabilities for single database table elements. | GPLv3 |
| [x_class_phpmailer](https://github.com/PHPMailer/PHPMailer) | Manages email sending operations within the framework. Note: This class is from PHPMailer, not created by Bugfish. | LGPL-2.1 |
| [x_class_perm](./classes/x_class_perm.html) | Controls user permissions and management functionalities. Ideal for implementing a permission system. | GPLv3 |
| [x_class_perm_item](./classes/x_class_perm_item.html) | Controls user permissions, including single-item permission objects. Ideal for implementing a permission system. | GPLv3 |
| [x_class_referer](./classes/x_class_referer.html) | Logs visitor referrers with configuration functions to control how referrers are saved in the database. | GPLv3 |
| [x_class_redis](./classes/x_class_redis.html) | Offers control over Redis functionality. Caches content on a Redis server to improve website speed. Requires PHP Module REDIS. | GPLv3 |
| [x_class_table](./classes/x_class_table.html) | Simplifies the creation of dynamic HTML tables with PHP editing capabilities. | GPLv3 |
| [x_class_user](./classes/x_class_user.html) | Creates various types of user logins with full functionality for password recovery, mail editing, and token operations. A comprehensive login/authentication and token system. | GPLv3 |
| [x_class_var](./classes/x_class_var.html) | Controls setup variables for websites and includes a function for creating forms to change these values. Ideal for managing constants. | GPLv3 |
| [x_class_zip](./classes/x_class_zip.html) | Enables file compression and decompression, compatible with `x_class_crypt` for direct encryption and decryption. Requires PHP Module ZIP. | GPLv3 |
| [x_class_version](./classes/x_class_version.html) | Retrieves version and author information about the currently included framework. | GPLv3 |

## CSS Library

Introducing the "Bugfish CSS Framework" – a solution for efficient web design. Simplify your development process with a comprehensive collection of pre-built classes designed to expedite the creation of responsive web layouts. To use it, include the CSS files located in the `css` folder.

| Name | License |
|------|---------|
| [CSS Classes Library](./css/index.html) | GPLv3 |


## JavaScript Library

Access a comprehensive array of JavaScript functions designed for integration across diverse projects, enhancing coding speed and efficiency in web development. Detailed documentation for each function is provided below. To incorporate these functions, include the JavaScript file in the `_javascript` subfolder within the central `_framework` folder. This implementation optimizes your coding process and elevates your web project's performance.

Find the JavaScript function file in: `/_framework/javascript/*.js`

| Name | License |
|------|---------|
| [JavaScript Function Library](./javascript/index.html) | GPLv3 |

-----------

## Downloads  
The [Downloads Section](./download.html) provides all the necessary files to get started with the project, including the latest software versions and any related resources.

-----------

## Contributing  
Find out how you can contribute to the project by visiting the [Contributing Page](./contributing.html). Whether you want to report bugs, suggest features, or submit improvements, we welcome your involvement.

-----------

## Warranty  
Review the terms of our warranty on the [Warranty Information Page](./warranty.html). This page outlines the scope of support and any applicable guarantees.

-----------

## Support  
If you need assistance, visit the [Support Page](./support.html) to find the available channels for getting help with any issues or questions you might have.

-----------

## License  
Get the full details on licensing by checking out the [License Information Page](./license.html). This section includes the terms and conditions under which the project is distributed.