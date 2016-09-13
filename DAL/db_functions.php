<?php
//Library of Database Functions

//Database Connection Variables
$localhost = "localhost";
$user = "root";
$password = "root";
$db = "dalton";  
$dsn = "mysql:host=$localhost;dbname=$db"; //data source name

//Declare Global Variables
$dbConnection = NULL;
$stmt = NULL;
$numRecords = NULL;


//Establish MySQL Connection
function connect()
{
	//required to access global variables
	global $user; 
	global $password; 
	global $dsn; 
	global $dbConnection;
	
	try
	{
		//create a PDO connection with the configuration data
		$dbConnection = new PDO($dsn, $user, $password);
		
		//sets the errormode of the PDO exception handler
		$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch (PDOException $error)
	{
		//Display error message if applicable
		echo "An Error occured: ".$error->getMessage();
	}
}  //end connect()
	


//SELECT all records from a table that meet where clause
function readQuery($table, $arrWhereNames, $arrWhereValues, $arrQuotesWhere)
{
	//required to access global variables	
	global $numRecords; 
	global $dbConnection; 
	global $stmt;
	
	connect();  // Run connect function
		
	$sqlStr = NULL;  //Initialise sql str
	
	//build sql string
	$sqlStr = "SELECT * FROM ".$table." ";		
		
	
	//check if array is null
	if ($arrWhereNames != NULL)
	{
		$sqlStr .= "WHERE ";
		
		$arrLength = sizeof($arrWhereNames);  //get length for arrWhereNames array
		
		for($j = 0; $j < $arrLength; $j++)
		{
			$whereColValue = $arrWhereValues[$j];
			
			if ($whereColValue == NULL)
			{
				$whereColValue = "NULL";
			}
			else if ($arrQuotesWhere[$j])
			{
				$whereColValue = $dbConnection->quote($whereColValue);  //use $dbConnection->quote() to escape special characters for db relevance, and surround string with single quotes
			}
			
			if ($j == ($arrLength - 1))
			{
				$sqlStr .= $arrWhereNames[$j] . "=" . $whereColValue.";";
			}		
			else
			{
				$sqlStr .= $arrWhereNames[$j] . "=" . $whereColValue." AND ";
			}
		}
	}
	else
	{
		$sqlStr .= ";";
	}
	
	//run query
	try
	{
		$stmt = $dbConnection->query($sqlStr);
		if ($stmt === false)
		{
			die("Error executing the query: $sqlStr");
		}
	}
	catch (PDOException $error)
	{
		//Display error message if applicable
		echo "An Error occured: ".$error->getMessage();
	}

	$numRecords = $stmt->rowcount();
	
	//close the database connection
	$dbConnection = NULL;  
}  //end readQuery()



//INSERT a Consultant record
function insertConsultant()
{		
	//required to access global variables	
	global $strConsultantId; 
	global $strConsultantFirstname;  
	global $strConsultantLastname; 
	global $strConsultantPhone; 
	global $strConsultantMobile; 
	global $strConsultantEmail; 
	global $strConsultantCommenceDate; 
	global $strConsultantDOB; 
	global $strConsultantStreetAddress; 
	global $strConsultantSuburb; 
	global $strConsultantPostcode;	
	
	global $booOk;

	$columnNamesArray = array("Consultant_Id", "First_Name", "Last_Name", "Home_Phone", "Mobile", "Email", "Date_Commenced", "DOB", "Street_Address", "Suburb", "Post_Code");
	
	$columnValuesArray = array($strConsultantId, $strConsultantFirstname, $strConsultantLastname, $strConsultantPhone, $strConsultantMobile, $strConsultantEmail, $strConsultantCommenceDate, $strConsultantDOB, $strConsultantStreetAddress, $strConsultantSuburb, $strConsultantPostcode);
	
	$columnValuesQuotesArray = array(true, true, true, true, true, true, true, true, true, true, false);  //need quotes in sql statement
	
	$theResult = insertRecord("d_consultant", $columnNamesArray, $columnValuesArray, $columnValuesQuotesArray, "Consultant", "should never need this");
	
	if (!$theResult)
	{
		$booOk = 0;
	}
}  //end insertConsultant()



//INSERT a Project record
function insertProject()
{
	//required to access global variables	
	global $strProjectNumber; 
	global $strProjectName;  
	global $strProjectDescription; 
	global $strProjectManager; 
	global $strProjectStartDate; 
	global $strProjectFinishDate; 
	global $strProjectBudget; 
	global $strProjectCostToDate; 
	global $strProjectTrackingStatement; 
	global $strProjectClientNumber;
	
	global $booProjectOk;		

	$columnNamesArray = array("Project_No", "Project_Name", "Project_Description", " Project_Manager", "Start_Date", "Finish_Date", "Budget", "Cost_To_Date", "Tracking_Statement", "Client_No");
	
	$columnValuesArray = array($strProjectNumber, $strProjectName, $strProjectDescription, $strProjectManager, $strProjectStartDate, $strProjectFinishDate, $strProjectBudget, $strProjectCostToDate, $strProjectTrackingStatement, $strProjectClientNumber);
	
	$columnValuesQuotesArray = array(true, true, true, true, true, true, true, true, true, false);  //need quotes in sql statement
	
	$theResult = insertRecord("d_project", $columnNamesArray, $columnValuesArray, $columnValuesQuotesArray, "Project", "Manager and/or Client Number");
		
	if (!$theResult)
	{
		$booProjectOk = 0;
	}
}  //end insertProject()



//INSERT record in D_Project_Consultant table
function insertConsultantToProject()
{	
	//required to access global variables	
	global $strConsultantId; 
	global $strProjectNumber;	
	global $strAssignmentDate; 
	global $strCompletionDate;
	global $strRole; 
	global $strHoursWorked;  //is float
	
	global $booAssignConsultantToProjectOk;	

	$columnNamesArray = array("Consultant_Id", "Project_No", "Date_Assigned", "Date_Completed", "Role", "Hours_Worked");
	
	$columnValuesArray = array($strConsultantId, $strProjectNumber, $strAssignmentDate, $strCompletionDate, $strRole, $strHoursWorked);
	
	$columnValuesQuotesArray = array(true, true, true, true, true, true);  //need quotes in sql statement
	
	$theResult = insertRecord("d_project_consultant", $columnNamesArray, $columnValuesArray, $columnValuesQuotesArray, "Consultant on Project", "Consultant and/or Project Number");
	
	if (!$theResult)
	{
		$booAssignConsultantToProjectOk = 0;
	}
}  //end insertConsultantToProject()



//INSERT record, return true if successful, return false if insertion fails.
function insertRecord($tableName, $arrOfColNames, $arrOfColVal, $arrQuotes, $duplicateErr, $foreignKeyErr)
{
	//required to access global variables	
	global $dbConnection; 
	global $stmt;
	
	connect(); //run connect function
		
	$sqlStr = NULL;  //Initialise Variable to hold query
	
	//build sql string		
	$sqlStr = "INSERT INTO ". $tableName ." (";
	
	$arrLength = sizeof($arrOfColNames);
	
	for($i = 0; $i < $arrLength; $i++)
	{
		if ($i == ($arrLength - 1))
		{
			$sqlStr .= $arrOfColNames[$i]." ";
		}		
		else
		{
			$sqlStr .= $arrOfColNames[$i].", ";
		}
	}
	
	$sqlStr .= ") VALUES (";
	
	for($j = 0; $j < $arrLength; $j++)
	{
		$colValue = $arrOfColVal[$j];
		
		if ($colValue == NULL)
		{
			$colValue = "NULL";
		}
		else if ($arrQuotes[$j])
		{
			$colValue = $dbConnection->quote($colValue);  //use $dbConnection->quote() to escape special characters for db relevance, and surround string with single quotes
		}
		
		if ($j == ($arrLength - 1))
		{
			$sqlStr .= $colValue." ";  //don't put comma if it is the last
		}		
		else
		{
			$sqlStr .= $colValue.", ";
		}
	}
	
	$sqlStr .= ");";
	
	//run query
	try
	{
		$stmt = $dbConnection->exec($sqlStr);
	}
	catch (PDOException $error)
	{
		$errinfo = ($dbConnection->errorInfo());		
		
		if ($errinfo[1] == 1062) //checking for a duplicate primary key value
		{
			echo "<p class='error'>WARNING: ".$duplicateErr." already exists</p><br/>";			
		}
		else if ($errinfo[1] == 1452) //checking for foreign key constraint (should not happen since lists are populated based on dara from database)
		{
			echo "<p class='error'>WARNING: ".$foreignKeyErr." does not exist</p><br/>";
		}
		else
		{
			//Display error message if applicable
			echo "<p class='error'>Unknown error occured: ".$error->getMessage()."</p><br/>";
		}
		return false;
	}
	
	$dbConnection = NULL;
	
	return true;
	
}  //end insertRecord()



//UPDATE 'Consultant' record
function updateConsultant()
{	
	//required to access global variables	
	global $strConsultantId;
	global $strConsultantFirstname;  
	global $strConsultantLastname; 
	global $strConsultantPhone; 
	global $strConsultantMobile; 
	global $strConsultantEmail; 
	global $strConsultantCommenceDate; 
	global $strConsultantDOB; 
	global $strConsultantStreetAddress; 
	global $strConsultantSuburb; 
	global $strConsultantPostcode;	
	
	global $booOk;  //needed

	$columnNamesArray = array("First_Name", "Last_Name", "Home_Phone", "Mobile", "Email", "Date_Commenced", "DOB", "Street_Address", "Suburb", "Post_Code");	//arr holds the column names 	
	$columnValuesArray = array($strConsultantFirstname, $strConsultantLastname, $strConsultantPhone, $strConsultantMobile, $strConsultantEmail, $strConsultantCommenceDate, $strConsultantDOB, $strConsultantStreetAddress, $strConsultantSuburb, $strConsultantPostcode);		//arr holds the column values	
	$columnValuesQuotesArray = array(true, true, true, true, true, true, true, true, true, false);  //need quotes in sql statement

	$whereColumnNamesArray = array("Consultant_Id");	//arr holds the column names 	
	$whereColumnValuesArray = array($strConsultantId);	//arr holds the column values	
	$whereColumnValuesQuotesArray = array(true);  //need quotes in sql statement
	
	$theResult = updateRecord("d_consultant", $columnNamesArray, $columnValuesArray, $columnValuesQuotesArray, $whereColumnNamesArray, $whereColumnValuesArray, $whereColumnValuesQuotesArray, "Consultant", "should never need this");
	
	if (!$theResult)
	{
		$booOk = 0;
	}
}  //end updateConsultant()



//UPDATE 'Project' record
function updateProject()
{	
	//required to access global variables	
	global $strProjectNumber; 
	global $strProjectName;  
	global $strProjectDescription; 
	global $strProjectManager; 
	global $strProjectStartDate; 
	global $strProjectFinishDate; 
	global $strProjectBudget; 
	global $strProjectCostToDate; 
	global $strProjectTrackingStatement; 
	global $strProjectClientNumber;
		
	global $booProjectOk;

	$columnNamesArray = array("Project_Name", "Project_Description", " Project_Manager", "Start_Date", "Finish_Date", "Budget", "Cost_To_Date", "Tracking_Statement", "Client_No");	
	$columnValuesArray = array($strProjectName, $strProjectDescription, $strProjectManager, $strProjectStartDate, $strProjectFinishDate, $strProjectBudget, $strProjectCostToDate, $strProjectTrackingStatement, $strProjectClientNumber);	
	$columnValuesQuotesArray = array(true, true, true, true, true, true, true, true, false);  //need quotes in sql statement

	$whereColumnNamesArray = array("Project_No");	
	$whereColumnValuesArray = array($strProjectNumber);	
	$whereColumnValuesQuotesArray = array(true);  //need quotes in sql statement
	
	$theResult = updateRecord("d_project", $columnNamesArray, $columnValuesArray, $columnValuesQuotesArray, $whereColumnNamesArray, $whereColumnValuesArray, $whereColumnValuesQuotesArray, "Project", "Manager and/or Client Number");
	
	if (!$theResult)
	{
		$booProjectOk = 0;
	}
}  //end updateProject()



//UPDATE record in D_Project_Consultant table
function updateConsultantToProject()
{	
	//required to access global variables
	global $dbConnection; 
	global $stmt; 
	
	global $STR_PERMANENT_CONSULTANT_ID;
	
	global $strConsultantId; 
	global $strProjectNumber;	
	global $strAssignmentDate; 
	global $strCompletionDate;
	global $strRole; 
	global $strHoursWorked;  //is float
	
	global $booAssignConsultantToProjectOk;	

	$columnNamesArray = array("Consultant_Id", "Date_Assigned", "Date_Completed", "Role", "Hours_Worked");	
	$columnValuesArray = array($strConsultantId, $strAssignmentDate, $strCompletionDate, $strRole, $strHoursWorked);	
	$columnValuesQuotesArray = array(true, true, true, true, true);  //need quotes in sql statement

	$whereColumnNamesArray = array("Consultant_Id", "Project_No");	
	$whereColumnValuesArray = array($STR_PERMANENT_CONSULTANT_ID, $strProjectNumber);	
	$whereColumnValuesQuotesArray = array(true, true);  //need quotes in sql statement
	
	$theResult = updateRecord("d_project_consultant", $columnNamesArray, $columnValuesArray, $columnValuesQuotesArray, $whereColumnNamesArray, $whereColumnValuesArray, $whereColumnValuesQuotesArray, "Consultant on Project", "Consultant and/or Project Number");
	
	if (!$theResult)
	{
		$booAssignConsultantToProjectOk = 0;
	}	
}  //end updateConsultant()



//UPDATE record, return true if successful, return false if update fails.
function updateRecord($tableName, $arrOfColNames, $arrOfColVal, $arrQuotes, $arrWhereNames, $arrWhereValues, $arrQuotesWhere, $duplicateErr, $foreignKeyErr)
{
	//required to access global variables	
	global $dbConnection; 
	global $stmt;
	
	connect(); //run connect function
		
	$sqlStr = NULL;  //Initialise Variable to hold query
	
	//build sql string		
	$sqlStr = "UPDATE ". $tableName ." SET ";
	
	$arrLength = sizeof($arrOfColNames);
	
	for($i = 0; $i < $arrLength; $i++)
	{
		$colValue = $arrOfColVal[$i];
		
		if ($colValue == NULL)
		{
			$colValue = "NULL";
		}
		else if ($arrQuotes[$i])
		{
			$colValue = $dbConnection->quote($colValue);  //use $dbConnection->quote() to escape special characters for db relevance, and surround string with single quotes
		}		
		
		//check if it is last index
		if ($i == ($arrLength - 1)) 
		{
			$sqlStr .= $arrOfColNames[$i]."=".$colValue." ";
		}		
		else
		{
			$sqlStr .= $arrOfColNames[$i]."=".$colValue.", ";
		}
	}
	
	$sqlStr .= "WHERE ";
	
	$arrLength = sizeof($arrWhereNames);  //get length for other array
	
	for($j = 0; $j < $arrLength; $j++)
	{
		$whereColValue = $arrWhereValues[$j];
		
		if ($whereColValue == NULL)
		{
			$whereColValue = "NULL";
		}
		else if ($arrQuotesWhere[$j])
		{
			$whereColValue = $dbConnection->quote($whereColValue);  //use $dbConnection->quote() to escape special characters for db relevance, and surround string with single quotes
		}
		
		if ($j == ($arrLength - 1))
		{
			$sqlStr .= $arrWhereNames[$j] . "=" . $whereColValue.";";
		}		
		else
		{
			$sqlStr .= $arrWhereNames[$j] . "=" . $whereColValue." AND ";
		}
	}
	
	//run query
	try
	{
		$stmt = $dbConnection->exec($sqlStr);
	}
	catch (PDOException $error)
	{
		$errinfo = ($dbConnection->errorInfo());		
		
		if ($errinfo[1] == 1062) //checking for a duplicate primary key value
		{
			echo "<p class='error'>WARNING: ".$duplicateErr." already exists</p><br/>";			
		}
		else if ($errinfo[1] == 1452) //checking for foreign key constraint (should not happen since lists are populated based on dara from database)
		{
			echo "<p class='error'>WARNING: ".$foreignKeyErr." does not exist</p><br/>";
		}
		else
		{
			//Display error message if applicable
			echo "<p class='error'>Unknown error occured: ".$error->getMessage()."</p><br/>";
		}
		return false;
	}
	
	$dbConnection = NULL;
	
	return true;
	
}  //end updateRecord()
	


//DELETE record(s) that meet the Where clause
function deleteRecord($table, $arrWhereNames, $arrWhereValues, $arrQuotesWhere)
{
	$booDeletionDone = false;  //boolean to return
		
	//required to access global variables	
	global $dbConnection;
	
	connect();  // Run connect function
		
	$sqlStr = NULL;  //Initialise Variable to hold query$sqlStr .= "WHERE ";
	
	//Delete Record(s)
	$sqlStr = "DELETE FROM ".$table." WHERE ";		
		
	$arrLength = sizeof($arrWhereNames);  //get length for other array
	
	for($j = 0; $j < $arrLength; $j++)
	{
		$whereColValue = $arrWhereValues[$j];
		
		if ($whereColValue == NULL)
		{
			$whereColValue = "NULL";
		}
		else if ($arrQuotesWhere[$j])
		{
			$whereColValue = $dbConnection->quote($whereColValue);  //use $dbConnection->quote() to escape special characters for db relevance, and surround string with single quotes
		}
		
		if ($j == ($arrLength - 1))
		{
			$sqlStr .= $arrWhereNames[$j] . "=" . $whereColValue.";";
		}		
		else
		{
			$sqlStr .= $arrWhereNames[$j] . "=" . $whereColValue." AND ";
		}
	}
	
		
	// Run Query
	try
	{
		$stmt = $dbConnection->exec($sqlStr);
		
		if($stmt === false)
		{
			die("Error executing the query: $sqlStr");
		}
		
		$booDeletionDone = true;  //update flag
    }
	catch (PDOException $error)
	{
		$errinfo = ($dbConnection->errorInfo());		
		
		if ($errinfo[1] == 1451) //Cannot delete or update a parent row
		{			
			echo "<p class='error'<br/><br/><br/>Warning: You cannot delete this record<br/><br/>";
			echo "Other records in the system depend on it<br/><br/>";
			echo "Press 'Cancel' to return to the overview</p>";	
		}
		else
		{
			//Display error message if applicable
			echo "<p class='error'>Unknown error occured: ".$error->getMessage()."</p><br/>";
		}
		$booDeletionDone = false;
    } 
	
    // Close the connection
	$dbConnection = NULL;	
	
	return $booDeletionDone;
} //end deleteRecord()

?>