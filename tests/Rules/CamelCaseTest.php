<?php

namespace PSRLinter\Tests\Rules;

use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt;
use PSRLinter\Rules\CamelCase;

class CamelCaseTest extends \PHPUnit_Framework_TestCase
{
    private $rule;

    public function setUp()
    {
        $this->rule = new CamelCase();
    }

    public function testLintFunctionCamelCase()
    {
        $this->assertTrue($this->rule->check(new Stmt\Function_("myFunction")));
        $this->assertTrue($this->rule->check(new Stmt\Function_("myfunction")));
        $this->assertFalse($this->rule->check(new Stmt\Function_("Myfunction")));
        $this->assertFalse($this->rule->check(new Stmt\Function_("MyFunction")));
    }

    public function testLintMethodCamelCase()
    {
        $this->assertTrue($this->rule->check(new Stmt\ClassMethod("myFunction")));
        $this->assertTrue($this->rule->check(new Stmt\ClassMethod("myfunction")));
        $this->assertFalse($this->rule->check(new Stmt\ClassMethod("Myfunction")));
        $this->assertFalse($this->rule->check(new Stmt\ClassMethod("MyFunction")));
    }

    public function testLintMagicMethods()
    {
        $this->assertTrue($this->rule->check(new Stmt\ClassMethod("__call")));
        $this->assertTrue($this->rule->check(new Stmt\ClassMethod("__construct")));
    }

    public function testLintVariableCamelCase()
    {
        $this->assertTrue($this->rule->check(new Variable("myVariable")));
        $this->assertTrue($this->rule->check(new Variable("myvariable")));
        $this->assertFalse($this->rule->check(new Variable("Myvariable")));
        $this->assertFalse($this->rule->check(new Variable("MyVariable")));
        $this->assertFalse($this->rule->check(new Variable("my_variable")));
    }

    public function testFixVariable()
    {
        $this->assertEquals(new Variable("myVariable"), $this->rule->fix(new Variable("my_variable")));
        $this->assertEquals(new Variable("myvariable"), $this->rule->fix(new Variable("myvariable")));
        $this->assertEquals(new Variable("myVariable"), $this->rule->fix(new Variable("myVariable")));
        $this->assertEquals(new Variable("myVariable"), $this->rule->fix(new Variable("my-variable")));
    }

    public function testFixFunction()
    {
        $this->assertEquals(new Stmt\Function_("myVariable"), $this->rule->fix(new Stmt\Function_("my_variable")));
        $this->assertEquals(new Stmt\Function_("myvariable"), $this->rule->fix(new Stmt\Function_("myvariable")));
        $this->assertEquals(new Stmt\Function_("myVariable"), $this->rule->fix(new Stmt\Function_("myVariable")));
        $this->assertEquals(new Stmt\Function_("myVariable"), $this->rule->fix(new Stmt\Function_("my-variable")));
    }

    public function testFixMethod()
    {
        $this->assertEquals(new Stmt\ClassMethod("myVariable"), $this->rule->fix(new Stmt\ClassMethod("my_variable")));
        $this->assertEquals(new Stmt\ClassMethod("myvariable"), $this->rule->fix(new Stmt\ClassMethod("myvariable")));
        $this->assertEquals(new Stmt\ClassMethod("myVariable"), $this->rule->fix(new Stmt\ClassMethod("myVariable")));
        $this->assertEquals(new Stmt\ClassMethod("myVariable"), $this->rule->fix(new Stmt\ClassMethod("my-variable")));
    }
}
