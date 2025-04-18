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
<title>Staff Salary</title>
</head>
<body>
	<div class="row">
       <div class="col-lg-12">
         <div class="panel panel-default">
           <div class="panel-heading">
               Staff Salary View
           </div>
            <div class="panel-body">
              <div class="table-responsive">
				<table class="table table-striped table-bordered table-hover" id="dataTables-example">

						<thead><tr><th></th><th>year</th><th>Month</th><th>Staff</th><th>Net Salary</th>
							<th>EPF</th><th>ETF</th></tr></thead><tbody>	
					<?php
						// Validate and sanitize GET parameters
						$yer = isset($_GET["year"]) ? base64_decode($_GET["year"]) : '';
						$mon = isset($_GET["month"]) ? base64_decode($_GET["month"]) : '';
						if (!preg_match('/^\d{4}$/', $yer)) {
							echo '<tr><td colspan="7">Invalid year parameter.</td></tr>';
						} elseif (!preg_match('/^(January|February|March|April|May|June|July|August|September|October|November|December)$/', $mon)) {
							echo '<tr><td colspan="7">Invalid month parameter.</td></tr>';
						} else {
							// Use prepared statement to prevent SQL injection
							$stmt = $connection->prepare("SELECT * FROM salary WHERE year=? AND month=?");
							$stmt->bind_param("ss", $yer, $mon);
							$stmt->execute();
							$result = $stmt->get_result();
							$x = 1;
							if ($result->num_rows > 0) {
								while ($viewarr = $result->fetch_assoc()) {
									if ($viewarr !== null && isset($viewarr['staffid'])) {
										$stmtstaff = $connection->prepare("SELECT name FROM school_staff WHERE SID=?");
										$stmtstaff->bind_param("s", $viewarr['staffid']);
										$stmtstaff->execute();
										$resultstaff = $stmtstaff->get_result();
										$viewarrstaff = $resultstaff->fetch_assoc();
										$name = ($viewarrstaff !== null && isset($viewarrstaff['name'])) ? $viewarrstaff['name'] : 'Unknown Staff';
										echo '<tr><td>' . $x . '</td><td>' . htmlspecialchars($yer) . '</td><td>' . htmlspecialchars($mon) . '</td>
										<td>' . htmlspecialchars($name) . '</td>
										<td>' . htmlspecialchars($viewarr["netsalary"]) . '</td>
										<td>' . htmlspecialchars($viewarr["epf"]) . '</td>
										<td>' . htmlspecialchars($viewarr["etf"]) . '</td>
										</tr>';
										$x++;
									}
								}
							} else {
								echo '<tr><td colspan="7">No salary records found for ' . htmlspecialchars($mon) . ' ' . htmlspecialchars($yer) . '.</td></tr>';
							}
							$stmt->close();
						}
					?>
					</tbody>
			</table>
			<table>

				<tr>
					<td>
						<center>
						<a href="index.php"> <input type='button' name="gobutton" class="btn btn-success" id="gobutton"value='Go Back' class="buttonPro gray"></a>
						</center>
					</td>
				</tr>
			</table>
			</div>
			</div>
		</div>
	</div>
</div>
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
