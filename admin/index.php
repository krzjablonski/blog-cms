<?php

// page title
$page_title = 'Dashboard';
$page_dsc = 'Lorem Ipsum';
$current_page = isset($_GET['pg']) ? filter_input(INPUT_GET, "pg", FILTER_SANITIZE_NUMBER_INT) : 1;

include 'inc/admin_header.inc.php';

include 'inc/admin_footer.inc.php' ?>
