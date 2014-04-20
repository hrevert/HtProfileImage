<?php
namespace HtProfileImageTest\Model;

use HtProfileImage\Model\StorageModel;
use HtProfileImage\Options\ModuleOptions;
use ZfcUser\Entity\User;

class StorageModelTest extends \PHPUnit_Framework_Testcase
{
    public function testGetUploadDirectory()
    {
        $options = new ModuleOptions(['upload_directory' => 'upload_directory']);
        $storageModel = new StorageModel($options);
        $this->assertEquals('upload_directory', $storageModel->getUploadDirectory());
    }

    public function testGetUserImage()
    {
        $options = new ModuleOptions(['upload_directory' => 'upload_directory']);
        $storageModel = new StorageModel($options);
        $user = new User;
        $user->setId(4);
        $this->assertEquals('upload_directory/4.png', $storageModel->getUserImage($user));
    }
}
