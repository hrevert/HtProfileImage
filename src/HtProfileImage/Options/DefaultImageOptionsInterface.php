<?php
namespace HtProfileImage\Options;

interface DefaultImageOptionsInterface
{
    public function setDefaultImage($defaultImage);

    public function getDefaultImage();

    public function setMaleImage($maleImage);

    public function getMaleImage();

    public function setFemaleImage($femaleImage);

    public function getFemaleImage();
}
