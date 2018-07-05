<?php

class Users extends Dbh{
  public function get_all_users(){
    $sql = "SELECT * FROM users";
    try {
      $query = $this->connect()->query( $sql );
      $output = $query->fetchAll(PDO::FETCH_ASSOC);
    } catch ( Exception $e ) {
      $error_message = $e->getMessage();
    }

    if( isset( $error_message ) ){
      error_log( $error_message );
      return false;
    }else{
      return $output



      ;
    }

  }

  public function auth_user( $id ){
    $sql = "UPDATE users SET authorization = 1 WHERE id = ?";
    try {
      $query = $this->connect()->prepare( $sql );
      $query->bindParam( 1, $id, PDO::PARAM_STR );
      $query->execute();
    } catch ( Exception $e ) {
      $error_message = $e->getMessage();
    }

    if( isset( $error_message ) ){
      error_log( $error_message );
      return false;
    }else{
      return true;
    }

  }

  public function delete_user( $id ){
    $sql = "DELETE FROM users WHERE id = ?";
    try {
      $query = $this->connect()->prepare( $sql );
      $query->bindParam( 1, $id, PDO::PARAM_STR);
      $query->execute();
    } catch ( Exception $e ) {
      $error_message = $e->getMessage();
    }

    if( isset( $error_message ) ){
      error_log( $error_message );
      return false;
    }else{
      return true;
    }
  }
}
