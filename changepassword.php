<?php
include("config.php");
if(!isset($_SESSION)) {
    session_start();
}
if(isset($_SESSION['usertype'])) {
    $usertype = $_SESSION['usertype'];
} else {
    $usertype = "guest";
}

if($usertype != "guest") {
    if(isset($_POST['btnsubmit'])) {
        $username = $_POST['txtusername'];
        $currentPassword = $_POST['txtcurrentpassword'];
        $newPassword = $_POST['txtnewpassword'];
        $reNewPassword = $_POST['txtrenewpassword'];

        // Prepare statement to fetch user password
        $stmt = $connection->prepare("SELECT password FROM login WHERE user_id = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $row = $result->fetch_assoc()) {
            if ($row["password"] === $currentPassword) {
                if ($newPassword === $reNewPassword) {
                    // Prepare statement to update password
                    $updateStmt = $connection->prepare("UPDATE login SET password = ? WHERE user_id = ?");
                    $updateStmt->bind_param("ss", $newPassword, $username);
                    if ($updateStmt->execute()) {
                        echo "<script>alert('Your new password has been updated successfully'); window.location.href='index.php?pg=signout.php&cp';</script>";
                    } else {
                        echo "<script>alert('Error updating password. Please try again later.');</script>";
                    }
                    $updateStmt->close();
                } else {
                    echo "<script>alert('Your new passwords do not match');</script>";
                }
            } else {
                echo "<script>alert('Your current password is incorrect');</script>";
            }
        } else {
            echo "<script>alert('User not found');</script>";
        }
        $stmt->close();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password | Teacher Management System</title>
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
        
        body {
            background-color: #f5f5f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
    .password-card {
        max-width: 1000px;
        border-radius: 10px;
        border: none;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
        
        .password-card .card-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 1.25rem;
            text-align: center;
            border-bottom: none;
        }
        
        .password-card .card-body {
            padding: 2rem;
        }
        
        .form-label {
            font-weight: 600;
            color: var(--secondary-color);
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
        
        .btn-action {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .password-strength {
            height: 5px;
            background: #e9ecef;
            border-radius: 3px;
            margin-top: 0.5rem;
            overflow: hidden;
        }
        
        .strength-meter {
            height: 100%;
            width: 0;
            transition: width 0.3s;
        }
        
        .password-requirements {
            font-size: 0.85rem;
            color: #6c757d;
            margin-top: 0.5rem;
        }
        
        .requirement {
            display: flex;
            align-items: center;
            margin-bottom: 0.25rem;
        }
        
        .requirement i {
            margin-right: 0.5rem;
            font-size: 0.75rem;
        }
        
        .requirement.valid {
            color: var(--success-color);
        }
        
        .requirement.valid i {
            color: var(--success-color);
        }
    </style>
</head>
<body>
    <div class="password-card">
        <div class="card-header">
            <h4><i class="fas fa-key me-2"></i>Change Password</h4>
        </div>
        <div class="card-body">
            <form id="passwordForm" name="forget" method="post" action="">
                <div class="mb-4">
                    <label for="txtusername" class="form-label">Username</label>
                    <input type="text" class="form-control" id="txtusername" name="txtusername" 
                           value="<?php echo htmlspecialchars($_SESSION['username']); ?>" readonly>
                </div>
                
                <div class="mb-4">
                    <label for="txtcurrentpassword" class="form-label">Current Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="txtcurrentpassword" 
                               name="txtcurrentpassword" required>
                        <span class="input-group-text toggle-password" style="cursor: pointer;">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label for="txtnewpassword" class="form-label">New Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="txtnewpassword" 
                               name="txtnewpassword" required onkeyup="checkPasswordStrength()">
                        <span class="input-group-text toggle-password" style="cursor: pointer;">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                    <div class="password-strength">
                        <div class="strength-meter" id="passwordStrength"></div>
                    </div>
                    <div class="password-requirements">
                        <div class="requirement" id="lengthReq">
                            <i class="fas fa-circle"></i>
                            <span>At least 8 characters</span>
                        </div>
                        <div class="requirement" id="numberReq">
                            <i class="fas fa-circle"></i>
                            <span>Contains a number</span>
                        </div>
                        <div class="requirement" id="specialReq">
                            <i class="fas fa-circle"></i>
                            <span>Contains a special character</span>
                        </div>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label for="txtrenewpassword" class="form-label">Confirm New Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="txtrenewpassword" 
                               name="txtrenewpassword" required onblur="checkpwd()">
                        <span class="input-group-text toggle-password" style="cursor: pointer;">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                    <div class="invalid-feedback" id="passwordMatchFeedback">
                        Passwords do not match
                    </div>
                </div>
                
                <div class="d-flex justify-content-between mt-4">
                    <button type="reset" class="btn btn-danger btn-action">
                        <i class="fas fa-trash-alt me-1"></i> Clear
                    </button>
                    <button type="submit" class="btn btn-success btn-action" name="btnsubmit" id="btnsubmit">
                        <i class="fas fa-save me-1"></i> Update Password
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Toggle password visibility
        document.querySelectorAll('.toggle-password').forEach(function(element) {
            element.addEventListener('click', function() {
                const input = this.parentElement.querySelector('input');
                const icon = this.querySelector('i');
                
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });
        
        // Password match validation
        function checkpwd() {
            const newPwd = document.getElementById('txtnewpassword');
            const confirmPwd = document.getElementById('txtrenewpassword');
            const feedback = document.getElementById('passwordMatchFeedback');
            
            if (newPwd.value !== confirmPwd.value && confirmPwd.value !== '') {
                confirmPwd.classList.add('is-invalid');
                feedback.style.display = 'block';
            } else {
                confirmPwd.classList.remove('is-invalid');
                feedback.style.display = 'none';
            }
        }
        
        // Password strength meter
        function checkPasswordStrength() {
            const password = document.getElementById('txtnewpassword').value;
            const strengthMeter = document.getElementById('passwordStrength');
            const lengthReq = document.getElementById('lengthReq');
            const numberReq = document.getElementById('numberReq');
            const specialReq = document.getElementById('specialReq');
            
            let strength = 0;
            
            // Check length
            if (password.length >= 8) {
                strength += 1;
                lengthReq.classList.add('valid');
                lengthReq.querySelector('i').classList.remove('fa-circle');
                lengthReq.querySelector('i').classList.add('fa-check');
            } else {
                lengthReq.classList.remove('valid');
                lengthReq.querySelector('i').classList.remove('fa-check');
                lengthReq.querySelector('i').classList.add('fa-circle');
            }
            
            // Check for numbers
            if (/\d/.test(password)) {
                strength += 1;
                numberReq.classList.add('valid');
                numberReq.querySelector('i').classList.remove('fa-circle');
                numberReq.querySelector('i').classList.add('fa-check');
            } else {
                numberReq.classList.remove('valid');
                numberReq.querySelector('i').classList.remove('fa-check');
                numberReq.querySelector('i').classList.add('fa-circle');
            }
            
            // Check for special characters
            if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
                strength += 1;
                specialReq.classList.add('valid');
                specialReq.querySelector('i').classList.remove('fa-circle');
                specialReq.querySelector('i').classList.add('fa-check');
            } else {
                specialReq.classList.remove('valid');
                specialReq.querySelector('i').classList.remove('fa-check');
                specialReq.querySelector('i').classList.add('fa-circle');
            }
            
            // Update strength meter
            const strengthPercent = (strength / 3) * 100;
            strengthMeter.style.width = strengthPercent + '%';
            
            // Change color based on strength
            if (strengthPercent < 40) {
                strengthMeter.style.backgroundColor = '#dc3545'; // Red
            } else if (strengthPercent < 70) {
                strengthMeter.style.backgroundColor = '#fd7e14'; // Orange
            } else {
                strengthMeter.style.backgroundColor = '#28a745'; // Green
            }
        }
    </script>
</body>
</html>
<?php
} else {
    header("location:index.php");    
}
?>