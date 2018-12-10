<?php
require 'bootstrap.php';

foreach (glob('routes/*.php') as $filename) {
    require $filename;
}


$app->run();
