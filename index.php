<?php

include ('vendor/autoload.php');

// Set up configuration options
$config = array();
include ('config/config.php');
if (file_exists('config/local.config.php')) {
    include ('config/local.config.php');
}

// Load Twig templating engine
$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader, $config['twig']);

$data = array(
    'application' => $config['application'],
);

echo $twig->render('index.html', array_merge(array('title' => 'Calculator'), $data));