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
                    //delete_consultant.php
                    
                    require_once("../DAL/db_functions.php");
                    
                    echo "<h1>Are you sure you want to delete this record?</h1>";
					
                    //only proceed if "Cancel" button is pressed
                    if (isset($_POST["cancel"]))
                    {
                        //redirect to the consultants.php page
                        header("Location: consultants.php");	
                    }	
					else if (isset($_POST["okDelete"])) //only proceed to delete if "Yes Delete" button is pressed
                    {					
						echo "<h2>Consultant Name: <em>" . $_POST[CONSULTANT_FNAME] . " ". $_POST[CONSULTANT_LNAME]. "</em></h2><br/>";
						echo "<h2>Consultant ID: <em>" . $_POST[ID] . "</em></h2><br/><br/>";
						
						echo "<form action='delete_consultant.php' method='post'>";
							
						echo '<div class="row">';
						echo '<div class="col_2"><input class="button" type="submit" name="okDelete" value="Yes Delete"></div>';
						echo '<div class="col_10"><input class="button" type="submit" name="cancel" value="Cancel">';
						echo '<input type="hidden" name="ID" value=' . $_POST[ID] . '>';
						echo '<input type="hidden" name="CONSULTANT_FNAME" value="' . $_POST[CONSULTANT_FNAME] . '">';
						echo '<input type="hidden" name="CONSULTANT_LNAME" value="' . $_POST[CONSULTANT_LNAME] . '"></div>';
						echo '</div>';							
									
						echo "</form>";
														
						//make arrays						
						$whereColumnNamesArray = array("Consultant_Id");	//arr holds the column names 
						$whereColumnValuesArray = array($_POST[ID]);	 //get consultant id from hidden input							
						$whereColumnValuesQuotesArray = array(true);  //need quotes in sql statement
						
						
						//try to do the delete
						//function is in db_functions.php (returns boolean)
						$booDeleteDone = deleteRecord("d_consultant", $whereColumnNamesArray, $whereColumnValuesArray, $whereColumnValuesQuotesArray);  
						
						//check if the record has been deleted
                        if ($booDeleteDone)
                        {
                            //redirect to the consultants page if no errors occurred in deleteRecord()
                            header("Location: consultants.php?SUCCESS_MESSAGE=deletedDone");
                        }
					}
					else //or it comes from the consultants page
                    {					
						echo "<h2>Consultant Name: <em>" . $_GET[CONSULTANT_FNAME] . " ". $_GET[CONSULTANT_LNAME]. "</em></h2><br/>";
						echo "<h2>Consultant ID: <em>" . $_GET[ID] . "</em></h2><br/><br/>";
						
						echo "<form action='delete_consultant.php' method='post'>";
						
						echo '<div class="row">';
						echo '<div class="col_2"><input class="button" type="submit" name="okDelete" value="Yes Delete"></div>';
						echo '<div class="col_10"><input class="button" type="submit" name="cancel" value="Cancel">';
						echo '<input type="hidden" name="ID" value=' . $_GET[ID] . '>';
						echo '<input type="hidden" name="CONSULTANT_FNAME" value="' . $_GET[CONSULTANT_FNAME] . '">';
						echo '<input type="hidden" name="CONSULTANT_LNAME" value="' . $_GET[CONSULTANT_LNAME] . '"></div>';
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



