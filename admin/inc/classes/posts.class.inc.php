<?php

// This class is used for extracting posts and pages form database. It requires limit and offset that should be provided by Pagination class nad passed as parameter for construct method.

class Posts extends Dbh {
  private $table;
  private $limit_and_offset;
  private $category;
  private $sort;
  private $limit;
  private $offset;
  private $search;

  function __construct($args){
    $this->table = $args['table'];

    if(isset($args['category'])){
      $this->category = $args['category'];
    }else{
      $this->category = null;
    }

    if(isset($args['search'])){
      $this->search = $args['search'];
    }else{
      $this->search = null;
    }


    if(isset($args['sort'])){
      $this->sort = $args['sort'];
    }else{
      $this->sort = 'id';
    }
    $this->limit = $args['limit'];
    $this->offset = $args['offset'];
  }

  public function add_post($vals){
    foreach($vals as $val){
      if(empty($val)){
        $error_message = "Please fill in all fields";
        return $error_message;
      }
    }

    $sql_placeholders = array();
    foreach($vals as $key => $val){
      if($key != 'category'){
        $sql_placeholders[] = "?";
      }
    }

    $sql_placeholders = implode(', ', $sql_placeholders);

    $sql = "INSERT INTO $this->table VALUES (NULL, $sql_placeholders)";

    try {
      $query = $this->connect()->prepare($sql);
      $counter = 1;
      foreach($vals as $key => $val){
        if($key != 'category'){
          if($key == 'image_id' || $key == 'author_id'){
            $query->bindParam($counter, $vals[$key], PDO::PARAM_INT);
          }else{
            $query->bindParam($counter, $vals[$key], PDO::PARAM_STR);
          }
        }
        $counter++;
      }
      $query->execute();
    } catch (Exception $e) {
      $error_message = "Posts error: ".$e->getMessage();
    }


    if(!isset($error_message) && $this->table == 'posts'){
      $last_post_id = $this->last_post_id();
      $connection = $this->connect();
      foreach($vals['category'] as $cat){
        try {
          $sql = "INSERT INTO posts_categories VALUES (NULL, ?, ?)";
          $query = $connection->prepare($sql);
          $query->bindParam(1, $last_post_id, PDO::PARAM_INT);
          $query->bindParam(2, $cat, PDO::PARAM_INT);
          $query->execute();
        } catch (Exception $e) {
          $error_message .= "Category error: ".$e->getMessage()."<br>";
          echo $error_message;
        } //end try
      } //endforeach
    } //endif

    if(isset($error_message)){
      return $error_message;
    }else{
      return "success";
    }

  }

  public function update_post($id, $vals){
    foreach($vals as $val){
      if(empty($val)){
        $error_message = "Please fill in all fields";
        return $error_message;
      }
    }

    $sql_placeholders = array();
    foreach($vals as $key => $val){
      if($key != 'category'){
        $sql_placeholders[] = " $key = ?";
      }
    }
    $sql_placeholders = implode(', ', $sql_placeholders);
    $sql = "UPDATE $this->table SET id = ?, $sql_placeholders  WHERE id = ?";

    try {
      $query = $this->connect()->prepare($sql);
      $query->bindParam(1, $id, PDO::PARAM_INT);
      $counter = 2;
      foreach($vals as $key => $val){
        if($key != 'category'){
          if($key == 'image_id' || $key == 'author_id'){
            $query->bindParam($counter, $vals[$key], PDO::PARAM_INT);
          }else{
            $query->bindParam($counter, $vals[$key], PDO::PARAM_STR);
          }
          $counter++;
        }
      }
      $query->bindParam($counter, $id, PDO::PARAM_INT);
      $query->execute();
    } catch (Exception $e) {
      $error_message = "Posts error: ".$e->getMessage()."<br>";
    }

    if(!isset($error_message) && $this->table == 'posts'){
      try {
        $sql = "DELETE FROM posts_categories
                WHERE post_id = ?";
        $query = $this->connect()->prepare($sql);
        $query->bindParam(1, $id, PDO::PARAM_INT);
        $query->execute();
      } catch (Exception $e) {
        $error_message = "Delete error: ".$e->getMessage()."<br>";
      }
    }

    if(!isset($error_message) && $this->table == 'posts'){
      $connection = $this->connect();
      foreach($vals['category'] as $cat){
        try {
          $sql = "INSERT INTO posts_categories VALUES (NULL, ?, ?)";
          $query = $connection->prepare($sql);
          $query->bindParam(1, $id, PDO::PARAM_INT);
          $query->bindParam(2, $cat, PDO::PARAM_INT);
          $query->execute();
        } catch (Exception $e) {
          $error_message .= "Category error: ".$e->getMessage()."<br>";
        } //end try
      } //endforeach
    } //endif


    if(isset($error_message)){
      return $error_message;
    }else{
      return "success";
    }
  }

  public function last_post_id(){
      try {
        $query = $this->connect()->query("SELECT id FROM $this->table ORDER BY id DESC LIMIT 1");
        $output = $query->fetch(PDO::FETCH_ASSOC);
        $output = $output['id'];
      } catch (Exception $e) {
        $error_message = "last_post_id error: ".$e->getMessage();
      }

      if(isset($error_message)){
        return $error_message;
      }else{
        return $output;
      }

  }

