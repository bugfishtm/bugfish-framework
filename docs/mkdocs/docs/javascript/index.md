# Javascript Library

## Introduction

Boost your web development efficiency with our library of reusable JavaScript functions, ideal for dynamic, interactive projects. Each function is fully documented for easy integration. To use, simply include the JavaScript file located at /`_framework/javascript/xjs_library.js`. Streamline your workflow and enhance performance with our pre-built modules.

## Functions

| Function                  | Parameters                                                                                                  | Purpose                                                        | How It Works (Summary)                                                     |
|---------------------------|-------------------------------------------------------------------------------------------------------------|----------------------------------------------------------------|----------------------------------------------------------------------------|
| **xjs_get**               | `parameterName` – Name of the GET parameter to retrieve                                                     | Get a URL GET parameter’s value                                | Splits query string into key-value pairs, decodes, and returns matching value. |
| **xjs_in_url**            | `parameterName` – String to search for in the current page URL                                               | Check if a string exists in the URL                            | Uses `window.location.href.includes()` to check presence.                  |
| **xjs_hide_id**           | `id` – jQuery object representing the element to hide                                                        | Hide an element by ID (using jQuery)                           | Sets CSS style `display: none` on the given object.                        |
| **xjs_show_id**           | `id` – jQuery object representing the element to show                                                        | Show an element by ID (using jQuery)                           | Sets CSS style `display: block` on the given object.                       |
| **xjs_toggle_id**         | `id` – jQuery object representing the element to toggle visibility                                           | Toggle visibility of an element                                | Checks current `display` style, changes between `none` and `block`.        |
| **xjs_is_email**          | `email` – String to validate as an email address                                                             | Validate email format                                          | Uses regex `/\S+@\S+\.\S+/` to test for pattern match.                     |
| **xjs_popup**             | `var_text` – HTML/text content to display inside popup<br>`var_entrie` *(optional)* – Button label text      | Create a popup with close button                               | Constructs HTML for popup, appends to `document.body`, adds remove action. |
| **xjs_genkey**            | `length` *(optional, default 12)* – Number of characters<br>`charset` *(optional)* – Allowed characters     | Generate random password/key                                   | Picks random characters from `charset` until reaching `length`.            |
| **xjs_dropdown_sort_abc** | `idname` – ID of the `<select>` dropdown element                                                            | Sort dropdown list alphabetically                              | Converts options to array, sorts by `text`, rebuilds `<select>`.           |
| **xjs_request_get**       | `url` – Destination URL<br>`params` – Object of query parameters<br>`callback` – Function to handle response| Make GET AJAX request                                          | Encodes params into query string, sends request, calls callback with data. |
| **xjs_request_post**      | `url` – Destination URL<br>`params` – Object of POST parameters<br>`callback` – Function to handle response | Make POST AJAX request                                         | Encodes params into URL-encoded string, sends request, calls callback.     |

## Examples

### xjs_get

```js
/* ##################################################################
   Function: xjs_get(parameterName)
   Purpose:  Get the value of a GET parameter from the current URL
   Example:
   // URL: https://example.com?page=home
   let page = xjs_get("page");
   console.log(page); // "home"
################################################################## */
```

### xjs_in_url

```js
/* ##################################################################
   Function: xjs_in_url(parameterName)
   Purpose:  Check if a string exists in the current URL
   Example:
   if (xjs_in_url("profile")) {
     console.log("Profile section is active");
   }
################################################################## */
```

### xjs_hide_id

```js
/* ##################################################################
   Function: xjs_hide_id(id)
   Purpose:  Hide an element by its jQuery ID
   Example:
   xjs_hide_id($("#contentBox"));
################################################################## */
```

### xjs_show_id

```js
/* ##################################################################
   Function: xjs_show_id(id)
   Purpose:  Show a previously hidden element by its jQuery ID
   Example:
   xjs_show_id($("#contentBox"));
################################################################## */
```

### xjs_toggle_id

```js
/* ##################################################################
   Function: xjs_toggle_id(id)
   Purpose:  Toggle an element’s visibility (show/hide)
   Example:
   xjs_toggle_id($("#sidebar"));
################################################################## */
```

### xjs_is_email

```js
/* ##################################################################
   Function: xjs_is_email(email)
   Purpose:  Validate if a string is a properly formatted email
   Example:
   console.log(xjs_is_email("hello@bugfish.de")); // true
################################################################## */
```

### xjs_popup

```js
/* ##################################################################
   Function: xjs_popup(var_text, var_entrie = "Close")
   Purpose:  Create a popup dynamically with optional close button text
   Example:
   xjs_popup("Welcome to Bugfish Framework!", "Got it");
################################################################## */
```

### xjs_genkey

```js
/* ##################################################################
   Function: xjs_genkey(length = 12, charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789")
   Purpose:  Generate a random password/key string
   Example:
   let key = xjs_genkey(16);
   console.log("Generated key:", key);
################################################################## */
```

### xjs_dropdown_sort_abc

```js
/* ##################################################################
   Function: xjs_dropdown_sort_abc(idname)
   Purpose:  Sort the options of a <select> dropdown alphabetically
   Example:
   xjs_dropdown_sort_abc("countryList");
################################################################## */
```

### xjs_request_get

```js
/* ##################################################################
   Function: xjs_request_get(url, params, callback)
   Purpose:  Send an asynchronous GET request with parameters
   Example:
   xjs_request_get("/api/user", {id: 42}, function(response, status) {
     console.log("Status:", status);
     console.log("Response:", response);
   });
################################################################## */
```

### xjs_request_post

```js
/* ##################################################################
   Function: xjs_request_post(url, params, callback)
   Purpose:  Send an asynchronous POST request with parameters
   Example:
   xjs_request_post("/api/save", {name: "Jan", role: "Developer"}, function(response, status) {
     console.log("Saved:", response);
   });
################################################################## */
```
