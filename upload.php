<?php
error_reporting(E_ALL);
  if (is_uploaded_file($_FILES['my-file']['tmp_name']) && $_FILES['my-file']['error']==0) {
    $path = 'images/' . $_FILES['my-file']['name'];
    if (!file_exists($path)) {
      if (move_uploaded_file($_FILES['my-file']['tmp_name'], $path)) {
        echo "The file was uploaded successfully.";
      } else {
        echo "The file was not uploaded successfully.";
      }
    } else {
      echo "File already exists. Please upload another file.";
    }
  } else {
    echo "The file was not uploaded successfully.";
    echo "(Error Code:" . $_FILES['my-file']['error'] . ")";
  }
?>