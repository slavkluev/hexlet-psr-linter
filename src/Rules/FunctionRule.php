<?php

namespace PSRLinter\Rules;

use PhpParser\Node;
use PSRLinter\RuleInterface;
use PSRLinter\Logger\Error;

class FunctionRule implements RuleInterface
{
    public static function check(Node $node)
    {
        if ($node instanceof Node\Stmt\Function_) {
            if (!\PHP_CodeSniffer::isCamelCaps($node->name)) {
                return new Error($node->name,
                    "Function name is not in camel case format",
                    Error::ERROR,
                    $node->getLine());
            }
        }
    }
}
