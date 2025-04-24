# PHP Class: `x_class_version`

The `x_class_version` class stores metadata about a software version, including details like the author, contact email, website, GitHub repository, and version number. Its properties are immutable, meaning they are set during instantiation or accessed directly without the ability to change them later. The class does not include any methods beyond storing and retrieving this information.

Use the class by including `/_framework/classes/x_class_version.php`.

!!! warning "Dependencies"
	- PHP 7.1-7.4
	- PHP 8.0-8.4
	
!!! warning "PHP-Modules"
	This class does not require any specific PHP modules.

## Properties

| Property | Type  | Visibility   | Description                                                              |
|----------|--------|-------|--------------------------------------------------------------------------|
| `autor`  | string | public readonly | The name of the author of the software.                                   |
| `contact`| string | public readonly |  The contact email for support or inquiries.                              |
| `website`| string | public readonly |  The official website for the software.                                   |
| `github` | string | public readonly |  The GitHub repository URL for the software.                              |
| `version`| string | public readonly |  The current version number of the software.                              |

## Example Usage

Here's a simple example of how to use the `x_class_version` class:

```php
<?php
// Create an instance of the x_class_version class
$versionInfo = new x_class_version();

// Access version information
echo "Author: " . $versionInfo->autor . "\n";
echo "Contact: " . $versionInfo->contact . "\n";
echo "Website: " . $versionInfo->website . "\n";
echo "GitHub: " . $versionInfo->github . "\n";
echo "Version: " . $versionInfo->version . "\n";
?>
```
