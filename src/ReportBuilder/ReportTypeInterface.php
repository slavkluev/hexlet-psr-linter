<?php

namespace PSRLinter\ReportBuilder;

interface ReportTypeInterface
{
    public function build($reports);
}
