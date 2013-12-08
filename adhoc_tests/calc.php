<?php
require_once '../vendor/autoload.php';

use Bert\Ernie\Ernie;

Ernie::mod('calculator', array(
    'add' => function($a, $b) { return $a + $b; },
    'subtract' => function($a, $b) { return $a - $b; },
));

Ernie::start();