<?php

namespace PSRLinter\Report;

class Error
{
    const LEVEL_WARNING = "warning";
    const LEVEL_ERROR = "error";
    const LEVEL_INFO = "info";

    private $title;
    private $description;
    private $type;
    private $line;

    public function __construct($title, $description, $type, $line)
    {
        $this->title = $title;
        $this->description = $description;
        $this->type = $type;
        $this->line = $line;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getLine()
    {
        return $this->line;
    }
}
