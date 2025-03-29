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
    <title>School Management | Teacher Management System</title>
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
            --danger-color: #dc3545;
        }
        
        .school-card {
            border-radius: 10px;
            border: none;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .school-card .card-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 1.25rem 1.5rem;
            border-bottom: none;
        }
        
        .school-card .card-header h4 {
            margin: 0;
            display: flex;
            align-items: center;
        }
        
        .school-card .card-header h4 i {
            margin-right: 10px;
        }
        
        .btn-add-school {
            background-color: var(--success-color);
            border: none;
            padding: 0.5rem 1.25rem;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-add-school:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
        }
        
        #schoolsTable th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            color: #6c757d;
            border-bottom-width: 2px;
        }
        
        #schoolsTable tr:hover {
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
        
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            padding-top: 1rem !important;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="school-card">
            <div class="card-header">
                <h4><i class="fas fa-school me-2"></i>School Management</h4>
            </div>
            <div class="card-body">
                <?php
                $sql3 = "SELECT * FROM school";
                $view = mysqli_query($connection,$sql3) or die("Error in sql3".mysqli_error($connection));
                
                $ida = base64_encode("add");
                echo '<div class="d-flex justify-content-between align-items-center mb-4">
                        <a href="index.php?id='.$ida.'" class="btn btn-success btn-add-school">
                            <i class="fas fa-plus-circle me-2"></i>Add New School
                        </a>
                      </div>';
                ?>
                
                <div class="table-responsive">
                    <table class="table table-hover" id="schoolsTable">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th>Census ID</th>
                                <th>School Name</th>
                                <th>Address</th>
                                <th>Telephone</th>
                                <th>Zone</th>
                                <th width="10%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $x = 1;
                            while($viewarr = mysqli_fetch_assoc($view)) {
                                $sqlzone = "SELECT zonename FROM zone WHERE zoneid='$viewarr[zoneid]'";
                                $resultzone = mysqli_query($connection,$sqlzone) or die("sql error in sqlzone ".mysqli_error($connection));
                                $rowzone = mysqli_fetch_assoc($resultzone);
                                ?>
                                <tr>
                                    <td class="fw-bold"><?php echo $x; ?></td>
                                    <td><?php echo htmlspecialchars($viewarr["censusid"]); ?></td>
                                    <td><?php echo htmlspecialchars($viewarr["name"]); ?></td>
                                    <td><?php echo htmlspecialchars($viewarr["address"]); ?></td>
                                    <td><?php echo htmlspecialchars($viewarr["tpnum"]); ?></td>
                                    <td><?php echo htmlspecialchars($rowzone["zonename"]); ?></td>
                                    <td class="action-btns">
                                        <?php
                                        $ide = base64_encode("edit");
                                        $idd = base64_encode("delete");
                                        echo '<a href="index.php?id='.$ide.'&schid='.base64_encode($viewarr["schoolid"]).'" 
                                              class="action-btn edit-btn" title="Edit">
                                                <i class="fas fa-pencil-alt"></i>
                                              </a>';
                                        echo '<a onClick="return deletedata()" 
                                              href="index.php?id='.$idd.'&schid='.base64_encode($viewarr["schoolid"]).'" 
                                              class="action-btn delete-btn" title="Delete">
                                                <i class="fas fa-trash-alt"></i>
                                              </a>';
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
            $('#schoolsTable').DataTable({
                responsive: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search schools...",
                    lengthMenu: "Show _MENU_ schools per page",
                    info: "Showing _START_ to _END_ of _TOTAL_ schools",
                    infoEmpty: "No schools available",
                    infoFiltered: "(filtered from _MAX_ total schools)",
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
                return confirm("Are you sure you want to delete this school?");
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