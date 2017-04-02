<?php

class Core {

	public $conn;
	public $servername = "localhost";
	public $dbname;
	public $dbusername;
	public $dbpassword;
	public $tblprefix;

	function init(){
		if($_POST){
			extract($_POST);
			$this->dbname = $dbname;
			$this->dbusername = $dbusername;
			$this->dbpassword = $dbpassword;
			$this->tblprefix = $tblprefix;
		}
	}

	function connect(){
		if($_POST){
			$this->conn = new mysqli($this->servername, $this->dbusername, $this->dbpassword, $this->dbname);
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
