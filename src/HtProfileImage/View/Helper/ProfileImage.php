<?php

namespace HtProfileImage\View\Helper;

use Zend\View\Helper\AbstractHtmlElement;
use ZfcUser\Mapper\UserInterface as UserMapperInterface;
use ZfcUser\Entity\UserInterface;
use HtProfileImage\Model\StorageModelInterface;
use HtProfileImage\Exception;
use HtProfileImage\Options\DisplayOptionsInterface;
use HtProfileImage\Service\CacheManagerInterface;

/**
 * This class gets image of a user
 * It is a view helper and called from view tempates
 */

class ProfileImage extends AbstractHtmlElement
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
     * @var UserInterface[]
     */
    protected $retrievedUsers = [];

    /**
     * @var StorageModelInterface
     */
    protected $storageModel;

    /**
     * @var CacheManagerInterface
     */
    protected $cacheManager;

    /**
     * @var string
     */
    protected $filterAlias;

    /**
     * Attributes for HTML image tag
     *
     * @var array
     */
    protected $attribs = [];

    /**
     * Constructor
     *
     * @var DisplayOptionsInterface $displayOptions
     * @var StorageModelInterface $storageModel
     * @var UserMapperInterface $userMapper
     */
    public function __construct(
        DisplayOptionsInterface $displayOptions,
        StorageModelInterface $storageModel,
        UserMapperInterface $userMapper
    )
    {
        $this->displayOptions = $displayOptions;
        $this->storageModel = $storageModel;
        $this->userMapper = $userMapper;
    }

    /**
     * Sets filterAlias
     *
     * @param string filterAlias
     * @return void
     */
    public function setFilterAlias($filterAlias)
    {
        $this->filterAlias = $filterAlias;
    }

    /**
     * Gets filterAlias
     *
     * @return filterAlias
     */
    public function getFilterAlias()
    {
        if (!$this->filterAlias) {
            $this->filterAlias = $this->displayOptions->getDisplayFilter();
        }

        return $this->filterAlias;
    }

    /**
     * gets StorageModelInterface
     * @return StorageModelInterface
     */
    protected function getStorageModel()
    {
        return $this->storageModel;
    }

    /**
     * gets DisplayOptionsInterface
     * @return DisplayOptionsInterface
     */
    protected function getDisplayOptions()
    {
        return $this->displayOptions;
    }

    /**
     * gets user from user_id
     * it only queries one time for a user
     * @param int $id (user_id)
     *
     * @return UserMapperInterface
     */
    protected function getUser($id)
    {
        if (!isset($this->retrievedUsers[$id])) {
            $user = $this->userMapper->findById($id);
            $this->retrievedUsers[$id] = $user;
        }

        return $this->retrievedUsers[$id];
    }

    /**
     * stores User data to prevent from querying to database
     * it only queries one time for a user
     *
     * @param  User $user
     * @return void
     */
    protected function setUser(UserInterface $user)
    {
        $this->retrievedUsers[$user->getId()] = $user;
    }

    public function setCacheManager(CacheManagerInterface $cacheManager)
    {
        $this->cacheManager = $cacheManager;
    }

    /**
     * Configure state
     *
     * @param  array $options
     * @return self
     */
    public function setOptions(array $options)
    {
        foreach ($options as $key => $value) {
            $method = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
            if (method_exists($this, $method)) {
                $this->{$method}($value);
            }
        }

        return $this;
    }

    /**
     * gets image of a user
     *
     * @param  User|int                        $user    (instance of User or user_id)
     * @param  array                           $options
     * @param  array                           $attribs
     * @return self|\Zend\View\Helper\Gravatar
     */
    public function __invoke($user, $attribs = null, $options = [])
    {
        $this->setOptions($options);
        if ($attribs !== null) {
            $this->setAttribs($attribs);
        }
        if (is_string($user) || is_int($user)) {
            $id = $user;
            $user = $this->getUser($id);
        } elseif ($user instanceof UserInterface) {
            $id = $user->getId();
            $this->setUser($user);
        } else {
            throw new Exception\InvalidArgumentException(
                sprintf(
                    '%s expects an instance of ZfcUser\Entity\UserInterface or integer(user_id) as 1st argument, %s provided instead',
                    __METHOD__,
                    is_object($user) ? get_class($user) : gettype($user)
                )
            );
        }

        if (!$this->getStorageModel()->userImageExists($user) &&
            $this->displayOptions->getEnableGravatarAlternative()
        ) {
            $this->getView()->gravatar()->setEmail($user->getEmail());
            $this->getView()->gravatar()->setAttribs($this->getAttribs());

            return $this->getView()->gravatar();
        }
        $filterAlias = $this->getFilterAlias();
        if (
            $this->cacheManager instanceof CacheManagerInterface &&
            $this->cacheManager->cacheExists($user, $filterAlias)
        ) {
            $url = $this->getView()->basePath() . '/' . $this->cacheManager->getCacheUrl($user, $filterAlias);
        } else {
            $url = $this->getView()->url('zfcuser/htimagedisplay', ['id' => $user->getId()]);
        }

        $this->setAttribs([
            'src' => $url
        ]);

        return $this;
    }

    /**
     * Return valid image tag
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getImgTag();
    }

    /**
     * Return valid HTML image tag
     *
     * @return string
     */
    public function getImgTag()
    {
        return '<img'
            . $this->htmlAttribs($this->getAttribs())
            . $this->getClosingBracket();
    }

    /**
     * Set attribs for image tag
     *
     * @param  array $attribs
     * @return self
     */
    public function setAttribs(array $attribs)
    {
        $this->attribs = $attribs;

        return $this;
    }

    /**
     * Get attribs of image
     *
     * @return array
     */
    public function getAttribs()
    {
        return $this->attribs;
    }
}
