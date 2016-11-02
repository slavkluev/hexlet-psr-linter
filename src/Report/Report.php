<?php

namespace PSRLinter\Report;

class Report
{
    private $errors;

    public function __construct()
    {
        $this->errors = [];
    }

    public function addError(Error $error)
    {
        $this->errors[] = $error;
        uasort($this->errors, [$this, 'lineSort']);
    }

    public function addReport(Report $report)
    {
        foreach ($report->getErrors() as $error) {
            $this->errors[] = $error;
        }
        uasort($this->errors, [$this, 'lineSort']);
    }

    private function lineSort(Error $error1, Error $error2)
    {
        if ($error1->getLine() < $error2->getLine()) {
            return -1;
        } elseif ($error1->getLine() > $error2->getLine()) {
            return 1;
        } else {
            return 0;
        }
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getCountOfWarnings()
    {
        return count(
            array_filter($this->errors, function ($item) {
                return ($item->getType() == Error::LEVEL_WARNING);
            })
        );
    }

    public function getCountOfErrors()
    {
        return count(
            array_filter($this->errors, function ($item) {
                return ($item->getType() == Error::LEVEL_ERROR);
            })
        );
    }

    public function getCountOfProblems()
    {
        return $this->getCountOfErrors() + $this->getCountOfWarnings();
    }
}
