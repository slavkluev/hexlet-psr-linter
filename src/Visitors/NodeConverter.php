<?php

namespace PSRLinter\Visitors;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;
use PSRLinter\Report\Report;

class NodeConverter extends NodeVisitorAbstract
{
    private $rules;

    public function __construct($rules)
    {
        $this->rules = $rules;
    }

    public function leaveNode(Node $node)
    {
        foreach ($this->rules as $rule) {
            if ($rule->isFixable($node)) {
                return $rule->fix($node);
            } else {
                $rule->check($node);
            }
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
