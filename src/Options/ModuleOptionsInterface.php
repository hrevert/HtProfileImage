<?php
namespace HtProfileImage\Options;

interface ModuleOptionsInterface extends
    DisplayOptionsInterface,
    StorageOptionsInterface,
    DefaultImageOptionsInterface,
    CacheOptionsInterface
{
    public function setPostUploadRoute($postUploadRoute);

    public function getPostUploadRoute();

    public function setMaxImageFileSize($maxImageFileSize);

    public function getMaxImageFileSize();

    public function setEnableInterUserImageUpload($enableInterUserImageUpload);

    public function getEnableInterUserImageUpload();

    public function setEnableImageDelete($enableImageDelete);

    public function getEnableImageDelete();

    public function setPostImageDeleteRoute($postImageDeleteRoute);

    public function getPostImageDeleteRoute();
}
