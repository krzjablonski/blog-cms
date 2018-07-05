<?php

class Contact extends Dbh{

  public function get_contact(){
    $sql = "SELECT * FROM contact";
    try {
      $query = $this->connect()->query($sql);
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

  public function update_contact($name, $phone, $email){
    if(empty($this->get_contact())){
      $sql = "INSERT INTO contact VALUES(1, ?, ?, ?)";
    }else{
      $sql = "UPDATE contact SET name = ?, phone = ?, email = ?";
    }
    try {
      $query = $this->connect()->prepare($sql);
      $query->bindParam(1, $name, PDO::PARAM_STR);
      $query->bindParam(2, $phone, PDO::PARAM_STR);
      $query->bindParam(3, $email, PDO::PARAM_STR);
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
