<?php

/*	
	Name:	Kirstine Brørup Nielsen
	ID:		100527988
	Date:	02.04.2016
	Web Programming - Assignment Part 2 - DALTON IT CONSULTING 
*/

//Library of Validation Functions
//validate_data.php


// Function to validate the Consultants, INSERT and UPDATE
function validateConsultant($saveaction)
{
	//global keyword is used to access the global variables from within this function				
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
	
	global $booConsultantId; 
	global $booConsultantFirstname;  
	global $booConsultantLastname; 
	global $booConsultantPhone; 
	global $booConsultantMobile; 
	global $booConsultantEmail; 
	global $booConsultantCommenceDate; 
	global $booConsultantCommenceDateTooEarly;
	global $booConsultantDOB;
	global $booConsultantDOBTooLate; 
	global $booConsultantStreetAddress; 
	global $booConsultantSuburb; 
	global $booConsultantPostcode;
	
	global $booOk;  //needed


	if($_POST["strConsultantId"] == NULL)
	{
		$booConsultantId = 1;
		$booOk = 0;
	}
	else //something was entered
	{		
		$strConsultantId = $_POST["strConsultantId"];
		$strConsultantId = trim($strConsultantId);  //trim the str for whitespace
		
		//check for correct length 9
		if (strlen($strConsultantId) != 9)
		{
			$booConsultantId = 1;
			$booOk = 0;			
		}
		else  //correct length
		{
			//get first 3 chars of the string
			$strFirstThree = substr($strConsultantId, 0, 3);
			
			//check if first 3 chars are letters
			if (ctype_alpha ($strFirstThree))  //first three are letters
			{
				//get rest of string
				$strLastSix = substr($strConsultantId, 3);
				
				//check if rest is all digits
				if (ctype_digit ($strLastSix))  //last six are digits
				{
					//input is valid
					//convert first three characters to uppercase
					$strFirstThree = strtoupper($strFirstThree);	
					
					//concat strings
					$strConsultantId = $strFirstThree . $strLastSix;			
				}
				else //last six are not all digits
				{
					$booConsultantId = 1;
					$booOk = 0;	
				}
			}
			else //first 3 chars not all letters
			{
				$booConsultantId = 1;
				$booOk = 0;				
			}
		}
	}		   
	
	if($_POST["strConsultantFirstname"] == NULL)
	{
		$booConsultantFirstname = 1;
		$booOk = 0;
	}
	else  //something entered
	{
		$strConsultantFirstname = $_POST["strConsultantFirstname"];
		$strConsultantFirstname = trim($strConsultantFirstname);  //trim
		
		//check if lenght is < 2
		if (strlen($strConsultantFirstname) < 2)
		{
			$booConsultantFirstname = 1;
			$booOk = 0;
		}
	}
	
	
	if($_POST["strConsultantLastname"] == NULL)
	{
		$booConsultantLastname = 1;
		$booOk = 0;
	}
	else  //something entered
	{
		$strConsultantLastname = $_POST["strConsultantLastname"];
		$strConsultantLastname = trim($strConsultantLastname);  //trim
		
		//check if lenght is < 2
		if (strlen($strConsultantLastname) < 2)
		{
			$booConsultantLastname = 1;
			$booOk = 0;
		}
	}		
		
		
	if($_POST["strConsultantPhone"] == NULL)
	{
		$booConsultantPhone = 1;
		$booOk = 0;
	}
	else  //something is entered
	{				
		$strConsultantPhone = $_POST["strConsultantPhone"];
		$strConsultantPhone = trim($strConsultantPhone);  //trim the str for whitespace
		
		//check if phone is valid
		if (! isValidPhoneNumberFormat($strConsultantPhone))
		{
			//invalid number
			$booConsultantPhone = 1;
			$booOk = 0;	
		}
	}	
		
	//for MOBILE: trim the str for whitespace before checking
	$strConsultantMobile = $_POST["strConsultantMobile"];
	$strConsultantMobile = trim($strConsultantMobile);
	
	//check if str length is more than zero
	if(strlen($strConsultantMobile) > 0)
	{		
		//check if phone is valid
		if (! isValidPhoneNumberFormat($strConsultantMobile))
		{
			//invalid number
			$booConsultantMobile = 1;
			$booOk = 0;	
		}
	}	 
	else  //if(strlen($strConsultantMobile) == 0) everything OK
	{
		$strConsultantMobile = NULL;
	}		
	
		
	//validate email input 
	if($_POST["strConsultantEmail"] == NULL)
	{
		$booConsultantEmail = 1;
		$booOk = 0;
	}
	else  //something is entered
	{
		$strConsultantEmail = $_POST["strConsultantEmail"];		
		$strConsultantEmail = trim($strConsultantEmail);  //trim the str for whitespace

		//check for valid email
		//http://php.net/manual/en/filter.examples.validation.php
		if (! filter_var($strConsultantEmail, FILTER_VALIDATE_EMAIL))
		{
			//invalid email
			$booConsultantEmail = 1;
			$booOk = 0;	
		}	
	}						


	//(YYYY-MM-DD is the actual format of any date post parameter)
	if($_POST["strConsultantCommenceDate"] == NULL)
	{
		$booConsultantCommenceDate = 1;
		$booOk = 0;
	}
	else  //something is entered
	{
		$strConsultantCommenceDate = $_POST["strConsultantCommenceDate"];		
		$strConsultantCommenceDate = trim($strConsultantCommenceDate);  //trim the str for whitespace
							
		//check date for length 10.   
		if (! isValidDate($strConsultantCommenceDate))
		{
			//invalid date format
			$booConsultantCommenceDate = 1;
			$booOk = 0;				
		}		
	}	
	
	
	if($_POST["strConsultantDOB"] == NULL)
	{
		$booConsultantDOB = 1;
		$booOk = 0;
	}
	else  //something is entered
	{
		$strConsultantDOB = $_POST["strConsultantDOB"];		
		$strConsultantDOB = trim($strConsultantDOB);  //trim the str for whitespace		
				
		//check date for length 10
		if (! isValidDate($strConsultantDOB))
		{
			//invalid date format
			$booConsultantDOB = 1;
			$booOk = 0;				
		}
		else  //valid date
		{			
			//create date obj for current date
			$now = date("Y-m-d");     
			
			//echo "now: ".$now;
			
			//check if $strConsultantDOB is less than now
			if (! isDate1LessDate2($strConsultantDOB, $now))
			{			
				//booConsultantDOBTooLate date is too late
				$booConsultantDOBTooLate = 1;
				$booOk = 0;			
			}			
		}
	}	
	
	
	//if both dates are valid	
	if ($booConsultantDOB == 0 && $booConsultantCommenceDate == 0)
	{
		//check if $strConsultantDOB is less than $strConsultantCommenceDate
		if (! isDate1LessDate2($strConsultantDOB, $strConsultantCommenceDate))
		{			
			//booConsultantCommenceDate date is too early
			$booConsultantCommenceDateTooEarly = 1;
			$booOk = 0;			
		}
	}	
	
	
	if($_POST["strConsultantStreetAddress"] == NULL)
	{
		$booConsultantStreetAddress = 1;
		$booOk = 0;
	}
	else  //something entered
	{
		$strConsultantStreetAddress = $_POST["strConsultantStreetAddress"];
		$strConsultantStreetAddress = trim($strConsultantStreetAddress);  //trim
		
		//check if lenght is < 2
		if (strlen($strConsultantStreetAddress) < 2)
		{
			$booConsultantStreetAddress = 1;
			$booOk = 0;
		}
	}
	
	
	if($_POST["strConsultantSuburb"] == NULL)
	{
		$booConsultantSuburb = 1;
		$booOk = 0;
	}
	else  //something entered
	{
		$strConsultantSuburb = $_POST["strConsultantSuburb"];
		$strConsultantSuburb = trim($strConsultantSuburb);  //trim
		
		//check if lenght is < 2
		if (strlen($strConsultantSuburb) < 2)
		{
			$booConsultantSuburb = 1;
			$booOk = 0;
		}
	}		
	
	
	if($_POST["strConsultantPostcode"] == NULL)
	{
		$booConsultantPostcode = 1;
		$booOk = 0;
	}
	else  //something is entered
	{		
		$strConsultantPostcode = $_POST["strConsultantPostcode"];
		$strConsultantPostcode = trim($strConsultantPostcode);  //trim the str for whitespace
		
		//length has to be 4
		if (strlen($strConsultantPostcode) != 4)
		{
			//not valid
			$booConsultantPostcode = 1;
			$booOk = 0;
		}
		else  //length ok
		{
			//check that all are digits
			if (! ctype_digit ($strConsultantPostcode))
			{
				//not all digits
				$booConsultantPostcode = 1;
				$booOk = 0;		
			}
		}
	}
		
	//End of the validation code
	
	//Now check if everything was ok and update the database if it was (using functions in the db_functions file).
	if ($booOk) 
	{		
		if ($saveaction == "addrecord")
		{
			insertConsultant();  //function is in db_functions.php file
		}
		else
		{
			updateConsultant();  //function is in db_functions.php file
		}
	}	
}  //end validateConsultant()



