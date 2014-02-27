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
}
