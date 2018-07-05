<?php

include 'admin_functions.inc.php';

user_logout();
header("Location: ../login.php");
exit();
