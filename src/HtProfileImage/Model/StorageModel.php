<?php

namespace HtProfileImage\Model;

use HtProfileImage\Options\StorageOptionsInterface;

class StorageModel
{
    // extension of image
    const USER_IMAGE_EXTENSION = "png";

    /**
    * @var StorageOptionsInterface
    */
    protected $storageOptions;

    
    public function __construct(StorageOptionsInterface $storageOptions)
    {
        $this->storageOptions = $storageOptions;
    }

    public function getStorageOptions()
    {
        return $this->storageOptions;
    }

    public function getUploadDirectory()
    {
        return $this->getStorageOptions()->getUploadDirectory();
    }

    public function getUserImage($id)
    {
         return $this->getUserImageWithoutExtension($id).'.'.$this->getUserImageExtension();
    }

    public function getUserImageExtension()
    {
        return static::USER_IMAGE_EXTENSION;
    }

    public function getUserImageWithoutExtension($id)
    {
        return $this->getUploadDirectory().'/'.$id;
    }

    public function userImageExists($id)
    {
        return is_readable($this->getUserImage($id));
    }

    public function deleteUserImage($id)
    {
        $file = $this->getUserImage($id);
        if (is_readable($file)) {
            unlink($file);
        }
    }

}