// Function to validate the Project, INSERT and UPDATE
function validateProject($saveaction)
{
	//global keyword is used to access the global variables from within this function
	global $strProjectNumber;   //needed for add porject
	global $strProjectName;  
	global $strProjectDescription; 
	global $strProjectManager;   //needed
	global $strProjectStartDate; 
	global $strProjectFinishDate; 
	global $strProjectBudget; 
	global $strProjectCostToDate; 
	global $strProjectTrackingStatement; 
	global $strProjectClientNumber;   //needed
	
	global $booProjectNumber;  //needed for add porject
	global $booProjectName;  
	global $booProjectDescription; 
	global $booProjectManager;   //needed
	global $booProjectStartDate; 
	global $booProjectFinishDate; 
	global $booProjectBudget; 
	global $booProjectCostToDate; 
	global $booProjectTrackingStatement; 
	global $booProjectClientNumber;   //needed
	
	global $booProjectOk;  //needed


	if($_POST["strProjectNumber"] == NULL)
	{
		$booProjectNumber = 1;
		$booProjectOk = 0;
	}
	else  //something was entered
	{		
		$strProjectNumber = $_POST["strProjectNumber"];
		$strProjectNumber = trim($strProjectNumber);  //trim the str for whitespace   
		
		//check if format is valid
		if (isValidProjectNumberFormat($strProjectNumber))
		{
			//convert first 3 chars to uppercase
			$strProjectNumber = convertToUpper($strProjectNumber);
		}
		else
		{
			$booProjectNumber = 1;
			$booProjectOk = 0;
		}
	}		 


	if($_POST["strProjectName"] == NULL)
	{
		$booProjectName = 1;
		$booProjectOk = 0;
	}
	else  //something was entered
	{		
		$strProjectName = $_POST["strProjectName"];
		$strProjectName = trim($strProjectName);  //trim the str for whitespace 
		
		//check length
		if (strlen($strProjectName) > 50  || strlen($strProjectName) < 2)
		{
			$booProjectName = 1;
			$booProjectOk = 0;
		}
	}
	   
	   
	if($_POST["strProjectDescription"] == NULL)
	{
		$booProjectDescription = 1;
		$booProjectOk = 0;
	}
	else  //something was entered
	{		
		$strProjectDescription = $_POST["strProjectDescription"];
		$strProjectDescription = trim($strProjectDescription);  //trim the str for whitespace 
		
		//check length
		if (strlen($strProjectDescription) > 250 || strlen($strProjectDescription) < 2)
		{
			$booProjectDescription = 1;
			$booProjectOk = 0;
		}		
	}
	   
	   
	if($_POST["strProjectManager"] == NULL)
	{
		$booProjectManager = 1;
		$booProjectOk = 0;
	}
	else
	{
		$strProjectManager = $_POST["strProjectManager"];
	}
	   
	
	//(YYYY-MM-DD is the actual format of any date post parameter)
	if($_POST["strProjectStartDate"] == NULL)
	{
		$booProjectStartDate = 1;
		$booProjectOk = 0;
	}
	else  //something is entered
	{
		$strProjectStartDate = $_POST["strProjectStartDate"];		
		$strProjectStartDate = trim($strProjectStartDate);  //trim the str for whitespace
								
		//check date for length 10.
		if (! isValidDate($strProjectStartDate))
		{
			//invalid date format
			$booProjectStartDate = 1;
			$booProjectOk = 0;			
		}		
	}	   
	
	//Finish date is optional
	$strProjectFinishDate = $_POST["strProjectFinishDate"];
	$strProjectFinishDate = trim($strProjectFinishDate);	
	
	//check if str length is more than zero
	if(strlen($strProjectFinishDate) > 0)
	{
		//check date for length 10.
		if (! isValidDate($strProjectFinishDate))
		{
			//invalid date format
			$booProjectFinishDate = 1;
			$booProjectOk = 0;	
		}
	}	 
	else  //if(strlen($strProjectFinishDate) == 0) everything OK
	{
		$strProjectFinishDate = NULL;
	}
	   
	      
	if($_POST["strProjectBudget"] == NULL)
	{
		$booProjectBudget = 1;
		$booProjectOk = 0;
	}
	else
	{
		$strProjectBudget = $_POST["strProjectBudget"];
		$strProjectBudget = trim($strProjectBudget);  //trim the str for whitespace 
		
		//check if it is a numeric
		if (! is_numeric($strProjectBudget))
		{
			$booProjectBudget = 1;
			$booProjectOk = 0;
		}
		else
		{
			//convert to float
			$strProjectBudget = (float) $strProjectBudget;
		}
	}
	   
	
	//cost to date is optional
	$strProjectCostToDate = $_POST["strProjectCostToDate"];
	$strProjectCostToDate = trim($strProjectCostToDate);  //trim the str for whitespace 	
	
	//check if str length is more than zero
	if(strlen($strProjectCostToDate) > 0)
	{
		//check if it is a numeric
		if (! is_numeric($strProjectCostToDate))
		{
			$booProjectCostToDate = 1;
			$booProjectOk = 0;
		}
		else
		{
			//convert to float
			$strProjectCostToDate = (float) $strProjectCostToDate;
		}		
	}	 
	else  //if(strlen($strProjectCostToDate) == 0) everything OK
	{
		$strProjectCostToDate = NULL;
	}
	   
		
	if($_POST["strProjectTrackingStatement"] == NULL)
	{
		$booProjectTrackingStatement = 1;
		$booProjectOk = 0;
	}
	else  //something was entered
	{		
		$strProjectTrackingStatement = $_POST["strProjectTrackingStatement"];
		$strProjectTrackingStatement = trim($strProjectTrackingStatement);  //trim the str for whitespace 
		
		//check length
		if (strlen($strProjectTrackingStatement) > 150 || strlen($strProjectTrackingStatement) < 2)
		{
			$booProjectTrackingStatement = 1;
			$booProjectOk = 0;
		}
	}
	   
	   
	if($_POST["strProjectClientNumber"] == NULL)
	{
		$booProjectClientNumber = 1;
		$booProjectOk = 0;
	}
	else
	{
		$strProjectClientNumber = $_POST["strProjectClientNumber"];
	}	
		
	//End of the validation code
	
	//Now check if everything was ok and update the database if it was (using functions in the db_functions file).	
	if ($booProjectOk) 
	{		
		if ($saveaction == "addrecord")
		{
			insertProject();  //function is in db_functions.php file
		}
		else
		{
			updateProject();  //function is in db_functions.php file
		}
	}	
}  //end function validateProject()



