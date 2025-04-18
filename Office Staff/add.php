<?php
include("../config.php");
if (!isset($_SESSION)) {
    session_start();
}
$usertype = $_SESSION['usertype'] ?? "guest";

if ($usertype == "zone" || $usertype == "clerk") {
    if (isset($_POST['btnsubmitadd'])) {
        $sql1 = "SELECT SID FROM school_staff ORDER BY SID DESC LIMIT 1";
        $result1 = mysqli_query($connection, $sql1) or die("Error in sql1" . mysqli_error($connection));
        $stfid = (mysqli_num_rows($result1) > 0) ? ++mysqli_fetch_assoc($result1)['SID'] : "SS000001";
        
        $fields = [
            'SID' => $stfid,
            'Name' => $_POST['txtstfname'],
            'Gender' => $_POST['txt_gend'],
            'Date_of_birth' => $_POST['txttdob'],
            'Age' => $_POST['txtage'],
            'NIC_number' => $_POST['txtnic'],
            'Religion' => $_POST['txtrelg'],
            'Nationality' => $_POST['txtnation'],
            'Civil_status' => $_POST['txtstcivel'],
            'Address' => $_POST['txtaddress'],
            'Telephone_number' => $_POST['txtphone'],
            'First_appoinment_date' => $_POST['txtapdate'],
            'First_appoinment_school' => $_POST['txtschool'],
            'Subject_teach' => $_POST['txtteach'],
            'Post' => $_POST['txtpost']
        ];
        
$sql2 = "INSERT INTO school_staff (" . implode(", ", array_keys($fields)) . ") VALUES ('" . implode("', '", array_map(function($value) use ($connection) { return mysqli_real_escape_string($connection, $value); }, array_values($fields))) . "')";
        mysqli_query($connection, $sql2) or die("Error in sql2" . mysqli_error($connection));

        $sql3 = "INSERT INTO staffwork (staffid, startdate, schoolid, post) VALUES ('$stfid', '{$_POST['txtapdate']}', '{$_POST['txtschool']}', '{$_POST['txtpost']}')";
        mysqli_query($connection, $sql3) or die("Error in sql3" . mysqli_error($connection));
        
        $sql4 = "INSERT INTO login (user_id, password, user_type, attempt) VALUES ('$stfid', '{$_POST['txtnic']}', 'teach', '0')";
        mysqli_query($connection, $sql4) or die("Error in sql4" . mysqli_error($connection));
        
        echo "<script>alert('Successfully Inserted into Database');window.location.href='index.php';</script>";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Staff Management | Teacher Management System</title>
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
        }
        
        .staff-card {
            border-radius: 10px;
            border: none;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .staff-card .card-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 1.25rem 1.5rem;
            border-bottom: none;
        }
        
        .staff-card .card-header h4 {
            margin: 0;
            display: flex;
            align-items: center;
        }
        
        .staff-card .card-header h4 i {
            margin-right: 10px;
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
        
        .form-group label {
            font-weight: 500;
            color: var(--secondary-color);
            margin-bottom: 0.5rem;
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
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="staff-card">
            <div class="card-header">
                <h4><i class="fas fa-user-tie me-2"></i>Add New Staff Member</h4>
            </div>
            <div class="card-body">
                <form action="" method="post" id="sch_staff">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="ms-3">Staff Name</label>
                                <input type="text" name="txtstfname" class="form-control" required placeholder="Type Staff Name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Gender</label>
                                <select name="txt_gend" class="form-control" required>
                                    <option value="">Select The Gender</option>
                                    <option>Male</option>
                                    <option>Female</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="ms-3">Date of Birth</label>
                                <input type="date" name="txttdob" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>NIC Number</label>
                                <input type="text" name="txtnic" class="form-control" required placeholder="Type NIC Number">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="ms-3">First Appointment School</label>
                                <select name="txtschool" class="form-control" required>
                                    <option value="">Select First Appointment School</option>
                                    <?php
                                    $sqlsch = "SELECT * FROM school";
                                    $resultsch = mysqli_query($connection, $sqlsch) or die("sql error in sqlsch " . mysqli_error($connection));
                                    while ($rowsch = mysqli_fetch_assoc($resultsch)) {
                                        echo '<option value="' . $rowsch["schoolid"] . '">' . $rowsch["name"] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group text-center mt-4">
                        <a href="index.php" class="btn btn-secondary me-2">
                            <i class="fas fa-arrow-left me-2"></i>Go Back
                        </a>
                        <input type="reset" class="btn btn-reset me-2" value="Reset">
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
<?php
} else {
    header("location:../index.php");
}
?>