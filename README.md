Responsive Apache Directory Listing
===================================

A directory listing configuration for the famous Apache web server. It greatly improves the default directory listing:

* HTML5
* Responsive
* Linked path navigation
* Clickable rows
* 183 preconfigured common file types
* CSV based file type configuration
* Configuration helper script
* Generic icons based on the file extensions
* Title shows current path location
* Denies navigation outside the root level

Try a [demo](http://finnrudolph.de/fileadmin/content/blog/2014/responsive_apache_directory_listing/demo/) to see some running code.

Installation
------------

###1. Download

Download the [latest version](https://github.com/countzero/responsive_apache_directory_listing/releases) and unpack it to a nice place on your machine.

###2. Upload

Upload the `.htaccess` file and the `public` directory to a location on your Apache web server.

###3. Configure

Open the [.htaccess](https://github.com/countzero/responsive_apache_directory_listing/blob/master/.htaccess#L12) file with an text editor of your choice. Change the value of the environment variable `ROOT_PATH` to the path on your Apache web server.

Open the [configuration_helper.php](https://github.com/countzero/responsive_apache_directory_listing/blob/master/public/configuration_helper.php) in your browser. Copy the content of the ".htaccess" textarea to the configuration section in the [.htaccess](https://github.com/countzero/responsive_apache_directory_listing/blob/master/.htaccess#L113) file.

Add File Types
--------------

Open the [file_types.csv](https://github.com/countzero/responsive_apache_directory_listing/blob/master/public/file_types.csv) file with an text editor of your choice and add new file types in the following pattern:

    css-prefix-;extension;Description of the File Type

Open the [configuration_helper.php](https://github.com/countzero/responsive_apache_directory_listing/blob/master/public/configuration_helper.php) in your browser. Copy the content of the ".htaccess" textarea to the configuration section in the [.htaccess](https://github.com/countzero/responsive_apache_directory_listing/blob/master/.htaccess#L113) file.
Replace all `td:after` CSS pseudo-element definitions in the [all.css](https://github.com/countzero/responsive_apache_directory_listing/blob/master/public/all.css#L302) file with the content of the "public/all.css" textarea.


Change Style
------------

Open the [all.css](https://github.com/countzero/responsive_apache_directory_listing/blob/master/public/all.css) file with an text editor of your choice and go nuts ;D

License
-----------
*Responsive Apache Directory Listing* is licensed under the [Creative Commons - Attribution-NonCommercial 3.0 Unported](http://creativecommons.org/licenses/by-nc/3.0/).