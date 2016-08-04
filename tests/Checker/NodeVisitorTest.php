<?php

namespace PSRLinter\Tests\Checker;

use PSRLinter\Checker\NodeVisitor;
use PhpParser\Node\Stmt;
use PSRLinter\Logger\Error;

class NodeVisitorTest extends \PHPUnit_Framework_TestCase
{
    private $visiter;

    public function setUp()
    {
        $rules = [["\\PSRLinter\\Rules\\FunctionRule", "check"]];
        $this->visiter = new NodeVisitor($rules);
    }

    public function testCheckNode()
    {
        $node = new Stmt\Function_("Myfunction");
        $error = new Error("Myfunction", "Function name is not in camel case format", Error::ERROR, -1);
        $this->visiter->enterNode($node);

        $this->assertEquals([$error], $this->visiter->getLogger()->getErrors());
    }
}
