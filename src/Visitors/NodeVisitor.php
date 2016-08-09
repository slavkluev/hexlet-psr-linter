<?php

namespace PSRLinter\Visitors;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;
use PSRLinter\Report\Report;

class NodeVisitor extends NodeVisitorAbstract
{
    private $rules;

    public function __construct($rules)
    {
        $this->rules = $rules;
    }

    public function enterNode(Node $node)
    {
        foreach ($this->rules as $rule) {
            $rule->check($node);
        }
    }

    public function getReport()
    {
        $report = new Report();
        foreach ($this->rules as $rule) {
            $report->addReport($rule->getReport());
        }
        return $report;
    }
}
