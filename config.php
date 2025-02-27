<?php
	$host='localhost';//server
	$user='root';// server name
	$password='';//password
	
	$connection=mysqli_connect($host,$user,$password);//server connection coding
	if(!$connection)
	{
		die("connecton to the server could not establish");
	}
	$result=mysqli_select_db($connection,"teachersbase");//database select code
	if(!$result)
	{
		die("database could not establish");
	}
	
?>
