<?php

namespace PSRLinter\Tests\ReportBuilder;

use PSRLinter\Report\Error;
use PSRLinter\Report\Report;
use PSRLinter\ReportBuilder\ReportTxt;

class ReportTxtTest extends \PHPUnit_Framework_TestCase
{
    public function testOneReport()
    {
        $report = new Report();
        $report->addError(new Error("test", "", Error::LEVEL_WARNING, 1));
        $reportTxt = new ReportTxt();

        $this->assertNotEquals(null, $reportTxt->build(["test.php" => $report]));
    }
}
