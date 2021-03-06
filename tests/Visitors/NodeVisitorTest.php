<?php

namespace PSRLinter\Tests\Visitors;

use PSRLinter\Rules\CamelCase;
use PSRLinter\Visitors\NodeVisitor;
use PhpParser\Node\Stmt;
use PSRLinter\Report\Error;

class NodeVisitorTest extends \PHPUnit_Framework_TestCase
{
    private $visitor;

    public function setUp()
    {
        $rules = ["PSRLinter\\Rules\\CamelCase"];
        $this->visitor = new NodeVisitor($rules);
    }

    public function testCheckNode()
    {
        $node = new Stmt\Function_("Myfunction");
        $error = new Error(
            "Myfunction",
            "Function name is not in camel case.",
            Error::LEVEL_ERROR,
            -1
        );
        $this->visitor->leaveNode($node);

        $this->assertEquals([$error], $this->visitor->getReport()->getErrors());
    }
}
