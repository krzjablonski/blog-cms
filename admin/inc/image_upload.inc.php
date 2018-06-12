<?php

include "classes\dbh.class.inc.php";
include "classes\media.class.inc.php";

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    if(isset($_GET['act'])){
      switch ($_GET['act']) {
        case 'upload':
          upload_image();
          break;
        case 'delete':
          break;
        default:
          // code...
          break;
      }
    }
}


function upload_image(){
  $file = $_FILES[0];

  $fileName = $file['name'];
  $fileTmpName = $file['tmp_name'];
  $fileSize = $file['size'];
  $fileError = $file['error'];
  $fileType = $file['type'];

  $alt_tag = isset($_POST['alt_tag']) ? filter_input(INPUT_POST, "alt_tag", FILTER_SANITIZE_STRING) : $fileName;

  $formats = array(
    'jpg',
    'jpeg',
    'png'
  );

  if($fileError == 0){
    $fileNameArray = explode('.', $fileName);
    $fileNameWExt = array_slice($fileNameArray, 0, -1);
    $newFileName = implode('.', $fileNameWExt)."-".uniqid().".".end($fileNameArray);
    if(in_array(end($fileNameArray), $formats)){
      move_uploaded_file($fileTmpName, '../../upload/'.$newFileName);
    }else{
      echo "Wrong file format";
    }
    $status = Media::add_media($newFileName, $alt_tag);
    if($status == "success"){
      echo "Success";
    }else{
      unlink('../../upload/'.$newFileName);
      echo "Database error";
    }
  }else{
    echo "File Error";
  }
}

function delete_image(){

}
