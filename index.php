<?php
//index.php
include 'connect.php';
include 'header.php';

 if(isset($_SESSION['signed_in'])) {

echo "Update: File Upload Feature Added.<br>
      Update: Email Verification Added.Now Email will be sent to verify user.Old users are Pre-Validated<br>
      Update: Forgot Password Feature Added.<br>
      Update: Your passwords are encrypted by high standard crypt function with one way Hashing(Means even I too cannot know your password).Only Brute Attack(Password Guessing) works, that too will take decades to crack.
 <br><br>"; 
 
$sql = "SELECT
            cat_id,
            cat_name,
            cat_description
        FROM
            categories";
 
$result = mysql_query($sql);
 
if(!$result)
{
    echo 'The categories could not be displayed, please try again later.';
}
else
{
    if(mysql_num_rows($result) == 0)
    {
        echo 'No categories defined yet.';
    }
    else
    {
        //prepare the table
        echo '<table border="1">
              <tr>
                <th>Category</th>
                <th>Last topic</th>
              </tr>'; 
             
        while($row = mysql_fetch_assoc($result))
        {               
            echo '<tr>';
                echo '<td class="leftpart">';

                    $sql1= " select * from topics where topic_cat=".$row['cat_id']." order by topic_id desc limit 1 ";


                $result1=mysql_query($sql1);
                while($row1=mysql_fetch_assoc($result1)) {
                	$topicid=$row1['topic_id'];
                	$tname=$row1['topic_subject'];
                	$tdate=$row1['topic_date'];}
                    echo '<h3><a href="category.php?id='.$row['cat_id'].'">' . $row['cat_name'] . '</a></h3>' . $row['cat_description'];
                echo '</td>';
                echo '<td class="rightpart">';
                if(!$result1) {echo 'The Topic can,t be displayed.';
                                echo mysql_error();    }
                else {if(mysql_num_rows($result1)==0) { echo 'There are no topics in this category';}
                       else {
                            echo '<a href="topic.php?id='.$topicid.'">'.$tname.'</a> at '.date('M j, Y, g:i a', strtotime($tdate));
                             }
                      }
                echo '</td>';
            echo '</tr>';
        }
    }
}
}
 else {include 'guest.php';}
 
include 'footer.php';
?>