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
    <title>School Staff Management | Teacher Management System</title>
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
        
        .btn-add-staff {
            background-color: var(--success-color);
            border: none;
            padding: 0.5rem 1.25rem;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-add-staff:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
        }
        
        #staffTable th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            color: #6c757d;
            border-bottom-width: 2px;
        }
        
        #staffTable tr:hover {
            background-color: rgba(52, 152, 219, 0.05);
        }
        
        .action-btns {
            white-space: nowrap;
        }
        
        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            margin: 0 3px;
            transition: all 0.3s;
        }
        
        .view-btn {
            background-color: rgba(23, 162, 184, 0.1);
            color: var(--info-color);
        }
        
        .view-btn:hover {
            background-color: var(--info-color);
            color: white;
        }
        
        .edit-btn {
            background-color: rgba(52, 152, 219, 0.1);
            color: var(--primary-color);
        }
        
        .edit-btn:hover {
            background-color: var(--primary-color);
            color: white;
        }
        
        .delete-btn {
            background-color: rgba(220, 53, 69, 0.1);
            color: var(--danger-color);
        }
        
        .delete-btn:hover {
            background-color: var(--danger-color);
            color: white;
        }
        
        .gender-icon {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 5px;
        }
        
        .male-icon {
            background-color: rgba(52, 152, 219, 0.1);
            color: var(--primary-color);
        }
        
        .female-icon {
            background-color: rgba(255, 192, 203, 0.3);
            color: #d63384;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="staff-card">
            <div class="card-header">
                <h4><i class="fas fa-chalkboard-teacher me-2"></i>School Staff Management</h4>
            </div>
            <div class="card-body">
                <?php
                $sql3 = "SELECT * FROM school_staff";
                $view = mysqli_query($connection, $sql3) or die("Error in sql3: " . mysqli_error($connection));
                
                $ida = base64_encode(string: "add");
                echo '<div class="d-flex justify-content-between align-items-center mb-4">
                        <a href="index.php?id='.$ida.'" class="btn btn-success btn-add-staff">
                            <i class="fas fa-user-plus me-2"></i>Add New Staff
                        </a>
                      </div>';
                ?>
                
                <div class="table-responsive">
                    <table class="table table-hover" id="staffTable">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th>Name</th>
                                <th>NIC Number</th>
                                <th>Address</th>
                                <th>School</th>
                                <th>Post</th>
                                <th width="12%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $x = 1;
                            while($viewarr = mysqli_fetch_assoc($view)) {
                                $sqlschool = "SELECT name FROM school WHERE schoolid = '" . mysqli_real_escape_string($connection, $viewarr['First_appoinment_school']) . "'";
                                $resultsch = mysqli_query($connection, $sqlschool) or die("SQL error in sqlschool: ".mysqli_error($connection));
                                $rowsch = mysqli_fetch_assoc($resultsch);
                                
                                $schoolName = $rowsch ? htmlspecialchars($rowsch["name"]) : "Unknown School";
                                ?>
                                <tr>
                                    <td class="fw-bold"><?php echo $x; ?></td>
                                    <td>
                                        <?php 
                                        $genderIcon = ($viewarr["Gender"] == "Male") ? 
                                            '<span class="gender-icon male-icon"><i class="fas fa-male"></i></span>' : 
                                            '<span class="gender-icon female-icon"><i class="fas fa-female"></i></span>';
                                        echo $genderIcon . htmlspecialchars($viewarr["Name"]); 
                                        ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($viewarr["NIC_number"]); ?></td>
                                    <td><?php echo htmlspecialchars($viewarr["Address"]); ?></td>
                                    <td><?php echo $schoolName; ?></td>
                                    <td><?php echo htmlspecialchars($viewarr["Post"]); ?></td>
                                    <td class="action-btns">
                                        <?php
                                        $idv = base64_encode("view");
                                        $ide = base64_encode("edit");
                                        $idd = base64_encode("delete");
                                        
                                        echo '<a href="index.php?id='.$idv.'&staffid='.base64_encode($viewarr["SID"]).'" 
                                              class="action-btn view-btn" title="View">
                                                <i class="fas fa-eye"></i>
                                              </a>';
                                        echo '<a href="index.php?id='.$ide.'&staffid='.base64_encode($viewarr["SID"]).'" 
                                              class="action-btn edit-btn" title="Edit">
                                                <i class="fas fa-pencil-alt"></i>
                                              </a>';
                                        if($usertype == "zone") {
                                            echo '<a onClick="return deletedata()" 
                                                  href="index.php?id='.$idd.'&staffid='.base64_encode($viewarr["SID"]).'" 
                                                  class="action-btn delete-btn" title="Delete">
                                                    <i class="fas fa-trash-alt"></i>
                                                  </a>';
                                        }
                                        ?>
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
            $('#staffTable').DataTable({
                responsive: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search staff...",
                    lengthMenu: "Show _MENU_ staff per page",
                    info: "Showing _START_ to _END_ of _TOTAL_ staff",
                    infoEmpty: "No staff available",
                    infoFiltered: "(filtered from _MAX_ total staff)",
                    paginate: {
                        first: "First",
                        last: "Last",
                        next: "Next",
                        previous: "Previous"
                    }
                },
                dom: '<"top"<"d-flex justify-content-between align-items-center"lf>>rt<"bottom"<"d-flex justify-content-between align-items-center"ip>><"clear">',
                pageLength: 10,
                lengthMenu: [5, 10, 25, 50, 100]
            });
            
            // Delete confirmation
            window.deletedata = function() {
                return confirm("Are you sure you want to delete this staff member?");
            };
        });
    </script>
</body>
</html>
<?php
} else {
    header("location:../index.php");
}
?>