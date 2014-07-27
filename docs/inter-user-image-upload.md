Inter User Image Upload
=================================
This module comes with an interesting option, `enable_inter_user_image_upload` which means whether or not to allow one user to upload other user's image. This is false by default. If you enable this, beware that any user can upload any user's image.
This option was added with flexibility in mind. In some applications, you may need to allow (so called) admin users to upload any user's image. This can be accomplished by enabling this option and listening to an event to check if the identity has access.
```php
<?php

namespace Application;

use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $app = $e->getApplication();
        $sharedManager = $app->getEventManger()->getSharedManger();
        $sharedManager->attach('HtProfileImage\Service\ProfileImageService', 'storeImage', function ($event) {
            $user = $event->getParam('user');
            // Now, check if the identity has access to this user
        });
    }
}

```

If you use [ZfcRbac](https://github.com/ZF-Commons/zfc-rbac), you can do something like this:
```php
<?php

namespace Application;

use Zend\Mvc\MvcEvent;
use ZfcRbac\Exception\UnauthorizedExcetion;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $app = $e->getApplication();
        $sharedManager = $app->getEventManger()->getSharedManger();
        $sharedManager->attach('HtProfileImage\Service\ProfileImageService', 'storeImage', function ($event) {
            $user = $event->getParam('user');
            $authorizationService = $app->getServiceManager()->get('ZfcRbac\Service\AuthorizationService');
            if (!$authorizationService->isGranted('user.image.upload', $user)) {
                throw new UnauthorizedExcetion('You are not allowed');
            }
        });
    }
}

```
