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
		echo $row['EMAIL'] . "<br>" . $row['COMMENT'] . "<br>".  $row['DATE'] . "<br>" ;
		}
}

	if ($_POST){
		$email= $_POST["email"];
		$comment= $_POST["comment"];
		$connect= mysql_connect("webpagesdb.it.auth.gr:3306","rhcpuser","rhcp123");
		if ($connect){
			mysql_select_db("comments",$connect);
                        if(strlen($name) <= '1'){ $name = 'Guest';}
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
