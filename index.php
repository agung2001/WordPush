<?php

require 'vendor/autoload.php';
define('SRC_PATH', getcwd() . '/src');
$setting = require('setting.php');
$migration = new Wordpush\Controller\Migration($setting);
$migration->build();
