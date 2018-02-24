<?php

class Core {

	public $conn;
	public $servername ;
	public $dbname;
	public $dbusername;
	public $dbpassword;
	public $tblprefix;

	function init(){
		$setting = require('setting.php');
		$this->servername	= $setting['servername'];
		$this->dbusername 	= $setting['dbusername'];
		$this->dbpassword 	= $setting['dbpassword'];		
		if($_POST){
			$this->dbname 		= $_POST['dbname'];
		}
	}

	function connect(){
		if($_POST){
			$this->conn = new mysqli(
				$this->servername, 
				$this->dbusername, 
				$this->dbpassword, 
				$this->dbname
			);
			if ($this->conn->connect_error)
				die("Connection failed: " . $this->conn->connect_error);
		}
	}

	function debug($string){
		echo '<pre>';
		print_r($string);
	}

	function execute($sql, $type = NULL){
		if ($this->conn->query($sql)) {
			if($type==NULL)
				return $this->conn->query($sql)->fetch_assoc();
			elseif($type=='insert')
				return $this->conn->insert_id;
			elseif($type=="update" || $type=="delete")
				return $this->conn->query($sql);
		} else {
		    die("Error: " . $sql . "<br>" . $this->conn->error);
		}
	}

}

?>
