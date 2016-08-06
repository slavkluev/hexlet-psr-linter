<?php

namespace PSRLinter\Tests\ReportBuilder;

use PSRLinter\Exceptions\UnexpectedFormatReporter;
use PSRLinter\ReportBuilder\ReportBuilder;

class ReportBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testUnexpectedFormatReporterException()
    {
        try {
            new ReportBuilder('test');
            $this->fail();
        } catch (UnexpectedFormatReporter $e){
        }
    }

    public function testTxtFormatNotException()
    {
        try {
            new ReportBuilder('txt');
        } catch (UnexpectedFormatReporter $e){
            $this->fail();
        }
    }
}
