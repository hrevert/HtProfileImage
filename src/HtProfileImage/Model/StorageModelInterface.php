<?php
    
namespace HtProfileImage\Model;

use HtProfileImage\Options\StorageOptionsInterface;

interface StorageModelInterface
{
    public function getUploadDirectory();

    public function getUserImage($id);

    public function getUserImageExtension();

    public function getUserImageWithoutExtension($id);

    public function userImageExists($id);

    public function deleteUserImage($id);
}
