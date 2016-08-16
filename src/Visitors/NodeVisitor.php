<?php

namespace PSRLinter\Visitors;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;
use PSRLinter\Report\Report;

class NodeVisitor extends NodeVisitorAbstract
{
    private $rules = [];
    private $fixNodes;

    public function __construct($rules, $fixNodes = false)
    {
        $this->fixNodes = $fixNodes;
        foreach ($rules as $rule) {
            $this->rules[] = new $rule();
        }
    }

    public function leaveNode(Node $node)
    {
        foreach ($this->rules as $rule) {
            if ($this->fixNodes && $rule->isFixable($node)) {
                return $rule->fix($node);
            }
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
