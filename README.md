# Bugfish Framework

## 📖 Introduction

The Bugfish Framework, meticulously designed for web developers, prioritizes security, flexibility, and performance. Its architecture streamlines development processes, enhancing efficiency and scalability, while a dedicated community provides support and resources for developers to maximize their projects' potential. Comprehensive documentation accompanies the framework, offering detailed insights into every function and class, accessible [here](https://bugfishtm.github.io/bugfish-framework/), serving as an invaluable resource to deepen understanding and facilitate smoother development workflows.

## 📚 Documentation
This framework is documented inside the files you can find in the "docs" folder. Just open the index.html with your web browser and you can navigate through the documentation of every class and function.

You can also find the documentation at: 
https://bugfishtm.github.io/bugfish-framework/

## 📂 Repository Folders

| Folder     | Description                                          |
|------------|------------------------------------------------------|
| _github    | Internal GitHub template files.                                    |
| _release   | Release packages.                                    |
| _framework | Framework files to be included in your project.                                  |
| _licenses  | Third-party licenses included in this software.           |
| _images    | Images related to this framework, mostly for this readme or product images.            |
| docs       | Framework documentation and also this project's GitHub page. You can find all functions and classes of this framework explained there!            |

## ⚙️ PHP Functions
Discover a collection of indispensable PHP functions crafted for seamless integration across various projects. Witness how these functions expedite and refine coding processes within web development. Comprehensive documentation for each function is provided below. To incorporate these functions seamlessly, include the PHP files within the designated _functions subfolder in the overarching _framework folder. This strategic approach optimizes coding efficiency and enhances web project performance.

## 🧩 PHP Classes
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

## 🎨 CSS Classes
Introducing the "Bugfish CSS Framework" – a solution for efficient web design. Simplify your development process with a comprehensive collection of pre-built classes, designed to expedite the creation of responsive web layouts. The Bugfish CSS Framework streamlines your design experience, making it faster and more professional. To use it, include the CSS files located in the css folder.

## 📜 Javascript Functions
Access a comprehensive array of JavaScript functions designed for integration across diverse projects, enhancing coding speed and efficiency in web development. Detailed documentation for each function is provided below. To incorporate these functions, include the JavaScript file in the _javascript subfolder within the central _framework folder. This implementation optimizes your coding process and elevates your web project's performance. Simplify your coding with our library of pre-built functions and modules, crafted to expedite the creation of dynamic, interactive web applications. Find the JavaScript Function file in: /_framework/javascript/*.js!

## 🙌 Support us for our work!

If you want to support us, include this image somewhere in your project, that people can see this project has been created with help of this framework:

![a](./_images/banner.jpg)

## 🤝 Get Support

Should you encounter any issues or have questions while using this software, please do not hesitate to reach out to us on our forum at [Bugfish Forum](www.bugfish.eu/forum). Additionally, you can request assistance via email at request@bugfish.eu, and we are dedicated to providing the support you require. We highly value your feedback and are committed to ensuring your success with our web project.

## 📜 Licensing Information

The Bugfish Framework is released under the GPLv3 License, affording you the freedom to use, modify, and distribute the project as you see fit. It is imperative to note that the "_vendor" folder contains various libraries, each with its own unique licenses. To ensure full compliance and understanding of the licensing terms associated with these included libraries, we encourage you to consult our comprehensive documentation on our GitHub page. This documentation provides exhaustive information regarding the specific licenses and any additional requirements tied to individual libraries. Your responsible adherence to these licenses is pivotal when utilizing this project. Your interest and collaboration are greatly appreciated. See Documentation of this Project in the _docs folder to get more insights about licenses of libraries used in this framework. All of them are LGPL or GPL Licenses.

🐟 Bugfish <3