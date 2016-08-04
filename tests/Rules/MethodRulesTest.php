<?php

namespace PSRLinter\Tests\Rules;

use PhpParser\Node\Stmt;
use PSRLinter\Logger\Error;
use PSRLinter\Rules\MethodRule;

class MethodRulesTest extends \PHPUnit_Framework_TestCase
{
    public function testCamelCase()
    {
        $this->assertNull(MethodRule::check(new Stmt\ClassMethod("myFunction")));
        $this->assertNull(MethodRule::check(new Stmt\ClassMethod("myfunction")));
        $this->assertInstanceOf(Error::class, MethodRule::check(new Stmt\ClassMethod("Myfunction")));
        $this->assertInstanceOf(Error::class, MethodRule::check(new Stmt\ClassMethod("MyFunction")));
    }

    public function testError()
    {
        $error = new Error("Myfunction", "Method name is not in camel case format", Error::ERROR, -1);
        $this->assertEquals($error, MethodRule::check(new Stmt\ClassMethod("Myfunction")));
    }

    public function testMagicFunction()
    {
        $this->assertNull(MethodRule::check(new Stmt\ClassMethod("__call")));
        $this->assertNull(MethodRule::check(new Stmt\ClassMethod("__construct")));
    }
}
