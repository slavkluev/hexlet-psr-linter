<?php

namespace PSRLinter\Rules;

use PhpParser\Node;
use PSRLinter\RuleInterface;
use PSRLinter\Logger\Error;

class VariableRule implements RuleInterface
{
    public static function check(Node $node)
    {
        if ($node instanceof Node\Expr\Variable) {
            if (!\PHP_CodeSniffer::isCamelCaps($node->name)) {
                return new Error(
                    "$node->name",
                    "Variable name is not in camel case format",
                    Error::WARNING,
                    $node->getLine()
                );
            }
        }
    }
}
