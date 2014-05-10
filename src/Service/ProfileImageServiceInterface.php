<?php
namespace HtProfileImage\Service;

use ZfcUser\Entity\UserInterface;

interface ProfileImageServiceInterface
{
    /**
     * Stores user image if valid
     *
     * @param  UserInterface $user
     * @param  array         $files
     * @return bool
     */
    public function storeImage(UserInterface $user, array $files);

    /**
     * Gets user image
     *
     * @param  UserInterface                 $user
     * @param  string                        $filterAlias Filter Alias
     * @return \Imagine\Image\ImageInterface
     */
    public function getUserImage(UserInterface $user, $filterAlias = null);

    /**
     * Deletes if user image exists
     *
     * @param  UserInterface $user
     * @return void
     */
    public function deleteUserImage(UserInterface $user);
}
