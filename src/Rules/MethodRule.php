<?php

namespace PSRLinter\Rules;

use PhpParser\Node;
use PSRLinter\RuleInterface;
use PSRLinter\Logger\Error;

class MethodRule implements RuleInterface
{
    private static $magicFunction = ['__construct', '__destruct', '__call', '__callStatic', '__get', '__set', '__isset',
        '__unset', '__sleep', '__wakeup', '__toString', '__invoke', '__set_state', '__clone', '__debugInfo'];

    public static function check(Node $node)
    {
        if ($node instanceof Node\Stmt\ClassMethod) {
            if (!\PHP_CodeSniffer::isCamelCaps($node->name) && !in_array($node->name, self::$magicFunction)) {
                return new Error(
                    "$node->name",
                    "Method name is not in camel case format",
                    Error::ERROR,
                    $node->getLine()
                );
            }
        }
    }
}
