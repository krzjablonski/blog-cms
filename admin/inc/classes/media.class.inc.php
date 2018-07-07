<?php

class Media extends Dbh{

  private $limit;
  private $offset;

  function __construct($limit = null, $offset = null){
    $this->limit = $limit;
    $this->offset = $offset;
  }

  public function get_all_media(){
    try {
      $sql = "SELECT * FROM media ";
      $orderby = " ORDER BY id DESC ";
      $limitAndOffset = " LIMIT ? OFFSET ?";
      if($this->limit !== null && $this->offset !== null){
        $query = $this->connect()->prepare($sql.$orderby.$limitAndOffset);
        $query->bindParam(1, $this->limit, PDO::PARAM_INT);
        $query->bindParam(2, $this->offset, PDO::PARAM_INT);
      }else{
        $query = $this->connect()->prepare($sql.$orderby);
      }
      $query->execute();
      $output = $query->fetchAll(PDO::FETCH_ASSOC);
      return $output;
    } catch (Exception $e) {
      error_log("Media Error: ".$e->getMessage());
      return false;
    }
  }

  public static function add_media($file_name, $alt_tag){
    $dbh = new Dbh;
    try {
      $sql = "INSERT INTO media VALUES (NULL, ?, ? )";
      $query = $dbh->connect()->prepare($sql);
      $query->bindParam(1, $file_name, PDO::PARAM_STR);
      $query->bindParam(2, $alt_tag, PDO::PARAM_STR);
      $query->execute();
      return true;
    } catch (Exception $e) {
      error_log($error_message = $e->getMessage());
      return false;
    }
  }

  public static function delete_media($id, $file_name){
    try {
      $db = new Dbh;
      $sql = "DELETE FROM media WHERE id = ?";
      $query = $db->connect()->prepare($sql);
      $query->bindParam(1, $id, PDO::PARAM_INT);
      if($query->execute()){
        unlink('../upload/'.$file_name);
        return true;
      }else{
        return false;
      }
    } catch (Exception $e) {
      error_log($e->getMessage());
      return false;
    }
  }

  public function count_media(){
    $sql = "SELECT COUNT(id) AS \"number\" FROM media";
    try {
      $db = new Dbh;
      $query = $db->connect()->prepare($sql);
      $query->execute();
      $output = $query->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      $error_message = $e->getMessage();
    }

    if(isset($error_message)){
      return $error_message;
    }else{
      return $output;
    }
  }
}
