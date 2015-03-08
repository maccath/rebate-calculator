<?php

$config = array_merge($config, array(
    'application' => array(
      'title' => 'Rebate Calculator',
    ),
    // Array to be passed into Twig_Environment constructor
    'twig' => array(
        'cache' => 'cache',
        'debug' => false,
    ),
));