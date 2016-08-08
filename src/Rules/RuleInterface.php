<?php

namespace PSRLinter\Rules;

use PhpParser\Node;
use PSRLinter\Report\Report;

interface RuleInterface
{
    public function check(Node $node);
    public function isFixable(Node $node);
    public function fix(Node $node);
    public function getReport() : Report;
}
