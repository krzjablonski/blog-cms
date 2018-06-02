<?php

class Dbh {
  private $DB_host = 'localhost';
  private $DB_driver = 'mysql';
  private $DB_database = 'bs_blog_cms';
  private $DB_user_name = 'root';
  private $DB_user_password = '';
  private $DB_charset = 'utf8mb4';

  protected function connect(){
    try {
      $dsn = $this->DB_driver.':host='.$this->DB_host.';dbname='.$this->DB_database.';charset='.$this->DB_charset;
      $pdo = new PDO($dsn, $this->DB_user_name, $this->DB_user_password);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (Exception $e) {
      echo 'Connection failed: '.$e->getMessage();
    }
    return $pdo;
  }
}
