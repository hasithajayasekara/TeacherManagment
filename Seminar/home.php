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
if($usertype == "zone" || $usertype == "clerk" || $usertype == "teach") {
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Seminar Management | Teacher Management System</title>
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
            --warning-color: #ffc107;
        }
        
        .seminar-card {
            border-radius: 10px;
            border: none;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .seminar-card .card-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 1.25rem 1.5rem;
            border-bottom: none;
        }
        
        .seminar-card .card-header h4 {
            margin: 0;
            display: flex;
            align-items: center;
        }
        
        .seminar-card .card-header h4 i {
            margin-right: 10px;
        }
        
        .btn-add-seminar {
            background-color: var(--success-color);
            border: none;
            padding: 0.5rem 1.25rem;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-add-seminar:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
        }
        
        #seminarTable th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            color: #6c757d;
            border-bottom-width: 2px;
        }
        
        #seminarTable tr:hover {
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
        
        .upcoming {
            background-color: rgba(40, 167, 69, 0.1);
            border-color: var(--success-color);
            color: var(--success-color);
        }
        
        .past {
            background-color: rgba(108, 117, 125, 0.1);
            border-color: #6c757d;
            color: #6c757d;
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
            background-color: rgba(255, 193, 7, 0.1);
            color: var(--warning-color);
        }
        
        .edit-btn:hover {
            background-color: var(--warning-color);
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
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="seminar-card">
            <div class="card-header">
                <h4><i class="fas fa-chalkboard-teacher me-2"></i>Seminar Management</h4>
            </div>
            <div class="card-body">
                <?php
                $sql3 = "SELECT * FROM seminar ORDER BY date DESC";
                $view = mysqli_query($connection,$sql3) or die("Error in sql3".mysqli_error($connection));
                
                $ida = base64_encode("add");
                if($usertype == "zone" || $usertype == "clerk") {
                    echo '<div class="d-flex justify-content-between align-items-center mb-4">
                            <a href="index.php?id='.$ida.'" class="btn btn-success btn-add-seminar">
                                <i class="fas fa-plus-circle me-2"></i>Add New Seminar
                            </a>
                          </div>';
                }
                ?>
                
                <div class="table-responsive">
                    <table class="table table-hover" id="seminarTable">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th width="15%">Date</th>
                                <th>Details</th>
                                <th width="12%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $x = 1;
                            while($viewarr = mysqli_fetch_assoc($view)) {
                                $seminarDate = new DateTime($viewarr["date"]);
                                $today = new DateTime();
                                $dateClass = ($seminarDate >= $today) ? 'upcoming' : 'past';
                                ?>
                                <tr>
                                    <td class="fw-bold"><?php echo $x; ?></td>
                                    <td>
                                        <span class="date-badge <?php echo $dateClass; ?>">
                                            <?php echo htmlspecialchars($seminarDate->format('Y-m-d')); ?>
                                        </span>
                                    </td>
                                    <td><?php echo htmlspecialchars($viewarr["details"]); ?></td>
                                    <td class="action-btns">
                                        <?php
                                        $idv = base64_encode("view");
                                        echo '<a href="index.php?id='.$idv.'&semid='.base64_encode($viewarr["seminarid"]).'" 
                                              class="action-btn view-btn" title="View Details">
                                                <i class="fas fa-eye"></i>
                                              </a>';
                                        
                                        if(($usertype == "zone" || $usertype == "clerk") && $seminarDate >= $today) {
                                            $ide = base64_encode("edit");
                                            echo '<a href="index.php?id='.$ide.'&semid='.base64_encode($viewarr["seminarid"]).'" 
                                                  class="action-btn edit-btn" title="Edit">
                                                    <i class="fas fa-pencil-alt"></i>
                                                  </a>';
                                            
                                            if($usertype == "zone") {
                                                $idd = base64_encode("delete");
                                                echo '<a onClick="return deletedata()" 
                                                      href="index.php?id='.$idd.'&semid='.base64_encode($viewarr["seminarid"]).'" 
                                                      class="action-btn delete-btn" title="Delete">
                                                        <i class="fas fa-trash-alt"></i>
                                                      </a>';
                                            }
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
            $('#seminarTable').DataTable({
                responsive: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search seminars...",
                    lengthMenu: "Show _MENU_ seminars per page",
                    info: "Showing _START_ to _END_ of _TOTAL_ seminars",
                    infoEmpty: "No seminars available",
                    infoFiltered: "(filtered from _MAX_ total seminars)",
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
                ],
                order: [[1, 'desc']] // Default sort by date descending
            });
            
            // Delete confirmation
            window.deletedata = function() {
                return confirm("Are you sure you want to delete this seminar?");
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