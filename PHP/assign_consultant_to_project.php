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
                    
                    <?php
                    //assign_consultant_to_project.php
                    
                    //include database function library
                    require_once("../DAL/db_functions.php");
                    require_once("../BLL/validate_data.php");
					
                    
                    //Declare Global Variables
                    
                    //assign
                    $strConsultantId = "";
                    $strProjectNumber = $_POST["strProjectNumber"];  //from FORM DATA strProjectNumber:EMS6219 (example)
					
                    $strAssignmentDate = ""; 
                    $strCompletionDate = "";
                    $strRole = "";
                    $strHoursWorked = "";
                    
                    //assign zero (false) to all
                    $booProjectNumber = 0;
                    $booAssignmentDate = 0;  
                    $booCompletionDate = 0;
                    $booHoursWorked = 0;					
					
					
					//get project name
					readQuery("d_project", array("Project_No"), array($strProjectNumber), array(true));
					
					while($arrRows = $stmt->fetch(PDO::FETCH_ASSOC))  //should be only one row
                    {
                    	$strProjectName = htmlspecialchars($arrRows['Project_Name'], ENT_QUOTES);  
					}
                    
                    $booAssignConsultantToProjectOk = 1;  //assign 1
                    
                    //array to hold all the roles
                    $arrRoleList = array("Analyst", "Database Administrator", "Database Designer","Designer", "Hardware", "Lead", "Network Engineer", "Networker", "Programmer", "Project Manager", "Software Architect", "Solo", "Tester");
					
                    $intLengthRoleList = count($arrRoleList);
                    
                    echo "<h1>Assign Consultant to Project:</h1>";
                    echo "<h2>Project Name: <em>".$strProjectName."</em></h2><br/>";
                    echo "<h2>Project Number: <em>".$strProjectNumber."</em></h2><br/>";
                    
                    
                    //check if 'Submit Details' button on this page is pressed
                    if (isset($_POST["submit"]))
                    {
                        $strConsultantId = $_POST["consultantIds"];  //store the consultant id from select menu
                        $strRole = $_POST["roles"];  //store the role from select menu
                        
                        validateConsultantToProject(addrecord);  //function is in validate_data.php file
                    
                        if ($booAssignConsultantToProjectOk)		
                        {
                            //Display success message if no errors occurred
                            echo "<p class='success'>Consultant was successfully assigned to Project</p><br/>";
                        }
                    }				
                    
                    //get data to select menu for Consultant ID
					readQuery("d_consultant", NULL, NULL, NULL);  //function is in db_functions.php
                    
                    //check if there are any Consultants
                    if($numRecords === 0)
                    {
                        //show nothing but 
                        echo "<p>No Consultants Found!</p>";
                    }
                    else  //at least one Consultant
                    {
                        echo "<p>* required field</p><br/>";
                        
                        //create table for Project - Consultant and populate it with the data
                        echo "<form action='assign_consultant_to_project.php' method='post'>";
                        
                        echo "<div class='row'>";
                        
                        echo "<table id='dalton'>";
                        
                        echo "<tr><th>Consultant ID and Name *</th><td><select name='consultantIds'>";
                        
                        //select menu for Consultant ID		
                        if (isset($_POST["submit"]))
                        {
                            //populate select menu for Consultant ID				
                            while($arrRows = $stmt->fetch(PDO::FETCH_ASSOC))
                            {							
                                //decide which to be the selected
                                if ($strConsultantId == $arrRows['Consultant_Id'])
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
                            //populate select menu for Consultant ID				
                            while($arrRows = $stmt->fetch(PDO::FETCH_ASSOC))
                            {
                                echo "<option value='".$arrRows['Consultant_Id']."'>".$arrRows['Consultant_Id']." ".htmlspecialchars($arrRows['First_Name'], ENT_QUOTES)." ".htmlspecialchars($arrRows['Last_Name'], ENT_QUOTES)."</option>";
                            }
                        }			
                                            
                        echo "</select></td>";						
                            
                            
                        echo "</tr><tr><th>Assignment Date *</th><td><input type='date' name='strAssignmentDate' size='10' value='".htmlspecialchars($strAssignmentDate, ENT_QUOTES)."' /></td>";
                        if ($booAssignmentDate)
                            echo "<td class='validationError'>Please enter an Assignment Date! Format DD/MM/YYYYY</td>";
                            
                        echo "</tr><tr><th>Completion Date</th><td><input type='date' name='strCompletionDate' size='10' value='".htmlspecialchars($strCompletionDate, ENT_QUOTES)."' /></td>";
                        if ($booCompletionDate)
                            echo "<td class='validationError'>Please enter a Completion Date! Format DD/MM/YYYYY. Field is optional</td>";						
                            
                        //build select menu Role
                        echo "</tr><tr><th>Role *</th><td><select name='roles'>";
                        
                        $intCounter = 0;  //counter for while looop
                        
                        //build select menu for Roles
                        while($intCounter < $intLengthRoleList)
                        {	
                            if($arrRoleList[$intCounter] == $strRole)
                            {
                                echo "<option value='".$arrRoleList[$intCounter]."' selected='selected'>".$arrRoleList[$intCounter]."</option>";
                            }
                            else
                            {
                                echo "<option value='".$arrRoleList[$intCounter]."'>".$arrRoleList[$intCounter]."</option>";
                            }
                            
                            $intCounter += 1;
                        }
                        
                        echo "</select></td>";					
                            
                        echo "</tr><tr><th>Hours worked</th><td><input type='text' name='strHoursWorked' maxlength='15' size='10' value='".htmlspecialchars($strHoursWorked, ENT_QUOTES)."' /></td>";
                        if ($booHoursWorked)
                            echo "<td class='validationError'>Please enter Hours worked (a number)! Optional field</td>";
						else
							echo "<td><em>Optional (a number)</em></td>";
                            	
                        echo "</tr></table></div><br/>";
                        
                        echo '<div class="row">';                         
                        echo '<div class="col_2"><input class="button" type="submit" name="submit" value="Submit Details" />';					
                        echo '<input type="hidden" name="strProjectNumber" value="'.$strProjectNumber.'" /></div>';
                        echo '<div><a href="projectStaffing.php" class="linkButton">Return to Projects~Consultants</a></div></div></form>';  //link tag redirects back to projectStaffing.php page
                        
                    }
                    
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