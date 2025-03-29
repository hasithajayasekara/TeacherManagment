<?php
$sqlschool = "SELECT schoolid FROM school";
$resultschool = mysqli_query($connection, $sqlschool) or die("SQL error in sqlschool");
$numschool = mysqli_num_rows($resultschool);

$sqlstafffemale = "SELECT SID FROM school_staff WHERE Gender='Female'";
$resultstafffemale = mysqli_query($connection, $sqlstafffemale) or die("SQL error in sqlstafffemale");
$numsstafffemale = mysqli_num_rows($resultstafffemale);

$sqlstaffmale = "SELECT SID FROM school_staff WHERE Gender='Male'";
$resultstaffmale = mysqli_query($connection, $sqlstaffmale) or die("SQL error in sqlstaffmale");
$numsstaffmale = mysqli_num_rows($resultstaffmale);

$totalstaff = $numsstafffemale + $numsstaffmale;

$sqlseminar = "SELECT seminarid FROM seminar";
$resultseminar = mysqli_query($connection, $sqlseminar) or die("SQL error in sqlseminar");
$numseminar = mysqli_num_rows($resultseminar);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Education Dashboard</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --accent-color: #e74c3c;
            --light-color: #ecf0f1;
            --dark-color: #2c3e50;
        }
        
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .dashboard-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
            border-radius: 0 0 10px 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .stat-card {
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            height: 100%;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        .stat-card .card-body {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        .stat-card .icon-wrapper {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            background-color: rgba(255, 255, 255, 0.2);
        }
        
        .stat-card .count {
            font-size: 2rem;
            font-weight: 700;
            margin: 0.5rem 0;
        }
        
        .stat-card .label {
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.8;
        }
        
        .section-card {
            border-radius: 10px;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            margin-bottom: 2rem;
            overflow: hidden;
        }
        
        .section-card .card-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            font-weight: 600;
            padding: 1rem 1.5rem;
            border-bottom: none;
        }
        
        .accordion-button:not(.collapsed) {
            background-color: rgba(52, 152, 219, 0.1);
            color: var(--primary-color);
        }
        
        .accordion-button:focus {
            box-shadow: none;
            border-color: rgba(52, 152, 219, 0.25);
        }
        
        .map-container {
            border-radius: 8px;
            overflow: hidden;
        }
        
        @media (max-width: 768px) {
            .stat-card {
                margin-bottom: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-header text-center">
        <div class="container">
            <h1 class="display-5 fw-bold">Education Management Dashboard</h1>
            <p class="lead">Comprehensive overview of schools, staff, and activities</p>
        </div>
    </div>

    <div class="container">
        <!-- Stats Section -->
        <div class="row g-4 mb-5">
            <div class="col-md-6 col-lg-3">
                <div class="stat-card bg-primary text-white">
                    <div class="card-body">
                        <div class="icon-wrapper">
                            <i class="fas fa-school fa-2x"></i>
                        </div>
                        <div class="count"><?php echo $numschool; ?></div>
                        <div class="label">Schools</div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-3">
                <div class="stat-card bg-success text-white">
                    <div class="card-body">
                        <div class="icon-wrapper">
                            <i class="fas fa-male fa-2x"></i>
                        </div>
                        <div class="count"><?php echo $numsstaffmale; ?></div>
                        <div class="label">Male Staff</div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-3">
                <div class="stat-card bg-warning text-white">
                    <div class="card-body">
                        <div class="icon-wrapper">
                            <i class="fas fa-female fa-2x"></i>
                        </div>
                        <div class="count"><?php echo $numsstafffemale; ?></div>
                        <div class="label">Female Staff</div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-3">
                <div class="stat-card bg-info text-white">
                    <div class="card-body">
                        <div class="icon-wrapper">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                        <div class="count"><?php echo $totalstaff; ?></div>
                        <div class="label">Total Staff</div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-3">
                <div class="stat-card bg-secondary text-white">
                    <div class="card-body">
                        <div class="icon-wrapper">
                            <i class="fas fa-chalkboard-teacher fa-2x"></i>
                        </div>
                        <div class="count"><?php echo $numseminar; ?></div>
                        <div class="label">Seminars</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- News and Map Section -->
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="section-card">
                    <div class="card-header">
                        <i class="fas fa-newspaper me-2"></i>Latest News & Announcements
                    </div>
                    <div class="card-body">
                        <div class="accordion" id="newsAccordion">
                            <div class="accordion-item border-0 mb-2">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button rounded" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true">
                                        <i class="fas fa-calendar-check me-2 text-primary"></i>Commencement of Work Year 2019
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#newsAccordion">
                                    <div class="accordion-body">
                                        <p>The official ceremony of the Commencement of Work Year 2019 was held at 9.00 am at the Ministry of Education. The event was attended by all regional directors and senior staff members.</p>
                                        <small class="text-muted">Posted on January 15, 2019</small>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item border-0 mb-2">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed rounded" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                        <i class="fas fa-database me-2 text-primary"></i>Evolving Northern Education Data Management Practice
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#newsAccordion">
                                    <div class="accordion-body">
                                        <p>Data and information are very vital factors of efficient education planning, development, and management. The new system will provide real-time analytics for better decision making.</p>
                                        <small class="text-muted">Posted on March 5, 2019</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="section-card">
                    <div class="card-header">
                        <i class="fas fa-map-marked-alt me-2"></i>Provincial Education Office Location
                    </div>
                    <div class="card-body p-0">
                        <div class="map-container">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d15829.877216097439!2d80.62816022705096!3d7.301052665688182!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1skandy+zone+office!5e0!3m2!1sen!2slk!4v1546883711502" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>