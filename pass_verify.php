        <?php
        
        include 'connect.php';
        include 'header.php';
         
           
             
            if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash']))
            
            
            
            {
    // Verify data
    $email = mysql_escape_string($_GET['email']); // Set email variable
    $hash = mysql_escape_string($_GET['hash']); // Set hash variable
$search = mysql_query("SELECT user_email, pass_hash, active FROM users WHERE user_email='".$email."' AND pass_hash='".$hash."' AND active='1'") or die(mysql_error()); 
$match  = mysql_num_rows($search);


if($match > 0){
	

    // We have a match, change the pass
    if(!isset($_POST['pass'])||empty($_POST['pass'])||!isset($_POST['pass2'])||empty($_POST['pass2'])||($_POST['pass']!==$_POST['pass2'])) {
echo '<table><tr><th colspan ="2">Password Reset</th></tr><form action="" method="post">
      <tr><td>New Password: </td><td><input type="password" name="pass"></td></tr>
      <tr><td>Retype Password: </td><td><input type="password" name="pass2"></td></tr>
      <tr><td colspan="2" align="center" ><input type="submit" name="submit"></td></tr></table> 
      ';    
      
      	if(isset($_POST['pass'])&&isset($_POST['pass2'])&&($_POST['pass']!==$_POST['pass2'])) {
    	
    	echo '<br><br>Passwords do not Match.Try Again';} 
    }
    
    else {
    	
    	
    	
    	
    	$pass = $_POST['pass'];
     $blowfish_salt = "$2y$10$".bin2hex(openssl_random_pseudo_bytes(22));
         $password0 = crypt($pass, $blowfish_salt);
   
    $work=mysql_query("UPDATE users SET user_pass='".mysql_escape_string($password0)."' , pass_hash='' WHERE user_email='".mysql_escape_string($email)."' AND pass_hash='".mysql_escape_string($hash)."' AND active='1'") ;
    if(!$work) {echo mysql_error();}
$done='Your account password is changed successfully to --> '.$pass.' <-- .You can now login with this password.';mail($email,'Password Changed',$done,'From:X-GenForum');
echo 'Your account password is changed successfully.';

}












}else{
    // No match -> invalid url or account has already been activated.
     echo '<div class="statusmsg">The url is either invalid or used before.</div>';
    }




}




else{
    // Invalid approach
    
    echo '<div class="statusmsg">Invalid approach, please use the link that has been send to your email.</div>';
} 
             
             
             
             
             
   include 'footer.php';         
             
        ?>
        