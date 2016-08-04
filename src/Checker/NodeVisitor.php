<?php

namespace PSRLinter\Checker;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;
use PSRLinter\Logger\Logger;

class NodeVisitor extends NodeVisitorAbstract
{
    private $rules;
    private $logger;

    public function __construct($rules)
    {
        $this->rules = $rules;
        $this->logger = new Logger();
    }

    public function enterNode(Node $node)
    {
        foreach ($this->rules as $rule) {
            if ($error = $rule($node)) {
                $this->logger->addError($error);
            }
        }
    }

    public function getLogger()
    {
        return $this->logger;
    }

}