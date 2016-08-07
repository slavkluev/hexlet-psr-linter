<?php

namespace PSRLinter\Tests\Fixtures;

$myVar = 1;

class Good {

    private $myVar;

    public function getMyVar()
    {
        return $this->myVar;
    }
}