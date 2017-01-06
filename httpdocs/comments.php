<?php
include('config.php');
function show(){
         $rec_limit = 10;

         /* Get total number of records */
         $sql = "SELECT * FROM comments";
         $retval = mysql_query( $sql);
 
         if(! $retval ) {
            die('Could not get data1: ' . mysql_error());
         }
         $row = mysqli_fetch_array($retval);
         $rec_count = $row[0];

         $numRows = mysql_num_rows($retval);
         $last = ceil($numRows / 10);

         $page=$_GET{'page'};  

         if( $page !=0) {
            /*$page = $page + 1;*/
            $offset=$rec_limit*$page;
         }else {
            /*$page=0;*/
            $offset=0;
         }

         $left_rec = $rec_count - ($page * $rec_limit);
         $sql = "SELECT * FROM comments ORDER BY DATE DESC LIMIT $offset, $rec_limit";
            
         $retval = mysql_query( $sql);
         
         if(! $retval ) {
            die('Could not get data2: ' . mysql_error());
         }
         
        while($row = mysql_fetch_array($retval)) {
            echo "EMAIL :{$row['EMAIL']}  <br> ".
               "COM : {$row['COMMENT']} <br> ".
               "DATE : {$row['DATE']} <br> ".
               "--------------------------------<br>";
         }

         
 

		if($page == $last-1){
			$previous = $page-1;
			echo "<a href = \"$_PHP_SELF?page=$previous\">Last 10 Records</a> ";
		}

		else if( $page > 0 && $page!=$last-1){
			$previous=$page-1;
            $next=$page+1;
            echo "<a href = \"$_PHP_SELF?page=$previous\">Last 10 Records</a> |";
            echo "<a href = \"$_PHP_SELF?page=$next\">Next 10 Records</a>";
        }
		else if( $page == 0 ){
            $page=$page+1;
            echo "<a href = \"$_PHP_SELF?page=$page\">Next 10 Records</a>";
         }
           
}

	if ($_POST){
			$email= addslashes(strip_tags($_POST["email"]));
			$comment= addslashes(strip_tags($_POST["comment"]));
			mysql_select_db("comments",$connect);
			if(empty($email) ){ 
                        $email= 'Guest';
                        }
			$query = "INSERT INTO comments(EMAIL,COMMENT) VALUES (\"" . $email . "\",\"" . $comment . "\")";
			if (mysql_query($query)){
                        $page=$_GET{'page'};  
                        header("location:  $_PHP_SELF?page=$page");
                        exit;
			}
		else{
			die("Failed to connect: ".mysql_error());
		}
		}
		

include('comments.html');
?> 
