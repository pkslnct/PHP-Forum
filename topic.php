<?php
//topic.php
include 'connect.php';
include 'header.php';



if(isset($_SESSION['signed_in'])) {
$previous = "javascript:history.go(-1)";
 echo '<a class="back" href="'.$previous.'"><< Back</a>';
 
//first select the category based on $_GET['cat_id']
$sql = "SELECT
    topic_id,
    topic_subject
FROM
    topics
WHERE
    topics.topic_id = " . mysql_real_escape_string($_GET['id']);
 
$result = mysql_query($sql);
 
if(!$result)
{
    echo 'The topic could not be displayed, please try again later.' . mysql_error();
}
else
{
    if(mysql_num_rows($result) == 0)
    {
        echo 'This topic does not exist.';
    }
    else
    {
       
     while($row = mysql_fetch_assoc($result))
        {
            echo '<h2>Posts in \'' . $row['topic_subject'] . '′</h2>';
       $subject=$row['topic_subject']; }
        //do a query for the posts
        $sql = "SELECT
    posts.post_topic,
    posts.post_content,
    posts.post_date,
    posts.post_by,
    posts.image_src,
    users.user_id,
    users.user_name
FROM
    posts
LEFT JOIN
    users
ON
    posts.post_by = users.user_id
WHERE
    posts.post_topic = " . mysql_real_escape_string($_GET['id']);
         
        $result = mysql_query($sql);
         
        if(!$result)
        {
            echo 'The topics could not be displayed, please try again later.';
        }
        else
        {
            if(mysql_num_rows($result) == 0)
            {
                echo 'There are no posts in this category yet.';
            }
            else
            {
                //prepare the table
                echo '<table border="1">
                      <tr>
                        <th colspan="2">'.$subject.'</th>
                        
                        
                      </tr>'; date_default_timezone_set('Asia/Kolkata');
                     
                while($row = mysql_fetch_assoc($result))
                {               
                    echo '<tr>';
                        echo '<td class="rightpart">';
                            echo  $row['user_name'].' '.date('M j, Y, g:i a', strtotime($row['post_date']));
                        echo '</td>';
                        echo '<td class="leftpart">';
                            echo $row['post_content'];


 if($row['image_src']) {
                        
                        $src =$row['image_src'];
                      $fimg=substr_replace($src, '/home/vhosts/xgenforum.orgfree.com', 0, 0);

$img = imagecreatefromstring(file_get_contents($fimg));
ob_start ();

imagejpeg($img, NULL,10);

imagedestroy($img);
$data = ob_get_contents ();
ob_end_clean ();
$aimg=substr_replace($src, 'http://xgenforum.orgfree.com', 0, 0);
 $image = "<a href=\"$aimg\"> <img id=\"upload\" src='data:image/jpeg;base64,".base64_encode ($data)."'></a>";
 echo $image;
                        
                        }

                        echo '</td>';
                    echo '</tr>';
                }echo '</table>';
            }
        
       if(isset($_SESSION['user_level'])) {

  echo '<br><table><form id="reply" method="post" enctype="multipart/form-data" action="reply.php?id='.$_GET['id'].'">
    <tr><td><textarea name="reply-content"></textarea></td></tr>
    <tr><td><input type="file" name="file" size="50" maxlength="25"><small>Max 10MB(All file-types Allowed)</small></td></tr>
    <tr><td><input type="submit" value="Submit reply" /></td></tr>
</form></table>';





}
else { echo 'You have to <a href="signin.php">Sign in</a> to post reply';}
        
        
        }
    }
}

}
 else {include 'guest.php';}
 
include 'footer.php';
?>