# Javascript Library

## Documentation
Access a comprehensive array of JavaScript functions designed for integration across diverse projects, enhancing coding speed and efficiency in web development. Detailed documentation for each function is provided below. To incorporate these functions, include the JavaScript file in the `_javascript` subfolder within the central `_framework` folder. This implementation optimizes your coding process and elevates your web project's performance. Simplify your coding with our library of pre-built functions and modules, crafted to expedite the creation of dynamic, interactive web applications. Find the JavaScript function file in: `/_framework/javascript/*.js`!


## Function Explanation

| Function                         | Explanation                                                                 | Parameters                                                                                                                   |
|----------------------------------|-----------------------------------------------------------------------------|------------------------------------------------------------------------------------------------------------------------------|
| `xjs_get(param)`                 | Extracts the value of a specific GET parameter from the URL.                 | `param` (String): The name of the GET parameter to retrieve.                                                                  |
| `xjs_in_url(param)`              | Checks if a given string exists within the current URL.                     | `param` (String): The string to search for within the URL.                                                                    |
| `xjs_hide_id(id)`                | Hides an HTML element with a specified ID by modifying its CSS property.    | `id` (String): The ID of the HTML element to hide.                                                                           |
| `xjs_show_id(id)`                | Shows a hidden HTML element with a specified ID by altering its CSS property.| `id` (String): The ID of the HTML element to show.                                                                           |
| `xjs_toggle_id(id)`              | Toggles the visibility of an HTML element with a specified ID.              | `id` (String): The ID of the HTML element to toggle.                                                                         |
| `xjs_is_email(email)`            | Checks if a given string represents a valid email address using a regular expression pattern. | `email` (String): The email address to validate.                                                                             |
| `xjs_popup(var_text, var_entrie)` | Dynamically creates a customizable popup element with an optional close button. | `var_text` (String): The content to display in the popup.<br>`var_entrie` (String, optional): The text for the close button (default is "Close"). |
| `xjs_genkey(length, charset)`    | Generates random passwords of a specified length using characters from a character set. | `length` (Number, optional): The length of the generated password (default is 12).<br>`charset` (String, optional): The character set for password generation (default includes letters and digits). |
| `xjs_dropdown_sort_abc(idname)`  | Sorts the options of a dropdown menu alphabetically.                        | `idname` (String): The ID of the select element to be sorted.                                                                 |
