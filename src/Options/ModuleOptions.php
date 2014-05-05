<?php

namespace HtProfileImage\Options;

use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions implements ModuleOptionsInterface
{
    protected $uploadDirectory = 'data/uploads/profile-images';

    protected $storageFilter = 'htprofileimage_store';

    protected $enableGender = false;

    protected $defaultImage;

    protected $maleImage;

    protected $femaleImage;

    protected $enableGravatarAlternative = true;

    protected $displayFilter  = 'htprofileimage_display';

    protected $postUploadRoute = 'zfcuser';

    protected $enableCache = true;

    protected $displayFilterList = ['htprofileimage_display'];

    protected $maxImageFileSize = '10MB';

    protected $enableInterUserImageUpload = false;

    protected $enableImageDelete = false;

    protected $postImageDeleteRoute = 'zfcuser';

    public function setUploadDirectory($uploadDirectory)
    {
        $this->uploadDirectory = $uploadDirectory;
    }

    public function getUploadDirectory()
    {
        return $this->uploadDirectory;
    }

    public function setStorageFilter($storageFilter)
    {
        $this->storageFilter = $storageFilter;
    }

    public function getStorageFilter()
    {
        return $this->storageFilter;
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

    public function setDisplayFilter($displayFilter)
    {
        $this->displayFilter = $displayFilter;
    }

    public function getDisplayFilter()
    {
        return $this->displayFilter;
    }

    public function setPostUploadRoute($postUploadRoute)
    {
        $this->postUploadRoute = $postUploadRoute;
    }

    public function getPostUploadRoute()
    {
        return $this->postUploadRoute;
    }

    public function setEnableCache($enableCache)
    {
        $this->enableCache = $enableCache;
    }

    public function getEnableCache()
    {
        return $this->enableCache;
    }

    public function setDisplayFilterList(array $displayFilterList)
    {
        $this->displayFilterList = $displayFilterList;
    }

    public function getDisplayFilterList()
    {
        return $this->displayFilterList;
    }

    public function setMaxImageFileSize($maxImageFileSize)
    {
        $this->maxImageFileSize = $maxImageFileSize;
    }

    public function getMaxImageFileSize()
    {
        return $this->maxImageFileSize;
    }

    public function setEnableInterUserImageUpload($enableInterUserImageUpload)
    {
        $this->enableInterUserImageUpload = (bool) $enableInterUserImageUpload;
    }

    public function getEnableInterUserImageUpload()
    {
        return $this->enableInterUserImageUpload;
    }

    public function setEnableImageDelete($enableImageDelete)
    {
        $this->enableImageDelete = (bool) $enableImageDelete;
    }

    public function getEnableImageDelete()
    {
        return $this->enableImageDelete;
    }

    public function setPostImageDeleteRoute($postImageDeleteRoute)
    {
        $this->postImageDeleteRoute = $postImageDeleteRoute;
    }

    public function getPostImageDeleteRoute()
    {
        return $this->postImageDeleteRoute;
    }
}
