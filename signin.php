<?php
// Start the session
session_start();
?>
<?php
//signin.php
include 'connect.php';
include 'header.php';
 
echo '<table><tr><th colspan="2"><h3>Sign in</h3></td></tr>';
 
//first, check if the user is already signed in. If that is the case, there is no need to display this page
if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true)
{
    echo '<tr><td colspan="2">You are already signed in, you can <a href="signout.php">sign out</a> if you want.</td></tr>';
}
else
{
    if($_SERVER['REQUEST_METHOD'] != 'POST')
    {
        /*the form hasn't been posted yet, display it
          note that the action="" will cause the form to post to the same page it is on */
        echo  '<tr><form method="post" action="">
            <tr><td>Username: </td><td><input type="text" name="user_name" /></td></tr>
            <tr><td>Password: </td><td><input type="password" name="user_pass"></td></tr><tr><td><a href="forgot.php" >Forgot Password?</a></td></tr>
            <tr><td  colspan="2" align="center"><input type="submit" value="Sign in" /></td>
</tr>
         </form></tr></table>';
    }
    else
    {
        /* so, the form has been posted, we'll process the data in three steps:
            1.  Check the data
            2.  Let the user refill the wrong fields (if necessary)
            3.  Varify if the data is correct and return the correct response
        */
        $errors = array(); /* declare the array for later use */
         
        if(!isset($_POST['user_name']))
        {
            $errors[] = 'The username field must not be empty.';
        }
         
        if(!isset($_POST['user_pass']))
        {
            $errors[] = 'The password field must not be empty.';
        }
         
        if(!empty($errors)) /*check for an empty array, if there are errors, they're in this array (note the ! operator)*/
        {
            echo '<tr><td colspan="2">Uh-oh.. a couple of fields are not filled in correctly..</td></tr>';
            echo '<tr><ul>';
            foreach($errors as $key => $value) /* walk through the array so all the errors get displayed */
            {
                echo '<tr><td><li>' . $value . '</li></td></tr>'; /* this generates a nice error list */
            }
            echo '</ul></tr>';
        }
        else
        {
            //the form has been posted without errors, so save it
            //notice the use of mysql_real_escape_string, keep everything safe!
            //also notice the sha1 function which hashes the password
            $sql = "SELECT 
                        user_id,
                        user_name,
                        user_level,
                        active,
                        user_pass
                    FROM
                        users
                    WHERE
                        user_name = '" . mysql_real_escape_string($_POST['user_name']) . "'
                    
                    AND
                        active='1' ";  
                         
            $result = mysql_query($sql);
            if(!$result)
            {
                //something went wrong, display the error
                echo '<tr><td colspan="2">Something went wrong while signing in. Please try again later.</td></tr>';
                //echo mysql_error(); //debugging purposes, uncomment when needed
            }
            else
            {
                //the query was successfully executed, there are 2 possibilities
                //1. the query returned data, the user can be signed in
                //2. the query returned an empty result set, the credentials were wrong
                if(mysql_num_rows($result) == 0)
                {
                    echo '<tr><td colspan="2">You have supplied a wrong username or you have not activated your account. Please try again.</td></tr>';
                }
                else
                {
                   
                	if(mysql_num_rows($result)==1) {
                		
                		
                		while($rows=mysql_fetch_assoc($result)) 
                		{
                			$pass_check=$rows['user_pass'];
                        $id=$rows['user_id'];                			
                			$name=$rows['user_name'];
                			$level=$rows['user_level'];
                			
                			}
                			
                			if (($pass_check == crypt($_POST['user_pass'], $pass_check))||$pass_check==sha1($_POST['user_pass']) ){
 


                		
                    //set the $_SESSION['signed_in'] variable to TRUE
                    $_SESSION['signed_in'] = true;
                     
                    //we also put the user_id and user_name values in the $_SESSION, so we can use it at various pages
                     $_SESSION['user_id']    = $id;
                        $_SESSION['user_name']  = $name;
                        $_SESSION['user_level'] = $level;
                     
                    echo '<tr><td colspan="2">Welcome, ' . $_SESSION['user_name'] . '. <a href="index.php">Proceed to the forum overview</a>.</td></tr>';
                
                
                } else {
  echo "Invalid password.Please Try again.";
} 
                
                
                
                }
                else {
                	echo 'Multiple usernames detected.You cannot login now.';}
                }
            }
        }
    }
}
 
include 'footer.php';
?>