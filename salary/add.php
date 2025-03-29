<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';

include("../config.php");
if (!isset($_SESSION)) {
  session_start();
}
if (isset($_SESSION['usertype'])) {
  $usertype = $_SESSION['usertype'];
} else {
  $usertype = "guest";
}
if ($usertype == "zone" || $usertype == "clerk") {
  if (isset($_POST['btnsubmitadd'])) {
    $totalloop = $_POST['txtloop'];
    $submit = 0;
    for ($x = 1; $x < $totalloop; $x++) {
      $basicsalary = (float)$_POST['txtstaffbsalary' . $x];
      $epf = ($basicsalary * 8) / 100;
      $etf = ($basicsalary * 12) / 100;


      $staffid = mysqli_real_escape_string($connection, $_POST['txtstaffid' . $x]);
      $sql2 = "INSERT INTO salary(staffid,netsalary,year,month,epf,etf) VALUES (
      '$staffid',
      '" . mysqli_real_escape_string($connection, $_POST['txtstaffbsalary' . $x]) . "',
      '" . mysqli_real_escape_string($connection, $_POST['txtyear']) . "',
      '" . mysqli_real_escape_string($connection, $_POST['txtmonth']) . "',
      '" . mysqli_real_escape_string($connection, $epf) . "',
      '" . mysqli_real_escape_string($connection, $etf) . "')";
      $result2 = mysqli_query($connection, $sql2) or die("Error in sql2" . mysqli_error($connection));

      // Fetch email of the staff member
      $emailQuery = "SELECT Email_Address FROM school_staff WHERE SID = '$staffid'";
      $emailResult = mysqli_query($connection, $emailQuery);

      if ($basicsalary > 0) {
        if ($emailRow = mysqli_fetch_assoc($emailResult)) {
          $to = $emailRow["Email_Address"];
          $subject = "Salary Update Notification";
          $message = "Dear Staff Member,\n\nYour salary has been updated for the month of " . $_POST['txtmonth'] . " in the year " . $_POST['txtyear'] . ".\nNet Salary: $basicsalary\nEPF: $epf\nETF: $etf\n\nBest Regards,\nYour Organization";

          // Send email using PHPMailer
          $mail = new PHPMailer(true);
          try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'thisarasadesh4@gmail.com';
            $mail->Password = 'hcqw oosi vgul mkvh';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('your-email@example.com', 'Your Organization');
            $mail->addAddress($to);
            $mail->Subject = $subject;
            $mail->Body = $message;

            $mail->send();
          } catch (Exception $e) {
            error_log("Email could not be sent. Mailer Error: {$mail->ErrorInfo}");
          }
        }
      }

      $submit++;
    }
    if ($submit > 0) {
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
                        $year = date("Y");
                        for ($x = $year; $x > $year - 5; $x--) {
                          echo '<option value="' . $x . '">' . $x . '</option>';
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
                        $month = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
                        for ($x = 0; $x < count($month); $x++) {
                          echo '<option value="' . $month[$x] . '">' . $month[$x] . '</option>';
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
                        $result = mysqli_query($connection, $sql1) or die("Error in sql1" . mysqli_error($connection));
                        $x = 1;
                        while ($view = mysqli_fetch_assoc($result)) {
                          echo '<tr><td>';
                          echo '<input type="hidden" value="' . $view["SID"] . '" name="txtstaffid' . $x . '" class="form-control">';
                          echo '<input type="text" value="' . $view["Name"] . '" name="txtstaffname' . $x . '" readonly class="form-control">';
                          echo '</td>';
                          echo '<td>';
                          echo '<input type="number" name="txtstaffbsalary' . $x . '"  class="form-control">';
                          echo '</td>';
                          echo '</tr>';
                          $x++;
                        }
                        echo '<input type="hidden" value="' . $x . '" name="txtloop" class="form-control">';
                        ?>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2">
                      <center>
                        <a href="index.php" class="btn btn-success">Go Back</a>
                        <input type="reset" name="btnreset" class="btn btn-danger" value="Reset">
                        <input type="submit" name="btnsubmitadd" class="btn btn-primary" value="Submit">
                      </center>
                    </td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  <?php
} else {
  header("location:../index.php");
}
  ?>
  </body>

  </html>