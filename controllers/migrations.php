<?php

include('core.php');

class Migrations extends Core {

  function migrate(){
    if(isset($_POST['url_to']) && $_POST['url_to'] != NULL){
      extract($_POST);

      //Options
        $sql = "UPDATE ".$this->tblprefix."_options SET option_value = replace(option_value, '$url_from', '$url_to') WHERE option_name = 'home' OR option_name = 'siteurl'; ";
      //Posts
        // $sql .= "UPDATE ".$this->tblprefix."_posts SET post_content = replace(post_content, '$url_from', '$url_to'); ";
      //Post Meta
        // $sql .= "UPDATE ".$this->tblprefix."_postmeta SET meta_value = replace(meta_value,'$url_from','$url_to'); ";

      // $this->debug($sql); 

      if(isset($execute) && $execute==1){
        $this->execute($sql,'update');
        return 'SUCCESS!';
      } else {
        return $sql;
      }
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

    // $conn     = mysql_connect(
    //     $this->servername,
    //     $this->dbusername,
    //     $this->dbpassword
    // );
    // $result   = mysql_query('SHOW DATABASES');
    // $databases= array();
    // while($row = mysql_fetch_array($result)){
    //   $databases = $row[0];
    // }
    // mysql_close($conn);
    // return $databases;
  }

  function showSiteURL(){
    if($_POST){
      $tblname = $this->tblprefix."_options";
      $sql = "SELECT option_value FROM $tblname WHERE option_name = 'siteurl' LIMIT 1;";
      $result = $this->execute($sql);
      return $result['option_value'];
    }
  }

}
?>
