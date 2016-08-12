<?php

namespace PSRLinter\Tests;

use PSRLinter\Linter;
use PSRLinter\Report\Error;
use PSRLinter\Report\Report;

class LinterTest extends \PHPUnit_Framework_TestCase
{
    private $linter;

    public function setUp()
    {
        $rules = [
            "PSRLinter\\Rules\\CamelCase",
            "PSRLinter\\Rules\\SideEffect"
        ];
        $this->linter = new Linter($rules);
    }

    public function testNull()
    {
        $report = new Report();

        $this->assertEquals($report, $this->linter->lint(null));
    }

    public function testEmptyCode()
    {
        $report = new Report();

        $this->assertEquals($report, $this->linter->lint(""));
    }

    public function testLintWithGoodCode()
    {
        $code = '<?php $myVar = 10;';
        $report = new Report();

        $this->assertEquals($report, $this->linter->lint($code));
    }

    public function testLintWithBadCode()
    {
        $code = '<?php $my_var = 10;';
        $report = new Report();
        $report->addError(new Error("my_var", "Variable name is not in camel case.", Error::LEVEL_WARNING, 1));

        $this->assertEquals($report, $this->linter->lint($code));
    }

    public function testLintNotCode()
    {
        $code = "asdadf";
        $report = new Report();

        $this->assertEquals($report, $this->linter->lint($code));
    }

    public function testFixWithGoodCode()
    {
        $code = '<?php $myVar = 10;';
        $expectedReport = new Report();

        $report = $this->linter->fix($code)[1];

        $this->assertEquals($expectedReport, $report);
    }

    public function testFixWithBadCode()
    {
        $code = '<?php $my_var = 10;';
        $expectedReport = new Report();
        $expectedReport->addError(new Error(
            "my_var => myVar",
            "The variable changed the name.",
            Error::LEVEL_INFO,
            1
        ));

        $report = $this->linter->fix($code)[1];

        $this->assertEquals($expectedReport, $report);
    }
}
