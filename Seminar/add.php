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
        $sql1 = "SELECT seminarid FROM seminar ORDER BY seminarid DESC LIMIT 1";
        $result1 = mysqli_query($connection, $sql1) or die("Error in sql1" . mysqli_error($connection));
        
        if (mysqli_num_rows($result1) > 0) {
            $row1 = mysqli_fetch_assoc($result1);
            $seminarid = ++$row1["seminarid"];
        } else {
            $seminarid = "SEM00001";
        }
        
        $sql2 = "INSERT INTO seminar (seminarid, date, details) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($connection, $sql2);
        mysqli_stmt_bind_param($stmt, "sss", $seminarid, $_POST['txtdate'], $_POST['txtdetails']);
        mysqli_stmt_execute($stmt);
        
        $totalloop = $_POST['txtloop'];
        
        for ($x = 1; $x <= $totalloop; $x++) {
            if ($_POST['txtstaffatten' . $x] == "Yes") {
                $staffid = mysqli_real_escape_string($connection, $_POST['txtstaffid' . $x]);
                
                $sql3 = "INSERT INTO seminarparticipant (seminarid, staffid) VALUES (?, ?)";
                $stmt2 = mysqli_prepare($connection, $sql3);
                mysqli_stmt_bind_param($stmt2, "ss", $seminarid, $staffid);
                mysqli_stmt_execute($stmt2);
                
                $emailQuery = "SELECT Email_Address FROM school_staff WHERE SID = '$staffid'";
                $emailResult = mysqli_query($connection, $emailQuery);
                if ($emailRow = mysqli_fetch_assoc($emailResult)) {
                    $to = $emailRow["Email_Address"];
                    $subject = "Seminar Invitation";
                    $message = "Dear Participant,\n\nYou have been selected for the seminar on " . $_POST['txtdate'] . ".\nDetails: " . $_POST['txtdetails'] . "\n\nBest Regards,\nYour Organization";
                    
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
        }
        
        echo "<script>alert('Successfully Inserted into Database'); window.location.href='index.php';</script>";
    }
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Seminar</title>
</head>
<body>
    <form action="" method="post" name="seminar" id="seminar">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Seminar Add</div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <tr>
                                    <td>Date</td>
                                    <td><input name="txtdate" type="date" value="<?php echo date('Y-m-d'); ?>" min="<?php echo date('Y-m-d'); ?>" required class="form-control"></td>
                                </tr>
                                <tr>
                                    <td>Details</td>
                                    <td><textarea name="txtdetails" required class="form-control" placeholder="Type Details"></textarea></td>
                                </tr>
                                <tr>
                                    <td colspan="2">Staff Details</td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <table class="table table-striped table-bordered table-hover">
                                            <tr>
                                                <th>Staff Name</th>
                                                <th>Participant</th>
                                            </tr>
                                            <?php
                                            $sql1 = "SELECT SID, Name FROM school_staff";
                                            $result = mysqli_query($connection, $sql1) or die("Error in sql1" . mysqli_error($connection));
                                            $x = 1;
                                            while ($view = mysqli_fetch_assoc($result)) {
                                                echo '<tr><td>';
                                                echo '<input type="hidden" value="' . $view["SID"] . '" name="txtstaffid' . $x . '" class="form-control">';
                                                echo '<input type="text" value="' . $view["Name"] . '" name="txtstaffname' . $x . '" readonly class="form-control">';
                                                echo '</td>';
                                                echo '<td>';
                                                echo '<select name="txtstaffatten' . $x . '" required class="form-control">';
                                                echo '<option value="No">No</option>';
                                                echo '<option value="Yes">Yes</option>';
                                                echo '</select>';
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
                                            <a href="index.php"><input type='button' name="gobutton" class="btn btn-success" value='Go Back'></a>
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
</body>
</html>