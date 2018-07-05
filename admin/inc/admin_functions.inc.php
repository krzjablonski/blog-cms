<?php

function user_logout(){
  session_start();
  session_unset();
  session_destroy();
}