  public function delete_post($id){
    $sql_posts = "DELETE FROM $this->table WHERE $this->table.id = ?";
    if($this->table == 'posts'){
      $sql_categories = "DELETE FROM posts_categories WHERE posts_categories.post_id = ?";
    }

    try {
      $query = $this->connect()->prepare($sql_posts);
      $query->bindParam(1, $id, PDO::PARAM_STR);
      $query->execute();
    } catch (Exception $e) {
      $status = false;
      echo "Couldn't remove post: ".$e->getMessage();
    }

    if(isset($sql_categories)){
      try {
        $query = $this->connect()->prepare($sql_categories);
        $query->bindParam(1, $id, PDO::PARAM_STR);
        $query->execute();
      } catch (Exception $e) {
        $status = false;
        echo "Couldn't remove categories connection: ".$e->getMessage();
      }

    }
    if(isset($status) && $status == false){
      return false;
    }else{
      return true;
    }

  }

  public static function get_all_categories(){
    $sql = "SELECT category_id, category_name from categories";
    $connect = new Dbh;
    return $connect->connect()->query($sql)->fetchAll(PDO::FETCH_ASSOC);
  }


  private function get_categories($id){
    $sql = "SELECT category_name FROM categories LEFT JOIN posts_categories ON categories.category_id = posts_categories.category_id WHERE post_id = ?";

    try {
      $query = $this->connect()->prepare($sql);
      $query->bindParam(1, $id, PDO::PARAM_INT);
      $query->execute();
    } catch (Exception $e) {
      echo $e->getMessage();
    }
    $output= array();
    while($row = $query->fetch(PDO::FETCH_ASSOC)){
      $output['categories'][] = $row['category_name'];
    }

    return $output;

  }

  public function get_posts(){
    try {
      $author_id = $this->table.".author_id";
      $sql = "SELECT * FROM $this->table JOIN authors ON authors.author_id = $author_id ";
      $this->sort = $this->table.'.'.$this->sort;

      if(!empty($this->category) && $this->table == 'posts'){
        if(empty($this->search)){
          $query = $this->connect()->prepare($sql." JOIN posts_categories ON posts_categories.post_id = posts.id
                                                    JOIN categories ON categories.category_id = posts_categories.category_id
                                                    WHERE categories.category_name = ? ORDER BY ? LIMIT ? OFFSET ?");
          $query->bindParam(1, $this->category, PDO::PARAM_STR);
          $query->bindParam(2, $this->sort, PDO::PARAM_STR);
          $query->bindParam(3, $this->limit, PDO::PARAM_INT);
          $query->bindParam(4, $this->offset, PDO::PARAM_INT);
        }else{
          $query = $this->connect()->prepare($sql." JOIN posts_categories ON posts_categories.post_id = posts.id
                                                    JOIN categories ON categories.category_id = posts_categories.category_id
                                                    WHERE categories.category_name = ? AND title LIKE ? ORDER BY ? LIMIT ? OFFSET ?");
          $query->bindParam(1, $this->category, PDO::PARAM_STR);
          $query->bindValue(2, "%".$this->search."%", PDO::PARAM_STR);
          $query->bindParam(3, $this->sort, PDO::PARAM_STR);
          $query->bindParam(4, $this->limit, PDO::PARAM_INT);
          $query->bindParam(5, $this->offset, PDO::PARAM_INT);
        }
        $query->execute();
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
          $output[$row['id']]['id'] = $row['id'];
          $output[$row['id']]['title'] = $row['title'];
          $output[$row['id']]['text'] = $row['text'];
          $output[$row['id']]['author_id'] = $row['author_id'];
          $output[$row['id']]['author_name'] = $row['author_name'];
          $output[$row['id']]['image_id'] = $row['image_id'];
          $output[$row['id']]['publish_date'] = $row['publish_date'];
          $output[$row['id']]['categories'][] = $row['category_name'];
        }

      }else{
        if(empty($this->search)){
          $query = $this->connect()->prepare($sql." ORDER BY ? LIMIT ? OFFSET ?");
          $query->bindParam(1, $this->sort, PDO::PARAM_STR);
          $query->bindParam(2, $this->limit, PDO::PARAM_INT);
          $query->bindParam(3, $this->offset, PDO::PARAM_INT);
        }else{
          $query = $this->connect()->prepare($sql." WHERE title LIKE ? ORDER BY ? LIMIT ? OFFSET ?");
          $query->bindValue(1, "%".$this->search."%", PDO::PARAM_STR);
          $query->bindParam(2, $this->sort, PDO::PARAM_STR);
          $query->bindParam(3, $this->limit, PDO::PARAM_INT);
          $query->bindParam(4, $this->offset, PDO::PARAM_INT);
        }

        $query->execute();
        $output = array();
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
          $output[$row['id']] = $row;
          if($this->table == 'posts'){
            $output[$row['id']] = array_merge($output[$row['id']], $this->get_categories($row['id']));
          }
        }

      }



    } catch (Exception $e) {
      echo $e->getMessage();
    }

    if(isset($output)){
      return $output;
    }else{
      return false;
    }
  }

  public function get_single_post($id){
    $sql = "SELECT * FROM $this->table LEFT JOIN Media ON $this->table.image_id = Media.id";

    $query = $this->connect()->prepare($sql. " WHERE $this->table.id = ?");
    $query->bindParam(1, $id, PDO::PARAM_INT);
    $query->execute();
    $output = $query->fetch(PDO::FETCH_ASSOC);

    if($this->table == 'posts'){
      $output = array_merge($output, $this->get_categories($id));
    }

    return $output;
    }

  public function count_posts(){
    $sql = "SELECT COUNT(id) AS \"number\" FROM $this->table";
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
