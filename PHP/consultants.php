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
                    <h1>Consultants</h1>
                    
                    <?php
                    // consultants.php
                    
                    //include database function library
                    require_once("../DAL/db_functions.php");
                    
                    if ($_GET[SUCCESS_MESSAGE] == "deletedDone")
                        echo "<p class='success'>Record was successfully deleted</p><br/>";
						
                    if ($_GET[SUCCESS_MESSAGE] == "editedDone")
                        echo "<p class='success'>Record was successfully updated</p><br/>";
						
                    if ($_GET[SUCCESS_MESSAGE] == "addDone")
                        echo "<p class='success'>Record was successfully added</p><br/>";						
                    
                    //run query on Consultant table, get all consultants
                    readQuery("d_consultant", NULL, NULL, NULL);  //function is in db_functions.php file
                    
                    //if there are any Consultant details in the database then continue
                    if($numRecords === 0)
                    {
                        echo "<p>No Consultants Found!</p><br/>";
                    }
                    else
                    {
                        $arrRows = NULL;
                        
                        //create Table and Headings
                        echo "<table id='dalton'>";
                        echo "<tr>";
                        echo "<th>ID</th>";
                        echo "<th>Firstname</th>";
                        echo "<th>Lastname</th>";
                        echo "<th>Phone</th>";
                        echo "<th>Mobile</th>";
                        echo "<th>Email</th>";
                        echo "<th>Began</th>";
                        echo "<th>DOB</th>";
                        echo "<th>Street address</th>";
                        echo "<th>Suburb</th>";
                        echo "<th>Postcode</th>";
                        echo "<th></th>";
                        echo "</tr>";
                        
                        //loop through Consultants and add row to table for each record
                        while($arrRows = $stmt->fetch(PDO::FETCH_ASSOC))
                        {
							//htmlspecialchars to escape special characters
                            echo "<tr>";
                            echo "<td>".htmlspecialchars($arrRows['Consultant_Id'], ENT_QUOTES)."</td>";
                            echo "<td>".htmlspecialchars($arrRows['First_Name'], ENT_QUOTES)."</td>";
                            echo "<td>".htmlspecialchars($arrRows['Last_Name'], ENT_QUOTES)."</td>";
                            echo "<td>".htmlspecialchars($arrRows['Home_Phone'], ENT_QUOTES)."</td>";
                            echo "<td>".htmlspecialchars($arrRows['Mobile'], ENT_QUOTES)."</td>";
                            echo "<td>".htmlspecialchars($arrRows['Email'], ENT_QUOTES)."</td>";
                            echo "<td class='tdNoWrap'>".htmlspecialchars($arrRows['Date_Commenced'], ENT_QUOTES)."</td>";
                            echo "<td class='tdNoWrap'>".htmlspecialchars($arrRows['DOB'], ENT_QUOTES)."</td>";
                            echo "<td>".htmlspecialchars($arrRows['Street_Address'], ENT_QUOTES)."</td>";
                            echo "<td>".htmlspecialchars($arrRows['Suburb'], ENT_QUOTES)."</td>";
                            echo "<td>".htmlspecialchars($arrRows['Post_Code'], ENT_QUOTES)."</td>";
                            
                            //add links with Consultant_Id as value, to edit and delete page
                            echo "<td><a class='linkDisplay' href='edit_consultant.php?ID=$arrRows[Consultant_Id]'>Edit</a>";
                            echo "<br/><a class='linkDisplay' href='delete_consultant.php?TYPE=Consultant&amp;ID=$arrRows[Consultant_Id]&amp;CONSULTANT_FNAME=$arrRows[First_Name]&amp;CONSULTANT_LNAME=$arrRows[Last_Name]'>Delete</a></td></tr>";		
                        }
                        echo "</table>";
                        echo "<br/>";
                    }
                    
                    echo '<div class="row">';	
                    echo '<div><a href="add_consultant.php" class="linkButton">New Consultant</a></div>';
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


