<?php
namespace HtProfileImage\Service;

use ZfcUser\Entity\UserInterface;
use HtProfileImage\Form\ProfileImageForm;

interface ProfileImageServiceInterface
{
    public function uploadImage(UserInterface $user, array $files);
}
