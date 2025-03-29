<?php
include("../config.php");
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
        $sql1 = "SELECT schoolid FROM school ORDER BY schoolid DESC LIMIT 1"; 
        $result1 = mysqli_query($connection,$sql1) or die("Error in sql1".mysqli_error($connection));
        if (mysqli_num_rows($result1) > 0) {
            $row1 = mysqli_fetch_assoc($result1);
            $schoolid = ++$row1["schoolid"];
        } else {
            $schoolid = "SCH00001";
        }
        
        $sql2 = "INSERT INTO school(schoolid, censusid, name, address, tpnum, zoneid) VALUES (
                '".mysqli_real_escape_string($connection,$schoolid)."',
                '".mysqli_real_escape_string($connection,$_POST['txtcensusid'])."',
                '".mysqli_real_escape_string($connection,$_POST['txtschname'])."',
                '".mysqli_real_escape_string($connection,$_POST['txtaddress'])."',
                '".mysqli_real_escape_string($connection,$_POST['txttpnum'])."',
                '".mysqli_real_escape_string($connection,$_POST['txtzone'])."')";
        $result2 = mysqli_query($connection,$sql2) or die("Error in sql2".mysqli_error($connection));
        
        if($result2) {
            echo "<script>alert('School successfully added to database');window.location.href='index.php';</script>";
        }
    }
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Add School | Teacher Management System</title>
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
        
        .school-form-card {
            max-width: 800px;
            margin: 2rem auto;
            border-radius: 10px;
            border: none;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .school-form-card .card-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 1.25rem 1.5rem;
            text-align: center;
            border-bottom: none;
        }
        
        .school-form-card .card-body {
            padding: 2rem;
        }
        
        .form-label {
            font-weight: 600;
            color: var(--secondary-color);
            margin-bottom: 0.5rem;
        }
        
        .form-control {
            padding: 0.75rem 1rem;
            border-radius: 8px;
            border: 1px solid #ddd;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(52, 152, 219, 0.25);
        }
        
        .form-select {
            padding: 0.75rem 1rem;
            border-radius: 8px;
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
        
        .input-group-text {
            background-color: #e9ecef;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="school-form-card">
            <div class="card-header">
                <h4><i class="fas fa-school me-2"></i>Add New School</h4>
            </div>
            <div class="card-body">
                <form action="" method="post" name="school" id="school">
                    <table class="form-table">
                        <tr>
                            <td>
                                <label for="txtcensusid" class="form-label">Census ID</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <input name="txtcensusid" type="text" onKeyPress="return isNumberKey(event)" 
                                           required class="form-control" id="txtcensusid" 
                                           placeholder="Enter census ID">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="txtschname" class="form-label">School Name</label>
                            </td>
                            <td>
                                <input name="txtschname" type="text" onKeyPress="return isTextKey(event)" 
                                       required class="form-control" id="txtschname" 
                                       placeholder="Enter school name">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="txtaddress" class="form-label">School Address</label>
                            </td>
                            <td>
                                <input name="txtaddress" type="text" required class="form-control" 
                                       id="txtaddress" placeholder="Enter school address">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="txttpnum" class="form-label">Telephone Number</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input name="txttpnum" type="text" onKeyPress="return isNumberKey(event)" 
                                           required class="form-control" id="txttpnum" 
                                           placeholder="Enter telephone number">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="txtzone" class="form-label">Zone</label>
                            </td>
                            <td>
                                <select name="txtzone" required class="form-select" id="txtzone">
                                    <option value="" selected disabled>Select Zone</option>
                                    <?php
                                    $sqlzone = "SELECT * FROM zone";
                                    $resultzone = mysqli_query($connection,$sqlzone) or die("sql error in sqlzone ".mysqli_error($connection));
                                    while($rowzone = mysqli_fetch_assoc($resultzone)) {
                                        echo '<option value="'.htmlspecialchars($rowzone["zoneid"]).'">'.htmlspecialchars($rowzone["zonename"]).'</option>';
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div class="d-flex justify-content-center mt-4">
                                    <a href="index.php" class="btn btn-action btn-back">
                                        <i class="fas fa-arrow-left"></i>Go Back
                                    </a>
                                    <button type="reset" name="btnreset" id="btnreset" 
                                            class="btn btn-action btn-reset">
                                        <i class="fas fa-undo"></i>Reset
                                    </button>
                                    <button type="submit" name="btnsubmitadd" id="btnsubmitadd" 
                                            class="btn btn-action btn-submit">
                                        <i class="fas fa-save"></i>Submit
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
    <script>
        function isTextKey(evt) {
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 65 || charCode > 90) && (charCode < 97 || charCode > 122) && charCode != 32) {
                return false;
            }
            return true;
        }
        
        function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
<?php
} else {
    header("location:../index.php");
}
?>