<?php
$page_title = "Authors";
include 'inc/admin_header.inc.php';

$authors = new Authors;

if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
  $job = filter_input(INPUT_POST, "job", FILTER_SANITIZE_STRING);
  $status = $authors->add_author($name, $job);
}elseif(isset($_GET['delete_id'])){
  $delete_id = filter_input(INPUT_GET, "delete_id", FILTER_SANITIZE_NUMBER_INT);
  $status = $authors->delete_author($delete_id);
}
?>

<div class="col-md-9">
  <?php if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($status) && strtolower($status) == 'success'): ?>
    <div class="alert alert-success" role="alert">
        Author added successfully.
    </div>
  <?php elseif($_SERVER['REQUEST_METHOD'] == 'POST' && isset($status)): ?>
    <div class="alert alert-danger" role="alert">
      <?php echo $status ?>
    </div>
  <?php elseif(isset($_GET['delete_id']) && isset($status) && strtolower($status) == 'success'): ?>
    <div class="alert alert-success" role="alert">
        Author deleted successfully.
    </div>
  <?php elseif(isset($_GET['delete_id']) && isset($status)): ?>
    <div class="alert alert-danger" role="alert">
      <?php echo $status ?>
    </div>
  <?php endif; ?>
  <table class="table table-striped">
    <thead>
      <tr>
        <th scope="col">Id</th>
        <th scope="col">Name</th>
        <th scope="col">Job</th>
        <th scope="col">Delete</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($authors->get_all_authors() as $author): ?>
        <tr>
          <th scope="row"><?php echo $author['author_id'] ?></th>
          <td><?php echo $author['author_name'] ?></a></td>
          <td><?php echo $author['author_position'] ?></td>
          <td><button class="delete_btn btn btn-danger btn-sm" data-title="<?php echo $author['author_name'] ?>" data-delete="<?php echo $author['author_id'] ?>" data-toggle="modal" data-target="#delete_modal"><i class="fas fa-trash-alt"></i></button></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<div class="col-md-3">
  <form class="" action="" method="post">
    <div class="form-group clearfix">
      <h3>Add New Author</h3>
      <label for="name">Enter Authors' Name</label>
      <input type="text" name="name" class="form-control mb-3">
      <label for="job">Enter Authors' Job</label>
      <input type="text" name="job" class="form-control mb-2">
      <button type="submit" name="button" class="btn btn-primary float-right">Add</button>
    </div>
  </form>
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
        <h6>You are deleing Author with:</h6>
        <ul>
          <li id="li_id">Id:</li>
          <li id="li_title">Name:</li>
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
