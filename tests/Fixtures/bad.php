<?php

namespace PSRLinter\Tests\Fixtures;

$my_var = 1;
$MyVAr = 3;

class Bad {

    function MyFunction()
    {
    }

    function my_function()
    {
    }
}

function test_test() {
}