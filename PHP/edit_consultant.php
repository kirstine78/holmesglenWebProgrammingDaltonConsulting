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
                    <h1>Edit Consultant Details</h1>
                    <?php
                    //edit_consultant.php
                    
                    //include database function library
                    require_once("../DAL/db_functions.php");
                    require_once("../BLL/validate_data.php");								
                    
                    //assign "" to all
                    $strConsultantId = ""; 
                    $strConsultantFirstname = "";  
                    $strConsultantLastname = ""; 
                    $strConsultantPhone = ""; 
                    $strConsultantMobile = ""; 
                    $strConsultantEmail = ""; 
                    $strConsultantCommenceDate = ""; 
                    $strConsultantDOB = ""; 
                    $strConsultantStreetAddress = ""; 
                    $strConsultantSuburb = ""; 
                    $strConsultantPostcode = ""; 
                    
                    //assign zero (false) to all
                    $booConsultantId = 0; 
                    $booConsultantFirstname = 0;  
                    $booConsultantLastname = 0; 
                    $booConsultantPhone = 0; 
                    $booConsultantMobile = 0; 
                    $booConsultantEmail = 0; 
                    $booConsultantCommenceDate = 0; 
					$booConsultantCommenceDateTooEarly = 0;
                    $booConsultantDOB = 0; 
					$booConsultantDOBTooLate = 0;
                    $booConsultantStreetAddress = 0; 
                    $booConsultantSuburb = 0; 
                    $booConsultantPostcode = 0;
                    
                    $booOk = 1;  //assign 1
                    
                    
                    //check if submit button (Submit edited details) is pressed
                    if (isset($_POST["submit"]))
                    {
                        $strConsultantId = $_POST['strConsultantId'];  
                        
                        validateConsultant(editconsultant);  //function is in validate_data.php file
        
                        if ($booOk)
                        {	                            
                            //Redirect to the Consultants page
                            header("Location: consultants.php?SUCCESS_MESSAGE=editedDone");
                        }					
                    }
                    else  //else this is true: isset($_GET[ID]) 
                    {
                        // Collect ID which is assigned Consultant Id variable from link on consultants.php page
                        $strConsultantId = $_GET[ID];                    
                                        
						//get consultant, just one
						readQuery("d_consultant", array("Consultant_Id"), array($strConsultantId), array(true));  //in db_functions.php
        
                        // if there is a record continue
                        if ($numRecords == 0) 
                        {
                            echo "<span class='error'>No Matching Consultant Found!</span><br /><br />";
                        } 
                        else  //should be only one
                        {
                            $arrRows = NULL;
                        
                            // Get first (and only result) from database
                            $arrRows = $stmt->fetch(PDO::FETCH_ASSOC);
                            
                            $strConsultantId = $arrRows['Consultant_Id']; //redundant cause it is already set
							
                            $strConsultantFirstname = $arrRows['First_Name'];  
                            $strConsultantLastname = $arrRows['Last_Name']; 
                            $strConsultantPhone = $arrRows['Home_Phone']; 
                            $strConsultantMobile = $arrRows['Mobile']; 
                            $strConsultantEmail = $arrRows['Email']; 
                            $strConsultantCommenceDate = $arrRows['Date_Commenced']; 
                            $strConsultantDOB = $arrRows['DOB']; 
                            $strConsultantStreetAddress = $arrRows['Street_Address']; 
                            $strConsultantSuburb = $arrRows['Suburb'];
                            $strConsultantPostcode = $arrRows['Post_Code'];
                        }					
                    }				
                    
                    echo "<h2>Consultant ID: <em>" . $strConsultantId . "</em></h2><br/><br/>";
                    
                    //create table for Consultant and populate it with the data
					//use htmlspecialchars to escape special characters				
                    echo "<form action='edit_consultant.php' method='post'>";
                    
                    echo "<div class='row'>";
                    
                    echo "<table id='dalton'>";
                        
                    echo "<tr><th>First name *</th><td><input type='text' name='strConsultantFirstname' maxlength='20' size='20' value='".htmlspecialchars($strConsultantFirstname, ENT_QUOTES)."' /></td>";
                    if ($booConsultantFirstname)
                        echo "<td class='validationError'>Please enter a First name (min 2 characters)!</td>";
					else
						echo "<td><em>min 2 characters</em></td>";	
                        
                    echo "</tr><tr><th>Last name *</th><td><input type='text' name='strConsultantLastname' maxlength='20' size='20' value='".htmlspecialchars($strConsultantLastname, ENT_QUOTES)."' /></td>";
                    if ($booConsultantLastname)
                        echo "<td class='validationError'>Please enter a Last name (min 2 characters)!</td>";
					else
						echo "<td><em>min 2 characters</em></td>";
                        
                    echo "</tr><tr><th>Phone *</th><td><input type='text' name='strConsultantPhone' maxlength='10' size='20' value='".htmlspecialchars($strConsultantPhone, ENT_QUOTES)."' /></td>";
                    if ($booConsultantPhone)
                        echo "<td class='validationError'>Please enter a Phone number (10 digits)!</td>";
					else
						echo "<td><em>10 digits</em></td>";
                        
                    echo "</tr><tr><th>Mobile</th><td><input type='text' name='strConsultantMobile' maxlength='10' size='20' value='".htmlspecialchars($strConsultantMobile, ENT_QUOTES)."' /></td>";
                    if ($booConsultantMobile)
                        echo "<td class='validationError'>Mobile number has to be 10 digits! This field is optional</td>";
					else
						echo "<td><em>10 digits (optional field)</em></td>";
                        
                    echo "</tr><tr><th>Email *</th><td><input type='text' name='strConsultantEmail' maxlength='40' size='30' value='".htmlspecialchars($strConsultantEmail, ENT_QUOTES)."' /></td>";
                    if ($booConsultantEmail)
                        echo "<td class='validationError'>Please enter valid Email</td>";
					else
						echo "<td><em>valid email</em></td>";
                        
                    echo "</tr><tr><th>Commencement Date *</th><td><input type='date' name='strConsultantCommenceDate' size='10' value='".htmlspecialchars($strConsultantCommenceDate, ENT_QUOTES)."' /></td>";
                    if ($booConsultantCommenceDate)
                        echo "<td class='validationError'>Please enter a Commencement Date! Format DD/MM/YYYYY</td>";
					else if ($booConsultantCommenceDateTooEarly)
                        echo "<td class='validationError'>Commencement Date has to be later than DOB</td>";
                        
                    echo "</tr><tr><th>Date of Birth *</th><td><input type='date' name='strConsultantDOB' size='10' value='".htmlspecialchars($strConsultantDOB, ENT_QUOTES)."' /></td>";
                    if ($booConsultantDOB)
                        echo "<td class='validationError'>Please enter a Date of Birth! Format DD/MM/YYYYY</td>";
					else if ($booConsultantDOBTooLate)
                        echo "<td class='validationError'>Date of Birth has to be earlier than today</td>"; 
                        
                    echo "</tr><tr><th>Street Address *</th><td><input type='text' name='strConsultantStreetAddress' maxlength='40' size='30' value='".htmlspecialchars($strConsultantStreetAddress, ENT_QUOTES)."' /></td>";
                    if ($booConsultantStreetAddress)
                        echo "<td class='validationError'>Please enter a Street Address (min 2 characters)!</td>";
					else
						echo "<td><em>min 2 characters</em></td>";
                        
                    echo "</tr><tr><th>Suburb *</th><td><input type='text' name='strConsultantSuburb' maxlength='30' size='20' value='".htmlspecialchars($strConsultantSuburb, ENT_QUOTES)."' /></td>";
                    if ($booConsultantSuburb)
                        echo "<td class='validationError'>Please enter a Suburb (min 2 characters)!</td>";
					else
						echo "<td><em>min 2 characters</em></td>";
                        
                    echo "</tr><tr><th>Postcode *</th><td><input type='text' name='strConsultantPostcode' maxlength='4' size='5' value='".htmlspecialchars($strConsultantPostcode, ENT_QUOTES)."' /></td>";
                    if ($booConsultantPostcode)
                        echo "<td class='validationError'>Please enter a Postcode (4 digits)!</td>";
					else
						echo "<td><em>4 digits</em></td>";
                        
                    echo "</tr></table></div><br/><input class='button' type='submit' name='submit' value='Submit Edited Details' /><input type='hidden' name='strConsultantId' value='".$strConsultantId."' /></form>";
                    
                    ?>
                    
                    
                </div>
                <div class="col_1"></div>
            </div>
        </section>
    </div>
    
    
    <footer >
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