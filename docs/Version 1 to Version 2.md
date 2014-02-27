Upgrading from version 1 to version 2
=======================================

A lot of changes have been made from version 1 to version 2. Some of the changes are listed [here](https://github.com/hrevert/HtProfileImage/releases/tag/v2.0.1-beta1).

## Removed Options:
1. storage_resizer
2. default_image_size
3. stored_image_size

## Added Options
1. enable_cache
2. storage_filter
3. display_filter

For more details, look [here](https://github.com/hrevert/HtProfileImage/blob/master/config/htprofileimage.global.php).

## Other Changes
1. `HtProfileImage\Controller\HtProfileImageController` has been renamed to `HtProfileImage\Controller\ProfileImageController`
2. `HtProfileImage\Service\ImageUpload` has been removed and `HtProfileImage\Service\ProfileImageService` has been added

We are extremely sorry but `change is progress`! 