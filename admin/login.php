<?php

$page_title = "Login";

include 'inc/admin_header.inc.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $username = trim( filter_input( INPUT_POST, "username", FILTER_SANITIZE_STRING ) );
  $password = trim( filter_input( INPUT_POST, "pas", FILTER_SANITIZE_SPECIAL_CHARS ) );
  $c_password = trim( filter_input( INPUT_POST, "pas2", FILTER_SANITIZE_SPECIAL_CHARS ) );
  $user_email = trim( filter_input( INPUT_POST, "user_email", FILTER_SANITIZE_EMAIL ) );
  $users = new Login( $username, $password, $c_password, $user_email );

  if( isset( $_GET['reg'] ) ){
    $register_validation = $users->validate_register_form();
    if( is_bool($register_validation) && $register_validation === true ){
      if( $users->register_user() ){
         header("location:login.php?registered=true");
         exit();
      }else{
        $error_message = "Error";
      }
    }else{
      $error_message = $register_validation;
    }
  }else{
    if( $users->login() === true ){
      header("location: index.php");
      exit();
    }else{
      $error_message = "Login or password incorect. Please try again";
    }
  }
}

?>

<?php if( !empty( $error_message ) ): ?>
  <div class="col-md-12">
    <div class="alert alert-danger" role="alert">
      <strong>Error:</strong> <?php echo $error_message; ?>
    </div>
  </div>
<?php endif; ?>
<?php if( isset( $_GET['registered'] ) && $_GET['registered'] == 'true' ): ?>
  <div class="col-md-12">
    <div class="alert alert-success" role="alert">
      You are now registered. Please use your login and password to Sign In.
    </div>
  </div>
<?php endif; ?>

<?php if( !isset($_GET['reg'] ) ): ?>
  <div class="col-md-12">
    <form class="" action="" method="post">
      <div class="form-group">
        <h2>Log in</h2>
        <label for="login">Username</label>
        <input type="text" name="username" id="login" class="form-control mb-3">
        <label for="pas">Password</label>
        <input type="password" name="pas" id="pas" class="form-control mb-3">
        <button type="submit" name="button" class="btn btn-primary btn-block mb-2">Login</button>
        <a href="login.php?reg=true">Don't have an account? Register.</a>
        </div>
      </div>
    </form>
  </div>
<?php else: ?>
  <div class="col-md-12">
    <form class="" action="" method="post">
      <div class="form-group">
        <h2>Register</h2>
        <label for="login">Username</label>
        <input type="text" name="username" id="login" class="form-control mb-3">
        <label for="user_email">Email</label>
        <input type="email" name="user_email" id="user_email" class="form-control mb-3">
        <label for="pas">Password</label>
        <input type="password" name="pas" id="pas" class="form-control mb-3">
        <label for="pas2">Confirm password</label>
        <input type="password" name="pas2" id="pas2" class="form-control mb-3">
        <button type="submit" name="button" class="btn btn-primary btn-block mb-2">Register</button>
        <a href="login.php">Already have an account? Log in.</a>
        </div>
      </div>
    </form>
  </div>
<?php endif; ?>
