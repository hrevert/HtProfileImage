HtProfileImage
==============

A Zend framework 2 module which adds profile image upload functionality to ZfcUser

Note: This module is not fully tested.

## Features

* Setting Gravatar as alternative when user has not uploaded his image
* Setting gender wise default image when user has not uploaded his image
* Resizing options for storing
* Useful view helpers to get user images from view templates

## Installation
* Add `"webino/webino-image-thumb": "dev-master",` && `"hrevert/ht-profile-image": "1.0.*",` to your composer.json and run `php composer.phar update`
* Enable this module && `WebinoPhpThumb` in `config/application.config.php`
* Copy file located in `config/htprofileimage.global.php` to `./config/autoload/htprofileimage.global.php` and change the values as you wish
 
## How To

Please check this [wiki](https://github.com/hrevert/HtProfileImage/wiki) for more details on how to use this module.




[![Bitdeli Badge](https://d2weczhvl823v0.cloudfront.net/hrevert/htprofileimage/trend.png)](https://bitdeli.com/free "Bitdeli Badge")

