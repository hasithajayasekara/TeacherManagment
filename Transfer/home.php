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
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Transfer Management | Teacher Management System</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --success-color: #28a745;
            --info-color: #17a2b8;
            --danger-color: #dc3545;
        }
        
        .transfer-card {
            border-radius: 10px;
            border: none;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .transfer-card .card-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 1.25rem 1.5rem;
            border-bottom: none;
        }
        
        .transfer-card .card-header h4 {
            margin: 0;
            display: flex;
            align-items: center;
        }
        
        .transfer-card .card-header h4 i {
            margin-right: 10px;
        }
        
        .btn-add-transfer {
            background-color: var(--success-color);
            border: none;
            padding: 0.5rem 1.25rem;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-add-transfer:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
        }
        
        #transferTable th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            color: #6c757d;
            border-bottom-width: 2px;
        }
        
        #transferTable tr:hover {
            background-color: rgba(52, 152, 219, 0.05);
        }
        
        .date-badge {
            padding: 0.5rem;
            border-radius: 6px;
            font-weight: 500;
            background-color: #f8f9fa;
            color: var(--secondary-color);
            border: 1px solid #dee2e6;
            min-width: 120px;
            display: inline-block;
            text-align: center;
        }
        
        .staff-name {
            font-weight: 500;
            color: var(--secondary-color);
        }
        
        .school-name {
            color: #495057;
        }
        
        .unknown-data {
            color: #6c757d;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="transfer-card">
            <div class="card-header">
                <h4><i class="fas fa-exchange-alt me-2"></i>Transfer Management</h4>
            </div>
            <div class="card-body">
                <?php
                $sql3 = "SELECT * FROM transfer";
                $view = mysqli_query($connection,$sql3);
                if(!$view) {
                    die("Error in SQL query: " . mysqli_error($connection));
                }
                
                $ida = base64_encode("add");
                echo '<div class="d-flex justify-content-between align-items-center mb-4">
                        <a href="index.php?id='.$ida.'" class="btn btn-success btn-add-transfer">
                            <i class="fas fa-plus-circle me-2"></i>Add New Transfer
                        </a>
                      </div>';
                ?>
                
                <div class="table-responsive">
                    <table class="table table-hover" id="transferTable">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th>Staff Name</th>
                                <th>School</th>
                                <th width="15%">Transfer Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $x = 1;
                            while($viewarr = mysqli_fetch_assoc($view)) {
                                // Initialize default values
                                $staffName = "Unknown Staff";
                                $schoolName = "Unknown School";
                                $transferDate = "Unknown Date";
                                
                                // Get staff name with error handling
                                if(!empty($viewarr['staffid'])) {
                                    $sqlstf = "SELECT Name FROM school_staff WHERE SID='".mysqli_real_escape_string($connection, $viewarr['staffid'])."'";
                                    $resultstf = mysqli_query($connection,$sqlstf);
                                    if($resultstf && mysqli_num_rows($resultstf) > 0) {
                                        $rowstf = mysqli_fetch_assoc($resultstf);
                                        $staffName = !empty($rowstf["Name"]) ? htmlspecialchars($rowstf["Name"]) : $staffName;
                                    }
                                }
                                
                                // Get school name with error handling
                                if(!empty($viewarr['schoolid'])) {
                                    $sqlschool = "SELECT name FROM school WHERE schoolid='".mysqli_real_escape_string($connection, $viewarr['schoolid'])."'";
                                    $resultsch = mysqli_query($connection,$sqlschool);
                                    if($resultsch && mysqli_num_rows($resultsch) > 0) {
                                        $rowsch = mysqli_fetch_assoc($resultsch);
                                        $schoolName = !empty($rowsch["name"]) ? htmlspecialchars($rowsch["name"]) : $schoolName;
                                    }
                                }
                                
                                // Format transfer date
                                if(!empty($viewarr["transferdate"])) {
                                    $date = strtotime($viewarr["transferdate"]);
                                    $transferDate = $date ? htmlspecialchars(date('Y-m-d', $date)) : $transferDate;
                                }
                                ?>
                                <tr>
                                    <td class="fw-bold"><?php echo $x; ?></td>
                                    <td class="<?php echo ($staffName == "Unknown Staff") ? 'unknown-data' : 'staff-name'; ?>">
                                        <?php echo $staffName; ?>
                                    </td>
                                    <td class="<?php echo ($schoolName == "Unknown School") ? 'unknown-data' : 'school-name'; ?>">
                                        <?php echo $schoolName; ?>
                                    </td>
                                    <td>
                                        <span class="date-badge">
                                            <?php echo $transferDate; ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php
                                $x++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    
    <script>
        $(document).ready(function() {
            $('#transferTable').DataTable({
                responsive: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search transfers...",
                    lengthMenu: "Show _MENU_ transfers per page",
                    info: "Showing _START_ to _END_ of _TOTAL_ transfers",
                    infoEmpty: "No transfers available",
                    infoFiltered: "(filtered from _MAX_ total transfers)",
                    paginate: {
                        first: "First",
                        last: "Last",
                        next: "Next",
                        previous: "Previous"
                    }
                },
                dom: '<"top"<"d-flex justify-content-between align-items-center"lf>>rt<"bottom"<"d-flex justify-content-between align-items-center"ip>><"clear">',
                pageLength: 10,
                lengthMenu: [5, 10, 25, 50, 100],
                order: [[3, 'desc']] // Default sort by transfer date descending
            });
        });
    </script>
</body>
</html>
<?php
} else {
    header("location:../index.php");
}
?>