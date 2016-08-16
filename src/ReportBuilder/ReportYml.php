<?php

namespace PSRLinter\ReportBuilder;

use PSRLinter\Report\Error;
use Symfony\Component\Yaml\Yaml;

class ReportYml implements ReportTypeInterface
{
    public function build($reports)
    {
        $result = [];
        foreach ($reports as $file => $report) {
            $result[$file] = array_map(function (Error $error) {
                return [
                    "line" => $error->getLine(),
                    "level" => $error->getType(),
                    "description" => $error->getDescription(),
                    "title" => $error->getTitle()
                ];
            }, $report->getErrors());
        }
        return Yaml::dump($result);
    }
}
