<?php
$connect= mysql_connect("webpagesdb.it.auth.gr:3306","rhcpuser","rhcp123");
	if ($connect){
		mysql_select_db("comments_rhcp",$connect);
	}
	else{	 
		die("Failed to connect: " .mysql_error());
	}
?>