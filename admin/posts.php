<?php

$page_title = 'Posts';
$page_dsc = 'All your posts';
$current_page = isset($_GET['pg']) ? filter_input(INPUT_GET, "pg", FILTER_SANITIZE_NUMBER_INT) : 1;

include 'inc/admin_header.inc.php';

$page_args = array(
  'search' => isset($_GET['search']) ? filter_input(INPUT_GET, "search", FILTER_SANITIZE_STRING) : null,
  'category' => isset($_GET['cat']) ? filter_input(INPUT_GET, "cat", FILTER_SANITIZE_STRING) : null,
  'page' => isset($_GET['page']) ? filter_input(INPUT_GET, "page", FILTER_SANITIZE_STRING) : null,
);

$pagination = new Pagination($current_page, 2, 'posts', $page_args);
$args = array(
  'table' => 'posts',
  'offset' => $pagination->get_offset(),
  'limit' => $pagination->get_limit(),
  'search' => isset($_GET['search']) ? filter_input(INPUT_GET, "search", FILTER_SANITIZE_STRING) : null,
  'category' => isset($_GET['cat']) ? filter_input(INPUT_GET, "cat", FILTER_SANITIZE_STRING) : null,
);

$posts = new Posts($args);

if(isset($_GET['delete_id'])){
  $status = $posts->delete_post(filter_input(INPUT_GET, "delete_id", FILTER_SANITIZE_NUMBER_INT));
}

?>
<div class="col-md-3 order-md-2">
  <?php if(isset($status) && $status === true):?>
    <div class="alert alert-success" role="alert">
      Post deleted successfully
    </div>
  <?php elseif(isset($status) && $status === false): ?>
    <div class="alert alert-danger" role="alert">
      Error: Couldn't remove post
    </div>
  <?php endif ?>
  <form class="form" action="" method="get">
    <div class="form-group">
      <label for="category">Select category</label>
      <select class="form-control mb-3" name="cat" id="category">
        <option value="">All categories</option>
        <?php
          foreach(Posts::get_all_categories() as $cat){
            if(isset($_GET['cat']) && $_GET['cat'] == $cat['category_name']){
              echo '<option value="'.$cat['category_name'].'" selected>'.$cat['category_name'].'</option>';
            }else{
              echo '<option value="'.$cat['category_name'].'">'.$cat['category_name'].'</option>';
            }
          }
        ?>
      </select>
      <label for="search">Search by title</label>
      <input class="form-control mb-3" type="text" name="search" value="<?php if(isset($_GET['search'])){echo filter_input(INPUT_GET, "search", FILTER_SANITIZE_STRING); } ?>">
      <input class="btn btn-primary" type="submit" value="Find">
      <a href="posts.php"><div class="btn btn-danger">Reset</div></a>
    </div>
  </form>
  <div class="form-group d-flex justify-content-between align-items-center">
    <h5 style="margin:0;">Add New Post</h5>
    <a href="single-post.php"><button class="btn btn-primary"><i class="fas fa-plus"></i></button></a>
  </div>
</div>

<div class="col-md-9 order-md-1">
  <ul class="pagination justify-content-end">
    <?php echo $pagination->show_pagination_back(); ?>
  </ul>
  <table class="table table-striped">
    <thead>
      <tr>
        <th scope="col">Id</th>
        <th scope="col">Title</th>
        <th scope="col">Category</th>
        <th scope="col">Publish date</th>
        <th scope="col">Author</th>
        <th scope="col">Delete</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($posts->get_posts() as $post): ?>
        <tr>
          <th scope="row"><?php echo $post['id'] ?></th>
          <td><a href="single-post.php?id=<?php echo $post['id']?>"><?php echo $post['title'] ?></a></td>
          <td><?php echo implode(', ', $post['categories']) ?></td>
          <td><?php echo $post['publish_date'] ?></td>
          <td><?php echo $post['author_name'] ?></td>
          <td><button class="delete_btn btn btn-danger btn-sm" data-title="<?php echo $post['title'] ?>" data-delete="<?php echo $post['id'] ?>" data-toggle="modal" data-target="#delete_modal"><i class="fas fa-trash-alt"></i></button></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <ul class="pagination justify-content-end">
    <?php echo $pagination->show_pagination_back(); ?>
  </ul>
</div>

<div class="modal fade" id="delete_modal" role="dialog" aria-labelledby="delete_modal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 clas="modal-title">Delete this post?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6>You are deleing post with:</h6>
        <ul>
          <li id="li_id">Id:</li>
          <li id="li_title">Title:</li>
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <a href="" id="delete_post_btn"><button type="button" class="btn btn-danger">Delete</button></a>
      </div>
    </div>
  </div>
</div>

<?php include 'inc/admin_footer.inc.php' ?>