// Function to validate the Project_Consultant, INSERT and UPDATE
function validateConsultantToProject($saveaction)
{	
	//global keyword is used to access the global variables from within this function	
	global $strAssignmentDate; 
	global $strCompletionDate;
	global $strHoursWorked;
	
	global $booAssignmentDate;  
	global $booCompletionDate;
	global $booHoursWorked;
	
	global $booAssignConsultantToProjectOk;
	

	//(YYYY-MM-DD is the actual format of any date post parameter)
	if($_POST["strAssignmentDate"] == NULL)
	{
		$booAssignmentDate = 1;
		$booAssignConsultantToProjectOk = 0;
	}
	else  //something is entered
	{
		$strAssignmentDate = $_POST["strAssignmentDate"];		
		$strAssignmentDate = trim($strAssignmentDate);  //trim the str for whitespace
		
		//check date for length 10.
		if (! isValidDate($strAssignmentDate))
		{
			//invalid date format
			$booAssignmentDate = 1;
			$booAssignConsultantToProjectOk = 0;			
		}
	}

	//for COMPLETION DATE: trim the str for whitespace before checking
	$strCompletionDate = $_POST["strCompletionDate"];
	$strCompletionDate = trim($strCompletionDate);
	
	//check if str length is more than zero
	if(strlen($strCompletionDate) > 0)
	{		
		//check date for length 10.
		if (! isValidDate($strCompletionDate))
		{
			//invalid date format
			$booCompletionDate = 1;
			$booAssignConsultantToProjectOk = 0;			
		}		
	} 
	else  //if(strlen($strCompletionDate) == 0) everything OK
	{
		$strCompletionDate = NULL;
	}
	  

	//hours worked optional	
	$strHoursWorked = $_POST["strHoursWorked"]; 
	$strHoursWorked = trim($strHoursWorked); 
	
	if(strlen($strHoursWorked) > 0)
	{		
		//check if it is a numeric
		if (! is_numeric($strHoursWorked))
		{
			$booHoursWorked = 1;
			$booAssignConsultantToProjectOk = 0;
		}
		else  //ok
		{
			//convert to float
			$strHoursWorked = (float) $strHoursWorked;
		}
	}
	else  //if(strlen($strHoursWorked) == 0) everything OK
	{	
		$strHoursWorked = NULL;	
	}	
		
	//End of the validation code
	
	//Now check if everything was ok and update the database if it was (using functions in the db_functions file).	
	if ($booAssignConsultantToProjectOk) 
	{		
		if ($saveaction == "addrecord")
		{
			insertConsultantToProject();  //function is in db_functions.php file
		}
		else
		{
			updateConsultantToProject();  //function is in db_functions.php file
		}
	}
}  //end function validateConsultantToProject()



