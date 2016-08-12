<?php

namespace PSRLinter;

use PhpParser\NodeTraverser;
use PhpParser\NodeVisitor\NameResolver;
use PhpParser\ParserFactory;
use PSRLinter\Rules\CamelCase;
use PSRLinter\Rules\SideEffect;
use PSRLinter\Visitors\NodeConverter;
use PSRLinter\Visitors\NodeVisitor;
use PSRLinter\Report\Report;
use PhpParser\PrettyPrinter;

class Linter
{
    private $rules;

    public function __construct($rules)
    {
        $this->rules = $rules;
    }

    public function lint($code) : Report
    {
        $ast = $this->getAST($code);
        $visitor = new NodeVisitor($this->rules);
        $this->traverse($ast, [$visitor]);
        $report = $visitor->getReport();
        return $report;
    }

    public function fix($code)
    {
        $ast = $this->getAST($code);
        $visitor = new NodeVisitor($this->rules, true);
        $stmts = $this->traverse($ast, [$visitor, new NameResolver()]);
        $prettyPrinter = new PrettyPrinter\Standard;
        $fixedCode = $prettyPrinter->prettyPrintFile($stmts);
        $report = $visitor->getReport();
        return [$fixedCode, $report];
    }

    private function getAST($code)
    {
        $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
        $ast = $parser->parse($code);
        return $ast;
    }

    private function traverse($ast, $visitors)
    {
        $traverser = new NodeTraverser;
        foreach ($visitors as $visitor) {
            $traverser->addVisitor($visitor);
        }
        $stmts = $traverser->traverse($ast);
        return $stmts;
    }
}
