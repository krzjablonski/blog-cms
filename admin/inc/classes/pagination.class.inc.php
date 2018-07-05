<?php

class Pagination extends Dbh {
  // variables
  protected $table;
  protected $column;
  protected $current_page;
  protected $items_per_page;
  protected $connection;
  protected $search;
  protected $page;
  protected $category;

  // End of variables

  // Construct method
  function __construct($current_page, $items_per_page, $table, $args){
    $this->connection = $this->connect();
    $this->current_page = $current_page;
    $this->items_per_page = $items_per_page;
    $this->table = $table;
    $this->column = "id";
    $this->search = isset($args['search']) ? $args['search'] : null;
    $this->page = isset($args['page']) ? $args['page'] : null;
    $this->category = isset($args['category']) ? $args['category'] : null;
  }
  // End of construct method

  // Get total items count
  function total_items(){
    try{
      $column = $this->table.".".$this->column;
      $sql = "SELECT COUNT($column) FROM $this->table ";

      if(!empty($this->category) && $this->table = "posts"){
        if(!empty($this->search)){
          $query = $this->connection->prepare($sql.'JOIN posts_categories ON posts_categories.post_id = posts.id
                                                    JOIN categories ON categories.category_id = posts_categories.category_id
                                                    WHERE categories.category_name = ? AND title LIKE ?');
          $query->bindParam(1, $this->category, PDO::PARAM_STR);
          $query->bindValue(2, "%".$this->search."%");
        }else{
          $query = $this->connection->prepare($sql.'JOIN posts_categories ON posts_categories.post_id = posts.id
                                                    JOIN categories ON categories.category_id = posts_categories.category_id
                                                    WHERE categories.category_name = ?');
          $query->bindParam(1, $this->category, PDO::PARAM_STR);
        }
      }else{
        if(!empty($this->search)){
          $query = $this->connection->prepare($sql." WHERE title LIKE ?");
          $query->bindValue(1, "%".$this->search."%");
        }else{
          $query = $this->connection->prepare($sql);
        }
      }
      $query->execute();
      $output = $query->fetchColumn(0);
    }catch(Exception $e){
      echo $e->getMessage();
    }
    return $output;
  }

  // total number of pages
  public function number_of_pages(){
    return ceil($this->total_items() / $this->items_per_page);
  }

  // Get offset
  public function get_offset(){
    return ($this->current_page-1)*$this->items_per_page;
  }

// limit and offset to add to query
  public function get_limit(){
    return $this->items_per_page;
  }

  // Next page method

  function next_page(){
    if($this->current_page >= $this->number_of_pages()){
      return $this->number_of_pages();
    }else{
      return $this->current_page+1;
    }
  }

  // End of Next page method

  // Prev page method

  function prev_page(){
    if($this->current_page <= 1){
      return 1;
    }else{
      return $this->current_page-1;
    }
  }

// End of Prev page method

  public function show_pagination_back(){
    $page = explode('\\', $this->page);
    if(isset($this->search)){
      $search = '&search='.$this->search;
    }else{
      $search = "";
    }

    if(isset($this->category)){
      $category = '&cat='.$this->category;
    }else{
      $category = "";
    }

    $output = ' <li class="page-item"><a class="page-link" href="'.end($page).'?cat='.$this->category.$search.'&pg='.$this->prev_page().'"><span aria-hidden="true">&laquo;</span></a></li>';
    for($i=1; $i<=$this->number_of_pages(); $i++){
      if($this->current_page == $i){
        $output .= ' <li class="page-item active"><a class="page-link">'.$i.'</a></li> ';
      }else{
        $output .= '<li class="page-item"><a href="'.end($page).'?pg='.$i.$category.$search.'" class="page-link">'.$i.'</a></li> ';
      }
    }
    $output .= ' <li class="page-item"><a class="page-link" href="'.end($page).'?cat='.$this->category.$search.'&pg='.$this->next_page().'"><span aria-hidden="true">&raquo;</span></a></li>';
    return $output;
  }

}
