<?php
namespace HtProfileImageTest\Options;

use HtProfileImage\Options\ModuleOptions;

class ModuleOptionsTest extends \PHPUnit_Framework_Testcase
{
    public function testSettersAndGetters()
    {
        $options = new ModuleOptions([
            'upload_directory' => 'random/path',
            'storage_filter' => 'storage_filter',
            'enable_gravatar_alternative' => false,
            'enable_gender' => true,
            'default_image' => 'abcd',
            'male_image' => 'male_image',
            'female_image' => 'female_image',
            'display_filter' => 'display_filter',
            'post_upload_route' => 'post_upload_route',
            'enable_cache' => false,
        ]);
        $this->assertEquals('random/path', $options->getUploadDirectory());
        $this->assertEquals('storage_filter', $options->getStorageFilter());
        $this->assertEquals(true, $options->getEnableGender());
        $this->assertEquals('abcd', $options->getDefaultImage());
        $this->assertEquals('male_image', $options->getMaleImage());
        $this->assertEquals('female_image', $options->getFemaleImage());
        $this->assertEquals(false, $options->getEnableGravatarAlternative());
        $this->assertEquals('display_filter', $options->getDisplayFilter());
        $this->assertEquals('post_upload_route', $options->getPostUploadRoute());
        $this->assertEquals(false, $options->getEnableCache());

    }

    public function testDefaultOptions()
    {
        $options = new ModuleOptions();
        $this->assertEquals('data/uploads/profile-images', $options->getUploadDirectory());
        $this->assertEquals('htprofileimage_store', $options->getStorageFilter());
        $this->assertEquals(false, $options->getEnableGender());
        $this->assertEquals(null, $options->getDefaultImage());
        $this->assertEquals(null, $options->getMaleImage());
        $this->assertEquals(null, $options->getFemaleImage());
        $this->assertEquals(true, $options->getEnableGravatarAlternative());
        $this->assertEquals('htprofileimage_display', $options->getDisplayFilter());
        $this->assertEquals('zfcuser', $options->getPostUploadRoute());
        $this->assertEquals(true, $options->getEnableCache());
    }
}
