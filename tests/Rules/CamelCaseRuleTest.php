<?php

namespace PSRLinter\Tests\Rules;

use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt;
use PSRLinter\Report\Error;
use PSRLinter\Rules\CamelCaseRule;

class CamelCaseRuleTest extends \PHPUnit_Framework_TestCase
{
    private $rule;

    public function setUp()
    {
        $this->rule = new CamelCaseRule();
    }

    public function testFunctionCamelCase()
    {
        $this->assertNull($this->rule->check(new Stmt\Function_("myFunction")));
        $this->assertNull($this->rule->check(new Stmt\Function_("myfunction")));
        $this->assertInstanceOf(Error::class, $this->rule->check(new Stmt\Function_("Myfunction")));
        $this->assertInstanceOf(Error::class, $this->rule->check(new Stmt\Function_("MyFunction")));
    }

    public function testFunctionError()
    {
        $error = new Error("Myfunction", "Function name is not in camel case format", Error::LEVEL_ERROR, -1);
        $this->assertEquals($error, $this->rule->check(new Stmt\Function_("Myfunction")));
    }

    public function testMethodCamelCase()
    {
        $this->assertNull($this->rule->check(new Stmt\ClassMethod("myFunction")));
        $this->assertNull($this->rule->check(new Stmt\ClassMethod("myfunction")));
        $this->assertInstanceOf(Error::class, $this->rule->check(new Stmt\ClassMethod("Myfunction")));
        $this->assertInstanceOf(Error::class, $this->rule->check(new Stmt\ClassMethod("MyFunction")));
    }

    public function testMethodError()
    {
        $error = new Error("Myfunction", "Method name is not in camel case format", Error::LEVEL_ERROR, -1);
        $this->assertEquals($error, $this->rule->check(new Stmt\ClassMethod("Myfunction")));
    }

    public function testMagicMethods()
    {
        $this->assertNull($this->rule->check(new Stmt\ClassMethod("__call")));
        $this->assertNull($this->rule->check(new Stmt\ClassMethod("__construct")));
    }

    public function testVariableCamelCase()
    {
        $this->assertNull($this->rule->check(new Variable("myVariable")));
        $this->assertNull($this->rule->check(new Variable("myvariable")));
        $this->assertInstanceOf(Error::class, $this->rule->check(new Variable("Myvariable")));
        $this->assertInstanceOf(Error::class, $this->rule->check(new Variable("MyVariable")));
        $this->assertInstanceOf(Error::class, $this->rule->check(new Variable("my_variable")));
    }

    public function testVariableError()
    {
        $error = new Error("my_var", "Variable name is not in camel case format", Error::LEVEL_WARNING, -1);
        $this->assertEquals($error, $this->rule->check(new Variable("my_var")));
    }
}
