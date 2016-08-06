<?php

namespace PSRLinter\Tests;


use PSRLinter\Exceptions\CodeErrorException;
use PSRLinter\Linter;
use PSRLinter\Report\Error;
use PSRLinter\Report\Report;

class LinterTest extends \PHPUnit_Framework_TestCase
{
    public function testNull()
    {
        $report = new Report();

        $this->assertEquals($report, (new Linter())->lint(null));
    }

    public function testEmptyCode()
    {
        $report = new Report();

        $this->assertEquals($report, (new Linter())->lint(""));
    }

    public function testLintWithGoodCode()
    {
        $code = '<?php $myVar = 10;';
        $report = new Report();

        $this->assertEquals($report, (new Linter())->lint($code));
    }

    public function testLintWithBadCode()
    {
        $code = '<?php $my_var = 10;';
        $report = new Report();
        $report->addError(new Error("my_var", "Variable name is not in camel case format", Error::LEVEL_WARNING, 1));

        $this->assertEquals($report, (new Linter())->lint($code));
    }

    public function testLintNotCode()
    {
        $code = "asdadf";
        $report = new Report();

        $this->assertEquals($report, (new Linter())->lint($code));
    }
}
