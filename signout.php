<?php
//signout.php
include 'connect.php';
include 'header.php';

if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true) {
session_destroy(); 
echo 'You Are Successfully Signed Out.<a href="signin.php">Sign in </a> again,If You Want.';
}
else { 
echo 'You Are Not Signed In.<a href="signin.php">Sign in </a> here.';
}

include 'footer.php';
?>