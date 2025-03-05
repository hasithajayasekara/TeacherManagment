<?php
include("config.php");
if(!isset($_SESSION))
{
	session_start();
}
if(isset($_POST['login_submit']))
{
	$username=$_POST["txtusername"];
	$password=$_POST["txtpassword"];
	$sql1="SELECT * FROM login WHERE user_id='$username' AND password ='$password'";
	$result1=mysqli_query($connection,$sql1);
	//$row1=mysqli_fetch_assoc($result1);	
	$n=mysqli_num_rows($result1);
	
			$sql3 ="SELECT * FROM login WHERE user_id = '$username' "; //connect with login table with username for get number of attempt
			$result3 = mysqli_query($connection,$sql3) or die("Error in sql3".mysqli_error($connection));
			$row3 = mysqli_fetch_assoc($result3);
	if(mysqli_num_rows($result3)==1)
	{
			
	if($n==1)
	{
		$row1=mysqli_fetch_assoc($result1);
		$usertype=$row1['user_type'];
		if($usertype=="pending")
		{
			echo "<script> alert('Your register not successfully please register new'); window.location.href ='index.php';</script>";
		}
		else if($usertype=="accept")
		{
			echo "<script> alert('Your account not activated please contact the management'); window.location.href ='index.php';</script>";
		}
		else if($usertype=="deleted")
		{
			echo "<script> alert('Your account is deleted please contact the management'); window.location.href ='index.php';</script>";
		}
		else if($usertype=="band")
		{
			echo "<script> alert('Your account is banded please contact the management'); window.location.href ='index.php';</script>";
		}
		else
		{
		$_SESSION['username']=$username;
		$_SESSION['usertype']=$usertype;
		$sql2 = "UPDATE login SET attempt=0 WHERE user_id='$username'";
		$result2=mysqli_query($connection,$sql2) or die("Error in sql2".mysqli_error($connection));
		header("location:index.php?pg=home.php");
		exit;
		}
	}
	else if($row3['attempt']>=3) // if login attempt more than three
	{
		echo "<script> alert('You attempt more than three please give your userID and contact number');</script>";
	}
	else
	{
		echo "<script> alert('The Password error'); </script>";
		$sql2 = "UPDATE login SET attempt=attempt+1 WHERE user_id='$username'";
		$result2=mysqli_query($connection,$sql2) or die("Error in sql2".mysqli_error($connection));
	}
	}
	else
	{
		echo "<script> alert('There is no such username'); </script>";
	}
}

?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->

<!-- BEGIN HEAD -->
<head>
     <meta charset="UTF-8" />
    <title>Teachers Management System | Login Page</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
     <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
    <!-- GLOBAL STYLES -->
     <!-- PAGE LEVEL STYLES -->
     <link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="assets/css/login.css" />
    <link rel="stylesheet" href="assets/plugins/magic/magic.css" />
     <!-- END PAGE LEVEL STYLES -->
</head>
    <!-- END HEAD -->

    <!-- BEGIN BODY -->
<body >

   <!-- PAGE CONTENT --> 
 <div class="container-fluid bg">
		<div class="row">
			<div class="col-md-4 col-sm-4 col-xs-12"></div>
			<div class="col-md-4 col-sm-4 col-xs-12">
			<form class="form-container" method="POST" action="#">
			<!--img class="img-thumbnail img-circle src="C:\Users\KEERTHI\Desktop\Software pro\images\login-system-icon-13.png"-->
			<center><h1>Login</h1></center>
			  <div class="form-group">
			  
			    <!--label for="txtusername"></label-->
			    <input type="text" class="form-control" name="txtusername" id="txtusername" placeholder="Username">
			  </div>
			  <div class="form-group">
			    <!--label for="txtpassword"></label-->
			    <input type="password" class="form-control" name="txtpassword" id="txtpassword" placeholder="Password">
			  </div>
			  <div class="checkbox">
			    <label>
			      <input type="checkbox">Remember me
			    </label>
			  </div>
			  <!--button type="Login" class="btn btn-success btn-block">Login</button-->
					<input type="submit" name="login_submit" id="login_submit" class="btn btn-success btn-block" value="Submit">
					</br>
					<input type="reset" name="login_reset" id="login_reset" class="btn btn-danger btn-block" value="Reset">
			</form>
			</div>
			<div class="col-md-4 col-sm-4 col-xs-12"></div>
		</div>
	</div>
	  <!--END PAGE CONTENT -->     
	      
      <!-- PAGE LEVEL SCRIPTS -->
      <script src="assets/plugins/jquery-2.0.3.min.js"></script>
      <script src="assets/plugins/bootstrap/js/bootstrap.js"></script>
   <script src="assets/js/login.js"></script>
      <!--END PAGE LEVEL SCRIPTS -->

</body>
    <!-- END BODY -->
</html>
//hasitha jayasekara