<?php

namespace PSRLinter\Tests\Visitors;

use PSRLinter\Rules\CamelCaseRule;
use PSRLinter\Visitors\NodeVisitor;
use PhpParser\Node\Stmt;
use PSRLinter\Report\Error;

class NodeVisitorTest extends \PHPUnit_Framework_TestCase
{
    private $visitor;

    public function setUp()
    {
        $rules = [new CamelCaseRule()];
        $this->visitor = new NodeVisitor($rules);
    }

    public function testCheckNode()
    {
        $node = new Stmt\Function_("Myfunction");
        $error = new Error("Myfunction", "Function name is not in camel case format", Error::LEVEL_ERROR, -1);
        $this->visitor->enterNode($node);

        $this->assertEquals([$error], $this->visitor->getReport()->getErrors());
    }
}
