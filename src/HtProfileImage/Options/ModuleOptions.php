<?php
    
namespace HtProfileImage\Options;

use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions
{
    protected $uploadDirectory = "data/uploads/profile-images";

    protected $defaultImageSize = 100;

    protected $storedImageSize = 160;

    protected $enableGender = true;

    protected $defaultImage;

    protected $maleImage;

    protected $femaleImage;

    public function setUploadDirectory($uploadDirectory)
    {
        $this->uploadDirectory = $uploadDirectory;
    }

    public function getUploadDirectory()
    {
        return $this->uploadDirectory;
    }

    public function setStoredImageSize($storedImageSize)
    {
        $this->storedImageSize = $storedImageSize;
    }

    public function getStoredImageSize()
    {
        return $this->storedImageSize;
    }

    public function setDefaultImageSize($defaultImageSize)
    {
        $this->defaultImageSize = $defaultImageSize;
    }

    public function getDefaultImageSize()
    {
        return $this->defaultImageSize;
    }

    public function setEnableGender($enableGender)
    {
        $this->enableGender = $enableGender;
    }

    public function getEnableGender()
    {
        return $this->enableGender;
    }

    public function setDefaultImage($defaultImage)
    {
        $this->defaultImage = $defaultImage;
    }

    public function getDefaultImage()
    {
        return $this->defaultImage;
    }

    public function setMaleImage($maleImage)
    {
        $this->maleImage = $maleImage;
    }

    public function getMaleImage()
    {
        return $this->maleImage;
    }

    public function setFemaleImage($femaleImage)
    {
        $this->femaleImage = $femaleImage;
    }

    public function getFemaleImage()
    {
        return $this->femaleImage;
    }
}

