<?php 
require 'vendor/autoload.php';
$rooter = new AltoRouter();

$rooter->map('GET', '/page2.php' , 'page2', 'page');