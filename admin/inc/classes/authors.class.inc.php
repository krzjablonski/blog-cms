<?php

class Authors extends Dbh{

  public function get_all_authors(){
    $sql = "SELECT * FROM authors";;
    try {
      $query = $this->connect()->query($sql);
      $output = $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      $error_message = $e->getMessage();
    }

    if(isset($error_message)){
      return $error_message;
    }else{
      return $output;
    }
  }

  public function add_author($name, $job){
    $sql = "INSERT INTO authors VALUES(NULL, ?, ?)";
    try {
      $query = $this->connect()->prepare($sql);
      $query->bindParam(1, $name, PDO::PARAM_STR);
      $query->bindParam(2, $job, PDO::PARAM_STR);
      $query->execute();

    } catch (Exception $e) {
      $error_message = $e->getMessage();
    }

     if(isset($error_message)){
       return $error_message;
     }else{
       return 'success';
     }
  }

  public function delete_author($id){
    $sql = "DELETE FROM authors WHERE author_id = ?";
    try {
      $query = $this->connect()->prepare($sql);
      $query->bindParam(1, $id, PDO::PARAM_STR);
      $query->execute();
    } catch (Exception $e) {
      $error_message = $e->getMessage();
    }
    if(isset($error_message)){
      return $error_message;
    }else{
      return 'success';
    }
  }
}
