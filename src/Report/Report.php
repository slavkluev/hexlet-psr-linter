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
    }

    public function addReport(Report $report)
    {
        foreach ($report->getErrors() as $error) {
            $this->errors[] = $error;
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
