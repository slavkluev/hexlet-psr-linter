<?php

namespace PSRLinter;

use PhpParser\Node;

interface RuleInterface
{
    public static function check(Node $node);
}