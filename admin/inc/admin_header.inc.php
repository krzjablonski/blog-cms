<?php
session_start();

if ( !isset( $_SESSION['user_id'] ) && strtolower( $page_title ) != "login" ){
  header("location:login.php");
  exit();
}

include 'inc/classes/dbh.class.inc.php';
include 'inc/classes/pagination.class.inc.php';
include 'inc/classes/posts.class.inc.php';
include 'inc/classes/media.class.inc.php';
include 'inc/classes/authors.class.inc.php';
include 'inc/classes/contact.class.inc.php';
include 'inc/classes/users.class.inc.php';
include 'inc/classes/login.class.inc.php';

include 'inc/admin_functions.inc.php';

ini_set("log_errors", 1);
ini_set("error_log", "php-error.log");
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="description" content="<?php if( isset( $page_dsc ) ) echo $page_dsc; ?>">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="css/admin_styles.css">
    <title><?php echo $page_title; ?></title>
  </head>
  <body>
    <?php if(strtolower($page_title) != "login"): ?>
      <div class="container-fluid" style="margin-bottom: 30px;">
        <div style="background-color: #555555" class="row">
          <div class="col">
            <ul style="font-size: .8em" class="nav justify-content-end">
              <li class="nav-item">
                <a style="color: rgba(255,255,255,.87); cursor: default;" class="nav-link disbaled" href="#"> <?php echo "Hello, " . $_SESSION['username']; ?></a>
              </li>
              <li class="nav-item">
                <a style="color: rgba(255,255,255,.87)" class="nav-link" href="users.php">Users</a>
              </li>
              <li class="nav-item">
                <a style="color: rgba(255,255,255,.87)" class="nav-link" href="inc/logout.inc.php">Logout</a>
              </li>
            </ul>
          </div>
        </div>
        <div class="row">
          <div class="col" style="padding: 0;">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
              <a class="navbar-brand" href="#">Blog CSM</a>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                  <li class="nav-item">
                    <a class="nav-link" href="index.php">Dashboard</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="posts.php">Posts</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="pages.php">Pages</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="authors.php">Authors</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="media.php">Media</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="contact-info.php">Contact</a>
                  </li>
                </ul>
              </div>
            </nav>
          </div>
        </div>

      </div>
    <?php endif; ?>

    <!-- Main container for the page  -->
    <div class="container">

      <!-- Main row for the page -->
      <div class="row">
