<?php

namespace PSRLinter\Rules;

use Doctrine\Common\Inflector\Inflector;
use PhpParser\Node;
use PSRLinter\Report\Error;
use PSRLinter\Report\Report;

class CamelCase implements RuleInterface
{
    private $report;
    private $magicFunction = [
        '__construct',
        '__destruct',
        '__call',
        '__callStatic',
        '__get',
        '__set',
        '__isset',
        '__unset',
        '__sleep',
        '__wakeup',
        '__toString',
        '__invoke',
        '__set_state',
        '__clone',
        '__debugInfo'
    ];

    public function __construct()
    {
        $this->report = new Report();
    }

    public function check(Node $node)
    {
        if ($node instanceof Node\Stmt\Function_) {
            if (!\PHP_CodeSniffer::isCamelCaps($node->name)) {
                $this->report->addError(
                    new Error(
                        $node->name,
                        "Function name is not in camel case.",
                        Error::LEVEL_ERROR,
                        $node->getLine()
                    )
                );
                return false;
            }
        } elseif ($node instanceof Node\Stmt\ClassMethod) {
            if (!\PHP_CodeSniffer::isCamelCaps($node->name) && !in_array($node->name, $this->magicFunction)) {
                $this->report->addError(
                    new Error(
                        $node->name,
                        "Method name is not in camel case.",
                        Error::LEVEL_ERROR,
                        $node->getLine()
                    )
                );
                return false;
            }
        } elseif ($node instanceof Node\Expr\Variable) {
            if (!\PHP_CodeSniffer::isCamelCaps($node->name)) {
                $this->report->addError(
                    new Error(
                        $node->name,
                        "Variable name is not in camel case.",
                        Error::LEVEL_WARNING,
                        $node->getLine()
                    )
                );
                return false;
            }
        }
        return true;
    }

    public function isFixable(Node $node) : bool
    {
        return true;
    }

    public function fix(Node $node) : Node
    {
        if ($node instanceof Node\Stmt\Function_) {
            if (!\PHP_CodeSniffer::isCamelCaps($node->name)) {
                $newName = Inflector::camelize($node->name);
                $this->report->addError(
                    new Error(
                        $node->name . " => " . $newName,
                        "The function changed the name.",
                        Error::LEVEL_INFO,
                        $node->getLine()
                    )
                );
                $node->name = $newName;
                return $node;
            }
        } elseif ($node instanceof Node\Stmt\ClassMethod) {
            if (!\PHP_CodeSniffer::isCamelCaps($node->name) && !in_array($node->name, $this->magicFunction)) {
                $newName = Inflector::camelize($node->name);
                $this->report->addError(
                    new Error(
                        $node->name . " => " . $newName,
                        "The method changed the name.",
                        Error::LEVEL_INFO,
                        $node->getLine()
                    )
                );
                $node->name = $newName;
                return $node;
            }
        } elseif ($node instanceof Node\Expr\Variable) {
            if (!\PHP_CodeSniffer::isCamelCaps($node->name)) {
                $newName = Inflector::camelize($node->name);
                $this->report->addError(
                    new Error(
                        $node->name . " => " . $newName,
                        "The variable changed the name.",
                        Error::LEVEL_INFO,
                        $node->getLine()
                    )
                );
                $node->name = $newName;
                return $node;
            }
        }
        return $node;
    }

    public function getReport(): Report
    {
        return $this->report;
    }
}
