<?php
$sql3 = "SELECT * FROM staffwork WHERE enddate='0000-00-00'";
$view = mysqli_query($connection,$sql3)or die("Error in sql3".mysqli_error($connection));
?>

<div class="section-card mb-4">
    <div class="card-header bg-primary text-white">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fas fa-exchange-alt me-2"></i>Transfer Notifications</h4>
            <span class="badge bg-light text-dark fs-6"><?php echo mysqli_num_rows($view); ?> Pending</span>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="transferTable">
                <thead class="table-light">
                    <tr>
                        <th width="5%">#</th>
                        <th>Teacher</th>
                        <th>Census ID</th>
                        <th>School Name</th>
                        <th>Work From</th>
                        <th>Years</th>
                        <th width="15%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $x = 1;
                    $ida = base64_encode("add");
                    $today = date("Y-m-d");
                    while($viewarr = mysqli_fetch_assoc($view)) {
                        $workstart = $viewarr["startdate"];
                        $diff = strtotime($today) - strtotime($workstart);
                        $diffyears = floor($diff / (365*60*60*24));
                        
                        if($diffyears >= 5) {
                            $sqlstaff = "SELECT Name FROM school_staff WHERE SID='$viewarr[staffid]'";
                            $resultstaff = mysqli_query($connection,$sqlstaff) or die("sql error in sqlstaff");
                            $rowstaff = mysqli_fetch_assoc($resultstaff);

                            $sqlschool = "SELECT censusid, name FROM school WHERE schoolid='$viewarr[schoolid]'";
                            $resultschool = mysqli_query($connection,$sqlschool) or die("sql error in sqlschool");
                            $rowschool = mysqli_fetch_assoc($resultschool);
                            ?>
                            <tr>
                                <td class="fw-bold"><?php echo $x; ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-light rounded-circle me-2 d-flex align-items-center justify-content-center">
                                            <i class="fas fa-user text-primary"></i>
                                        </div>
                                        <div><?php echo htmlspecialchars($rowstaff["Name"]); ?></div>
                                    </div>
                                </td>
                                <td><?php echo htmlspecialchars($rowschool["censusid"]); ?></td>
                                <td><?php echo htmlspecialchars($rowschool["name"]); ?></td>
                                <td>
                                    <span class="badge bg-light text-dark">
                                        <?php echo date("M d, Y", strtotime($viewarr["startdate"])); ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge <?php echo $diffyears >= 7 ? 'bg-danger' : 'bg-warning'; ?>">
                                        <?php echo $diffyears; ?> years
                                    </span>
                                </td>
                                <td>
                                    <a href="Transfer/index.php?id=<?php echo $ida; ?>&transtaffid=<?php echo base64_encode($viewarr["staffid"]); ?>" 
                                       class="btn btn-sm btn-primary d-flex align-items-center">
                                        <i class="fas fa-exchange-alt me-1"></i>
                                        <span>Transfer</span>
                                    </a>
                                </td>
                            </tr>
                            <?php
                            $x++;
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Include this in your head section if not already present -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    .section-card {
        border-radius: 10px;
        border: none;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }
    
    .section-card .card-header {
        background: linear-gradient(135deg, #3498db, #2c3e50);
        color: white;
        font-weight: 600;
        padding: 1rem 1.5rem;
        border-bottom: none;
    }
    
    .avatar-sm {
        width: 32px;
        height: 32px;
    }
    
    #transferTable th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        color: #6c757d;
    }
    
    #transferTable tr:hover {
        background-color: rgba(52, 152, 219, 0.05);
    }
    
    .badge {
        font-weight: 500;
        padding: 0.35em 0.65em;
    }
</style>

<!-- DataTables for enhanced table functionality -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        $('#transferTable').DataTable({
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search transfers...",
            },
            dom: '<"top"f>rt<"bottom"lip><"clear">',
            pageLength: 10
        });
    });
</script>