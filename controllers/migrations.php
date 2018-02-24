<?php

include('core.php');

class Migrations extends Core {

  function Migrate($tblprefix,$tables,$url){ 
    //Options
      $sql = "UPDATE ".$tblprefix."_options SET option_value = replace(option_value, '".$url['from']."', '".$url['to']."') WHERE option_name = 'home' OR option_name = 'siteurl'; ";
    //Tables
      // foreach($tables as $table){
        
      // }
    if(isset($_POST['execute']) && $_POST['execute']==1){
      $this->execute($sql,'update');
      return 'SUCCESS!';
    } else {
      return $sql;
    }
  }

  function showDatabases(){
    $pdo    = new PDO( 
      "mysql:host=".$this->servername, 
      $this->dbusername, 
      $this->dbpassword 
    );
    $statement = $pdo->prepare("SHOW DATABASES;");
    $statement->execute();
    $databases = $statement->fetchAll(PDO::FETCH_NUM);
    $data      = array();
    foreach($databases as $database)
      $data[] = $database[0];
    return $data;
  }

  function showTables($dbname){
    $pdo    = new PDO( 
      "mysql:host=".$this->servername, 
      $this->dbusername, 
      $this->dbpassword 
    );
    $statement = $pdo->prepare("SHOW TABLES FROM $dbname;");
    $statement->execute();
    $tables    = $statement->fetchAll(PDO::FETCH_NUM);
    $data      = array();
    foreach($tables as $table)
      $data[] = $table[0];
    return $data;
  }

  function showSiteURL($tblprefix){
    $tblname = $tblprefix."_options";
    $sql = "SELECT option_value FROM $tblname WHERE option_name = 'siteurl' LIMIT 1;";
    $result = $this->execute($sql);
    return $result['option_value'];
  }

  function getPrefix($tables){
    $tblprefix = ''; $counter = 0; $array = array();
    foreach($tables as $table){
      $prefix = explode('_', $table);
      if(isset($prefix[0])) $prefix = $prefix[0];
      if( !isset( $array[$prefix] ) )
        $array[$prefix] = 1;
      else
        $array[$prefix]++;
    }
    foreach($array as $prefix => $number){
      if($number>$counter){
        $tblprefix  = $prefix;
        $counter    = $number;
      }
    }
    return $tblprefix;
  }

}
?>
