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

if($usertype == "zone") {
    $stfid = base64_decode($_GET["staffid"]);

    // Fetch the staff details using the SID (staff ID)
    $sql_fetch = "SELECT * FROM school_staff WHERE SID='$stfid'";
    $result = mysqli_query($connection, $sql_fetch);

    if(mysqli_num_rows($result) > 0) {
        $staff = mysqli_fetch_assoc($result);
        $staff_name = $staff['Name'];  // Assuming there's a 'name' field for the staff
        $staff_email = $staff['Email_Address']; // Assuming there's an 'email_address' field for the staff
    }

    // Delete the staff from the database
    $sql3 = "DELETE FROM school_staff WHERE SID='$stfid'";
    $view = mysqli_query($connection, $sql3) or die("Error in sql3" . mysqli_error($connection));

    if($view) {
        // PHPMailer email notification
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.yourmailserver.com'; // Set the SMTP server to send through
            $mail->SMTPAuth = true;
            $mail->Username = 'thisarasadesh4@gmail.com'; // SMTP username (your email)
            $mail->Password = 'hcqw oosi vgul mkvh'; // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587; // TCP port to connect to (use 465 for SSL)

            // Recipients
            $mail->setFrom('admin@yourdomain.com', 'Admin');
            $mail->addAddress( 'your@dadad.com'); // Admin or other email recipient

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'User Deletion Notification';
            $mail->Body    = "
            <html>
            <head>
                <title>User Deletion Notification</title>
            </head>
            <body>
                <p>The following staff member has been successfully deleted from the system:</p>
                <p><strong>Staff ID:</strong> $stfid</p>
                <p><strong>Name:</strong> $staff_name</p>
                <p><strong>Email:</strong> $staff_email</p>
                <p><strong>Action:</strong> Deleted from the school_staff database.</p>
                <p>If this action was not intended, please contact the administrator.</p>
            </body>
            </html>";

            // Send the email
            $mail->send();
            echo "<script> alert('Successfully deleted from Database and email sent.');window.location.href='index.php'; </script>";
        } catch (Exception $e) {
            echo "<script> alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}');window.location.href='index.php'; </script>";
        }
    }
} else {
    header("location:../index.php");
}
?>
