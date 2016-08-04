<?php

namespace PSRLinter;

use League\CLImate\CLImate;
use PhpParser\NodeTraverser;
use PhpParser\ParserFactory;
use PSRLinter\Checker\NodeVisitor;
use PSRLinter\Logger\Error;
use PSRLinter\Logger\Logger;

class Linter
{
    private $cli;

    public function __construct()
    {
        $this->cli = new CLImate();
    }

    public function run($args)
    {
        $path = $args[0];
        $files = Utils::getFiles($path);

        $rules = Utils::getRules();

        $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);

        foreach ($files as $file) {
            $traverser = new NodeTraverser;
            $visiter = new NodeVisitor($rules);
            $traverser->addVisitor($visiter);

            $code = file_get_contents($file);
            $stmts = $parser->parse($code);
            $traverser->traverse($stmts);
            $logger = $visiter->getLogger();

            $this->printFileDir($file);
            $this->cli->br();
            if ($logger->getCountOfProblems() > 0) {
                $this->printItems($logger);
                $this->cli->br();
            }
            $this->printSummary($logger);
            $this->cli->br();
        }
    }

    private function printFileDir($file)
    {
        $this->cli->out($file);
    }

    private function printItems(Logger $logger)
    {
        foreach ($logger->getErrors() as $error) {
            $this->printItem($error);
        }
    }

    private function printItem(Error $error)
    {
        $this->cli->inline(sprintf("%-7s", $error->getLine()));
        $this->cli->inline(sprintf("%-10s", $error->getType()));
        $this->cli->inline(sprintf("%-45s", $error->getDescription()));
        $this->cli->inline(sprintf("%-20s", $error->getTitle()));
        $this->cli->br();
    }

    private function printSummary(Logger $logger)
    {
        $countOfErrors = $logger->getCountOfErrors();
        $countOfWarnings = $logger->getCountOfWarnings();
        $countOfProblems = $logger->getCountOfProblems();
        if ($countOfProblems == 0) {
            $this->cli->green("Problems have not been detected.");
        } else {
            $this->cli->red(
                sprintf(
                    "%d problems (%d errors, %d warnings)",
                    $countOfProblems,
                    $countOfErrors,
                    $countOfWarnings
                )
            );
        }
    }
}
