Access image from view templates
===================================

This wiki will show you how to access image from view templates.

Here, is the syntax:
```php
echo $this->htProfileImage($user, $attributes, $options);
```
Where,

1. `$user` is the instance of user entity class of ZfcUser

2. `$attributes` is an associative array of attributes to apply to `img` element. (optional)

3. `$options` is associative array of options (optional)


For Example,
```php
echo $this->htProfileImage($this->zfcUserIdentity(), array('class' => 'my-awesome-class'), array('filter' => 'my-awesome-filter')); // 
```
Note: if filter is not provided, then [this](https://github.com/hrevert/HtProfileImage/blob/master/config/htprofileimage.global.php#L83) will be used as default

This will output something similiar to 
```php
<img src='url/of/image' class='my-awesome-class'>
```
When, you only have `user_id`, you can also access the image, such as 
```php
echo $this->htProfileImage($userId);
```
