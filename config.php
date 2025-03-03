<?php
	$host='localhost';//server
	$user='root';// server name
	$password='';//password
	$database="teacherbase";
	
	$connection=mysqli_connect($host,$user,$password);//server connection coding
	//check connection
	if(!$connection)
	{
		die("connecton to the server could not establish".mysqli_connect_error());
	}
	//select data base
	$result=mysqli_select_db($connection,"teachersbase");//database select code
	if(!$result)
	{
		die("database could not establish: ");
	}
	
?>
