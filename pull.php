<?php
define('PRIVATE_KEY', 'q1w2e3r4t5y6u7i8o9p0');

if ($_SERVER['REQUEST_METHOD'] === 'POST'
        && $_REQUEST['thing'] === PRIVATE_KEY)
{
    echo "start\n";
    echo shell_exec("git pull origin master 2>&1") . "\n";
    echo "finish\n";
}