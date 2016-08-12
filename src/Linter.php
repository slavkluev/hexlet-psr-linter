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
    private $config;

    public function __construct($pathToConfigFile = __DIR__ . "/config.json")
    {
        $json = file_get_contents($pathToConfigFile);
        $this->config = json_decode($json, true);
    }

    public function lint($code) : Report
    {
        $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
        $traverser = new NodeTraverser;
        $visitor = new NodeVisitor($this->config["rules"]);
        $traverser->addVisitor($visitor);
        $stmts = $parser->parse($code);
        $traverser->traverse($stmts);
        $report = $visitor->getReport();
        return $report;
    }

    public function fix($code)
    {
        $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
        $prettyPrinter = new PrettyPrinter\Standard;
        $traverser = new NodeTraverser;
        $visitor = new NodeVisitor($this->config["rules"], true);
        $traverser->addVisitor(new NameResolver());
        $traverser->addVisitor($visitor);
        $stmts = $parser->parse($code);
        $stmts = $traverser->traverse($stmts);
        $fixedCode = $prettyPrinter->prettyPrintFile($stmts);
        $report = $visitor->getReport();
        return [$fixedCode, $report];
    }
}
