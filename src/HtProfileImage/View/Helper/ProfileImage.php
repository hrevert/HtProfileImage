<?php
    
namespace HtProfileImage\View\Helper;

use HtProfileImage\Options\DisplayOptionsInterface;
use Zend\View\Helper\Gravatar;
use ZfcUser\Mapper\User as UserMapper;
use HtProfileImage\Model\StorageModel;
use ZfcUser\Entity\User;

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


    public function __construct(DisplayOptionsInterface $displayOptions)
    {
        $this->displayOptions = $displayOptions;
    }

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

    protected function setUser(User $user)
    {
        $id = $user->getId();
        $this->retrievedUsers[$id] = $user;
    }

    public function __invoke($user, $options = array(), $attribs = array())
    {
        if (!isset($options['img_size'])) {
            $size = $this->getDisplayOptions()->getDefaultImageSize();
            $options['img_size'] = $size;
        } else {
            $size = $options['img_size'];
        }
        $this->setOptions($options);
        if (!empty($attribs)) {
            $this->setAttribs($attribs);
        }
        if (is_string($user) || is_int($user)) {
            $id = $user;
        } elseif($user instanceof User) {
            $id = $user->getId();
            $this->setUser($user);
        } else {
                throw new \InvalidArgumentException(
                    sprintf(
                        "%s expects an instance of ZfcUser\Entity\User or user_id as 1st argument",
                        __METHOD__
                    )
                );            
        }

        
        if(!$this->getStorageModel()->userImageExists($id) && $this->getDisplayOptions()->getEnableGravatarAlternative()) {
            $user = $this->getUser($id);
            $this->setEmail($user->getEmail());
            $url = $this->getAvatarUrl();
        } else {
            if ($this->getDisplayOptions()->getEnableGender()) {
                $user = $this->getUser($id);
                if (method_exists($user, 'getGender')) {
                    $params['gender'] = $user->getGender();
                }
            }
            $params = array('id' => $id, 'size' => $size);
            $url = $this->getView()->url('zfcuser/htimagedisplay', $params);
        }
        $this->setAttribs(array(
            'style' => "width:$size".'px'.";height:$size".'px'.";",
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
