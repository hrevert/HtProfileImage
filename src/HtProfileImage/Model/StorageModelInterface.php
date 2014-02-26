<?php
    
namespace HtProfileImage\Model;

use HtProfileImage\Options\StorageOptionsInterface;
use ZfcUser\Entity\UserInterface;

interface StorageModelInterface
{
    public function getUploadDirectory();

    public function getUserImage(UserInterface $user);

    public function getUserImageExtension();

    public function getUserImageWithoutExtension(UserInterface $user);

    public function userImageExists(UserInterface $user);

    public function deleteUserImage(UserInterface $user);
}
