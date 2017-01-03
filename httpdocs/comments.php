<?php
$connect= mysql_connect("webpagesdb.it.auth.gr:3306","rhcpuser","rhcp123");
	if ($connect){
		mysql_select_db("comments_rhcp",$connect);
	}
	else	 die("Failed to connect: " .mysql_error());
	
function show(){
                $rec_limit = 10;

         /* Get total number of records */
         $sql = "SELECT * FROM comments";
         $retval = mysql_query( $sql);
         
         if(! $retval ) {
            die('Could not get data1: ' . mysql_error());
         }
         $row = mysql_fetch_array($retval);
         $rec_count = $row[0];

/* Doesn't work*/
         $page= $_GET{'page'};  

         if( $page !=0) {
            $page = $page + 1;
            $offset = $rec_limit * $page ;
         }else {
            $offset = 0;
         }
  
         $left_rec = $rec_count - ($page * $rec_limit);
         $sql = "SELECT * FROM comments LIMIT $offset, $rec_limit";
            
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
        
         if( $page > 0 ) {
            $last = $page - 2;
            echo "<a href = \"$_PHP_SELF?page = $last\">Last 10 Records</a> |";
            echo "<a href = \"$_PHP_SELF?page = $page\">Next 10 Records</a>";
         }else if( $page == 0 ) {
            echo "<a href = \"$_PHP_SELF?page = $page\">Next 10 Records</a>";
         }else if( $left_rec < $rec_limit ) {
            $last = $page - 2;
            echo "<a href = \"$_PHP_SELF?page = $last\">Last 10 Records</a>";
         }
           
}

	if ($_POST){
		$email= addslashes(strip_tags($_POST["email"]));
		$comment= addslashes(strip_tags($_POST["comment"]));
		$connect= mysql_connect("webpagesdb.it.auth.gr:3306","rhcpuser","rhcp123");
		if ($connect){
			mysql_select_db("comments",$connect);
                        if(empty($email) ){ $email= 'Guest';}
			$query = "INSERT INTO comments(EMAIL,COMMENT) VALUES (\"" . $email . "\",\"" . $comment . "\")";
			if (mysql_query($query)){
                              header("location: comments.php");
                               exit;
			}
			else	 die( "Failed: ". mysql_error());
			
		}
		else die("Failed to connect: ".mysql_error());
	}

include('comments.html');
?> 
