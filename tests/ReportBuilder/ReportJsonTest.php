<?php

namespace PSRLinter\Tests\ReportBuilder;

use PSRLinter\Report\Error;
use PSRLinter\Report\Report;
use PSRLinter\ReportBuilder\ReportJson;

class ReportJsonTest extends \PHPUnit_Framework_TestCase
{
    public function testOneReport()
    {
        $report = new Report();
        $report->addError(new Error("test", "", Error::LEVEL_WARNING, 1));
        $reportJson = new ReportJson();

        $this->assertNotEquals(null, $reportJson->build(["test.php" => $report]));
    }
}
