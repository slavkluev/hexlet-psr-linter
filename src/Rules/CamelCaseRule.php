<?php

namespace PSRLinter\Rules;

use PhpParser\Node;
use PSRLinter\Report\Error;

class CamelCaseRule implements RuleInterface
{
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

    public function check(Node $node)
    {
        if ($node instanceof Node\Stmt\Function_) {
            if (!\PHP_CodeSniffer::isCamelCaps($node->name)) {
                return new Error(
                    $node->name,
                    "Function name is not in camel case format",
                    Error::LEVEL_ERROR,
                    $node->getLine()
                );
            }
        } elseif ($node instanceof Node\Stmt\ClassMethod) {
            if (!\PHP_CodeSniffer::isCamelCaps($node->name) && !in_array($node->name, $this->magicFunction)) {
                return new Error(
                    "$node->name",
                    "Method name is not in camel case format",
                    Error::LEVEL_ERROR,
                    $node->getLine()
                );
            }
        } elseif ($node instanceof Node\Expr\Variable) {
            if (!\PHP_CodeSniffer::isCamelCaps($node->name)) {
                return new Error(
                    "$node->name",
                    "Variable name is not in camel case format",
                    Error::LEVEL_WARNING,
                    $node->getLine()
                );
            }
        }
    }
}
