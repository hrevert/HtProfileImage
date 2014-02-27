<?php

namespace HtProfileImage\Model;

use HtProfileImage\Options\StorageOptionsInterface;
use ZfcUser\Entity\UserInterface;

class StorageModel implements StorageModelInterface
{
    // extension of image
    const USER_IMAGE_EXTENSION = 'png';

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
     * Gets StorageOptionsInterface
     *
     * @return StorageOptionsInterface
     */
    public function getStorageOptions()
    {
        return $this->storageOptions;
    }

    /**
     * Gets upload directory where profile images are uploaded
     *
     * @return string
     */
    public function getUploadDirectory()
    {
        return $this->getStorageOptions()->getUploadDirectory();
    }

    /**
     * Gets path to image of a user
     *
     * @param  UserInterface $user
     * @return string
     */
    public function getUserImage(UserInterface $user)
    {
         return $this->getUserImageWithoutExtension($user) . '.' . $this->getUserImageExtension();
    }

    /**
     * Gets extension with which a user image is saved
     *
     * @return string
     */
    public function getUserImageExtension()
    {
        return static::USER_IMAGE_EXTENSION;
    }

    /**
     * Gets path to image of a user(without extension(png))
     *
     * @return string
     */
    public function getUserImageWithoutExtension(UserInterface $user)
    {
        return $this->getUploadDirectory() . '/' . $user->getId();
    }

    /**
     * Checks if user has uploaded his image(check if user image exists)
     *
     * @param  UserInterface $user
     * @return bool
     */
    public function userImageExists(UserInterface $user)
    {
        return is_readable($this->getUserImage($user));
    }

    /**
     * Deletes if user image exists
     *
     * @param  UserInterface $user
     * @return void
     */
    public function deleteUserImage(UserInterface $user)
    {
        $file = $this->getUserImage($user);
        if (is_readable($file)) {
            unlink($file);
        }
    }

}
