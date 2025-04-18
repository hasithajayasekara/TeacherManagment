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
    $totalloop = (int)$_POST['txtloop'];
    $submit = 0;
    $year = $_POST['txtyear'];
    $month = $_POST['txtmonth'];

    // Validate year and month
    if (!preg_match('/^\d{4}$/', $year) || !preg_match('/^(January|February|March|April|May|June|July|August|September|October|November|December)$/', $month)) {
      echo "<script>alert('Invalid year or month.');</script>";
    } else {
      // Check if salary already exists for this period using prepared statement
      $checkSql = $connection->prepare("SELECT COUNT(*) as count FROM salary WHERE year=? AND month=?");
      $checkSql->bind_param("ss", $year, $month);
      $checkSql->execute();
      $checkResult = $checkSql->get_result();
      $checkRow = $checkResult->fetch_assoc();

      if ($checkRow['count'] > 0) {
        echo "<script>alert('Salary records already exist for $month $year!');</script>";
      } else {
        for ($x = 1; $x < $totalloop; $x++) {
          $basicsalary = (float)$_POST['txtstaffbsalary' . $x];

          if ($basicsalary > 0) {
            $staffid = $_POST['txtstaffid' . $x];
            $epf = ($basicsalary * 8) / 100;
            $etf = ($basicsalary * 12) / 100;

            // Insert salary using prepared statement
            $sql2 = $connection->prepare("INSERT INTO salary(staffid, netsalary, year, month, epf, etf) VALUES (?, ?, ?, ?, ?, ?)");
            $sql2->bind_param("sdssdd", $staffid, $basicsalary, $year, $month, $epf, $etf);
            $result2 = $sql2->execute();

            if ($result2) {
              // Get staff details for email using prepared statement
              $emailQuery = $connection->prepare("SELECT Name, Email_Address FROM school_staff WHERE SID = ?");
              $emailQuery->bind_param("s", $staffid);
              $emailQuery->execute();
              $emailResult = $emailQuery->get_result();

              if ($emailResult && $emailRow = $emailResult->fetch_assoc()) {
                $to = $emailRow["Email_Address"];
                $staffName = $emailRow["Name"];

                // Validate email address
                if (filter_var($to, FILTER_VALIDATE_EMAIL)) {
                  $subject = "Salary Update Notification - $month $year";
                  $message = "Dear $staffName,\n\n";
                  $message .= "Your salary details for $month $year have been processed:\n\n";
                  $message .= "Basic Salary: " . number_format($basicsalary, 2) . "\n";
                  $message .= "EPF (8%): " . number_format($epf, 2) . "\n";
                  $message .= "ETF (12%): " . number_format($etf, 2) . "\n";
                  $message .= "Net Salary: " . number_format($basicsalary, 2) . "\n\n";
                  $message .= "Best Regards,\nSchool Management System";

                  $mail = new PHPMailer(true);
                  try {
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'thisarasadesh4@gmail.com';

                    // Get SMTP app password from environment variable
                    $smtpPassword = getenv('SMTP_APP_PASSWORD');
                    if (!$smtpPassword || $smtpPassword === 'your-app-password') {
                        // SMTP password not set properly, log error and notify user
                        error_log("SMTP_APP_PASSWORD environment variable is not set or invalid.");
                        echo "<script>alert('SMTP password is not configured properly. Please set SMTP_APP_PASSWORD environment variable.');</script>";
                        // Optionally, for testing only, uncomment the next line and set your app password directly here (not recommended for production)
                        // $smtpPassword = 'your_actual_app_password_here';
                    }
                    $mail->Password = $smtpPassword;

                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;

                    $mail->setFrom('noreply@schoolsystem.com', 'School Management System');
                    $mail->addAddress($to, $staffName);
                    $mail->Subject = $subject;
                    $mail->Body = $message;

                    try {
                        $mail->send();
                    } catch (Exception $e) {
                        error_log("Email could not be sent to $staffName. Error: {$mail->ErrorInfo}");
                        echo "<script>alert('Email sending failed for $staffName.');</script>";
                    }
                }
              }
              $submit++;
            }
          }
        }

        if ($submit > 0) {
          $_SESSION['success_message'] = "Salary records for $month $year added successfully!";
          header("Location: index.php");
          exit();
        }
      }
    }
  }
