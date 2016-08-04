<?php

namespace PSRLinter\Tests;

use PSRLinter\Utils;

class UtilsTest extends \PHPUnit_Framework_TestCase
{
    public function testGetFiles()
    {
        $files = [
            __DIR__ . DIRECTORY_SEPARATOR . "Fixtures" . DIRECTORY_SEPARATOR . "bad.php",
            __DIR__ . DIRECTORY_SEPARATOR . "Fixtures" . DIRECTORY_SEPARATOR . "good.php"
        ];
        $this->assertEquals($files, Utils::getFiles(__DIR__ . DIRECTORY_SEPARATOR . "Fixtures"));
    }

    public function testGetRules()
    {
    }
}
