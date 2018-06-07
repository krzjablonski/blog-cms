<?php

$page_title = 'Posts';
$page_dsc = 'All your posts';

include 'inc/admin_header.inc.php';

$args = array(
  'table' => 'posts',
  'offset' => 0,
  'limit' => 1,
  'search' => isset($_GET['search']) ? filter_input(INPUT_GET, "search", FILTER_SANITIZE_STRING) : null,
  'category' => isset($_GET['cat']) ? filter_input(INPUT_GET, "cat", FILTER_SANITIZE_STRING) : null,
);

$single_post = new Posts($args);
$categories = Posts::get_all_categories();
$authors = Posts::get_all_authors();
$media = new Media;
$media_items = $media->get_all_media();

if(isset($_GET['id'])){
  $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
  $post = $single_post->get_single_post($id);
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){

  $vals = array(
    'image_id' => filter_input(INPUT_POST, "image_id", FILTER_SANITIZE_NUMBER_INT),
    'title' => filter_input(INPUT_POST, "post_title", FILTER_SANITIZE_STRING),
    'text' => filter_input(INPUT_POST, "post_text", FILTER_SANITIZE_STRING),
    'author_id' => filter_input(INPUT_POST, "author_id", FILTER_SANITIZE_NUMBER_INT),
    'publish_date' => filter_input(INPUT_POST, "publish_date", FILTER_SANITIZE_STRING),
    'category' => filter_input(INPUT_POST, "category", FILTER_SANITIZE_NUMBER_INT, FILTER_FORCE_ARRAY),
  );

  if(isset($_GET['id'])){
    $status = $single_post->update_post($id, $vals);
    if($status == "success"){
      header("location:single-post.php?id=".$id);
    }
  }else{
    $status = $single_post->add_post($vals);
    if($status == "success"){
      header("location:single-post.php?id=".$single_post->last_post_id());
    }
  }

}
?>


<form class="col" action="" method="post">
  <?php if(isset($status) && $status != "success"): ?>
    <div class="alert alert-danger" role="alert">
      <?php echo $status; ?>
   </div>
  <?php endif; ?>
  <div class="row">
    <div class="col-md-9">
      <div class="form-group">
        <label for="post_title">Title of the post</label>
        <input class="form-control" type="text" name="post_title" id="post_title" value="<?php if(isset($post)){echo $post['title'];}elseif(isset($vals['title'])){echo $vals['title'];} ?>">
      </div>
      <div class="form-group">
        <label for="post_text">Text of the post</label>
        <textarea class="form-control" rows="30" name="post_text" id="post_text"><?php if(isset($post)){echo $post['text'];}elseif(isset($vals['text'])){echo $vals['text'];} ?></textarea>
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <h3>Operations</h3>
        <button type="submit" name="button" class="btn btn-primary btn-lg">Update</button>
      </div>
      <div class="form-group">
        <label for="publish_date"><h3>Set Publish date<h3></label>
        <input class="form-control datepicker" type="text" placeholder="choose" name="publish_date" id="publish_date" autocomplete="off" >
      </div>
      <div class="form-group">
        <img class="featured-img" src="<?php if(isset($post)){echo "../upload/".$post['file_name']; } ?>" alt="">
        <h3>Add Image</h3>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#media_modal">
          <?php
            if(isset($post['file_name'])){
              echo "Change";
            }else{
              echo "Add New";
            }
          ?>
        </button>
      </div>
      <div class="form-group">
        <h3>Categories</h3>
        <?php
          foreach($categories as $category){
            if(isset($post) && in_array($category['category_name'], $post['categories'])){
              echo "<div class='form-check'>";
              echo '<input checked class="form-check-input" name="category[]" type="checkbox" value="'.$category['category_id'].'">';
              echo '<lable class="form-check-label" for="'.$category['category_name'].'">'.$category['category_name'].'</label>';
              echo '</div>';
            }else{
              echo "<div class='form-check'>";
              echo '<input class="form-check-input" name="category[]" type="checkbox" value="'.$category['category_id'].'">';
              echo '<lable class="form-check-label" for="'.$category['category_name'].'">'.$category['category_name'].'</label>';
              echo '</div>';
            }
          }
        ?>
      </div>
      <div class="form-group">
        <label for="Author">Select Author</label>
        <select class="form-control" name="author_id">
          <option>-- Select Author --</option>
          <?php
            foreach($authors as $author){
              if((isset($post) && $post['author_id'] == $author['author_id']) || (isset($vals['author_id']) && $vals['author_id'] == $author['author_id'])){
                echo '<option selected value="'.$author['author_id'].'">'.$author['author_name'].' - '.$author['author_position'].'</option>';
              }else{
                echo '<option value="'.$author['author_id'].'">'.$author['author_name'].' - '.$author['author_position'].'</option>';
              }
            }
          ?>
        </select>
      </div>
    </div>
  </div>
  <div class="modal fade" id="media_modal" role="dialog" aria-labelledby="media_modal" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 1000px;">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Select Photo</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group d-flex">
            <?php foreach($media_items as $key => $item): ?>
              <?php if($post['image_id'] == $item['id']): ?>
                <div class="col-md-3">
                  <label for="image-<?php echo $item['id'] ?>">
                    <img src="../upload/<?php echo $item['file_name'] ?>" alt="<?php echo $item['alt_tag'] ?>" class="img-thumbnail">
                    <input checked class="media_input" data-name="<?php echo $item['file_name'] ?>" hidden type="radio" id="image-<?php echo $item['id'] ?>" name="image_id" value="<?php echo $item['id'] ?>">
                  </label>
                </div>
              <?php else: ?>
                <div class="col-md-3">
                  <label for="image-<?php echo $item['id'] ?>">
                    <img src="../upload/<?php echo $item['file_name'] ?>" alt="<?php echo $item['alt_tag'] ?>" class="img-thumbnail">
                    <input class="media_input" data-name="<?php echo $item['file_name'] ?>" hidden type="radio" id="image-<?php echo $item['id'] ?>" name="image_id" value="<?php echo $item['id'] ?>">
                  </label>
                </div>
              <?php endif; ?>
            <?php endforeach; ?>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" data-media_btn="save" data-dismiss="modal">Save changes</button>
        </div>
      </div>
    </div>
  </div>
</form>


<?php include 'inc/admin_footer.inc.php' ?>
