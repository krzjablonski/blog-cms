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
    // Add post to the database;
    $sql = "INSERT INTO $this->table VALUES (NULL, ?, ?, ?, ?, ?)";

    try {
      $query = $this->connect()->prepare($sql);
      foreach($vals as $key => $val){
        if(is_int($val)){
          $query->bindParam($key+1, $val, PDO::PARAM_INT);
        }else{
          $query->bindParam($key+1, $val, PDO::PARAM_STR);
        }
      }
    } catch (Exception $e) {
      $error_msg = true;
      echo $e->getMessage();
    }

    if(isset($error_msg)){
      return 'Error. Please try again later.';
    }else{
      return 'Sucess';
    }


  }

  public function delete_post(){
    // deletes post from database;
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

    while($row = $query->fetch(PDO::FETCH_ASSOC)){
      $output['categories'][] = $row['category_name'];
    }

    return $output;

  }

  public function get_posts(){
    try {
      $sql = "SELECT * FROM $this->table";
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
          $query = $this->connect()->prepare($sql.' JOIN posts_categories ON posts_categories.post_id = posts.id
                                                    JOIN categories ON categories.category_id = posts_categories.category_id
                                                    WHERE categories.category_name = ? AND title LIKE ? ORDER BY ? LIMIT ? OFFSET ?');
          $query->bindParam(1, $this->category, PDO::PARAM_STR);
          $query->bindValue(2, "%".$this->search."%", PDO::PARAM_STR);
          $query->bindParam(3, $this->sort, PDO::PARAM_STR);
          $query->bindParam(4, $this->limit, PDO::PARAM_INT);
          $query->bindParam(5, $this->offset, PDO::PARAM_INT);
        }
        $query->execute();
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
          $output[$row['id']]['title'] = $row['title'];
          $output[$row['id']]['text'] = $row['text'];
          $output[$row['id']]['author_id'] = $row['author_id'];
          $output[$row['id']]['image_id'] = $row['image_id'];
          $output[$row['id']]['categories'][] = $row['category_name'];
        }

      }else{
        if(empty($this->search)){
          $query = $this->connect()->prepare($sql.' ORDER BY ? LIMIT ? OFFSET ?');
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
          $output[$row['id']] = array_merge($output[$row['id']], $this->get_categories($row['id']));
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
    $sql = "SELECT * FROM $this->table";

    $query = $this->connect()->prepare($sql. ' WHERE id = ?');
    $query->bindParam(1, $id, PDO::PARAM_INT);
    $query->execute();

    $output = $query->fetch(PDO::FETCH_ASSOC);
    $output = array_merge($output, $this->get_categories($id));

    return $output;
    }
  }
