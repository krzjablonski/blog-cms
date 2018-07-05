<?php

// page title
$page_title = 'Dashboard';
$page_dsc = 'Lorem Ipsum';
$current_page = isset($_GET['pg']) ? filter_input(INPUT_GET, "pg", FILTER_SANITIZE_NUMBER_INT) : 1;

include 'inc/admin_header.inc.php';

$args = array(
  'table' => 'posts',
  'offset' => 0,
  'limit' => 1,
  'search' => null,
  'category' => null,
);

$post = new Posts($args);
$last_post_id = intval($post->last_post_id());
$last_post = $post->get_single_post($last_post_id);

$media = new Media;

$post_count = $post->count_posts();
$media_count = $media->count_media();

?>

<div class="col-md-12 mb-5">
  <?php if(isset($_GET['edit_title'])): ?>
    <form class="form-inline" action="" method="post">
      <div class="form-group row" style="width:100%;">
        <input class="form-control col-md-9" type="text" name="blog_title" placeholder="Enter new blog title">
        <button type="submit" name="button" class="btn btn-primary col-md-3">Save</button>
      </div>
    </form>
  <?php else: ?>
    <h1><small>Title of your blog:</small> Blog CMS <small><a href="index.php?edit_title=true"><i class="far fa-edit"></i></a></small></h1>
  <?php endif; ?>
</div>

<div class="col-md-4">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title"><a href="single-post.php?id=<?php echo $post->last_post_id(); ?>"><?php echo $last_post['title'] ?></a></h5>
      <h6 class="card-subtitle mb-2 text-muted"><small>Date of publish:</small> <?php echo $last_post['publish_date']; ?></h6>
      <p class="card-text"><?php echo substr($last_post['text'], 0, 120)."[...]"; ?></p>
      <a href="single-post.php?id=<?php echo $post->last_post_id(); ?>" class="card-link">Edit</a>
      <a href="posts.php" class="card-link">See all posts</a>
    </div>
  </div>
</div>

<div class="col-md-4">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Number of published posts</h5>
      <p class="card-text" style="font-size: 2em"><?php echo $post_count['number']; ?></p>
      <a href="posts.php" class="card-link">See all posts</a>
    </div>
  </div>
</div>

<div class="col-md-4">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Number of media items</h5>
      <p class="card-text" style="font-size: 2em"><?php echo $media_count['number']; ?></p>
      <a href="media.php" class="card-link">See all media</a>
    </div>
  </div>
</div>

<?php
include 'inc/admin_footer.inc.php' ?>
