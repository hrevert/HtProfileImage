<?php
    
namespace HtProfileImage\Options;

interface StorageOptionsInterface
{
    public function setUploadDirectory($uploadDirectory);

    public function getUploadDirectory();

    public function setStoredImageSize($storedImageSize);

    public function getStoredImageSize();

    public function setStorageResizer(array $storageResizer);

    public function getStorageResizer();
}
