<?php

$config = Config::singleton();

$config->set('controllersFolder', 'controllers/');
$config->set('modelsFolder', 'models/');
$config->set('viewsFolder', 'views/');

/* $config->set('dbhost', 'localhost');
$config->set('dbname', 'mvc');
$config->set('dbuser', 'root');
$config->set('dbpass', null); */

$config->set('dbhost', 'localhost');
$config->set('dbname', 'revistac_db');
$config->set('dbuser', 'revistac_db');
$config->set('dbpass', 'C0mpuca5as');
?>