<?php
include 'inc/admin_functions.inc.php';
include 'inc/classes/dbh.class.inc.php';
include 'inc/classes/pagination.class.inc.php';
include 'inc/classes/posts.class.inc.php';



?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="description" content="<?php echo $page_dsc; ?>">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" href="css/admin_style.css">
    <title><?php echo $page_title; ?></title>
  </head>
  <body>

    <!-- Main container for the page  -->
    <div class="container">

      <!-- Main row for the page -->
      <div class="row">
