Access user image path
========================

This is actually very easy:

From ServiceLocatorAware Classes, you can do

```php
$imagePath = $this->getServiceLocator()->get('HtProfileImage\StorageModel')->getUserImage($user);
```
To check if user image exists:
```php
$exists = $this->getServiceLocator()->get('HtProfileImage\StorageModel')->userImageExists($user);
// will return boolean (true or false)
```