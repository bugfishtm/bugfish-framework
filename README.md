# Bugfish Framework

## 🔍 Overview

> [!NOTE]
> No new features are planned for this project at this time.

> [!TIP]
> This project is actively maintained, with regular updates and prompt fixes for reported issues.

The Bugfish Framework, meticulously designed for web developers, prioritizes security, flexibility, and performance. Its architecture streamlines development processes, enhancing efficiency and scalability, while a dedicated community provides support and resources for developers to maximize their projects' potential.

![Cover](./_images/framework.jpg)

### Requirements

#### PHP Version

- PHP 8.3/8.4 is recommended.
- You can find specific requirements in the different documentation sections of our libraries.

#### PHP Modules

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

### PHP Functions
Discover a collection of indispensable PHP functions crafted for seamless integration across various projects. Witness how these functions expedite and refine coding processes within web development. Comprehensive documentation for each function is provided below. To incorporate these functions seamlessly, include the PHP files within the designated _functions subfolder in the overarching _framework folder. This strategic approach optimizes coding efficiency and enhances web project performance.

### PHP Classes
These classes, located in /_framework/classes/x_*, are crucial for their functionality, efficiency, and thorough testing across various websites. They enhance development and save time. Note: Some classes require a database connection. They will install necessary tables automatically if configured correctly. Not all classes require MySQL; refer to the documentation for specific requirements. If MySQL is needed, provide a valid x_class_mysql object to the class.

| Name | Description | License |
|------|-------------|---------|
| ✅x_class_2fa | The TwoFactorAuthenticator class in PHP generates and verifies Time-Based One-Time Password (TOTP) codes for two-factor authentication (2FA). It offers methods for generating random secret keys, creating 2FA codes, and validating them, enhancing security in PHP applications. | GPLv3 |
| ✅x_class_api | Facilitates the creation of simple and secure API requests. This class needs PHP Module CURL to work properly. It supports token-authentication on API Requests and more. | GPLv3 |
| ✅x_class_benchmark | The x_class_benchmark file lets you benchmark the consumption of resources for sites on your website. PHP Values which refer to benchmarking related values will be saved in a database per URL and overwritten if the URL is refreshed to monitor consumption even after changes! | GPLv3 |
| ✅x_class_block | Facilitates session-based user counting and block operations. This makes it easy for you to block users out of various areas, in case they are making bad decisions and raising their counter! | GPLv3 |
| ✅x_class_comment | Enables commenting functionality, suitable for guestbooks or website comment sections. Could also act as a simple Chat or Logging Tool! | GPLv3 |
| ✅x_class_csrf | Provides robust CSRF protection for web forms, supporting external actions. You have a set of functions to control everything what is going on with CSRF Keys. This class will spare you a lot of time and serve you well to get some basic security into your website! | GPLv3 |
| ✅x_class_curl | Efficiently handles Curl requests and logs them for web operations. This class makes it easier to build PHP Curl Requests. PHP Module CURL is needed to run this class. | GPLv3 |
| ✅x_class_crypt | Provides file and string encryption capabilities. You can decrypt and encrypt strings/files. It uses a simple encryption method to make your files secure. | GPLv3 |
| ✅x_class_debug | Aids in debugging and offers development notifications and functions. You can check if PHP Modules are enabled or get some Benchmarks out of your website. | GPLv3 |
| ✅x_class_eventbox | The x_class_eventbox PHP class simplifies the display of user notifications and messages on a web page. | GPLv3 |
| ✅x_class_hitcounter | Counts website visitors per page URL. You have different configuration functions to handle how this counting operation should act in various cases. | GPLv3 |
| ✅x_class_ipbl | Implements IP blacklisting. This class allows you to raise counters for IPs and block certain areas if an IP is acting suspicious! This can make a main difference in website security and even prevent brute-force attacks to any of your logins if implemented the right way. | GPLv3 |
| ✅x_class_log | Provides a class for logging operations. Easy and smart you can make log entries for almost every possibility. | GPLv3 |
| ✅x_class_lang | Manages language translation for multi-language websites. You can easily add translation keys and manage them with a variation of functions and parameters! | GPLv3 |
| ✅x_class_mail | Handles mail sending operations, with a subclass for sending operation items. This class depends on x_class_phpmailer. | GPLv3 |
| ✅x_class_mail_template | Creates mail templates with substitutions and footer/header options, compatible with x_class_mail. This class makes it easier to quick prepare E-Mail Templates to build E-Mails - to send out to customers or others! | GPLv3 |
| ✅x_class_mysql | Provides MySQL database handling capabilities, along with additional features. This is another flagship of this framework. Most classes here need an x_class_mysql object to run properly. This class serves a lot in security and Error-Readability. It can make work much easier and has a Database logging system to store errors in Statements which may occur and much, much more! | GPLv3 |
| ✅x_class_phpmailer | Manages email sending operations within the framework. This class is not made by me "Bugfish". It's the PHPMailer Class you can find on: [Github](https://github.com/PHPMailer/PHPMailer) | LGPL-2.1 |
| ✅x_class_perm | Controls permissions for users, including single-item permission objects. You can control permissions with this and it is storage-saving. 1-n Relation. If you are in search of a permission system and you won't build one on your own, then you have found what you have searched for! | GPLv3 |
| ✅x_class_referer | Logs visitor referrers. You have some configuration functions to control how referrers will be saved into the database. | GPLv3 |
| ✅x_class_redis | Offers control over Redis functionality. With this class, you can cache content on a Redis server, which will make your website faster. This may come in handy if your website is serving mass on dynamically generated content, which does not change so fast. PHP Module REDIS is needed to run this class. | GPLv3 |
| ✅x_class_table | The x_class_table PHP class simplifies the creation of dynamic HTML tables with quick PHP editing capabilities. | GPLv3 |
| ✅x_class_user | Creates various types of user logins, with full functionality for password recovery, mail editing with token operations, and more. This is a flagship of this framework. It can serve you a complete working login/authentication and token system right away! | GPLv3 |
| ✅x_class_var | Controls setup variables for use on websites and includes a function to create forms for changing these values. You can control and set up constants on a page or in code. If you search for a constant management class, this is your way to go! | GPLv3 |
| ✅x_class_zip | Enables file compression and decompression, compatible with x_class_crypt for direct encryption and decryption. PHP Module ZIP is required to run this class. | GPLv3 |
| ✅x_class_version | Fetch version information and information about the author at the currently deployed framework instance. | GPLv3 |

