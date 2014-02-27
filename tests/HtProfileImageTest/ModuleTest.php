<?php
namespace HtProfileImageTest;

use HtProfileImage\Module;

class ModuleTest extends \PHPUnit_Framework_Testcase
{
    public function testConfigIsArray()
    {
        $module = new Module();
        $this->assertInternalType('array', $module->getConfig());
        $this->assertInternalType('array', $module->getServiceConfig());
        $this->assertInternalType('array', $module->getViewHelperConfig());
    }
}
