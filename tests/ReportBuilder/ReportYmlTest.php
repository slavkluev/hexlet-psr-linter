<?php

namespace PSRLinter\Tests\ReportBuilder;

use PSRLinter\Report\Error;
use PSRLinter\Report\Report;
use PSRLinter\ReportBuilder\ReportYml;

class ReportYmlTest extends \PHPUnit_Framework_TestCase
{
    public function testEmpty()
    {
        $reportYml = new ReportYml();

        $this->assertEquals(null, $reportYml->build(""));
    }

    public function testOneReport()
    {
        $report = new Report();
        $report->addError(new Error("test", "", Error::LEVEL_WARNING, 1));
        $reportYml = new ReportYml();

        $this->assertNotEquals(null, $reportYml->build(["test.php" => $report]));
    }
}
