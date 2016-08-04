<?php

namespace PSRLinter\Tests;

use PSRLinter\Utils;

class UtilsTest extends \PHPUnit_Framework_TestCase
{
    public function testGetFiles()
    {
        $files = [__DIR__ . "\\Fixtures\\bad.php", __DIR__ . "\\Fixtures\\good.php"];
        $this->assertEquals($files, Utils::getFiles(__DIR__ . "\\Fixtures"));
    }

    public function testGetRules()
    {
    }
}
