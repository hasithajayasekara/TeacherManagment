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

// Custom function to generate unique seminarid
function generateSeminarId($connection) {
    $prefix = "SEM";
    $defaultId = $prefix . "00001";

    $sql = "SELECT seminarid FROM seminar ORDER BY seminarid DESC LIMIT 1";
    $result = mysqli_query($connection, $sql) or die("Error in seminarid query: " . mysqli_error($connection));

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $lastId = $row['seminarid'];

        // Extract numeric part
        $numPart = intval(substr($lastId, strlen($prefix)));

        // Increment numeric part
        $newNum = $numPart + 1;

        // Format new ID with leading zeros
        $newId = $prefix . str_pad($newNum, 5, "0", STR_PAD_LEFT);

        // Check for duplicates and increment if necessary
        while (true) {
            $checkSql = "SELECT seminarid FROM seminar WHERE seminarid = '$newId'";
            $checkResult = mysqli_query($connection, $checkSql) or die("Error in duplicate check: " . mysqli_error($connection));
            if (mysqli_num_rows($checkResult) == 0) {
                break;
            }
            $newNum++;
            $newId = $prefix . str_pad($newNum, 5, "0", STR_PAD_LEFT);
        }
        return $newId;
    } else {
        return $defaultId;
    }
}

if ($usertype == "zone" || $usertype == "clerk") {
    if (isset($_POST['btnsubmitadd'])) {
        $seminarid = generateSeminarId($connection);

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
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Seminar Management | Teacher Management System</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --success-color: #28a745;
            --info-color: #17a2b8;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
        }
        
        .seminar-card {
            border-radius: 10px;
            border: none;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .seminar-card .card-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 1.25rem 1.5rem;
            border-bottom: none;
        }
        
        .seminar-card .card-header h4 {
            margin: 0;
            display: flex;
            align-items: center;
        }
        
        .seminar-card .card-header h4 i {
            margin-right: 10px;
        }
        
        .form-control {
            border-radius: 6px;
            padding: 0.75rem 1rem;
            border: 1px solid #dee2e6;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(52, 152, 219, 0.25);
        }
        
        .table-responsive {
            border-radius: 8px;
            overflow: hidden;
        }
        
        .table {
            margin-bottom: 0;
        }
        
        .table th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            color: #6c757d;
            border-bottom-width: 2px;
            background-color: #f8f9fa;
        }
        
        .table tr:hover {
            background-color: rgba(52, 152, 219, 0.05);
        }
        
        .btn-submit {
            background-color: var(--primary-color);
            border: none;
            padding: 0.5rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(52, 152, 219, 0.3);
        }
        
        .btn-reset {
            background-color: var(--danger-color);
            border: none;
            padding: 0.5rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-reset:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3);
        }
        
        .btn-back {
            background-color: var(--secondary-color);
            border: none;
            padding: 0.5rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-back:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(44, 62, 80, 0.3);
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="seminar-card">
            <div class="card-header">
                <h4><i class="fas fa-chalkboard-teacher me-2"></i>Add New Seminar</h4>
            </div>
            <div class="card-body">
                <form action="" method="post" name="seminar" id="seminar">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label ms-3">Date</label>
                                <input name="txtdate" type="date" class="form-control ms-3" 
                                       value="<?php echo date('Y-m-d'); ?>" 
                                       min="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Details</label>
                                <textarea name="txtdetails" required class="form-control" 
                                          placeholder="Type seminar details"></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="form-group">
                                <h5 class="mb-3"><i class="fas fa-users me-2 ms-3"></i>Staff Participants</h5>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th width="70%">Staff Name</th>
                                                <th width="30%">Participant</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql1 = "SELECT SID, Name FROM school_staff";
                                            $result = mysqli_query($connection, $sql1) or die("Error in sql1" . mysqli_error($connection));
                                            $x = 1;
                                            while ($view = mysqli_fetch_assoc($result)) {
                                                echo '<tr>';
                                                echo '<td>';
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
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group text-center mt-4">
                        <a href="index.php" class="btn btn-back text-white me-2">
                            <i class="fas fa-arrow-left me-2"></i>Go Back
                        </a>
                        <input type="reset" name="btnreset" class="btn btn-reset me-2" value="Reset">
                        <input type="submit" name="btnsubmitadd" class="btn btn-submit" value="Submit">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Form validation can be added here if needed
        });
    </script>
</body>
</html>