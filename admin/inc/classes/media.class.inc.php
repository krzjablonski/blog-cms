<?php

class Media extends Dbh{

  public function get_all_media(){
    try {
      $sql = "SELECT * FROM media";
      $query = $this->connect()->query($sql);
      $output = $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      $error_message = "Media Error: ".$e->getMessage();
    }

    if(isset($error_message)){
      return false;
    }else{
      return $output;
    }
  }

  public function add_media(){

  }
}
