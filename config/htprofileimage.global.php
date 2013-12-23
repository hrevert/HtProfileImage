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
     * Default Image Size
     *
     * Default size of image rendered in view templates
     * You can also pass this value from view helper(profileImage)
     *
     * Default value: 80
     * Accepted values: size (in pixel) 
     */
    //'default_image_size' => 80,

    /**
     * Size of image to store
     *
     * The size of image(of newly uploaded images) to store 
     *
     * Default value: 160
     * Accepted values: size (in pixel) 
     */
    //'stored_image_size' => 160,

    /**
     * Alternative when no image is found
     *
     * Whether or not to enable gravatar as alternative when no image is found
     * When a user has not uploaded his image
     *
     * Default value: true
     * Accepted values: boolean true or false
     */
    //'enableGravatarAlternative' => true,

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
     * Crop image or not
     *
     * Whether or not to crop image when called from view helper(profileImage)
     *
     * Default value: true
     * Accepted values: boolean true or false
     */
    //'serve_cropped_image' => true
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
