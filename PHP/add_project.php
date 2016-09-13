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
                    <h1>Add Project Details</h1>              
                    
                    <?php
                    //add_consultant.php
                    
                    //include database function library
                    require_once("../DAL/db_functions.php");
                    require_once("../BLL/validate_data.php");
                    
                    
                    //Declare Global Variables
                    
                    //assign "" to all
                    $strProjectNumber = ""; 
                    $strProjectName = "";  
                    $strProjectDescription = ""; 
                    $strProjectManager = ""; 
                    $strProjectStartDate = ""; 
                    $strProjectFinishDate = ""; 
                    $strProjectBudget = ""; 
                    $strProjectCostToDate = ""; 
                    $strProjectTrackingStatement = ""; 
                    $strProjectClientNumber = "";
                    
                    //assign zero (false) to all
                    $booProjectNumber = 0; 
                    $booProjectName = 0;  
                    $booProjectDescription = 0; 
                    $booProjectManager = 0; 
                    $booProjectStartDate = 0; 
                    $booProjectFinishDate = 0; 
                    $booProjectBudget = 0; 
                    $booProjectCostToDate = 0; 
                    $booProjectTrackingStatement = 0; 
                    $booProjectClientNumber = 0;
                    
                    $booProjectOk = 1;  //assign 1				
                    
                    //check if submit button is pressed
                    if (isset($_POST["submit"]))
                    {
                        validateProject(addrecord);  //function is in validate_data.php file				
            
                        if ($booProjectOk)		
                        {
                            //Redirect to the projects.php page if no errors occurred
                            header("Location: projects.php?SUCCESS_MESSAGE=addDone");
                        }					
                    }				
                    
                    echo "<p>* required field</p><br/>";
                    
                                    
                    //create table for Project and populate it with the data				
                    echo "<form action='add_project.php' method='post'>";
                    
                    echo "<div class='row'>";
                    
                    echo "<table id='dalton'>";
                    
                    echo "<tr><th>Project Number *</th><td><input type='text' name='strProjectNumber' maxlength='7' size='10' value='".htmlspecialchars($strProjectNumber, ENT_QUOTES)."' /></td>";
                    if ($booProjectNumber)
                        echo "<td class='validationError'>Please enter a Project Number. Exactly 7 characters (3 letters followed by 4 digits)!</td>";
					else
						echo "<td><em>example: ABC1234</em></td>";						
									
                    
					//htmlspecialchars to escape special characters    
                    echo "</tr><tr><th>Project Name *</th><td><input type='text' name='strProjectName' maxlength='50' size='38' value='".htmlspecialchars($strProjectName, ENT_QUOTES)."' /></td>";
                    if ($booProjectName)
                        echo "<td class='validationError'>Please enter a Project name (min 2 characters)!</td>";
					else
						echo "<td><em>min 2 characters</em></td>";	
                    
					//htmlspecialchars to escape special characters    
                    echo "</tr><tr><th>Description *</th><td><textarea cols='40' rows='5' name='strProjectDescription'>".htmlspecialchars($strProjectDescription, ENT_QUOTES)."</textarea></td>";
                    if ($booProjectDescription)
                        echo "<td class='validationError'>Please enter a Description (min 2 characters)!</td>";
					else
						echo "<td><em>min 2 characters</em></td>";	
                                            
                                
                    //get data to populate select menu for Project Manager: Foreign Key (Project_Manager) References D_Consultant (Consultant_Id)				
					readQuery("d_consultant", NULL, NULL, NULL);  //function is in db_functions.php	
                            
                    echo "</tr><tr><th>Project Manager *</th><td><select name='strProjectManager'>";
                    
                    if (isset($_POST["submit"]))
                    {
                        //populate select menu for Project Manager (Consultant ID)
                        while($arrRows = $stmt->fetch(PDO::FETCH_ASSOC))
                        {							
                            //decide which to be the selected='selected'
                            if ($strProjectManager == $arrRows['Consultant_Id'])
                            {
                                echo "<option value='".$arrRows['Consultant_Id']."' selected='selected'>".$arrRows['Consultant_Id']." ".htmlspecialchars($arrRows['First_Name'], ENT_QUOTES)." ".htmlspecialchars($arrRows['Last_Name'], ENT_QUOTES)."</option>";
                            }
                            else
                            {
                                echo "<option value='".$arrRows['Consultant_Id']."'>".$arrRows['Consultant_Id']." ".htmlspecialchars($arrRows['First_Name'], ENT_QUOTES)." ".htmlspecialchars($arrRows['Last_Name'], ENT_QUOTES)."</option>";
                            }
                        }
                    }
                    else  //don't set selected
                    {
                        //populate select menu for Project Manager (Consultant ID)
                        while($arrRows = $stmt->fetch(PDO::FETCH_ASSOC))
                        {
                            echo "<option value='".$arrRows['Consultant_Id']."'>".$arrRows['Consultant_Id']." ".htmlspecialchars($arrRows['First_Name'], ENT_QUOTES)." ".htmlspecialchars($arrRows['Last_Name'], ENT_QUOTES)."</option>";
                        }
                    }			
                                        
                    echo "</select></td>";					
                        
                    //htmlspecialchars to escape special characters
                    echo "</tr><tr><th>Start Date *</th><td><input type='date' name='strProjectStartDate' size='10' value='".htmlspecialchars($strProjectStartDate, ENT_QUOTES)."' /></td>";
                    if ($booProjectStartDate)
                        echo "<td class='validationError'>Please enter a valid Start Date! Format DD/MM/YYYYY</td>";

                    //htmlspecialchars to escape special characters
                    echo "</tr><tr><th>Finish Date</th><td><input type='date' name='strProjectFinishDate' size='10' value='".htmlspecialchars($strProjectFinishDate, ENT_QUOTES)."' /></td>";
                    if ($booProjectFinishDate)
                        echo "<td class='validationError'>Please enter a valid Finish Date! Format DD/MM/YYYYY. This field is optional</td>";
                    
					//htmlspecialchars to escape special characters    
                    echo "</tr><tr><th>Budget *</th><td><input type='text' name='strProjectBudget' size='10' value='".htmlspecialchars($strProjectBudget, ENT_QUOTES)."' /></td>";
                    if ($booProjectBudget)
                        echo "<td class='validationError'>Please enter a valid Budget (a number in digits)!</td>";
					else
						echo "<td><em>a number in digits</em></td>";
                    
					//htmlspecialchars to escape special characters    
                    echo "</tr><tr><th>Cost to Date</th><td><input type='text' name='strProjectCostToDate' size='10' value='".htmlspecialchars($strProjectCostToDate, ENT_QUOTES)."' /></td>";
                    if ($booProjectCostToDate)
                        echo "<td class='validationError'>Please enter valid Cost to Date (a number in digits)! This field is optional</td>";
					else
						echo "<td><em>Optional (a number in digits)</em></td>";
                    
					//htmlspecialchars to escape special characters    
                    echo "</tr><tr><th>Tracking Statement *</th><td><textarea cols='40' rows='5' name='strProjectTrackingStatement'>".htmlspecialchars($strProjectTrackingStatement, ENT_QUOTES)."</textarea></td>";
                    if ($booProjectTrackingStatement)
                        echo "<td class='validationError'>Please enter a Tracking Statement (min 2 characters)!</td>";	
					else
						echo "<td><em>min 2 characters</em></td>";			
                    
                                
                    //get data to populate select menu for Client Number: Foreign Key (Client_No) References D_Client (Client_No)
					readQuery("d_client", NULL, NULL, NULL);  //function is in db_functions.php
                            
                    echo "</tr><tr><th>Client Number *</th><td><select name='strProjectClientNumber'>";
                    
                    if (isset($_POST["submit"]))
                    {
                        //populate select menu for Client Number			
                        while($arrRows = $stmt->fetch(PDO::FETCH_ASSOC))
                        {							
                            //decide which to be the selected
                            if ($strProjectClientNumber == $arrRows['Client_No'])
                            {
                                echo "<option value='".$arrRows['Client_No']."' selected='selected'>".$arrRows['Client_No']."</option>";
                            }
                            else
                            {
                                echo "<option value='".$arrRows['Client_No']."'>".$arrRows['Client_No']."</option>";
                            }
                        }
                    }
                    else  //don't set selected
                    {
                        //populate select menu for Client Number				
                        while($arrRows = $stmt->fetch(PDO::FETCH_ASSOC))
                        {
                            echo "<option value='".$arrRows['Client_No']."'>".$arrRows['Client_No']."</option>";
                        }
                    }			
                                        
                    echo "</select></td>";
                        
                    echo "</tr></table></div><br/><input class='button' type='submit' name='submit' value='Submit New Details' /></form>";
                    
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