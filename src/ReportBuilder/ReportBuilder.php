<?php

namespace PSRLinter\ReportBuilder;

use PSRLinter\Exceptions\UnexpectedFormatReporter;

class ReportBuilder
{
    private $reporter;
    private $formats = [
        'txt' => ReportTxt::class,
        'json' => ReportJson::class,
        'yml' => ReportYml::class
    ];

    public function __construct($format = 'txt')
    {
        if (!in_array($format, array_keys($this->formats))) {
            throw new UnexpectedFormatReporter();
        }
        $this->reporter = new $this->formats[$format];
    }

    public function build($reports)
    {
        if ($reports == null) {
            return null;
        }
        return $this->reporter->build($reports);
    }
}
