<?php

namespace PSRLinter\ReportBuilder;

class ReportJson implements ReportTypeInterface
{
    public function build($reports)
    {
        if ($reports == null) {
            return null;
        }

        $result = [];
        foreach ($reports as $file => $report) {
            $result[$file] = array_map(function ($error) {
                return [
                    "line" => $error->getLine(),
                    "level" => $error->getType(),
                    "description" => $error->getDescription(),
                    "title" => $error->getTitle()
                ];
            }, $report->getErrors());
        }
        return json_encode($result, JSON_PRETTY_PRINT);
    }
}
