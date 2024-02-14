#!/usr/bin/env php
<?php

function f($f)
{
    $f = $f . '/vendor/autoload.php';
    echo $f . PHP_EOL;
    if (file_exists($f)) {
        echo $f . PHP_EOL;
        return true;
    }
}

f(__DIR__) ||
f(dirname(__DIR__)) ||
f(dirname(dirname(__DIR__))) ||
f(dirname(dirname(dirname(__DIR__)))) ||
f(dirname(dirname(dirname(dirname(__DIR__))))) ||
f(dirname(dirname(dirname(dirname(dirname(__DIR__)))))) ||
die(1);
