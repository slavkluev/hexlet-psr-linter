<?php

namespace PSRLinter\Tests\Report;

use PSRLinter\Report\Error;
use PSRLinter\Report\Report;

class ReportTest extends \PHPUnit_Framework_TestCase
{
    private $logger;
    private $errors = [];

    public function setUp()
    {
        $this->logger = new Report();

        $this->errors[] = new Error("test", "", Error::LEVEL_WARNING, 1);
        $this->errors[] = new Error("test", "", Error::LEVEL_ERROR, 1);
        $this->errors[] = new Error("test", "", Error::LEVEL_WARNING, 1);

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
