<?php

namespace HtProfileImage\Model;

use HtProfileImage\Options\StorageOptionsInterface;

class StorageModel implements StorageModelInterface
{
    // extension of image
    const USER_IMAGE_EXTENSION = "png";

    /**
     * @var StorageOptionsInterface
     */
    protected $storageOptions;

    /**
     * Constructor
     *
     * @param $storageOptions StorageOptionsInterface
     * @return void
     */
    public function __construct(StorageOptionsInterface $storageOptions)
    {
        $this->storageOptions = $storageOptions;
    }

    /**
     * gets StorageOptionsInterface
     * @return StorageOptionsInterface
     */
    public function getStorageOptions()
    {
        return $this->storageOptions;
    }

    /**
     * gets upload directory where profile images are uploaded
     * @return string
     */
    public function getUploadDirectory()
    {
        return $this->getStorageOptions()->getUploadDirectory();
    }

    /**
     * gets path to image of a user
     * @return string
     */
    public function getUserImage($id)
    {
         return $this->getUserImageWithoutExtension($id).'.'.$this->getUserImageExtension();
    }


    /**
     * gets extension with which a user image is saved
     * @return string
     */
    public function getUserImageExtension()
    {
        return static::USER_IMAGE_EXTENSION;
    }

    /**
     * gets path to image of a user(without extension(png))
     * @return string
     */
    public function getUserImageWithoutExtension($id)
    {
        return $this->getUploadDirectory().'/'.$id;
    }

    /**
     * checks if user has uploaded his image(check if user image exists)
     * @param int $id
     * @return bool
     */
    public function userImageExists($id)
    {
        return is_readable($this->getUserImage($id));
    }

    /**
     * deletes if user image exists
     * @param int $id
     * @return void
     */
    public function deleteUserImage($id)
    {
        $file = $this->getUserImage($id);
        if (is_readable($file)) {
            unlink($file);
        }
    }

}
