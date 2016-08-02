<?php

namespace PSRLinter;

class LinterTest extends \PHPUnit_Framework_TestCase
{
    public function testGetName()
    {
        $name = "John";
        $linter = new Linter($name);

        $this->assertEquals($name, $linter->getName());
    }
}
