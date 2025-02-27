<?php
include("../config.php");
if(!isset($_SESSION))
{
	session_start();
}
if(isset($_SESSION['usertype']))
{
	$usertype=$_SESSION['usertype'];
}
else
{
	$usertype="guest";
}
if($usertype=="zone" || $usertype=="clerk")
{
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Zone</title>
<script type="text/javascript">
function deletedata() // make alert for delete branch details 
{
	var x=confirm("Are You Sure delete this record");
	if(x)
	{
		return true;
	}
	else
	{
		return false;
	}
}
</script>
</head>
<body>
<?php	
	$sql3 = "SELECT * FROM zone";
	$view = mysqli_query($connection,$sql3)or die("Error in sql3".mysqli_error($connection));
	echo '<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           <h4> Zone</h4>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">';
	$ida=base64_encode("add");
	$ide=base64_encode("edit");
	$idd=base64_encode("delete");
	echo '<a href="index.php?id='.$ida.'"><input type="button" class="btn btn-primary" value="Add New Zone"></a><br><br>';
	
	echo '<table  class="table table-striped table-bordered table-hover"  id="dataTables-example">
	<thead><tr><th></th><th>Zone Name</th></tr></thead><tbody>';	
	$x=1;
	while($viewarr = mysqli_fetch_assoc($view))
	{
		echo '<tr><td>'.$x.'</td><td>'.$viewarr["zonename"].'</td>';
		
		/*echo'<td>';  
		echo '<a href="index.php?id='.$ide.'&zoid='.base64_encode($viewarr["zoneid"]).'"><i class="icon-edit"></i></a>  ';
		if($usertype=="zone")
		{
			echo '<a onClick="return deletedata()" href="index.php?id='.$idd.'&zoid='.base64_encode($viewarr["zoneid"]).'"><i class="icon-remove"></i></a>';
		}
		echo '</td>';*/
		
		echo '</tr>';
		$x++;
	}
	echo '</tbody></table></div></div></div></div></div>';

//usertype check end
}
else
{
	header("location:../index.php");
}
?>
</body>
</html>