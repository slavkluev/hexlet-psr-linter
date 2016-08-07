<?php

namespace PSRLinter\ReportBuilder;

use PSRLinter\Report\Error;
use PSRLinter\Report\Report;

class ReportTxt implements ReportTypeInterface
{
    public function build($reports)
    {
        if ($reports == null) {
            return null;
        }

        $result = [];
        foreach ($reports as $file => $report) {
            $item = [];
            $item[] = $file;
            if ($this->buildErrors($report)) {
                $item[] = $this->buildErrors($report);
            }
            $item[] = $this->buildSummary($report);
            $result[] = implode($item, PHP_EOL);
        }
        return implode($result, PHP_EOL . PHP_EOL);
    }

    private function buildErrors(Report $report)
    {
        $errorsArray = array_map(function (Error $error) {
            return sprintf(
                "%-7s%-10s%-45s%-20s",
                $error->getLine(),
                $error->getType(),
                $error->getDescription(),
                $error->getTitle()
            );
        }, $report->getErrors());
        return implode($errorsArray, PHP_EOL);
    }

    private function buildSummary(Report $report)
    {
        $countOfErrors = $report->getCountOfErrors();
        $countOfWarnings = $report->getCountOfWarnings();
        $countOfProblems = $report->getCountOfProblems();
        if ($countOfProblems == 0) {
            return "Problems have not been detected.";
        } else {
            return sprintf(
                "%d problems (%d errors, %d warnings)",
                $countOfProblems,
                $countOfErrors,
                $countOfWarnings
            );
        }
    }
}
