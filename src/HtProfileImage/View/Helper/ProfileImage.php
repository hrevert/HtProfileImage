<?php
    
namespace HtProfileImage\View\Helper;

use HtProfileImage\Options\DisplayOptionsInterface;
use Zend\View\Helper\Gravatar;
use ZfcUser\Mapper\User as UserMapper;
use HtProfileImage\Model\StorageModel;

class ProfileImage extends Gravatar
{

    /**
    * @var DisplayOptionsInterface
    */
    protected $displayOptions;

    /**
    * @var UserMapper
    */
    protected $userMapper;

    /**
    * @array whose elements are elements are instance of \ZfcUser\Entity\User
    */
    protected $retrievedUsers = array();

    /**
    * @var StorageModel
    */
    protected $storageModel;

    /**
    * set StorageModel 
    * @param $storageModel StorageModel
    */
    public function setStorageModel(StorageModel $storageModel)
    {
        $this->storageModel = $storageModel;
    }
    
    public function getStorageModel()
    {
        return $this->storageModel;
    }

    public function setDisplayOptions(DisplayOptionsInterface $displayOptions)
    {
        $this->displayOptions = $displayOptions;
    }

    public function getDisplayOptions()
    {
        return $this->displayOptions;
    }


    public function setUserMapper(UserMapper $userMapper)
    {
        $this->userMapper = $userMapper;
    }

    public function getUserMapper()
    {
        return $this->userMapper;
    }

    public function getUser($id)
    {
        if (!isset($this->retrievedUsers[$id])) {
            $user = $this->getUserMapper()->findById($id);
            $this->retrievedUsers[$id] = $user;
        }

        return $this->retrievedUsers[$id];
    }

    public function __invoke($user, $options = array(), $attribs = array())
    {
        if (!isset($options['img_size'])) {
            $size = $this->getDisplayOptions()->getDefaultImageSize();
        } else {
            $size = $options['img_size'];
        }
        if (!empty($options)) {
            $this->setOptions($options);
        }
        if (!empty($attribs)) {
            $this->setAttribs($attribs);
        }
        if (is_string($user) || is_int($user)) {
            $id = $user;
            $user = $this->getUser($id);
            if (!$user) {
                throw new \InvalidArgumentException(
                    sprintf(
                        "%s expects an instance of ZfcUser\Entity\User or user_id as 1st argument",
                        __METHOD__
                    )
                );
            }
        }

        $id = $user->getId();
        if(!$this->getStorageModel()->userImageExists($id) && $this->getDisplayOptions()->getEnableGravatarAlternative()) {
            
            return $this->getView()->gravatar($user->getEmail(), $options, $attribs);
        } else {
            $params = array('id' => $user->getId(), 'size' => $size);
            if (method_exists($user, 'getGender')) {
                $params['gender'] = $user->getGender();
            }
            $url = $this->getView()->url('zfcuser/htimagedisplay', $params);
        }
        $this->setAttribs(array(
            'style' => "width:$size;height:$size;",
            'src' => $url
        ));
        return $this;
    }

    /**
     * Return valid image tag
     *
     * @return string
     */
    public function getImgTag()
    {
        $html = '<img'
            . $this->htmlAttribs($this->getAttribs())
            . $this->getClosingBracket();

        return $html;
    }
}
