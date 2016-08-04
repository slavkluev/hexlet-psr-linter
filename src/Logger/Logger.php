<?php

namespace PSRLinter\Logger;

class Logger
{
    private $errors;

    public function __construct()
    {
        $this->errors = [];
    }

    public function addError(Error $error)
    {
        $this->errors[] = $error;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getCountOfWarnings()
    {
        return count(
            array_filter($this->errors, function ($item) {
                return ($item->getType() == Error::WARNING);
            })
        );
    }

    public function getCountOfErrors()
    {
        return count(
            array_filter($this->errors, function ($item) {
                return ($item->getType() == Error::ERROR);
            })
        );
    }

    public function getCountOfProblems()
    {
        return self::getCountOfErrors() + self::getCountOfWarnings();
    }
}