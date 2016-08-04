<?php

namespace PSRLinter\Tests\Rules;

use PhpParser\Node\Stmt;
use PSRLinter\Logger\Error;
use PSRLinter\Rules\FunctionRule;

class FunctionRuleTest extends \PHPUnit_Framework_TestCase
{
    public function testCamelCase()
    {
        $this->assertNull(FunctionRule::check(new Stmt\Function_("myFunction")));
        $this->assertNull(FunctionRule::check(new Stmt\Function_("myfunction")));
        $this->assertInstanceOf(Error::class, FunctionRule::check(new Stmt\Function_("Myfunction")));
        $this->assertInstanceOf(Error::class, FunctionRule::check(new Stmt\Function_("MyFunction")));
    }

    public function testError()
    {
        $error = new Error("Myfunction", "Function name is not in camel case format", Error::ERROR, -1);
        $this->assertEquals($error, FunctionRule::check(new Stmt\Function_("Myfunction")));
    }
}
