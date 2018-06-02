<?php

$page_title = 'Posts';
$page_dsc = 'All your posts';
$current_page = isset($_GET['pg']) ? filter_input(INPUT_GET, "pg", FILTER_SANITIZE_NUMBER_INT) : 1;

include 'inc/admin_header.inc.php';

$page_args = array(
  'search' => isset($_GET['search']) ? filter_input(INPUT_GET, "search", FILTER_SANITIZE_STRING) : null,
  'category' => isset($_GET['category']) ? filter_input(INPUT_GET, "category", FILTER_SANITIZE_STRING) : null,
  'page' => isset($_GET['page']) ? filter_input(INPUT_GET, "page", FILTER_SANITIZE_STRING) : null,
);

$pagination = new Pagination($current_page, 4, 'posts', $page_args);
$args = array(
  'table' => 'posts',
  'offset' => $pagination->get_offset(),
  'limit' => $pagination->get_limit(),
  'search' => isset($_GET['search']) ? filter_input(INPUT_GET, "search", FILTER_SANITIZE_STRING) : null,
  'category' => isset($_GET['category']) ? filter_input(INPUT_GET, "category", FILTER_SANITIZE_STRING) : null,
);

$posts = new Posts($args);

?>
<div class="col-md-12">
  <button class="btn btn-primary" type="button" name="button">Add New Post</button>
</div>
<div class="col-md-12">
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
          <td><?php echo $post['title'] ?></td>
          <td><?php echo implode(', ', $post['categories']) ?></td>
          <td><?php echo $post['publish_date'] ?></td>
          <td><?php echo $post['author_id'] ?></td>
          <td>x</td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <ul class="pagination justify-content-end">
    <?php echo $pagination->show_pagination_back(); ?>
  </ul>
</div>