//check if Project number format is valid (EMS6220), return boolean
function isValidProjectNumberFormat($someProjectNo)
{	
	//check for correct length 7
	if (strlen($someProjectNo) != 7)
	{
		return false;		
	}
	else  //correct length
	{
		//get first 3 chars of the string
		$strFirstThree = substr($someProjectNo, 0, 3);
		
		//check if first 3 chars are letters
		if (ctype_alpha ($strFirstThree))  //first three are letters
		{
			//get rest of string
			$strLastFour = substr($someProjectNo, 3);
			
			//check if rest is all digits
			if (ctype_digit ($strLastFour))  //last four are digits
			{
				//format is valid
				return true;		
			}
			else //last four are not all digits
			{
				return false;
			}
		}
		else //first 3 chars not all letters
		{
			return false;			
		}
	}
}  //end isValidProjectNumberFormat()



//convert first 3 chars to upper
function convertToUpper($someString)
{
	//convert first three characters to uppercase
	$strPortionUpper = substr($someString, 0, 3);	
	$strPortionUpper = strtoupper($strPortionUpper);	
	
	$strPortionUntouched = substr($someString, 3);	
	
	//concat strings
	$someString = $strPortionUpper . $strPortionUntouched;	
	
	return $someString;
}


//check the phone format, return boolean
function isValidPhoneNumberFormat($somePhoneNo)
{		
	//check if exactly 10 length
	if (strlen($somePhoneNo) != 10)
	{
		//invalid length
		return false;		
	}
	else  //ok length
	{
		//check if all is digits
		if (! ctype_digit ($somePhoneNo))  //not all digits
		{
			return false;			
		}
		return true;
	}
}  //end isValidPhoneNumberFormat()
	
	

//check the DATE format length 10 YYYY-MM-DD, return boolean
function isValidDate($strSomeDate)
{		
	//check length
	if (strlen($strSomeDate) != 10)
	{
		//invalid length
		return false;			
	}
	else  //ok length
	{		
		return true;
	}	
}  //end isValidDate()



//check if date1 is smaller than date2, return booolean
function isDate1LessDate2($date1, $date2)
{		
	//create objects
	$dateEarliest = date_create($date1); // format of yyyy-mm-dd
	$dateLatest = date_create($date2); // format of yyyy-mm-dd   
   
   //check if date1 < date2
	if ($dateEarliest < $dateLatest)
	{
		return true ;  //true or false
	}
	else
	{
		return false;
	}	
}  //end isDate1LessDate2()



?>