### CSS Classes
Introducing the "Bugfish CSS Framework" – a solution for efficient web design. Simplify your development process with a comprehensive collection of pre-built classes, designed to expedite the creation of responsive web layouts. The Bugfish CSS Framework streamlines your design experience, making it faster and more professional. To use it, include the CSS files located in the css folder.

### Javascript Functions
Access a comprehensive array of JavaScript functions designed for integration across diverse projects, enhancing coding speed and efficiency in web development. Detailed documentation for each function is provided below. To incorporate these functions, include the JavaScript file in the _javascript subfolder within the central _framework folder. This implementation optimizes your coding process and elevates your web project's performance. Simplify your coding with our library of pre-built functions and modules, crafted to expedite the creation of dynamic, interactive web applications. Find the JavaScript Function file in: /_framework/javascript/*.js!

## 📖 Documentation

The following documentation is intended for both end-users and developers.


| **Description**                                                       | **Link**                                                                                         |
|----------------------------------------------------------------------|-------------------------------------------------------------------------------------------------|
| Access the online documentation for this project. | [https://bugfishtm.github.io/bugfish-framework/index.html](https://bugfishtm.github.io/bugfish-framework/index.html)  |

## ❓ Support Channels

If you encounter any issues or have questions while using this software, feel free to contact us:

- **GitHub Issues** is the main platform for reporting bugs, asking questions, or submitting feature requests: [https://github.com/bugfishtm/bugfish-framework/issues](https://github.com/bugfishtm/bugfish-framework/issues)
- **Discord Community** is available for live discussions, support, and connecting with other users: [Join us on Discord](https://discord.com/invite/xCj7AEMmye)  
- **Email support** is recommended only for urgent security-related issues: [security@bugfish.eu](mailto:security@bugfish.eu)

## 📢 Spread the Word

Help us grow by sharing this project with others! You can:  

* **Tweet about it** – Share your thoughts on [Twitter/X](https://twitter.com) and link us!  
* **Post on LinkedIn** – Let your professional network know about this project on [LinkedIn](https://www.linkedin.com).  
* **Share on Reddit** – Talk about it in relevant subreddits like [r/programming](https://www.reddit.com/r/programming/) or [r/opensource](https://www.reddit.com/r/opensource/).  
* **Tell Your Community** – Spread the word in Discord servers, Slack groups, and forums.  

## 📁 Repository Structure 

This table provides an overview of key files and folders related to the repository. Click on the links to access each file for more detailed information. If certain folders are missing from the repository, they are irrelevant to this project.

|Document Type|Description|
|----|-----|
| .github | Folder with github setup files. |
| [.github/CODE_OF_CONDUCT.md](./.github/CODE_OF_CONDUCT.md) | The community guidelines. |
| _changelogs | Folder for changelogs. |
| _images | Folder for project images. |
| _licenses | Folder for 3rd party licenses. |
| _releases | Folder for releases. |
| _framework | Folder with the source code. |
| docs | Folder for the documentation. | 
| .gitattributes | Repository setting file. Only for development purposes. |
| .gitignore | Repository ignore file. Only for development purposes. |
| README.md | Readme of this project. You are currently looking at this file. |
| repository_reset.bat | File to reset this repository. Only for development purposes. |
| repository_update.bat | File to update this repository. Only for development purposes. |
| [CONTRIBUTING.md](CONTRIBUTING.md) | Information for contributors. | 
| [CHANGELOG.md](CHANGELOG.md) | Information about changelogs. | 
| [SECURITY.md](SECURITY.md) | How to handle security issues. |
| [LICENSE.md](LICENSE.md) | License of this project. |

## 📑 Changelog Information

Refer to the `_changelogs` folder for detailed insights into the changes made across different versions. The changelogs are available in **HTML format** within this folder, providing a structured record of updates, modifications, and improvements over time. Additionally, **GitHub Releases** follow the same structure and also include these changelogs for easy reference.

## 🌱 Contributing to the Project

I am excited that you're considering contributing to our project! Here are some guidelines to help you get started.

**How to Contribute**

1. Fork the repository to create your own copy.
2. Create a new branch for your work (e.g., `feature/my-feature`).
3. Make your changes and ensure they work as expected.
4. Run tests to confirm everything is functioning correctly.
5. Commit your changes with a clear, concise message.
6. Push your branch to your forked repository.
7. Submit a pull request with a detailed description of your changes.
8. Reference any related issues or discussions in your pull request.

**Coding Style**

- Keep your code clean and well-organized.
- Add comments to explain complex logic or functions.
- Use meaningful and consistent variable and function names.
- Break down code into smaller, reusable functions and components.
- Follow proper indentation and formatting practices.
- Avoid code duplication by reusing existing functions or modules.
- Ensure your code is easily readable and maintainable by others.

## 🤝 Community Guidelines

We’re on a mission to create groundbreaking solutions, pushing the boundaries of technology. By being here, you’re an integral part of that journey. 

**Positive Guidelines:**
- Be kind, empathetic, and respectful in all interactions.
- Engage thoughtfully, offering constructive, solution-oriented feedback.
- Foster an environment of collaboration, support, and mutual respect.

**Unacceptable Behavior:**
- Harassment, hate speech, or offensive language.
- Personal attacks, discrimination, or any form of bullying.
- Sharing private or sensitive information without explicit consent.

Let’s collaborate, inspire one another, and build something extraordinary together!

## 🛡️ Warranty and Security

I take security seriously and appreciate responsible disclosure. If you discover a vulnerability, please follow these steps:

- **Do not** report it via public GitHub issues or discussions. Instead, please contact the [security@bugfish.eu](mailto:security@bugfish.eu) email address directly.   
- Provide as much detail as possible, including a description of the issue, steps to reproduce it, and its potential impact.  

I aim to acknowledge reports within **2–4 weeks** and will update you on our progress once the issue is verified and addressed.

This software is provided as-is, without any guarantees of security, reliability, or fitness for any particular purpose. We do not take responsibility for any damage, data loss, security breaches, or other issues that may arise from using this software. By using this software, you agree that We are not liable for any direct, indirect, incidental, or consequential damages. Use it at your own risk.

## 📜 License Information

The license for this software can be found in the [LICENSE.md](LICENSE.md) file. Third-party licenses are located in the ./_licenses folder. The software may also include additional licensed software or libraries.

🐟 Bugfish 
