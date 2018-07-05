<?php

class Login extends Dbh{
  private $username;
  private $password;
  private $c_password;
  private $email;

  function __construct( $username, $password, $c_password, $user_email ){
    $this->username = $username;
    $this->password = $password;
    $this->c_password = isset( $c_password ) ? $c_password : null;
    $this->email = isset( $user_email ) ? $user_email : null;
  }
  public function is_username_available(){
    $sql = "SELECT COUNT( username ) FROM users WHERE username = ? OR email = ?";
    try {
      $query = $this->connect()->prepare( $sql );
      $query->bindParam( 1, $this->username, PDO::PARAM_STR );
      $query->bindParam( 2, $this->email, PDO::PARAM_STR );
      $query->execute();
      $usernames_count = $query->fetchColumn();
    } catch ( Exception $e ) {
      $error_message = $e->getMessage();
    }

    if(isset( $error_message )){
      return $error_message;
    }else{
      if( $usernames_count > 0 ){
        return false;
      }else{
        return true;
      }
    }
  }

  public function validate_register_form(){
    if( empty( $this->username ) || empty( $this->password ) || empty( $this->c_password ) || empty( $this->email ) ){
      $error_message = "Fill in all fields";
      return $error_message;
    }else{
      // Validate email address
      if( !filter_var( $this->email, FILTER_VALIDATE_EMAIL ) ){
        $error_message = "Email is invalid. \n";
        return $error_message;
      }
      // Check if username or email ar taken
      $status = $this->is_username_available();
      if( $status === false ){
        $error_message = "This username or email are taken. \n";
        return $error_message;
      }elseif( is_string( $status ) ){
        // Database error
        $error_message = $status;
        return $error_message;
      }else{
        // Check if passwords match
        if($this->password !== $this->c_password){
          $error_message = "Passwords do not match. \n";
          return $error_message;
        // Check if password is longer than 6 characters
      }elseif( strlen( $this->password ) < 6 ){
          $error_message = "Passwords needs to be longer than 6 characters \n";
          return $error_message;
        }elseif( !preg_match( '/\d/', $this->password ) ){
          $error_message = "Passwords needs to contain at least one digit. \n";
          return $error_message;
        }else{
          return true;
        }
      }
    }
  }

  public function register_user(){
    $sql = "INSERT INTO users VALUES ( NULL, ?, ?, ?, DEFAULT )";
    $hpas = password_hash( $this->password, PASSWORD_DEFAULT );
    try {
      $query = $this->connect()->prepare( $sql );
      $query->bindParam( 1, $this->username, PDO::PARAM_STR );
      $query->bindParam( 2, $hpas, PDO::PARAM_STR );
      $query->bindParam( 3, $this->email, PDO::PARAM_STR );
      $query->execute();
    } catch ( Exception $e ) {
      $error_message = $e->getMessage();
    }

    if( isset( $error_message ) ){
      return $error_message;
    }else{
      return true;
    }
  }

  private function is_valid_login(){
    $sql = "SELECT COUNT( id ) FROM users WHERE username = ?";
    try {
      $query = $this->connect()->prepare( $sql );
      $query->bindParam( 1, $this->username, PDO:: PARAM_STR );
      $query->execute();
      $output = $query->fetchColumn();
    } catch ( Exception $e ) {
      $error_message = $e->getMessage();
    }

    if( isset( $error_message ) || $output == 0 ){
      return false;
    }elseif( $output > 0 ){
      return true;
    }

  }

  private function get_current_user(){
    $sql = "SELECT * FROM users WHERE username = ?";

    try {
      $query = $this->connect()->prepare( $sql );
      $query->bindParam( 1, $this->username, PDO::PARAM_STR );
      $query->execute();
      $output = $query->fetch(PDO::FETCH_ASSOC);
    } catch ( Exception $e ) {
      $error_message = $e->getMessage();
    }

    if( !empty( $output ) && !isset( $error_message ) ){
      return $output;
    }else{
      return false;
    }

  }

  public function login(){
    if( empty( $this->username ) || empty( $this->password ) ){
      return false;
    }else{
      $is_valid_login = $this->is_valid_login();
      if(  !$is_valid_login ){
        return false;
        echo "invalid login";
      }else{
        $current_user = $this->get_current_user();
        $checkPassword = password_verify( $this->password, $current_user['password'] );
        if( $checkPassword === false ){
          return false;
          echo "wrong password";
        }elseif( $checkPassword === true ){
          $_SESSION['user_id'] = $current_user['id'];
          $_SESSION['username'] = $current_user['username'];
          return true;
        }
      }
    }
  }
}
