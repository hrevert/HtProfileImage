<?php
    
namespace HtProfileImage\Options;

interface DisplayOptionsInterface
{
    public function setDefaultImageSize($defaultImageSize);

    public function getDefaultImageSize();

    public function getEnableGravatarAlternative();

    public function setEnableGravatarAlternative($enableGravatarAlternative);

    /*
    public function setServeCroppedImage($serveCroppedImage);

    public function getServeCroppedImage();

    public function getMaleImage();

    public function getFemaleImage();

    public function setMaleImage($maleImage);

    public function setFemaleImage($femaleImage);*/


}