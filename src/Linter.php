<?php

namespace PSRLinter;

use League\CLImate\CLImate;
use PhpParser\NodeTraverser;
use PhpParser\ParserFactory;
use PSRLinter\Rules\FunctionRule;
use PSRLinter\Rules\CamelCaseRule;
use PSRLinter\Rules\VariableRule;
use PSRLinter\Visitors\NodeVisitor;
use PSRLinter\Report\Error;
use PSRLinter\Report\Report;

class Linter
{
    private $cli;

    public function __construct()
    {
        $this->cli = new CLImate();
    }

    public function lint($code) : Report
    {
        $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
        $traverser = new NodeTraverser;
        $visitor = new NodeVisitor($this->getRules());
        $traverser->addVisitor($visitor);
        $stmts = $parser->parse($code);
        $traverser->traverse($stmts);
        $report = $visitor->getReport();
        return $report;
    }

    private function getRules()
    {
        $rules = [
            new CamelCaseRule()
        ];
        return $rules;
    }
}
