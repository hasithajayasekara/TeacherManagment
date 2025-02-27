<?php
$sqlschool="SELECT schoolid FROM school";
$resultschool=mysqli_query($connection,$sqlschool) or die("sql error in sqlschool");
$numschool=mysqli_num_rows($resultschool);

$sqlstafffemale="SELECT SID FROM school_staff WHERE Gender='Female'";
$resultstafffemale=mysqli_query($connection,$sqlstafffemale) or die("sql error in sqlstafffemale");
$numsstafffemale=mysqli_num_rows($resultstafffemale);

$sqlstaffmale="SELECT SID FROM school_staff WHERE Gender='Male'";
$resultstaffmale=mysqli_query($connection,$sqlstaffmale) or die("sql error in sqlstaffmale");
$numsstaffmale=mysqli_num_rows($resultstaffmale);

$totalstaff=$numsstafffemale+$numsstaffmale;

$sqlseminar="SELECT seminarid FROM seminar";
$resultseminar=mysqli_query($connection,$sqlseminar) or die("sql error in sqlseminar");
$numseminar=mysqli_num_rows($resultseminar);
?>
<!--BLOCK SECTION -->
                 <div class="row">
                    <div class="col-lg-12">
                        <div style="text-align: center;">
                           
                            <a class="quick-btn" href="#">
                                <i class="icon-check icon-2x"></i>
                                <span> Schools</span>
                                <span class="label label-danger"><?php echo $numschool; ?></span>
                            </a>

                            <a class="quick-btn" href="#">
                                <i class="icon-envelope icon-2x"></i>
                                <span>Male</span>
                                <span class="label label-success"><?php echo $numsstaffmale; ?></span>
                            </a>
                            <a class="quick-btn" href="#">
                                <i class="icon-signal icon-2x"></i>
                                <span>Female</span>
                                <span class="label label-warning"><?php echo $numsstafffemale; ?></span>
                            </a>
                            <a class="quick-btn" href="#">
                                <i class="icon-external-link icon-2x"></i>
                                <span>Total</span>
                                <span class="label btn-metis-2"><?php echo $totalstaff; ?></span>
                            </a>
                            <a class="quick-btn" href="#">
                                <i class="icon-lemon icon-2x"></i>
                                <span>Seminar</span>
                                <span class="label btn-metis-4"><?php echo $numseminar; ?></span>
                            </a>

                            
                            
                        </div>

                    </div>

                </div>
                  <!--END BLOCK SECTION -->
                <hr />
                   <!-- CHART & CHAT  SECTION -->
                 <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                News
                            </div>

                                                
			<div class="panel-body">
				<div class="panel panel-primary">
					<div class="panel-heading">
						Commencement of Work Year 2019
					</div>
					<div class="panel-body">
						The official ceremony of the Commencement of Work Year 2019 was held at 9.00 am at the Ministry of Education, Cultural Affairs, and Sports & Youth Affairs of the Northern Province under the auspices of the Mr.S.Sathiyaseelan, Secretary to the Ministry of Education. All the staff of the Ministry of Education, Department of Cultural Affairs and Zonal Education Office, Jaffna participated in this ceremony.

Secretary has hoisted the National Flag in the presence of the all the staff.  Staff from Jaffna Zonal Education Office were singing the National Anthem after hoisting the National Flag

After Observing two minutes silence to commemorate the war heroes and others who sacrificed their lives on behalf of the motherland, Administrative Officer of the Ministry of Education has read aloud the Oath of Public Servants.

Finally the Secretary Delivered a brief speech on the necessity of ensuring the prompt, honest and unwavering contribution of all members of the staff, in the effort of creating a better tomorrow with a new economic and social order for the benefit of all Sri Lankans, as the concluding event of the programme.
					</div>
				</div>
				<div class="panel panel-primary">
					<div class="panel-heading">
						Evolving Northern Education Data Management Practice
					</div>
					<div class="panel-body">
					Data and information are very vital factors of efficient education planning, development and management processes. The earlier practice of collecting data through printed forms had its drawbacks such as delays, data losses and time consuming processing methods. Therefore a standalone digital data base was designed and the data collection was administered through compact discs which were distributed among Education Zones to enter their raw data at their offices and return in a specified time interval. Even though this method was advantageous than the earlier methods it still had several shortfalls such as technical difficulties in handling, different approaches of raw data collection from schools and processing delays. Considering these challenges it was attempted to maintain an offline locally distributed data base in two locations to which the officials should physically travel and enter data. 
					</div>
				</div>
		</div>

                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12"> 
						<div class="panel panel-primary">
					<div class="panel-heading">
						Provincial Education Kandy 
					</div>
					<div class="panel-body">
					<iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d15829.877216097439!2d80.62816022705096!3d7.301052665688182!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1skandy+zone+office!5e0!3m2!1sen!2slk!4v1546883711502" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
					</div>
				</div>
					</div>                    
                </div>