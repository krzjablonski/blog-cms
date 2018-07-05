<?php
$page_title = "Users";
include 'inc/admin_header.inc.php';

$users = new Users;

if( $_SERVER['REQUEST_METHOD'] == 'POST' ){
  $username = trim( filter_input( INPUT_POST, "username", FILTER_SANITIZE_STRING ) );
  $password = trim( filter_input( INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS ) );
  $c_password = trim( filter_input( INPUT_POST, "c_password", FILTER_SANITIZE_SPECIAL_CHARS ) );
  $user_email = trim( filter_input( INPUT_POST, "user_email", FILTER_SANITIZE_EMAIL ) );
  $register_obj = new Login( $username, $password, $c_password, $user_email );

  $register_validation = $register_obj->validate_register_form();
  if( is_bool($register_validation) && $register_validation === true ){
    if( $register_obj->register_user() ){
        echo '<div class="alert alert-success col-md-12" role="alert">User added successfully!</div>';
    }
  }else{
      echo '<div class="alert alert-danger col-md-12" role="alert"><strong>ERROR:</strong> '.$register_validation.'</div>';
  }
}
?>

<div class="col-md-9">
  <?php
  if( isset( $_GET['auth'] ) ){
    $auth_id = filter_input( INPUT_GET, "auth", FILTER_SANITIZE_NUMBER_INT );
    $auth_result = $users->auth_user( $auth_id );
    if( $auth_result ){
      echo '<div class="alert alert-success" role="alert">User authorized successfully!</div>';
    }elseif( !$auth_result ){
      echo '<div class="alert alert-danger" role="alert">Error occured. Please try again later.</div>';
    }
  }elseif( isset( $_GET['delete_id'] ) ){
    $delete_item = filter_input( INPUT_GET, "delete_id", FILTER_SANITIZE_NUMBER_INT );
    $delete_result = $users->delete_user( $delete_item );
      if( $delete_result ){
        echo '<div class="alert alert-success" role="alert">User deleted successfully!</div>';
      }elseif( !$delete_result ){
        echo '<div class="alert alert-danger" role="alert">Error occured. Please try again later.</div>';
      }
    }
  ?>
  <table class="table table-striped">
    <thead>
      <tr>
        <th scope="col">Id</th>
        <th scope="col">Username</th>
        <th scope="col">Email</th>
        <th scope="col">Activate</th>
        <th scope="col">Delete</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach( $users->get_all_users() as $user ): ?>
        <tr>
          <th scope="row"><?php echo $user['id'] ?></th>
          <td><?php echo $user['username'] ?></a></td>
          <td><?php echo $user['email'] ?></a></td>
          <td>
            <?php if( !$user['authorization'] ): ?>
              <a href="users.php?auth=<?php echo $user['id'] ?>"><button class="btn btn-primary btn-sm">Authorization</button></a>
            <?php else: ?>
              <i class="fas fa-check text-success"></i>
            <?php endif; ?>
          </td>
          <td><button class="delete_btn btn btn-danger btn-sm" data-title="<?php echo $user['username'] ?>" data-delete="<?php echo $user['id'] ?>" data-toggle="modal" data-target="#delete_modal"><i class="fas fa-trash-alt"></i></button></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<div class="col-md-3">
  <form class="" action="" method="post">
    <div class="form-group clearfix">
      <h3>Add New Author</h3>
      <label for="username">Enter Username</label>
      <input type="text" name="username" class="form-control mb-3">
      <label for="user_email">Enter Email</label>
      <input type="email" name="user_email" class="form-control mb-2">
      <label for="password">Enter Password</label>
      <input type="password" name="password" class="form-control mb-2">
      <label for="c_password">Confirm password</label>
      <input type="password" name="c_password" class="form-control mb-2">
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
