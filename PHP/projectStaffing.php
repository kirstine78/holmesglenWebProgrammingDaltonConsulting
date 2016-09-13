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
                    <h1>Projects and assigned Consultants</h1>
                    
                    
                    <?php
                    // projectStaffing.php
                    
                    //include database function library
                    require_once("../DAL/db_functions.php");
                    
                    if ($_GET[SUCCESS_MESSAGE] == "deletedDone")
                        echo "<p class='success'>Record was successfully deleted</p><br/>";
                    
                    //run query on Project table
                    readQuery("d_project", NULL, NULL, NULL);  //function is in db_functions.php file
                    
                    $strProjectNumber = $_GET["projects"];
                    
                    //check if there are any Projects
                    if($numRecords === 0)
                    {
                        //show nothing but 
                        echo "<p>No Projects Found!</p>";
                    }
                    else  //at least one project
                    {					
                        echo "<form action='projectStaffing.php' method='get' class='preserveWhite'>";
                                            
                        //build the drop down menu for Projects
                        echo "<strong id='projectStaffingSelMenu'>Show Consultants assigned to Project:</strong>     <select name='projects'>";
                        
                        //only if 'Show assigned Consultants' button has been pressed
                        if (isset($_GET["showAssignedConsultants"]))
                        {
                            echo "<option value=''>-- Select --</option>";
                            
                            while($arrRows = $stmt->fetch(PDO::FETCH_ASSOC))
                            {
                                //decide which to be the selected
                                if ($strProjectNumber == $arrRows['Project_No'])
                                {
                                    echo "<option value='".htmlspecialchars($arrRows['Project_No'], ENT_QUOTES)."' selected='selected'>".htmlspecialchars($arrRows['Project_No'], ENT_QUOTES). " ". htmlspecialchars($arrRows['Project_Name'], ENT_QUOTES) ."</option>";
                                }
                                else
                                {
                                    echo "<option value='".htmlspecialchars($arrRows['Project_No'], ENT_QUOTES)."'>".htmlspecialchars($arrRows['Project_No'], ENT_QUOTES). " ". htmlspecialchars($arrRows['Project_Name'], ENT_QUOTES) ."</option>";
                                }
                            }
                            echo "</select>         <input class='button' type='submit' name='showAssignedConsultants' value='Show assigned Consultants'><br/><br/>";		
                        }
                        else
                        {
                            echo "<option value='' selected='selected'>-- Select --</option>";
                            while($arrRows = $stmt->fetch(PDO::FETCH_ASSOC))
                            {
                                echo "<option value='".htmlspecialchars($arrRows['Project_No'], ENT_QUOTES)."'>".htmlspecialchars($arrRows['Project_No'], ENT_QUOTES). " ". htmlspecialchars($arrRows['Project_Name'], ENT_QUOTES) ."</option>";
                            }	
                            echo "</select>         <input class='button' type='submit' name='showAssignedConsultants' value='Show assigned Consultants'>";					
                        }
                        
                                
                        echo "</form>";					
                    }
                        
                    //only proceed if "Show assigned Consultants" button is pressed
                    if (isset($_GET["showAssignedConsultants"]))
                    {				
                        $strProjectNumber = $_GET["projects"];
                        
                        if ($strProjectNumber == "")
                        {
                            //don't try to communicate with db
                            echo "<p class='error'>Please select a Project from the list!</p>";
                        }
                        else
                        {					
                            //get all records from project_consultant that match projectnumber
							readQuery("d_project_consultant", array("Project_No"), array($strProjectNumber), array(true));  //in db_functions.php
                            
                            //if there are any project_consultant matching details in the database then continue
                            if($numRecords === 0)
                            {
                                echo "<p class='error'>There are currently no Consultants assigned to this Project!</p><br/><br/><br/>";
                            }
                            else  //one or more
                            {
                                $arrRows = NULL;
                                
                                //create Table and Headings
                                echo "<table id='dalton'>";
                                echo "<tr>";
                                echo "<th>Consultant ID</th>";
                                echo "<th>Project Number</th>";
                                echo "<th>Assignment Date</th>";
                                echo "<th>Completion Date</th>";
                                echo "<th>Role</th>";
                                echo "<th>Hours</th>";
                                echo "<th></th>";
                                echo "</tr>";
                            
                                //loop through Consultants and add row to table for each record
                                while($arrRows = $stmt->fetch(PDO::FETCH_ASSOC))
                                {
									//use htmlspecialchars to escape special characters
                                    echo "<tr>";
                                    echo "<td>".htmlspecialchars($arrRows['Consultant_Id'], ENT_QUOTES)."</td>";
                                    echo "<td>".htmlspecialchars($arrRows['Project_No'], ENT_QUOTES)."</td>";
                                    echo "<td class='tdNoWrap'>".htmlspecialchars($arrRows['Date_Assigned'], ENT_QUOTES)."</td>";
                                    echo "<td class='tdNoWrap'>".htmlspecialchars($arrRows['Date_Completed'], ENT_QUOTES)."</td>";
                                    echo "<td>".htmlspecialchars($arrRows['Role'], ENT_QUOTES)."</td>";
                                    echo "<td>".htmlspecialchars($arrRows['Hours_Worked'], ENT_QUOTES)."</td>";
                                    
                                    //add links with Consultant_Id and Project_No as values, to edit and delete page
                                    echo "<td><a class='linkDisplay' href='edit_consultant_on_project.php?ID=$arrRows[Consultant_Id]&amp;PROJECT_NO=$arrRows[Project_No]&amp;ROLE=$arrRows[Role]'>Edit</a><br/>";
                                    echo "<a class='linkDisplay' href='delete_consultant_on_project.php?TYPE=Consultant_ON_PROJECT&amp;ID=$arrRows[Consultant_Id]&amp;PROJECT_NO=$arrRows[Project_No]'>Delete</a>";
                                    echo "</td></tr>";
                                }
								
                                echo "</table>";
                                echo "<br/>";
                            }
                            
                            //need to pass the project number
                            echo '<form action="assign_consultant_to_project.php" method="post">';
                            echo '<input class="button" type="submit" name="submit New Consultant to Project" value="Assign New Consultant to Project">';
                            echo '<input type="hidden" name="strProjectNumber" value="'.$strProjectNumber.'">';
                            echo "</form>";
                            
                            if ($numRecords > 0)
                            {
                                if ($numRecords == 1)
								{
                                    echo "<br/><p>$numRecords record returned</p>";	
								}
                                else
								{
                                    echo "<br/><p>$numRecords records returned</p>";
								}
                            }
                        }					
                    }  //end of: "only proceed if 'Show assigned Consultants' button is pressed part"
                        
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


