<?php
include("../config.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';

if(!isset($_SESSION)) {
    session_start();
}
if(isset($_SESSION['usertype'])) {
    $usertype = $_SESSION['usertype'];
} else {
    $usertype = "guest";
}

if($usertype == "zone" || $usertype == "clerk") {
    if(isset($_POST['btnsubmitadd'])) {
        // Validate inputs
        $staffid = mysqli_real_escape_string($connection, $_POST['txtstaff']);
        $transferdate = mysqli_real_escape_string($connection, $_POST['txtTransferdate']);
        $schoolid = mysqli_real_escape_string($connection, $_POST['txtschool']);
        $post = mysqli_real_escape_string($connection, $_POST['txtpost']);

        // Insert transfer record
        $sql2 = "INSERT INTO transfer(staffid, transferdate, schoolid) VALUES (
            '$staffid', '$transferdate', '$schoolid')";
        $result2 = mysqli_query($connection, $sql2) or die("Error in sql2: ".mysqli_error($connection));

        if($result2) {
            // Get current school assignment
            $sqlpreschool = "SELECT * FROM staffwork WHERE staffid='$staffid' AND enddate='0000-00-00'";
            $resultpreschool = mysqli_query($connection, $sqlpreschool) or die("Error: ".mysqli_error($connection));
            
            if(mysqli_num_rows($resultpreschool) > 0) {
                $rowpreschool = mysqli_fetch_assoc($resultpreschool);
                // Calculate previous day as end date
                $previdate = date("Y-m-d", strtotime($transferdate) - 86400);
                
                // Update previous assignment
                $sqlupdate = "UPDATE staffwork SET enddate='$previdate' 
                             WHERE staffid='$staffid' AND startdate='".$rowpreschool['startdate']."'";
                $resultupdate = mysqli_query($connection, $sqlupdate) or die("Error: ".mysqli_error($connection));
            }

            // Insert new assignment
            $sql3 = "INSERT INTO staffwork(staffid, startdate, schoolid, post) VALUES (
                '$staffid', '$transferdate', '$schoolid', '$post')";
            $result3 = mysqli_query($connection, $sql3) or die("Error: ".mysqli_error($connection));

            if($result3) {
                // Send notification email
                $emailQuery = "SELECT ss.Name, ss.Email_Address, sc.name as school_name 
                              FROM school_staff ss 
                              JOIN school sc ON sc.schoolid='$schoolid'
                              WHERE ss.SID = '$staffid'";
                $emailResult = mysqli_query($connection, $emailQuery);
                
                if($emailResult && mysqli_num_rows($emailResult) > 0) {
                    $emailRow = mysqli_fetch_assoc($emailResult);
                    $to = $emailRow["Email_Address"];
                    $staffName = $emailRow["Name"];
                    $schoolName = $emailRow["school_name"];
                    
                    $subject = "Staff Transfer Notification";
                    $message = "Dear $staffName,\n\nYou have been transferred to $schoolName.\n\n";
                    $message .= "Transfer Date: $transferdate\n";
                    $message .= "New Post: $post\n\n";
                    $message .= "Best regards,\nSchool Management System";

                    $mail = new PHPMailer(true);
                    try {
                        // Server settings
                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com';
                        $mail->SMTPAuth = true;
                        $mail->Username = 'thisarasadesh4@gmail.com';
                        $mail->Password = 'your-app-password'; // Use app-specific password
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                        $mail->Port = 587;

                        // Recipients
                        $mail->setFrom('noreply@schoolsystem.com', 'School Management System');
                        $mail->addAddress($to, $staffName);
                        
                        // Content
                        $mail->isHTML(false);
                        $mail->Subject = $subject;
                        $mail->Body = $message;

                        $mail->send();
                    } catch (Exception $e) {
                        error_log("Email could not be sent. Error: {$mail->ErrorInfo}");
                    }
                }

                $_SESSION['success_message'] = "Transfer recorded successfully!";
                header("Location: index.php");
                exit();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Add Transfer | School Management System</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --success-color: #28a745;
            --danger-color: #dc3545;
            --light-color: #f8f9fa;
        }
        
        .transfer-form-card {
            max-width: 800px;
            margin: 2rem auto;
            border-radius: 10px;
            border: none;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .transfer-form-card .card-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 1.25rem 1.5rem;
            text-align: center;
            border-bottom: none;
        }
        
        .transfer-form-card .card-header h4 {
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .transfer-form-card .card-header h4 i {
            margin-right: 10px;
        }
        
        .transfer-form-card .card-body {
            padding: 2rem;
        }
        
        .form-label {
            font-weight: 600;
            color: var(--secondary-color);
            margin-bottom: 0.5rem;
        }
        
        .form-control, .form-select {
            padding: 0.75rem 1rem;
            border-radius: 8px;
            border: 1px solid #ddd;
            transition: all 0.3s;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(52, 152, 219, 0.25);
        }
        
        .btn-action {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
            min-width: 120px;
            margin: 0 0.5rem;
        }
        
        .btn-action i {
            margin-right: 0.5rem;
        }
        
        .btn-submit {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-submit:hover {
            background-color: #2c3e50;
            border-color: #2c3e50;
            transform: translateY(-2px);
        }
        
        .btn-reset {
            background-color: var(--danger-color);
            border-color: var(--danger-color);
        }
        
        .btn-back {
            background-color: #6c757d;
            border-color: #6c757d;
        }
        
        .form-table {
            width: 100%;
        }
        
        .form-table td {
            padding: 1rem 0;
            vertical-align: middle;
        }
        
        .select2-container--default .select2-selection--single {
            height: auto;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="transfer-form-card">
            <div class="card-header">
                <h4><i class="fas fa-exchange-alt me-2"></i>Staff Transfer</h4>
            </div>
            <div class="card-body">
                <form action="" method="post" name="transferForm" id="transferForm">
                    <table class="form-table">
                        <tr>
                            <td width="30%"><label for="txtstaff" class="form-label">Staff Name</label></td>
                            <td>
                                <select name="txtstaff" required class="form-select" id="txtstaff">
                                    <?php
                                    if(isset($_GET["transtaffid"])) {
                                        $staffid = base64_decode($_GET["transtaffid"]);
                                        $sqlsch = "SELECT ss.SID, ss.Name FROM school_staff ss WHERE ss.SID='$staffid'";
                                    } else {
                                        $sqlsch = "SELECT ss.SID, ss.Name FROM school_staff ss, staffwork sw 
                                                  WHERE ss.SID=sw.staffid AND sw.enddate='0000-00-00'";
                                        echo '<option value="" selected disabled>Select Staff Name</option>';
                                    }

                                    $resultsch = mysqli_query($connection, $sqlsch);
                                    if($resultsch) {
                                        while($rowsch = mysqli_fetch_assoc($resultsch)) {
                                            echo '<option value="'.htmlspecialchars($rowsch["SID"]).'">'
                                                .htmlspecialchars($rowsch["Name"]).'</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="txtTransferdate" class="form-label">Transfer Date</label></td>
                            <td>
                                <input name="txtTransferdate" type="date" 
                                       value="<?php echo date("Y-m-d"); ?>" 
                                       required class="form-control" id="txtTransferdate">
                            </td>
                        </tr>
                        <tr>
                            <td><label for="txtschool" class="form-label">New School</label></td>
                            <td>
                                <select name="txtschool" required class="form-select" id="txtschool">
                                    <option value="" selected disabled>Select School</option>
                                    <?php
                                    $sqlsch = "SELECT schoolid, name FROM school ORDER BY name";
                                    $resultsch = mysqli_query($connection, $sqlsch);
                                    if($resultsch) {
                                        while($rowsch = mysqli_fetch_assoc($resultsch)) {
                                            echo '<option value="'.htmlspecialchars($rowsch["schoolid"]).'">'
                                                .htmlspecialchars($rowsch["name"]).'</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="txtpost" class="form-label">New Post</label></td>
                            <td>
                                <select name="txtpost" id="txtpost" class="form-select" required>
                                    <option value="" selected disabled>Select Post</option>
                                    <?php
                                    $spost = array("Principal", "Vice Principal", "Sectional Head", "Teacher");
                                    foreach($spost as $post) {
                                        echo '<option value="'.htmlspecialchars($post).'">'.htmlspecialchars($post).'</option>';
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div class="d-flex justify-content-center mt-4">
                                    <a href="index.php" class="btn btn-action btn-back">
                                        <i class="fas fa-arrow-left"></i> Go Back
                                    </a>
                                    <button type="reset" name="btnreset" id="btnreset" 
                                            class="btn btn-action btn-reset">
                                        <i class="fas fa-undo"></i> Reset
                                    </button>
                                    <button type="submit" name="btnsubmitadd" id="btnsubmitadd" 
                                            class="btn btn-action btn-submit">
                                        <i class="fas fa-save"></i> Submit Transfer
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Select2 for enhanced select boxes -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Initialize Select2 for select boxes
            $('#txtstaff, #txtschool, #txtpost').select2({
                width: '100%',
                placeholder: $(this).data('placeholder')
            });

            // Set default staff if coming from transfer notification
            <?php if(isset($_GET["transtaffid"])): ?>
                $('#txtstaff').val('<?php echo htmlspecialchars($staffid); ?>').trigger('change');
            <?php endif; ?>
        });
    </script>
</body>
</html>