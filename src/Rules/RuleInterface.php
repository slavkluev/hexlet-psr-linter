<?php

namespace PSRLinter\Rules;

use PhpParser\Node;

interface RuleInterface
{
    public function check(Node $node);
}
