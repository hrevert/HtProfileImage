<?php

namespace HtProfileImage\View\Helper;

use Zend\View\Helper\AbstractHelper;

class DisplayUser extends AbstractHelper
{


    public function __invoke($user, $size = null)
    {
        $profileImage = $this->getView()->profileImage();
        if (is_int($user) || is_string($user)) {
            $user = $profileImage->getUser($user);
        }
        $imgUrl = $profileImage->__invoke($user, $size);
        $html .= $this->getView()->profileImage($type, $id, $gender); // retutrns <img src='url/to/image'/>
        $html .= "<br/>";
        $html .= "<span>";
        $html .= $this->getView()->escapeHtml($name);
        $html .= "</span>";
        return $html;         
    }    
}

