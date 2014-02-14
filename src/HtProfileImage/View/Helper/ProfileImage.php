<?php
    
namespace HtProfileImage\View\Helper;

use HtProfileImage\Options\DisplayOptionsInterface;
use Zend\View\Helper\Gravatar;
use ZfcUser\Mapper\UserInterface as UserMapperInterface;
use HtProfileImage\Model\StorageModelInterface;
use ZfcUser\Entity\UserInterface;
use HtProfileImage\Exception;

/**
 * This class gets image of a user
 * It is a view helper and called from view tempates
 */

class ProfileImage extends Gravatar
{

    /**
    * @var DisplayOptionsInterface
    */
    protected $displayOptions;

    /**
    * @var UserMapperInterface
    */
    protected $userMapper;

    /**
    * @array whose elements are elements are instance of \ZfcUser\Entity\UserInterface
    */
    protected $retrievedUsers = array();

    /**
    * @var StorageModelInterface
    */
    protected $storageModel;


    public function __construct(DisplayOptionsInterface $displayOptions)
    {
        $this->displayOptions = $displayOptions;
    }

    /**
    * set StorageModelInterface 
    * @param $storageModel StorageModelInterface
    */
    public function setStorageModel(StorageModelInterface $storageModel)
    {
        $this->storageModel = $storageModel;
    }

    /**
     * gets StorageModelInterface 
     * @return StorageModelInterface
     */    
    public function getStorageModel()
    {
        return $this->storageModel;
    }

    /**
     * gets DisplayOptionsInterface 
     * @return DisplayOptionsInterface
     */ 
    public function getDisplayOptions()
    {
        return $this->displayOptions;
    }

    /**
     * sets UserMapperInterface
     * @param UserMapperInterface $userMapper
     * @return void
     */ 
    public function setUserMapper(UserMapperInterface $userMapper)
    {
        $this->userMapper = $userMapper;
    }

    /**
     * gets UserMapperInterface
     * @return UserMapperInterface
     */
    public function getUserMapper()
    {
        return $this->userMapper;
    }

    /**
     * gets user from user_id
     * it only queries one time for a user
     * @param int $id (user_id)
     *
     * @return UserMapperInterface
     */
    public function getUser($id)
    {
        if (!isset($this->retrievedUsers[$id])) {
            $user = $this->getUserMapper()->findById($id);
            $this->retrievedUsers[$id] = $user;
        }

        return $this->retrievedUsers[$id];
    }

    /**
     * stores User data to prevent from querying to database
     * it only queries one time for a user
     *
     * @param User $user 
     * @return void
     */
    protected function setUser(UserInterface $user)
    {
        $id = $user->getId();
        $this->retrievedUsers[$id] = $user;
    }

    /**
     * gets image of a user
     *
     * @param User|int $user (instance of User or user_id)
     * @param array $options
     * @param array $attribs      
     * @return self
     */
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
        } elseif($user instanceof UserInterface) {
            $id = $user->getId();
            $this->setUser($user);
        } else {
                throw new Exception\InvalidArgumentException(
                    sprintf(
                        "%s expects an instance of ZfcUser\Entity\UserInterface or user_id as 1st argument",
                        __METHOD__
                    )
                );            
        }

        
        if(!$this->getStorageModel()->userImageExists($id) && $this->getDisplayOptions()->getEnableGravatarAlternative()) {
            $user = $this->getUser($id);
            $this->setEmail($user->getEmail());
            $url = $this->getAvatarUrl();
        } else {
            $params = array('id' => $id, 'size' => $size);
            if ($this->getDisplayOptions()->getEnableGender()) {
                $user = $this->getUser($id);
                if (method_exists($user, 'getGender')) {
                    $params['gender'] = $user->getGender();
                }
            }
            $url = $this->getView()->url('zfcuser/htimagedisplay', $params);
        }
        $this->setAttribs(array(
            'style' => "width:$size" . "px;height:$size" . 'px;',
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
