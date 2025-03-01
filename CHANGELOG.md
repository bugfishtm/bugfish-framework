# Changelog


## [3.36] - 2025-01-13
### Changes
- x_class_mail_template: Now contains Database Key for Language (Reinstallation Required of Table)
- x_class_mail_template: name_exists($name) function now gives back ID instead of true.
- x_class_mail_template: Changes in different functions to use languages keys for templates. (Multi Language)
- x_class_user: Added Additional Table fields for SuitefishCMS (No Reinstallation required, fields are just optional for use with suitefish-cms)
- x_class_user: New User Table Fields: user_firstname, user_lastname, user_street, user_company, user_postcode, user_country, user_city, user_region, user_tel

## [3.35] - 2024-11-29
### Changes
- Changes on the Documentation
- Change on General GLP Notice
 
## [3.34] - 2024-11-29
### Changes
- Language Class x_class_lang array from Database now same structure as from file retrieval.

## [3.33] - 2024-08-23
### Changes
- Disabled User Class un-confirmed Account Deletion on Adduser and Mail Edit Functionalities to prevent data lass. New Error Messages.

## [3.32] - 2024-08-23
### Changes
- Additional method in `x_class_user` for confirmation of Users.
- Great Documentation overhaul

## [3.31] - 2024-08-22
### Changes
- Fixed `x_class_user` for `login_as` functionality.

## [3.30] - 2024-06-26
### Changes
- Optimizations for different classes.
- Added Translation Key Substitutions to `x_class_lang`.
- Added `x_class_2fa` for Two-Factor Authentication.
- Updated GPLv3 and Bugfish Copyright Notice.
- Added `user_2fa` field to `x_class_user` table.
- Finalizations for integration with "bugfishCMS".

## [3.21] - 2024-06-07
### Changes
- Made Array for Translations public in `x_class_lang` for runtime use.

## [3.20] - 2024-05-05
### Notes
- `x_class_user`: Login As User functionality untested (for side-by-side login as admin for another user).

## [3.10] - 2024-04-01
### Changes
- Class enhancements and fixes for PHP9 compatibility.

## [3.00] - 2024-03-21
### Changes
- Class enhancements and fixes for PHP9 compatibility.

## [2.90] - 2024-03-07
### Changes
- Class enhancements and fixes for PHP9 compatibility.

## [2.75] - 2024-02-11
### Changes
- Class enhancements and fixes for PHP9 compatibility.

## [2.6] - 2024-01-13
### Changes
- Minor warning removals.

## [2.5] - 2024-01-10
### Changes
- Class enhancements and fixes for Referers.

🐟 Bugfish <3