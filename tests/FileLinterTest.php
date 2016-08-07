<?php

namespace PSRLinter\Tests;

use PSRLinter\Exceptions\EmptyListOfFiles;
use PSRLinter\FileLinter;

class FileLinterTest extends \PHPUnit_Framework_TestCase
{
    private $fileLinter;

    public function setUp()
    {
        $this->fileLinter = new FileLinter();
    }

    public function testEmpty()
    {
        $this->expectException(EmptyListOfFiles::class);
        $this->fileLinter->lint("");
    }

    public function testEmptyDirectory()
    {
        $this->expectException(EmptyListOfFiles::class);
        $directory = __DIR__ . DIRECTORY_SEPARATOR . "Fixtures" . DIRECTORY_SEPARATOR . "Empty";
        $this->fileLinter->lint($directory);
    }

    public function testInvalidFile()
    {
        $this->expectException(EmptyListOfFiles::class);
        $pathFile = __DIR__ . DIRECTORY_SEPARATOR . "Fixtures" . DIRECTORY_SEPARATOR . "text.txt";
        $this->fileLinter->lint($pathFile);
    }

    public function testFile()
    {
        $pathFile = __DIR__ . DIRECTORY_SEPARATOR . "Fixtures" . DIRECTORY_SEPARATOR . "good.php";
        $reports = $this->fileLinter->lint($pathFile);
        $this->assertNotEquals([], $reports);
    }

    public function testDirectory()
    {
        $directory = __DIR__ . DIRECTORY_SEPARATOR . "Fixtures";
        $reports = $this->fileLinter->lint($directory);
        $this->assertNotEquals([], $reports);
    }
}
