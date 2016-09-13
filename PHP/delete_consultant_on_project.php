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
                    //delete_consultant_on_project.php
                    
                    require_once("../DAL/db_functions.php");
                    
                        
                    //only proceed if "Cancel" button is pressed
                    if (isset($_POST["cancel"]))
                    {
                        //redirect to the projectStaffing.php page
                        header("Location: projectStaffing.php");	
                    }
                    else if (isset($_POST["okDelete"])) //only proceed to delete if "Yes Delete" button is pressed
                    {					
						//get project name
						readQuery("d_project", array("Project_No"), array($_POST[PROJECT_NO]), array(true));  //in db_functions.php
						
						while($arrRows = $stmt->fetch(PDO::FETCH_ASSOC))  //should be only one row
						{
							$strProjectName = htmlspecialchars($arrRows['Project_Name'], ENT_QUOTES);  
						}
						
						//get consultant name
						readQuery("d_consultant", array("Consultant_Id"), array($_POST[ID]), array(true));  //in db_functions.php						
						
						while($arrRows = $stmt->fetch(PDO::FETCH_ASSOC))  //should be only one row
						{
							$strConsultantFirstname = htmlspecialchars($arrRows['First_Name'], ENT_QUOTES);  
							$strConsultantLastname = htmlspecialchars($arrRows['Last_Name'], ENT_QUOTES);
						}
						
						echo "<h1>Are you sure you want to delete this record?</h1>";
						echo "<h2>Consultant Name: <em>" . $strConsultantFirstname . " " . $strConsultantLastname . " </em> </h2><br/>";					
						echo "<h2>Consultant Id: <em>" . $_POST[ID] . " </em> </h2><br/>";
						echo "<p>assigned to</p><br/>";
						echo "<h2>Project Name: <em>" . $strProjectName . "</em></h2><br/>";
						echo "<h2>Project Number: <em>" . $_POST[PROJECT_NO] . "</em></h2><br/><br/>";
						
						echo "<form action='delete_consultant_on_project.php' method='post'>";
						
						echo '<div class="row">';
						echo '<div class="col_2"><input class="button" type="submit" name="okDelete" value="Yes Delete"></div>';
						echo '<div class="col_10"><input class="button" type="submit" name="cancel" value="Cancel"></div>';
						echo '<input type="hidden" name="ID" value=' . $_POST[ID] . '>';
						echo '<input type="hidden" name="PROJECT_NO" value=' . $_POST[PROJECT_NO] . '>';
						echo '</div>';							
									
						echo "</form>";	
														
						//make arrays
						$whereColumnNamesArray = array("Consultant_Id", "Project_No");	 //arr holds the column names 
						$whereColumnValuesArray = array($_POST[ID], $_POST[PROJECT_NO]);	//get consultant id and project number from hidden input			
						$whereColumnValuesQuotesArray = array(true, true);  //need quotes in sql statement
	
						//try to do the delete	
                        $booDeleteDone = deleteRecord("d_project_consultant", $whereColumnNamesArray, $whereColumnValuesArray, $whereColumnValuesQuotesArray);  //function is in db_functions.php (returns boolean)
                        
                        //check if the record has been deleted
                        if ($booDeleteDone)
                        {						
                            //redirect to the projectStaffing page if no errors occurred in deleteRecord()
                            header("Location: projectStaffing.php?SUCCESS_MESSAGE=deletedDone");
                        }
					}
					else //or it comes from the projectStaffing page
					{
						//get project name
						readQuery("d_project", array("Project_No"), array($_GET[PROJECT_NO]), array(true));  //in db_functions.php
						
						while($arrRows = $stmt->fetch(PDO::FETCH_ASSOC))  //should be only one row
						{
							$strProjectName = htmlspecialchars($arrRows['Project_Name'], ENT_QUOTES);  
						}
						
						//get consultant name
						readQuery("d_consultant", array("Consultant_Id"), array($_GET[ID]), array(true));  //in db_functions.php
						
						
						while($arrRows = $stmt->fetch(PDO::FETCH_ASSOC))  //should be only one row
						{
							$strConsultantFirstname = htmlspecialchars($arrRows['First_Name'], ENT_QUOTES);  
							$strConsultantLastname = htmlspecialchars($arrRows['Last_Name'], ENT_QUOTES);
						}
						
						echo "<h1>Are you sure you want to delete this record?</h1>";
						echo "<h2>Consultant Name: <em>" . $strConsultantFirstname . " " . $strConsultantLastname . " </em> </h2><br/>";					
						echo "<h2>Consultant Id: <em>" . $_GET[ID] . " </em> </h2><br/>";
						echo "<p>assigned to</p><br/>";
						echo "<h2>Project Name: <em>" . $strProjectName . "</em></h2><br/>";
						echo "<h2>Project Number: <em>" . $_GET[PROJECT_NO] . "</em></h2><br/><br/>";
						
						echo "<form action='delete_consultant_on_project.php' method='post'>";
						
						echo '<div class="row">';
						echo '<div class="col_2"><input class="button" type="submit" name="okDelete" value="Yes Delete"></div>';
						echo '<div class="col_10"><input class="button" type="submit" name="cancel" value="Cancel"></div>';
						echo '<input type="hidden" name="ID" value=' . $_GET[ID] . '>';
						echo '<input type="hidden" name="PROJECT_NO" value=' . $_GET[PROJECT_NO] . '>';
						echo '</div>';							
									
						echo "</form>";	
						
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



