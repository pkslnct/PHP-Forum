<?php
//guest.php

echo '<h3>Before You can visit the Forum<h3><br><h3>You Need to Sign up</h3>';
 	echo '<table class="start"><tr><th colspan="2"><h3>Sign Up</h3></tr>
 	      <tr><td id="signup">
 	      
        <form method="post" action="signup.php">
        <tr><td>Username: </td><td><input type="text" name="user_name" /></td></tr>
        <tr><td>Password: </td><td><input type="password" name="user_pass"></td></tr>
        <tr><td>Password again: </td><td><input type="password" name="user_pass_check"></td></tr>
        <tr><td>E-mail: </td><td><input type="email" name="user_email"></td></tr>
        <tr><td colspan="2" align="center"><input type="submit" value="Sign Up" /></td></tr>
     </form>
 	      </td></table><br>
<h3>Or Signin</h3> 	      
 	      <table class="start">
 	      <tr><th colspan="2"><h3>Sign in</h3></th></tr>
 	      <td id="signin">
 	      <form method="post" action="signin.php">
            <tr><td>Username: </td><td><input type="text" name="user_name" /></td></tr>
            <tr><td>Password: </td><td><input type="password" name="user_pass"></td></tr><tr><td><a href="forgot.php" >Forgot Password?</a></td></tr>
            <tr><td colspan="2" align="center"><input type="submit" value="Sign in" /></td>
</tr>
         </form>
 	      </td>
 	      </tr></table>';



?>