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

    public function testLintEmpty()
    {
        $this->expectException(EmptyListOfFiles::class);
        $this->fileLinter->lint("");
    }

    public function testFixEmpty()
    {
        $this->expectException(EmptyListOfFiles::class);
        $this->fileLinter->fix("");
    }

    public function testLintEmptyDirectory()
    {
        $this->expectException(EmptyListOfFiles::class);
        $directory = __DIR__ . DIRECTORY_SEPARATOR . "Fixtures" . DIRECTORY_SEPARATOR . "Empty";
        $this->fileLinter->lint($directory);
    }

    public function testFixEmptyDirectory()
    {
        $this->expectException(EmptyListOfFiles::class);
        $directory = __DIR__ . DIRECTORY_SEPARATOR . "Fixtures" . DIRECTORY_SEPARATOR . "Empty";
        $this->fileLinter->fix($directory);
    }

    public function testLintInvalidFile()
    {
        $this->expectException(EmptyListOfFiles::class);
        $pathFile = __DIR__ . DIRECTORY_SEPARATOR . "Fixtures" . DIRECTORY_SEPARATOR . "text.txt";
        $this->fileLinter->lint($pathFile);
    }

    public function testFixInvalidFile()
    {
        $this->expectException(EmptyListOfFiles::class);
        $pathFile = __DIR__ . DIRECTORY_SEPARATOR . "Fixtures" . DIRECTORY_SEPARATOR . "text.txt";
        $this->fileLinter->fix($pathFile);
    }

    public function testLintFile()
    {
        $pathFile = __DIR__ . DIRECTORY_SEPARATOR . "Fixtures" . DIRECTORY_SEPARATOR . "good.php";
        $reports = $this->fileLinter->lint($pathFile);
        $this->assertNotEquals([], $reports);
    }

    public function testLintDirectory()
    {
        $directory = __DIR__ . DIRECTORY_SEPARATOR . "Fixtures";
        $reports = $this->fileLinter->lint($directory);
        $this->assertNotEquals([], $reports);
    }
}
