<?php

namespace PSRLinter\Tests\Rules;

use PhpParser\Node\Expr\Variable;
use PSRLinter\Logger\Error;
use PSRLinter\Rules\VariableRule;

class VariableRuleTest extends \PHPUnit_Framework_TestCase
{
    public function testCamelCase()
    {
        $this->assertNull(VariableRule::check(new Variable("myVariable")));
        $this->assertNull(VariableRule::check(new Variable("myvariable")));
        $this->assertInstanceOf(Error::class, VariableRule::check(new Variable("Myvariable")));
        $this->assertInstanceOf(Error::class, VariableRule::check(new Variable("MyVariable")));
        $this->assertInstanceOf(Error::class, VariableRule::check(new Variable("my_variable")));
    }

    public function testError()
    {
        $error = new Error("my_var", "Variable name is not in camel case format", Error::WARNING, -1);
        $this->assertEquals($error, VariableRule::check(new Variable("my_var")));
    }
}
