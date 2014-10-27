HtProfileImage
==============
[![Master Branch Build Status](https://api.travis-ci.org/hrevert/HtProfileImage.png?branch=master)](http://travis-ci.org/hrevert/HtProfileImage)
[![Latest Stable Version](https://poser.pugx.org/hrevert/ht-profile-image/v/stable.png)](https://packagist.org/packages/hrevert/ht-profile-image)
[![Latest Unstable Version](https://poser.pugx.org/hrevert/ht-profile-image/v/unstable.png)](https://packagist.org/packages/hrevert/ht-profile-image)
[![Total Downloads](https://poser.pugx.org/hrevert/ht-profile-image/downloads.png)](https://packagist.org/packages/hrevert/ht-profile-image)

A Zend framework 2 module which adds profile image upload functionality to ZfcUser

## Requirement
* [Zend Framework 2](https://github.com/zendframework/zf2)
* [ZfcUser](https://github.com/ZF-Commons/ZfcUser)
* [HtImgModule](https://github.com/hrevert/HtImgModule)

## Features

* Setting Gravatar as alternative when user has not uploaded his image
* Setting gender wise default image when user has not uploaded his image
* Resizing options for storing
* Useful view helpers to get user images from view templates

## Installation
* Add `"hrevert/ht-profile-image": "2.3.*",` to your composer.json and run `php composer.phar update`
* Enable this module as `HtProfileImage` and `HtImgModule` in `config/application.config.php`
* Copy file located in `config/htprofileimage.global.php` to `./config/autoload/htprofileimage.global.php` and change the values as you wish
* Import the SQL schema located in `./vendor/hrevert/ht-profile-image//data/schema.sql` if you use want to use different default images for different genders.
 
Note: Also, checkout the options of `HtImgModule`.
 
## How To

Please check this [/docs](/docs) folder for more details on how to use this module.

## TODO
1. Ajax image upload
2. Improve tests
