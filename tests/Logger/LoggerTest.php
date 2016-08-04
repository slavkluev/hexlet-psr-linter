<?php

namespace PSRLinter\Tests\Logger;

use PSRLinter\Logger\Error;
use PSRLinter\Logger\Logger;

class LoggerTest extends \PHPUnit_Framework_TestCase
{
    private $logger;
    private $errors = [];

    public function setUp()
    {
        $this->logger = new Logger();

        $this->errors[] = new Error("test", "", Error::WARNING, 1);
        $this->errors[] = new Error("test", "", Error::ERROR, 1);
        $this->errors[] = new Error("test", "", Error::WARNING, 1);

        foreach ($this->errors as $error) {
            $this->logger->addError($error);
        }
    }

    public function testCountOfErrors()
    {
        $this->assertEquals(1, $this->logger->getCountOfErrors());
    }

    public function testCountOfWarnings()
    {
        $this->assertEquals(2, $this->logger->getCountOfWarnings());
    }

    public function testCountOfProblems()
    {
        $this->assertEquals(3, $this->logger->getCountOfProblems());
    }

    public function testGetErrors()
    {
        $this->assertEquals($this->errors, $this->logger->getErrors());
    }
}
