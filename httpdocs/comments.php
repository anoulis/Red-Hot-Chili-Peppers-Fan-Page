<?php
$connect= mysql_connect("webpagesdb.it.auth.gr:3306","rhcpuser","rhcp123");
	if ($connect){
		mysql_select_db("comments_rhcp",$connect);
	}
	else	 die("Failed to connect: " .mysql_error());
	
function show(){
		$query2 = "SELECT * FROM comments";
		$result = mysql_query ($query2);
		while ($row = mysql_fetch_array($result)){
		echo  strip_tags($row['EMAIL']) . "<br>" .  strip_tags($row['COMMENT']) . "<br>".   strip_tags($row['DATE']) . "<br>" ;
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
