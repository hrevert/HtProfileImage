<?php
namespace HtProfileImage\Service;

use ZfcUser\Entity\UserInterface;
use Imagine\Image\ImageInterace;

interface CacheManagerInterface
{
    /**
     * Checks if cache exists
     *
     * @param UserInterface $user
     * @param string $filter
     * @return bool
     */
    public function cacheExists(UserInterface $user, $filter);

    /**
     * Gets url of a cache
     *
     * @param UserInterface $user
     * @param string $filter
     * @return string
     */
    public function getCacheUrl(UserInterface $user, $filter);
  
    /**
     * Gets path of a cache
     *
     * @param UserInterface $user
     * @param string $filter
     * @return string
     */
    public function getCachePath(UserInterface $user, $filter);  
    
    /**
     * Creates a new cache of image of a user
     *
     * @param UserInterface $user
     * @param string $filter
     * @param ImageInterace $image
     * @return void
     */
    public function createCache(UserInterface $user, $filter, ImageInterace $image);
    
    /**
     * Deletes a new of image of a user
     *
     * @param UserInterface $user
     * @param string $filter
     * @return bool
     */
    public function deleteCache(UserInterface $user, $filter);            
}
