<?php
/*
*  Controller Area
*/
	include('controllers/migrations.php');

	//Public Variable
	$migrations = new Migrations;
	if($_POST) extract($_POST);

	//Call function
	$migrations->init();
	$migrations->connect();
	$databases	= $migrations->showDatabases();
	$url_from 	= $migrations->showSiteURL();
	$result 	= $migrations->migrate();

/*
*  View Area
*/
	$data = [
		'controller'	=> 'migrations',
		'action' 		=> 'init',
		'result' 		=> $result,
		'databases' 	=> $databases,
	];
	include('views/layout.php');

	exit;

	//Procedd Data
	$result = init($data);
	debug($result);
	exit;
?>
