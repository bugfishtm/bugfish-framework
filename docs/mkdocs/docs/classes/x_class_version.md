# Class Documentation: `x_class_version`

## Documentation
The `x_class_version` class provides metadata about the version of the software. It includes information about the author, contact details, website, GitHub repository, and version number. This class is a straightforward way to manage and access version-related information.

- **Immutable Properties**: The properties of this class are public and intended to be set during class instantiation or directly accessed. They do not have setter methods to enforce changes.  
- **No Methods**: This class does not include methods for functionality beyond storing and accessing the provided information.  

## Requirements

### PHP Modules
- **None**: This class does not require any specific PHP modules.

### External Classes
- **None**: This class does not depend on any external classes.

## Class Properties

### `autor`

| Property | Type   | Description                      |
|----------|--------|----------------------------------|
| `autor`  | string | The name of the author of the software. |

### `contact`

| Property | Type   | Description                      |
|----------|--------|----------------------------------|
| `contact`| string | The contact email for support or inquiries. |

### `website`

| Property | Type   | Description                      |
|----------|--------|----------------------------------|
| `website`| string | The official website for the software. |

### `github`

| Property | Type   | Description                      |
|----------|--------|----------------------------------|
| `github` | string | The GitHub repository URL for the software. |

### `version`

| Property | Type   | Description                      |
|----------|--------|----------------------------------|
| `version`| string | The current version number of the software. |

### `beta`

| Property | Type   | Description                      |
|----------|--------|----------------------------------|
| `beta`   | boolean| Indicates whether the version is a beta release. |



## Example Usage

Here's a simple example of how to use the `x_class_version` class:

```php
// Create an instance of the x_class_version class
$versionInfo = new x_class_version();

// Access version information
echo "Author: " . $versionInfo->autor . "\n";
echo "Contact: " . $versionInfo->contact . "\n";
echo "Website: " . $versionInfo->website . "\n";
echo "GitHub: " . $versionInfo->github . "\n";
echo "Version: " . $versionInfo->version . "\n";
echo "Beta: " . ($versionInfo->beta ? "Yes" : "No") . "\n";
```