?>
  <!doctype html>
  <html lang="en">

  <head>
    <meta charset="utf-8">
    <title>Staff Salary Management | School System</title>
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
        --warning-color: #ffc107;
      }

      .salary-card {
        border-radius: 10px;
        border: none;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        overflow: hidden;
      }

      .salary-card .card-header {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        padding: 1.25rem 1.5rem;
        text-align: center;
        border-bottom: none;
      }

      .salary-card .card-header h4 {
        margin: 0;
        display: flex;
        align-items: center;
        justify-content: center;
      }

      .salary-card .card-header h4 i {
        margin-right: 10px;
      }

      .salary-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 10px;
      }

      .salary-table th {
        background-color: #f8f9fa;
        padding: 12px 15px;
        text-align: left;
        font-weight: 600;
        color: var(--secondary-color);
      }

      .salary-table td {
        padding: 12px 15px;
        vertical-align: middle;
        border-top: 1px solid #dee2e6;
      }

      .salary-table tr:hover td {
        background-color: rgba(52, 152, 219, 0.05);
      }

      .form-control,
      .form-select {
        padding: 0.75rem 1rem;
        border-radius: 8px;
        border: 1px solid #ddd;
        transition: all 0.3s;
      }

      .form-control:focus,
      .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.25rem rgba(52, 152, 219, 0.25);
      }

      .btn-action {
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s;
        min-width: 120px;
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

      .input-group-text {
        background-color: #e9ecef;
      }

      .salary-input {
        text-align: right;
        font-weight: 500;
      }
    </style>
  </head>

  <body>
    <div class="container mt-4">
      <div class="salary-card">
        <div class="card-header">
          <h4><i class="fas fa-money-bill-wave me-2"></i>Staff Salary Management</h4>
        </div>
        <div class="card-body">
          <form action="" method="post" name="staffsal" id="staffsal">
            <div class="row mb-4">
              <div class="col-md-6">
                <label for="txtyear" class="form-label ms-3">Year</label> <!-- ms-3 adds left margin -->
                <select name="txtyear" id="txtyear" class="form-select" required>
                  <option value="" selected disabled>Select Year</option>
                  <?php
                  $year = date("Y");
                  for ($x = $year; $x > $year - 5; $x--) {
                    echo '<option value="' . $x . '">' . $x . '</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="col-md-6">
                <label for="txtmonth" class="form-label">Month</label>
                <select name="txtmonth" id="txtmonth" class="form-select" required>
                  <option value="" selected disabled>Select Month</option>
                  <?php
                  $month = array(
                    "January",
                    "February",
                    "March",
                    "April",
                    "May",
                    "June",
                    "July",
                    "August",
                    "September",
                    "October",
                    "November",
                    "December"
                  );
                  foreach ($month as $m) {
                    echo '<option value="' . $m . '">' . $m . '</option>';
                  }
                  ?>
                </select>
              </div>
            </div>

            <div class="table-responsive">
              <table class="salary-table">
                <thead>
                  <tr>
                    <th width="60%">Staff Name</th>
                    <th width="40%">Basic Salary (Rs.)</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sql1 = "SELECT SID, Name FROM school_staff ORDER BY Name";
                  $result = mysqli_query($connection, $sql1) or die("Error in sql1: " . mysqli_error($connection));
                  $x = 1;
                  while ($view = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                    echo '<td>';
                    echo '<input type="hidden" value="' . htmlspecialchars($view["SID"]) . '" name="txtstaffid' . $x . '" class="form-control">';
                    echo '<input type="text" value="' . htmlspecialchars($view["Name"]) . '" name="txtstaffname' . $x . '" readonly class="form-control">';
                    echo '</td>';
                    echo '<td>';
                    echo '<div class="input-group">';
                    echo '<span class="input-group-text">Rs.</span>';
                    echo '<input type="number" name="txtstaffbsalary' . $x . '" class="form-control salary-input" min="0" step="0.01">';
                    echo '</div>';
                    echo '</td>';
                    echo '</tr>';
                    $x++;
                  }
                  echo '<input type="hidden" value="' . $x . '" name="txtloop">';
                  ?>
                </tbody>
              </table>
            </div>

            <div class="d-flex justify-content-center mt-4 gap-3">
              <a href="index.php" class="btn btn-action btn-back">
                <i class="fas fa-arrow-left"></i> Go Back
              </a>
              <button type="reset" name="btnreset" class="btn btn-action btn-reset">
                <i class="fas fa-undo"></i> Reset
              </button>
              <button type="submit" name="btnsubmitadd" class="btn btn-action btn-submit">
                <i class="fas fa-save"></i> Submit Salaries
              </button>
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
        // Validate at least one salary is entered before submission
        $('#staffsal').submit(function(e) {
          let hasSalary = false;
          $('input[type="number"]').each(function() {
            if ($(this).val() > 0) {
              hasSalary = true;
              return false; // break out of loop
            }
          });

          if (!hasSalary) {
            alert('Please enter at least one salary amount before submitting.');
            e.preventDefault();
          }
        });

        // Format salary inputs on blur
        $('.salary-input').on('blur', function() {
          if ($(this).val() !== '') {
            $(this).val(parseFloat($(this).val()).toFixed(2));
          }
        });
      });
    </script>
  </body>

  </html>
<?php
} else {
  header("location:../index.php");}}