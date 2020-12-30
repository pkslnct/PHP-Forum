<?php
include 'connect.php';
include 'header.php';$yes=0;

if(isset($_POST['email'])&&!empty($_POST['email']) ){

$sql="select * from users where user_email='".mysql_real_escape_string($_POST['email'])."' AND active='1'";
$result=mysql_query($sql);
if(!$result)
{echo 'Problem with Database';
}
else {
	if(mysql_num_rows($result)==0) 
	{
	
	echo 'No Such Email Registered Or Verified'; 
	}
	else {$hash = md5( rand(0,1000) );
		
		$sql1="update  users set pass_hash='". mysql_escape_string($hash) ."' where user_email='".mysql_real_escape_string($_POST['email'])."'";
		if(!mysql_query($sql1)) { echo 'Cannot do it right now,Try after sometime or contact Admin';echo mysql_error();}
		else {
	$email=$_POST['email'];
  $message='Hello,

	You got this message because you asked for password reset. 

	If it was not you ,You don\'t need to do anything,.

	Otherwise Here is your Password Reset Link:


   http://xgenforum.orgfree.com/pass_verify.php?email='.$_POST['email'].'&hash='.$hash.'



	Regards.';
	
	mail($email,'Password Reset Request',$message,'From:X-GenForum');$yes=1;
}
}}}

echo '<table><tr><th colspan="2"><h3>Forgot Password</h3></th></tr><form action="" method="post">
<tr><td>Email: <input type="email" name="email"/></td></tr>
<tr><td><input type="submit" name="submit" value="Request Password"/></td></tr>
</form></table>



';

if($yes==1){echo '<br><br>Password Reset Link Sent to Email';}

include 'footer.php';

?>





