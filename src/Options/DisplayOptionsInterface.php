<?php

namespace HtProfileImage\Options;

interface DisplayOptionsInterface
{
    public function getDisplayFilter();

    public function setDisplayFilter($displayFilter);

    public function getEnableGravatarAlternative();

    public function setEnableGravatarAlternative($enableGravatarAlternative);

    public function setEnableGender($enableGender);

    public function getEnableGender();

}
