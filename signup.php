<?php
//signup.php
include 'connect.php';
include 'header.php';
 
echo '<table>
         <tr><th colspan="2" ><h3>Sign up</h3></th></tr>';
 
if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    /*the form hasn't been posted yet, display it
      note that the action="" will cause the form to post to the same page it is on */
    echo  '
        <tr> 
        <form method="post" action="">
        <tr><td>Username: </td><td><input type="text" name="user_name" /></td></tr>
        <tr><td>Password: </td><td><input type="password" name="user_pass"></td></tr>
        <tr><td>Password again: </td><td><input type="password" name="user_pass_check"></td></tr>
        <tr><td>E-mail: </td><td><input type="email" name="user_email"></td></tr>
        <tr><td>';



  include 'captcha.php';
  $image1="<img height=\"110%\" width=\"60%\" id=\"upload\" src='data:image/png;base64,".base64_encode ($data1)."'/>";
  echo $image1;echo '</td>';
      echo '<td><input id="captcha" onclick="document.getElementById("captcha").innerHTML =\'\'" type="text" name="captcha" value="Enter Captcha"></td></tr>';
        
        
        
        echo '<tr><td colspan="2" align="center"><input type="submit" value="Sign Up" /></td></tr>
     </form></tr>';
}
else
{
    /* so, the form has been posted, we'll process the data in three steps:
        1.  Check the data
        2.  Let the user refill the wrong fields (if necessary)
        3.  Save the data 
    */
    $errors = array(); /* declare the array for later use */
     
    if(isset($_POST['user_name']))
    {
        //the user name exists
        if(!ctype_alnum($_POST['user_name']))
        {
            $errors[] = 'The username can only contain letters and digits.';
        }
        if(strlen($_POST['user_name']) > 30)
        {
            $errors[] = 'The username cannot be longer than 30 characters.';
        }
    }
    else
    {
        $errors[] = 'The username field must not be empty.';
    }



if(isset($_POST['captcha'])) 
     { 
     
            if($_POST['captcha']!==$_SESSION['digit']) 
                  {$errors[]= 'CAPTCHA do not match.';}
     
     
     
     }
     else {$errors[]='The CAPTCHA Field cannot be empty.';}

     
     
    if(isset($_POST['user_pass']))
    {
        if($_POST['user_pass'] != $_POST['user_pass_check'])
        {
            $errors[] = 'The two passwords did not match.';
        }
    }
    else
    {
        $errors[] = 'The password field cannot be empty.';
    }



list($userName, $mailDomain) = explode("@", $_POST['user_email']); 

if (checkdnsrr($mailDomain, "MX")) { 

  // this is a valid email domain! 

} 

else { 

  // this email domain doesn't exist! bad dog! no biscuit! 
  $errors[]= 'The Email is invalid. Host Name does not Exist.';
} 






     
    if(!empty($errors)) /*check for an empty array, if there are errors, they're in this array (note the ! operator)*/
    {
        echo '<tr><td colspan="2">Uh-oh.. a couple of fields are not filled in correctly..<a href="signup.php">Please Try Again.</a></td></tr>';
        echo '<tr><ul>';
        foreach($errors as $key => $value) /* walk through the array so all the errors get displayed */
        {
            echo '<tr><td><li>' . $value . '</li></td></tr>'; /* this generates a nice error list */
        }
        echo '</ul></tr>';
    }
    else
    {


 $sql1="select * from users where user_name='" . mysqli_real_escape_string($con,$_POST['user_name']) . "' 
                                              or
                                    user_email='" . mysqli_real_escape_string($con,$_POST['user_email']) . "'";
    
    if(mysql_num_rows(mysqli_query($con,$sql1))==0) {
    	
    




$pass = $_POST['user_pass'];
     $blowfish_salt = "$2y$10$".bin2hex(openssl_random_pseudo_bytes(22));
         $password0 = crypt($pass, $blowfish_salt);
         $hash = md5( rand(0,1000) );
        //the form has been posted without, so save it
        //notice the use of mysql_real_escape_string, keep everything safe!
        //also notice the sha1 function which hashes the password
        $sql = "INSERT INTO
                    users(user_name, user_pass, user_email ,user_date, user_level, hash)
                VALUES('" . mysqli_real_escape_string($con,$_POST['user_name']) . "',
                       '$password0',
                       '" . mysqli_real_escape_string($con,$_POST['user_email']) . "',
                        NOW(),
                        0,'". mysqli_escape_string($con,$hash) ."')";
                         
        $result = mysqli_query($con,$sql);
        if(!$result)
        {
            //something went wrong, display the error
            echo '<tr><td colspan="2" >Something went wrong while registering. Please try again later.</td></tr>';
            //echo mysql_error(); //debugging purposes, uncomment when needed
        }
        else
        { $name=mysqli_real_escape_string($con,$_POST['user_name']);
        $password=mysqli_real_escape_string($con,$_POST['user_pass']);
        	
        	$to      = mysqli_real_escape_string($con,$_POST['user_email']); // Send email to our user
$subject = 'Signup | Verification'; // Give the email a subject 
$message = '
 
Thanks for signing up!
Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.
 
------------------------
Username: '.$name.'
Password: '.$password.'
------------------------
 
Please click this link to activate your account:
http://xgenforum.orgfree.com/verify.php?email='.$to.'&hash='.$hash.'
 
'; // Our message above including the link
                     
$headers='From:X-GenForum'; // Set from headers


mail($to, $subject, $message,$headers); // Send our email
        	





            echo '<tr><td colspan="2" >Successfully registered. Check Your Email for Verification Link.After that you can <a href="signin.php">sign in</a> and start posting! :-)</td></tr>';
        }
     }
else {echo '<tr><td>Username or Email already taken.<a href="signup.php" >Please try again</a></tr></td>';}  
    }
}
 
include 'footer.php';
?>