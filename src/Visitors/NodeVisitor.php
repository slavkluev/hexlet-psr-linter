<?php

namespace PSRLinter\Visitors;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;
use PSRLinter\Report\Report;
use PSRLinter\RuleInterface;

class NodeVisitor extends NodeVisitorAbstract
{
    private $rules;
    private $report;

    public function __construct($rules)
    {
        $this->rules = $rules;
        $this->report = new Report();
    }

    public function enterNode(Node $node)
    {
        foreach ($this->rules as $rule) {
            if ($error = $rule->check($node)) {
                $this->report->addError($error);
            }
        }
    }

    public function getReport()
    {
        return $this->report;
    }
}
