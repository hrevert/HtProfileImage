HtProfileImage
==============

A Zend framework module which adds profile image upload functionality to ZfcUser

Note: This module is not fully tested.

## Features

* Setting Gravatar as alternative when user has not uploaded his image
* Setting gender wise default image when user has not uploaded his image
* Resizing options for storing
* Useful view helpers to get user images from view templates

## Installation
* Add `"hrevert/ht-profile-image": "1.0.*",` to your composer.json and run `php composer.phar update`
* Enable the module in `config/application.config.php`
* Copy file located in `./vendor/Auth/config/htprofileimage.global.php` to `./config/autoload/htprofileimage.global.php` and change the values as you wish

Please check this [wiki](https://github.com/hrevert/HtProfileImage/wiki) for more details on how to use this module.


