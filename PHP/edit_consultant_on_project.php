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
                    //edit_consultant_on_project.php
                    
                    //include database function library
                    require_once("../DAL/db_functions.php");
                    require_once("../BLL/validate_data.php");
                    
                    //declare
                    $STR_PERMANENT_CONSULTANT_ID = $_GET[ID];
                    
                    //assign
                    $strConsultantId = "";
                    $strProjectNumber = $_GET[PROJECT_NO];  //Collect PROJECT_NO from url on projectStaffing.php page PROJECT_NO=$arrRows[Project_No]
                    
                    $strAssignmentDate = ""; 
                    $strCompletionDate = "";
                    $strRole = "";
                    $strHoursWorked = "";
                    
                    //assign zero (false) to all
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
                                    
                    
                    //check if submit button (Update REcord) is pressed
                    if (isset($_POST["submit"]))
                    {
                        $strConsultantId = $_POST["consultantIds"];  //store the consultant id from select menu
                        $strProjectNumber = $_POST['strProjectNumber'];
                        $strRole = $_POST['roles'];		
					
						//get project name
						readQuery("d_project", array("Project_No"), array($strProjectNumber), array(true));
						
						while($arrRows = $stmt->fetch(PDO::FETCH_ASSOC))  //should be only one row
						{
							$strProjectName = htmlspecialchars($arrRows['Project_Name'], ENT_QUOTES);  
						}
                        
                        $STR_PERMANENT_CONSULTANT_ID = $_POST['originalConsultantId'];
                        
                        echo "<h1>Update record related to Project:</em></h1>";  //want it displayed above an eventual error msg
						echo "<h2>Project Name: <em>".$strProjectName."</em></h2><br/>";
						echo "<h2>Project Number: <em>".$strProjectNumber."</em></h2><br/>";
                                            
                        validateConsultantToProject(editrecord);  //function is in validate_data.php file
        
                        if ($booAssignConsultantToProjectOk)  //$booAssignConsultantToProjectOk is updated in validateConsultantToProject()
                        {
                            //Display success message if no errors occurred
                            echo "<p class='success'>Record was successfully updated</p><br/>";
                        }					
                    }
                    else  //else this is true: isset($_GET[ID]) 
                    {
                        //Collect ID from link on projectStaffing.php page ID=$arrRows[Consultant_Id]
                        $strConsultantId = $_GET[ID];					
                        $strRole = $_GET[ROLE];				
                                                
                        echo "<h1>Update record related to Project:</em></h1>";  //want it displayed above an eventual error msg
						echo "<h2>Project Name: <em>".$strProjectName."</em></h2><br/>";
						echo "<h2>Project Number: <em>".$strProjectNumber."</em></h2><br/>";        
                                        
						//get certain consultant on project, should be just one row
						readQuery("d_project_consultant", array("Consultant_Id", "Project_No"), array($strConsultantId, $strProjectNumber), array(true, true));  //in db_functions.php
        
                        // if there is a record continue
                        if ($numRecords == 0) 
                        {
                            echo "<span class='error'>Something went wrong!</span><br /><br />";
                        } 
                        else 
                        {
                            $arrRows = NULL;
                        
                            // Get first (and only result) from database
                            $arrRows = $stmt->fetch(PDO::FETCH_ASSOC);
                            
                            $strAssignmentDate = $arrRows['Date_Assigned']; 
                            $strCompletionDate = $arrRows['Date_Completed'];
                            $strHoursWorked = $arrRows['Hours_Worked'];			
                        }					
                    }						
                    
                    //get data to select menu for Consultant ID
					readQuery("d_consultant", NULL, NULL, NULL);
                    
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
                        echo "<form action='edit_consultant_on_project.php' method='post'>";
                        
                        echo "<div class='row'>";
                        
                        echo "<table id='dalton'>";
                        
                        echo "<tr><th>Consultant ID and Name *</th><td><select name='consultantIds'>";
                            
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
                                            
                        echo "</select></td>";			
                            
                        echo "</tr><tr><th>Assignment Date *</th><td><input type='date' name='strAssignmentDate' size='10' value='".htmlspecialchars($strAssignmentDate, ENT_QUOTES)."' /></td>";
                        if ($booAssignmentDate)
                            echo "<td class='validationError'>Please enter an Assignment Date! Format DD/MM/YYYYY</td>";
                            
                        echo "</tr><tr><th>Completion Date</th><td><input type='date' name='strCompletionDate' size='10' value='".htmlspecialchars($strCompletionDate, ENT_QUOTES)."' /></td>";
                        if ($booCompletionDate)
                            echo "<td class='validationError'>Please enter a Completion Date! Format DD/MM/YYYYY. Field is optional</td>";						
                            
                        
                        //build select menu for Roles		
                        echo "</tr><tr><th>Role *</th><td><select name='roles'>";
                        
                        $intCounter = 0;  //counter for while looop
                        
                        //populate select menu for Roles	
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
                            echo "<td class='validationError'>Please enter Hours worked (a number)! Optional</td>";						
                                
                        echo "</tr></table></div><br/>";
                        
                        echo '<div class="row">';	
                             
                        echo '<div class="col_2"><input class="button" type="submit" name="submit" value="Update record" />';					
                        echo '<input type="hidden" name="strProjectNumber" value="'.$strProjectNumber.'" />';					
                        echo '<input type="hidden" name="strProjectName" value="'.$strProjectName.'" />';					
                        echo '<input type="hidden" name="originalConsultantId" value="'.$STR_PERMANENT_CONSULTANT_ID.'" /></div>';
                        echo '<div><a href="projectStaffing.php" class="linkButton">Return to Projects~Consultants</a></div></div></form><br/>';  //link tag redirects back to projectStaffing.php page					
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