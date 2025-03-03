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
  if(isset($_POST['btnsubmitadd']))
  {
    $totalloop=$_POST['txtloop'];
    $submit=0;
    for ($x=1; $x < $totalloop ; $x++) 
    { 
      $basicsalary= $_POST['txtstaffbsalary'.$x];
      $epf=($basicsalary*8)/100;
      $etf=($basicsalary*12)/100;

      $sql2= "INSERT INTO salary(staffid,netsalary,year,month,epf,etf) VALUES (
      '".mysqli_real_escape_string($connection,$_POST['txtstaffid'.$x])."',
      '".mysqli_real_escape_string($connection,$_POST['txtstaffbsalary'.$x])."',
      '".mysqli_real_escape_string($connection,$_POST['txtyear'])."',
      '".mysqli_real_escape_string($connection,$_POST['txtmonth'])."',
      '".mysqli_real_escape_string($connection,$epf)."',
      '".mysqli_real_escape_string($connection,$etf)."')";
      $result2= mysqli_query($connection,$sql2) or die("Error in sql2".mysqli_error($connection));

      $submit++;
    }
    if($submit>0)
    {
      echo "<script> alert('Successfully Insert into Database');window.location.href='index.php'; </script>";
    }
  }
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Staff salary</title>
</head>
<body>
<form action="" method="post" name="staffsal" id="staffsal">
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             Staff Salary Add
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
  <table class="table table-striped table-bordered table-hover" width="200" border="0" align="center">
    
    <tr>
      <td>Year</td>
      <td>
        <select name="txtyear" id="txtyear" class="form-control">
                <option>Select The Year</option>
                <?php
                    $year=date("Y");
                  for($x=$year;$x>$year-5;$x--)
                  {
                    echo '<option value="'.$x.'">'.$x.'</option>';
                  }
                ?>
        </select>
      </td>
    </tr>
	<tr>
      <td>Month</td>
      <td>
      	<select name="txtmonth" id="txtmonth" class="form-control">
                <option>Select The Month</option>
                <?php
                  $month=array("January","February","March","April","May","June","July","August","September","October","November","December");
                  for($x=0;$x<count($month);$x++)
                  {
                    echo '<option value="'.$month[$x].'">'.$month[$x].'</option>';
                  }
                ?>
        </select>
      </td>
    </tr>
    <tr>
      <td colspan="2">
        <table>
          <th>Staff Name</th>
          <th>Basic Salary</th>
    <?php
      $sql1 = "SELECT SID,Name FROM school_staff";
      $result = mysqli_query($connection,$sql1)or die("Error in sql1".mysqli_error($connection));
      $x=1;
      while($view = mysqli_fetch_assoc($result))
        {
          echo '<tr><td>';
          echo '<input type="hidden" value="'.$view["SID"].'" name="txtstaffid'.$x.'" class="form-control" id="txtstaffid'.$x.'">';
          echo '<input type="text" value="'.$view["Name"].'" name="txtstaffname'.$x.'" readonly class="form-control" id="txtstaffname'.$x.'">';
          echo '</td>';
          echo '<td>';
          echo '<input type="number" name="txtstaffbsalary'.$x.'" onKeyPress="return isNumberKey(event)" required class="form-control" id="txtstaffbsalary">';
          echo '</td>';
          echo '</tr>';
          $x++;
        }

        echo '<input type="hidden" value="'.$x.'" name="txtloop"class="form-control" id="txtloop">';
    ?>
  </table>
  </td>
  </tr>	
    <tr>
      <td colspan="2">
		<center><a href="index.php"> <input type='button' name="gobutton" class="btn btn-success" id="gobutton"value='Go Back' class="buttonPro gray"></a>
		<input type="reset" name="btnreset" id="btnreset" class="btn btn-danger" value="Reset">
		<input type="submit" name="btnsubmitadd" id="btnsubmitadd" class="btn btn-primary" value="Submit">
		</center>
	</td>
    </tr>
  </table></div></div></div></div></div>
</form>
<?php
//usertype check end
}
else
{
	header("location:../index.php");
}
?>
</body>
</html>