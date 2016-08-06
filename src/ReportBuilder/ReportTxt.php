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

        $result = "";
        foreach ($reports as $file => $report) {
            $result .= $file . PHP_EOL . implode(
                array_map(function($error) {
                    return sprintf(
                        "%-7s%-10s%-45s%-20s" . PHP_EOL,
                        $error->getLine(),
                        $error->getType(),
                        $error->getDescription(),
                        $error->getTitle()
                        );
                }, $report->getErrors())
                );
            $result .= $this->printSummary($report) . PHP_EOL . PHP_EOL;
        }
        return $result;
    }

    private function printSummary(Report $report)
    {
        $countOfErrors = $report->getCountOfErrors();
        $countOfWarnings = $report->getCountOfWarnings();
        $countOfProblems = $report->getCountOfProblems();
        if ($countOfProblems == 0) {
            return "Problems have not been detected.";
        } else {
            return
                sprintf(
                    "%d problems (%d errors, %d warnings)",
                    $countOfProblems,
                    $countOfErrors,
                    $countOfWarnings
                );

        }
    }
}
