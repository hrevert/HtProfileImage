<?php
    
namespace HtProfileImage\Options;

use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions implements 
    StorageOptionsInterface, 
    DisplayOptionsInterface
{
    protected $uploadDirectory = "data/uploads/profile-images";

    protected $defaultImageSize = 80;

    protected $storedImageSize = 200;

    protected $storageResizer = false;

    protected $enableGender = false;

    protected $defaultImage;

    protected $maleImage;

    protected $femaleImage;

    protected $enableGravatarAlternative = true;

    protected $serveCroppedImage  = true;

    protected $postUploadRoute = 'zfcuser';

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

    public function setStorageResizer(array $storageResizer)
    {
        $this->storageResizer = $storageResizer;
    }

    public function getStorageResizer()
    {
        return $this->storageResizer;
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
        $this->enableGender = (bool) $enableGender;
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

    public function getEnableGravatarAlternative()
    {
        return $this->enableGravatarAlternative;
    }

    public function setEnableGravatarAlternative($enableGravatarAlternative) 
    {
        $this->enableGravatarAlternative = (bool) $enableGravatarAlternative;
    }

    public function setServeCroppedImage($serveCroppedImage)
    {
        $this->serveCroppedImage = $serveCroppedImage;
    }

    public function getServeCroppedImage()
    {
        return $this->serveCroppedImage;
    }

    public function setPostUploadRoute($postUploadRoute)
    {
        $this->postUploadRoute = $postUploadRoute;
    }

    public function getPostUploadRoute()
    {
        return $this->postUploadRoute;
    }
}
