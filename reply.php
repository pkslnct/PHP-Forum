<?php
//create_cat.php
include 'connect.php';
include 'header.php';
 
if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    //someone is calling the file directly, which we don't want
    echo 'This file cannot be called directly.';
}
else
{
    //check for sign in status
    if(!$_SESSION['signed_in'])
    {
        echo 'You must be signed in to post a reply.';
    }
    else
    {

$html1='';$file1=0;
     if (is_uploaded_file($_FILES['file']['tmp_name']) && $_FILES['file']['error']==0) 
     { $file1=1;
    	 $file = rand(1000,100000)."-".$_FILES['file']['name'];
    $file_loc = $_FILES['file']['tmp_name'];
 $file_size = $_FILES['file']['size'];
 $file_type = $_FILES['file']['type'];
 $folder="uploads/";
$img_src='';
 
 move_uploaded_file($file_loc,$folder.$file);
 if (($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/jpg")
|| ($_FILES["file"]["type"] == "image/png"))
{
 $html1='';
 $img_src='/uploads/'.$file.'';
 }
 else {
 	$html1='<br><a href="uploads/'.$file.'">'.$_FILES['file']['name'].'</a>';
 	   }
 
 $sql="INSERT INTO tbl_uploads(file,type,size,file_topic,file_user) VALUES('$file','$file_type','$file_size',". mysql_real_escape_string($_GET['id']) ."," . $_SESSION['user_id'] . ")";
 if(mysql_query($sql))
 {echo 'Upload Success';$postid1=mysql_insert_id();} 
    }



$reply0=htmlspecialchars($_POST['reply-content']);
$reply2=nl2br($reply0);
$reply1='<p>'.mysql_real_escape_string($reply2).'</p>';

        //a real user posted a real reply
        $sql = "INSERT INTO 
                    posts(post_content,
                          post_date,
                          post_topic,
                          post_by,image_src) 
                VALUES ('" .$reply1 . mysql_real_escape_string($html1)."',
                        NOW(),
                        " . mysql_real_escape_string($_GET['id']) . ",
                        " . $_SESSION['user_id'] . ",'$img_src')";
                        
                     
                         
        $result = mysql_query($sql);
        
        if($file1==1) 
        {$postid=mysql_insert_id();
        	$sql="update tbl_uploads set file_post=$postid where id=$postid1";
             if(!mysql_query($sql)) { echo 'post no. not updated'; echo mysql_error(); echo $file; }   }     
                         
        if(!$result)
        {
            echo 'Your reply has not been saved, please try again later.';
        }
        else
        {
            echo 'Your reply has been saved, check out <a href="topic.php?id=' . htmlentities($_GET['id']) . '">the topic</a>.';
        }
    }
}
 
include 'footer.php';
?>