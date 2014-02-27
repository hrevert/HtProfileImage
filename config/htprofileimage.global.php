<?php
/**
 * HtProfileImage Configuration
 *
 * If you have a ./config/autoload/ directory set up for your project, you can
 * drop this config file in it and change the values as you wish.
 */
$settings = array(
    /**
     * Upload Directory
     *
     * Please set directory where user images will be uploaded.
     * Donot forget to set appropriate permission for that directory
     */
    //'upload_directory' => 'data/uploads/profile-images',

    /**
     * Storage Filter
     *
     * Filter Alias for new uploading images
     * If you do not know filters, please see https://github.com/hrevert/HtImgModule/blob/master/docs/Filters%2C%20Filter%20Loaders%20And%20Filter%20Aliases.md
     */
    //'storage_filter' => 'htprofileimage_store,

    /**
     * Alternative when no image is found
     *
     * Whether or not to enable gravatar as alternative when no image is found
     * When a user has not uploaded his image
     *
     * Default value: true
     * Accepted values: boolean true or false
     */
    //'enable_gravatar_alternative' => true,

    /**
     * Alternative when no image is found
     *
     * Whether or not to set gender-wise default image
     * When gravatar is disabled and user has not uploaded his image
     *
     * Default value: false
     * Accepted values: boolean true or false
     */
    //'enable_gender' => false,

    /**
     * Alternative when no image is found
     *
     * Default image
     * When gravatar is disabled and user has not uploaded his image and gender-wise image is disabled
     *
     * Accepted values: "path/to/image.ext"
     */
    //'default_image' = '',

    /**
     * Alternative when no image is found
     *
     * Default image for male gender
     * When gravatar is disabled and user has not uploaded his image and gender-wise image is enabled
     *
     * Accepted values: "path/to/image.ext"
     */
    //'male_image' => '',

    /**
     * Alternative when no image is found
     *
     * Default image for female gender
     * When gravatar is disabled and user has not uploaded his image and gender-wise image is enabled
     *
     * Accepted values: "path/to/image.ext"
     */
    //'female_image' => '',

    /**
     * Display Filter
     *
     * Filter Alias for for display images
     * You can also pass this value from view helper(profileImage)
     */
    //'storage_filter' => 'htprofileimage_display,

    /**
     * Post Upload Route
     *
     * Route to redirect after a user has uploaded his/her image
     * Default value: 'zfcuser'
     * If set to null, user will not be redirected
     */
    //'post_upload_route' => 'zfcuser',

    /**
     * Enable Cache
     *
     * Do you want to store cache of filtered image in the web directory
     *
     * Default: value
     * Accepted Values: bool
     */
    // 'enable_cache' => true,
);

/**
 * You do not need to edit below this line
 */
return array(
    'htprofileimage' => $settings,
    'zfcuser' => array(
        'user_entity_class' => (isset($settings['enable_gender']) && $settings['enable_gender'] == true) ? "HtProfileImage\Entity\User" : "ZfcUser\Entity\User",
    )
);
