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
	if(isset($_POST['dbname']))
		$tables		= $migrations->showTables($_POST['dbname']);
	if(isset($tables))
		$tblprefix 	= $migrations->getPrefix($tables);
	if(isset($tblprefix))
		$url_from 	= $migrations->showSiteURL($tblprefix);

	if(isset($_POST['url_to']) && $_POST['url_to'] != NULL){
		$url = array();
		$url['from']= $url_from;
		$url['to']  = $_POST['url_to'];
		$result 	= $migrations->Migrate($tblprefix,$tables,$url);
	} else
		$result		= 'No query has performed';
	$data = [
		'controller'	=> 'migrations',
		'action' 		=> 'init',
		'result' 		=> $result,
		'databases' 	=> $databases,
	];

/*
*  View Area
*/
	include('views/layout.php');

	exit;

	//Procedd Data
	$result = init($data);
	debug($result);
	exit;
?>
