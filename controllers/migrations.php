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
