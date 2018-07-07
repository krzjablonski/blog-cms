<?php

include "classes\dbh.class.inc.php";
include "classes\media.class.inc.php";

if($_SERVER['REQUEST_METHOD'] == 'POST'){

  if(!empty($_FILES)){
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

        if(Media::add_media($newFileName, $alt_tag)){
          move_uploaded_file($fileTmpName, '../../upload/'.$newFileName);
          echo 'Success';
          exit();
        }else{
          echo 'Database error';
          exit();
        }

      }else{
        echo 'Wrong file format';
        exit();
      }

    }else{
      $error_message = htmlspecialchars("Picture failure. Please try another picture.");
      return 'Picture failure. Please try another picture.';
      exit();
    }
  }else{
    echo "Choose file to upload";
    exit();
  }
}
