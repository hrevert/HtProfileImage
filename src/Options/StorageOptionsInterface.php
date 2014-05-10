<?php

namespace HtProfileImage\Options;

interface StorageOptionsInterface
{
    public function setUploadDirectory($uploadDirectory);

    public function getUploadDirectory();

    public function setStorageFilter($storageFilter);

    public function getStorageFilter();

    public function setEnableImageDelete($enableImageDelete);

    public function getEnableImageDelete();
}
