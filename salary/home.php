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
    <title>Salary Management | Teacher Management System</title>
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
            border-bottom: none;
        }
        
        .salary-card .card-header h4 {
            margin: 0;
            display: flex;
            align-items: center;
        }
        
        .salary-card .card-header h4 i {
            margin-right: 10px;
        }
        
        .btn-add-salary {
            background-color: var(--success-color);
            border: none;
            padding: 0.5rem 1.25rem;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-add-salary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
        }
        
        #salaryTable th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            color: #6c757d;
            border-bottom-width: 2px;
        }
        
        #salaryTable tr:hover {
            background-color: rgba(52, 152, 219, 0.05);
        }
        
        .month-badge {
            padding: 0.35em 0.65em;
            border-radius: 50px;
            font-weight: 500;
            text-transform: uppercase;
        }
        
        .year-badge {
            padding: 0.35em 0.65em;
            border-radius: 4px;
            font-weight: 500;
            background-color: #f8f9fa;
            color: var(--secondary-color);
            border: 1px solid #dee2e6;
        }
        
        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: rgba(23, 162, 184, 0.1);
            color: var(--info-color);
            transition: all 0.3s;
        }
        
        .action-btn:hover {
            background-color: var(--info-color);
            color: white;
            transform: scale(1.1);
        }
        
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            padding-top: 1rem !important;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="salary-card">
            <div class="card-header">
                <h4><i class="fas fa-money-bill-wave me-2"></i>Salary Management</h4>
            </div>
            <div class="card-body">
                <?php
                $sql3 = "SELECT DISTINCT year, month FROM salary";
                $view = mysqli_query($connection,$sql3) or die("Error in sql3".mysqli_error($connection));
                
                $ida = base64_encode("add");
                echo '<div class="d-flex justify-content-between align-items-center mb-4">
                        <a href="index.php?id='.$ida.'" class="btn btn-success btn-add-salary">
                            <i class="fas fa-plus-circle me-2"></i>Add New Salary Records
                        </a>
                      </div>';
                ?>
                
                <div class="table-responsive">
                    <table class="table table-hover" id="salaryTable">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th>Year</th>
                                <th>Month</th>
                                <th width="10%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $x = 1;
                            while($viewarr = mysqli_fetch_assoc($view)) {
                                // Convert month number to month name
                                $monthNumber = (int)$viewarr["month"];
                                $monthName = date("F", mktime(0, 0, 0, $monthNumber, 10));
                                ?>
                                <tr>
                                    <td class="fw-bold"><?php echo $x; ?></td>
                                    <td><span class="year-badge"><?php echo htmlspecialchars($viewarr["year"]); ?></span></td>
                                    <td><span class="month-badge bg-primary text-white"><?php echo $monthName; ?></span></td>
                                    <td>
                                        <?php
                                        $idv = base64_encode("view");
                                        echo '<a href="index.php?id='.$idv.'&year='.base64_encode($viewarr["year"]).'&month='.base64_encode($viewarr["month"]).'" 
                                              class="action-btn" title="View Salary Records">
                                                <i class="fas fa-eye"></i>
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
            $('#salaryTable').DataTable({
                responsive: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search salary records...",
                    lengthMenu: "Show _MENU_ records per page",
                    info: "Showing _START_ to _END_ of _TOTAL_ records",
                    infoEmpty: "No salary records available",
                    infoFiltered: "(filtered from _MAX_ total records)",
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
                columnDefs: [
                    { orderable: false, targets: [3] } // Disable sorting on actions column
                ]
            });
            
            // Delete confirmation
            window.deletedata = function() {
                return confirm("Are you sure you want to delete this salary record?");
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