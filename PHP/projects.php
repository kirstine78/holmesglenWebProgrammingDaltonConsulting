<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <!--
        Name:	Kirstine Brørup Nielsen
        ID:		100527988
        Date:	02.04.2016
        Web Programming - Assignment Part 2 - DALTON IT CONSULTING
    -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<!--link external stylesheets-->
<link rel="stylesheet" type="text/css" href="../CSS/grid.css"/>
<link rel="stylesheet" type="text/css" href="../CSS/style.css"/>
<link rel="icon" href="../ASSETS/logoDaltonTab.jpg"/>

<title>Dalton IT Consulting</title>
</head>

<body>

<div class="grid"><!--start grid-->

    <div class="mainROW">
        <header>
            <div class="row">
                <div class="col_1"></div>
                <div class="col_2">
                    <img src="../ASSETS/logoDaltonBanner.jpg" class="logo_image" alt="Logo" />
                </div>
                <div class="col_8">
                        <img src="../ASSETS/banner.jpg" class="banner_image" alt="Banner image" />
                </div>
                <div class="col_1"></div>
            </div>
        </header>
            
        
        <section>
            <div class="row">
                <div class="col_1 navbarBackground"></div>
                <div class="col_10 navbarBackground">
                    <div class="navBarMargin">
                        <ul>
                            <li class="col_2 "><center><a href="../index.html">Home</a></center></li>
                            <li class="col_2 "><center><a href="services.html">Services</a></center></li>
                            <li class="col_2 "><center><a href="consultants.php">Consultants</a></center></li>
                            <li class="col_2 "><center><a href="projects.php">Projects</a></center></li>
                            <li class="col_2 "><center><a href="projectStaffing.php">Projects~Consultants</a></center></li>
                            <li class="col_2 "><center><a href="contact.html">Contact Us</a></center></li>
                        </ul>
                    </div>
                </div>
                <div class="col_1 navbarBackground"></div>
            </div>
        
            <div class="row">
                <div class="col_1"></div>
                <div class="col_10">
                    <h1>Projects</h1>                
                    
                    <?php
                    // projects.php
                    
                    //include database function library
                    require_once("../DAL/db_functions.php");
                    
                    if ($_GET[SUCCESS_MESSAGE] == "deletedDone")
                        echo "<p class='success'>Record was successfully deleted</p><br/>";
						
                    if ($_GET[SUCCESS_MESSAGE] == "addDone")
                        echo "<p class='success'>Record was successfully added</p><br/>";
						
                    if ($_GET[SUCCESS_MESSAGE] == "editDone")
                        echo "<p class='success'>Record was successfully updated</p><br/>";
						
                    
                    //run query on Consultant table
                    readQuery("d_project", NULL, NULL, NULL);  //function is in db_functions.php file
                    
                    //if there are any Consultant details in the database then continue
                    if($numRecords === 0)
                    {
                        echo "<p>No Projects Found!</p><br/>";
                    }
                    else
                    {
                        $arrRows = NULL;
                        
                        //create Table and Headings
                        echo "<table id='dalton'>";
                        echo "<tr>";
                        echo "<th>Project Number</th>";
                        echo "<th>Project Name</th>";
                        echo "<th>Description</th>";
                        echo "<th>Project Manager</th>";
                        echo "<th>Start</th>";
                        echo "<th>Finish</th>";
                        echo "<th>Budget</th>";
                        echo "<th>Cost to date</th>";
                        echo "<th>Tracking Statement</th>";
                        echo "<th>Client No</th>";
                        echo "<th></th>";
                        echo "</tr>";
                        
                        //loop through Projects and add row to table for each record
                        while($arrRows = $stmt->fetch(PDO::FETCH_ASSOC))
                        {
							//htmlspecialchars to escape special characters
                            echo "<tr>";
                            echo "<td>".htmlspecialchars($arrRows['Project_No'], ENT_QUOTES)."</td>";
                            echo "<td>".htmlspecialchars($arrRows['Project_Name'], ENT_QUOTES)."</td>";
                            echo "<td>".htmlspecialchars($arrRows['Project_Description'], ENT_QUOTES)."</td>";
                            echo "<td>".htmlspecialchars($arrRows['Project_Manager'], ENT_QUOTES)."</td>";
                            echo "<td class='tdNoWrap'>".htmlspecialchars($arrRows['Start_Date'], ENT_QUOTES)."</td>";
                            echo "<td class='tdNoWrap'>".htmlspecialchars($arrRows['Finish_Date'], ENT_QUOTES)."</td>";
                            echo "<td>".htmlspecialchars($arrRows['Budget'], ENT_QUOTES)."</td>";
                            echo "<td>".htmlspecialchars($arrRows['Cost_To_Date'], ENT_QUOTES)."</td>";
                            echo "<td>".htmlspecialchars($arrRows['Tracking_Statement'], ENT_QUOTES)."</td>";
                            echo "<td>".htmlspecialchars($arrRows['Client_No'], ENT_QUOTES)."</td>";
                            
                            //add links with Project_No as value, to edit and delete page
                            echo "<td><a class='linkDisplay' href='edit_project.php?PROJECT_NUMBER=$arrRows[Project_No]'>Edit</a>";
                            echo "<br/><a class='linkDisplay' href='delete_project.php?TYPE=Project&amp;PROJECT_NUMBER=$arrRows[Project_No]&amp;PROJECT_NAME=$arrRows[Project_Name]'>Delete</a></td></tr>";		
                        }
                        echo "</table>";
                        echo "<br/>";
                    }
                    
                    echo '<div class="row">';		 
                    echo '<div><a href="add_project.php" class="linkButton">New Project</a></div>';
                    echo '</div>';
                    
                    if ($numRecords == 1)
                        echo "<br/><p>$numRecords record returned</p>";	
                    else
                        echo "<br/><p>$numRecords records returned</p>";	
                        
                    ?>                              
                    
                </div>
                <div class="col_1"></div>
            </div>
        </section>
	</div>    
    
    <footer>
    	<div class="row footerStyle">
        	<div class="col_1"></div>
            <div class="col_10">
                <div class="center">
                    <strong>Dalton IT Consulting</strong> ~ 101 Dalton Rd ~ Dalton 9999 ~ Australia
                    <br/>
                    Ph: +61 123 456 789 ~ Email: dalton@daltonitconsulting.com
                </div>
            </div>
            <div class="col_1"></div>
        </div>
    </footer>

</div><!--end grid-->

</body>
</html>


