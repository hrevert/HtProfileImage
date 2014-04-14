HtProfileImage
==============
[![Master Branch Build Status](https://api.travis-ci.org/hrevert/HtProfileImage.png?branch=master)](http://travis-ci.org/hrevert/HtProfileImage)
[![Latest Stable Version](https://poser.pugx.org/hrevert/ht-profile-image/v/stable.png)](https://packagist.org/packages/hrevert/ht-profile-image)
[![Latest Unstable Version](https://poser.pugx.org/hrevert/ht-profile-image/v/unstable.png)](https://packagist.org/packages/hrevert/ht-profile-image)
[![Total Downloads](https://poser.pugx.org/hrevert/ht-profile-image/downloads.png)](https://packagist.org/packages/hrevert/ht-profile-image)

A Zend framework 2 module which adds profile image upload functionality to ZfcUser

## Features

* Setting Gravatar as alternative when user has not uploaded his image
* Setting gender wise default image when user has not uploaded his image
* Resizing options for storing
* Useful view helpers to get user images from view templates

## Installation
* Add `"hrevert/ht-profile-image": "2.0.*",` to your composer.json and run `php composer.phar update`
* Execute the sql commando in `data/mysql.sql`
* Enable this module in `config/application.config.php`
* Copy file located in `config/htprofileimage.global.php` to `./config/autoload/htprofileimage.global.php` and change the values as you wish

## How To

Please check this [wiki](https://github.com/hrevert/HtProfileImage/wiki) for more details on how to use this module.

## TODO
1. Ajax image upload
2. Improve tests
