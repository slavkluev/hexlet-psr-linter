<?php

namespace PSRLinter\Rules;

use PhpParser\Node;
use PSRLinter\Report\Error;
use PSRLinter\Report\Report;

class SideEffect implements RuleInterface
{
    private $statementNodes = [
        "Stmt_Function",
        "Stmt_Class"
    ];
    private $sideEffect = [
        "Expr_FuncCall",
        "Expr_Include",
        "Stmt_Echo"
    ];
    private $statementNodeFlag = false;
    private $sideEffectFlag = false;

    public function check(Node $node)
    {
        if (in_array($node->getType(), $this->statementNodes)) {
            $this->statementNodeFlag = true;
        } elseif (in_array($node->getType(), $this->sideEffect)) {
            $this->sideEffectFlag = true;
        }
    }

    public function isFixable(Node $node)
    {
        return false;
    }

    public function fix(Node $node)
    {
    }

    public function getReport(): Report
    {
        $report = new Report();
        if ($this->sideEffectFlag && $this->statementNodeFlag) {
            $report->addError(new Error(
                "",
                "A file contains expression and statement nodes.",
                Error::LEVEL_ERROR,
                0
            ));
        }
        return $report;
    }
}
