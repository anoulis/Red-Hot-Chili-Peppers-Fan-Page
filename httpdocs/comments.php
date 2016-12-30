<?php
	$connect= mysql_connect("webpagesdb.it.auth.gr:3306","rhcpuser","rhcp123");
	if ($connect){
		mysql_select_db("comments_rhcp",$connect);
		$query2 = "SELECT * FROM comments";
		$result = mysql_query ($query2);
		while ($row = mysql_fetch_array($result)){
		echo $row['EMAIL'] . "<br>" . $row['COMMENT'];
		}
	}
	else	die("Failed to connect: " .mysql_error());
	
	if ($_POST){
		$email= $_POST["email"];
		$comment= $_POST["comment"];
		$connect= mysql_connect("webpagesdb.it.auth.gr:3306","rhcpuser","rhcp123");
		
		if ($connect){
			mysql_select_db("comments",$connect);
			$query = "INSERT INTO comments(EMAIL,COMMENT) VALUES (\"" . $email . "\",\"" . $comment . "\")";
			if (mysql_query($query)){
				echo "Success.";
			}
			else	die( "Failed: ". mysql_error());
			
		}
		else die("Failed to connect: ".mysql_error());
	}
include('comments.html');
?> 
