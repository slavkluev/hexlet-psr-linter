<?php

namespace PSRLinter\Tests\ReportBuilder;

use PSRLinter\Exceptions\UnexpectedFormatReporter;
use PSRLinter\ReportBuilder\ReportBuilder;

class ReportBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testUnexpectedFormatReporterException()
    {
        $this->expectException(UnexpectedFormatReporter::class);
        new ReportBuilder('test');
    }

    public function testTxtFormatNotException()
    {
        try {
            new ReportBuilder('txt');
        } catch (UnexpectedFormatReporter $e) {
            $this->fail();
        }
    }
}
