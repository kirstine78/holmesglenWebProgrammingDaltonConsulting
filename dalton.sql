--  Dalton  Consulting

-- delete database and rebuild new database

Drop Database If Exists dalton;
Create Database If Not Exists dalton;
Use dalton;

-- Build tables and Add Test Data

Create Table If Not Exists D_Client
(
 Client_No					SmallInt(4)		Not Null,
 Company_Name				VarChar(40)		Not Null,
 Company_Street_Address		VarChar(40)		Not Null,
 Company_Suburb				VarChar(30)		Not Null,
 Company_Post_Code			SmallInt(4)		Not Null,
 Company_Phone				Char(10)			Not Null,
 Company_Contact_Name			VarChar(30)		Not Null,
 Contact_Position			VarChar(30)		Not Null,
 Contact_Phone				Char(10)			Not Null,
 Contact_Email				VarChar(40)		Not Null,
 Deputy_Contact				VarChar(40)		Not Null,
 Deputy_Phone				Char(10)			Not Null,
 Deputy_Email				VarChar(40)		Not Null,
 Constraint Client_pk Primary Key (Client_No)
 ) Engine=InnoDB Default Charset=utf8;

Insert Into D_Client Values ( 7561, 'dalton College', '87 Oak St.', 'Springvale', 3171, '0485117642', 'Jason', 'Head Janitor', '0485117682', 'j.newman@dalton.edu.au', 'Helga', '0485117643', 'h.luu@dalton.edu.au' );
Insert Into D_Client Values ( 7687, 'EM Screen Systems Inc.', '40 Main St.', 'Millbury', 1527, '5088659995', 'Joyce', 'Assistant Director', '5088659995', 'joyce@emscreensystems.com', 'Paul', '5088659995', 'eg@emscreensystems.com' );
Insert Into D_Client Values ( 7594, 'Western Resturaunts Inc.', '1280 W. Central Ave.', 'Sutherland', 9747, '5414591249', 'Christy', 'Supervisor', '5414591249', 'christy@westernresturaunts.com', 'Rick', '5414591252', 'admin@westernresturaunts.com' );
Insert Into D_Client Values ( 7638, 'Springvale Public Library', '386 Springvale Rd.', 'Springvale', 3171, '0647891534', 'Joann', 'People Quieter', '0647891532', 'j.white@springvalepubliclibrary.com.au', 'Matt Mejaour', '0647891536', 'm.mejaour@springvalepubliclibrary.com.au' );


Create Table If Not Exists D_Skill
(
 Skill_ID					Char(5)			Not Null,
 Skill_Name				VarChar(30)		Not Null,
 Skill_Description			VarChar(150)		Not Null,
 Constraint Skill_pk Primary Key (Skill_ID)
) Engine=InnoDB Default Charset=utf8;

-- test data
Insert Into D_Skill Values ( 'JAV01', 'Java Programming', 'Ability to program using the Java Language' );
Insert Into D_Skill Values ( 'NET01', 'Networking', 'Installation and maintenance of computer networks' );
Insert Into D_Skill Values ( 'ELE01', 'Electrical', 'Installation and maintenance of electrical networks' );
Insert Into D_Skill Values ( 'CAD01', 'Computer Assisted Design', 'Design of projects in autoCAD' );
Insert Into D_Skill Values ( 'CON01', 'Contracting', 'Work on walls, ceiling, and floors' );


Create Table If Not Exists D_Consultant
(
 Consultant_Id				Char(9)		Not Null,
 First_Name				VarChar(20) 	Not Null,
 Last_Name					VarChar(20)	Not Null,
 Home_Phone				Char(10)		Not Null,
 Mobile					Char(10),
 Email 					VarChar(40)	Not Null,
 Date_Commenced				Date 			Not Null,
 DOB						Date 			Not Null,
 Street_Address 				VarChar(40)	Not Null,
 Suburb 					VarChar(30)	Not Null,
 Post_Code 				SmallInt(4)	Not Null,
 Constraint Consultant_pk Primary Key (Consultant_Id)
) Engine=InnoDB Default Charset=utf8;

Insert Into D_Consultant Values ( 'SMI130001', 'John', 'Smith', '2081473215', NULL, 'j.smith@mcmillanit.com', '2013/03/25', '1987/05/27', '11B S. 4th. Ave.', 'Pocatello', 9801 );
Insert Into D_Consultant Values ( 'TRA010001', 'LeAnn', 'Tracy', '5414591499', '5415301419', 'l.tracy@mcmillanit.com', '2001/03/31', '1985/03/08', '235 Sherman St. Apt. 118', 'Sutherland', 9747 );
Insert Into D_Consultant Values ( 'MCL100001', 'Robert', 'McLeod', '2081473215', '7742761572', 'r.mcleod@mcmillanit.com', '2010/06/15', '1992/02/25', '9 Jackie Dr.', 'Millbury', 1527 );
Insert Into D_Consultant Values ( 'WAT120001', 'Samantha', 'Waters', '0647915384', NULL, 's.waters@mcmillanit.com', '2012/04/25', '1991/01/08', '118 Dandenong Rd.', 'Chadstone', 3058 );
Insert Into D_Consultant Values ( 'SAK120002', 'Gavin', 'Saker', '0876491835', '3497865218', 'g.saker@mcmillanit.com', '2012/04/27', '1989/09/07', '128 Cherry St.', 'Seaford', 3185 );


Create Table If Not Exists D_Branch
(
 Branch_Code				Char(3)			Not Null,
 Branch_Name				VarChar(20)		Not Null,
 Manager 					Char(9)			Not Null,
 Branch_Address				VarChar(40)		Not Null,
 Suburb 					VarChar(30)		Not Null,
 Post_Code 				SmallInt(4)		Not Null,
 Phone 					Char(10)			Not Null,
 Constraint Branch_pk Primary Key (Branch_Code),
 Constraint Branch_Consultant_fk Foreign Key (Manager) References D_Consultant (Consultant_Id)
) Engine=InnoDB Default Charset=utf8;

Insert Into D_Branch Values ( 'MEL', 'Melbourne', 'SMI130001', '153 S. Oak Ave.', 'Melbourne', 4186, 1759486387 );
Insert Into D_Branch Values ( 'SYD', 'Sydney', 'WAT120001', '1123 Sturt street', 'Sydney', 2186, 1759486387 );

Create Table If Not Exists D_Project
(
 Project_No				Char(7)			Not Null,
 Project_Name				VarChar(50)		Not Null,
 Project_Description			VarChar(250)		Not Null,
 Project_Manager				Char(9)			Not Null,
 Start_Date				Date 				Not Null,
 Finish_Date				Date,
 Budget					Float(12)			Not Null,
 Cost_To_Date				Float(12),
 Tracking_Statement			VarChar(150)		Not Null,
 Client_No					SmallInt(4)		Not Null,
 Constraint Project_pk Primary Key (Project_No),
 Constraint Project_Consultant_fk Foreign Key (Project_Manager) References D_Consultant (Consultant_Id),
 Constraint Project_Client_fk Foreign Key (Client_No) References D_Client (Client_No)
) Engine=InnoDB Default Charset=utf8;

Insert Into D_Project Values ( 'MAY5416', 'dalton College network upgrade', "Upgrading of the college's network including the replacement of three servers and the addition of new", 'SMI130001', '2012/11/16', '2013/01/02', '175000', '167654.58', 'This project was completed on time and under budget', 7561 );
Insert Into D_Project Values ( 'MAY5417', 'dalton College network expansion', "Expansion of the college's network to new building", 'SMI130001', '2013/02/04', '2013/02/23', '38000', '35489.47', 'This project was completed early and under budget', 7561 );
Insert Into D_Project Values ( 'MAY5418', 'dalton College network maintenance', "Full inspection and maitenence on the college's network", 'MCL100001', '2013/05/30', NULL, '2500', NULL, 'This project has not yet begun', 7561 );

Insert Into D_Project Values ( 'EMS6219', 'EM Screen Systems network installation', "Primary installationof EM Screen's network", 'TRA010001', '2011/08/03', '2011/08/10', '75000', '56178.43', 'This project was delayed, but finished under budget', 7687 );
Insert Into D_Project Values ( 'EMS6220', 'EM Screen Systems network upgrade', "Upgrading of EM Screen's network to accomidate growth", 'TRA010001', '2012/04/13', '2012/04/28', '100000', '94862.17', 'This project was completed early and under budget', 7687 );
Insert Into D_Project Values ( 'EMS6221', 'EM Screen Systems network repair', "repair of EM Screen's network after flood", 'TRA010001', '2012/09/24', '2012/10/09', '35000', '38000', 'This project met unforseen circumstances and was delayed and over budget', 7687 );
Insert Into D_Project Values ( 'EMS6222', 'EM Screen Systems network upgrade', "Upgrading of EM Screen's network to accomidate growth", 'SMI130001', '2013/04/19', NULL, '90000', '68741.38', 'This project is on going.', 7687 );

Insert Into D_Project Values ( 'WRS7248', 'Western Resturaunts', "Upgrading of the college's network including the replacement of three servers and the addition of new", 'SMI130001', '2012/11/16', '2012/01/02', '175000', '167654.58', 'This project was completed on time and under budget', 7594 );
Insert Into D_Project Values ( 'WRS7249', 'Western Resturaunts network upgrade', "Upgrading of the college's network including the replacement of three servers and the addition of new", 'TRA010001', '2013/06/08', NULL, '175000', '167654.58', 'This project was completed on time and under budget', 7594 );

Insert Into D_Project Values ( 'SPL2476', 'Springvale Public Library network upgrade', "Upgrading of the library's network including the replacement all public access computers", 'TRA010001', '2011/06/17', '2011/08/19', '350000', '408351.46', 'This project was completed lat and over budget', 7638 );
Insert Into D_Project Values ( 'SPL2477', 'Springvale Public Library catalog upgrade', "Upgrading of the library's catalog system.", 'TRA010001', '2012/11/16', '2013/01/18', '5000', '4987.26', 'This project was completed early and under budget', 7638 );
Insert Into D_Project Values ( 'SPL2478', 'Springvale Public Library expansion', "Expanding the Library's network to older sections of the Library", 'SMI130001', '2013/04/05', NULL, '280000', '128.48', 'This project is on schedulle and on budget', 7638 );

Create Table If Not Exists D_Project_Consultant
(
 Consultant_Id				Char(9)			Not Null,
 Project_No				Char(7)			Not Null,
 Date_Assigned				Date 				Not Null,
 Date_Completed				Date,
 Role						VarChar(30)		Not Null,
 Hours_Worked				Float(5),
 Constraint Project_Consultant_pk Primary Key (Consultant_Id, Project_No),
 Constraint Project_Consultant_Consultant_fk Foreign Key (Consultant_Id) References D_Consultant (Consultant_Id),
 Constraint Project_Consultant_Project_fk Foreign Key (Project_No) References D_Project (Project_No)
) Engine=InnoDB Default Charset=utf8;

Insert Into D_Project_Consultant Values ( 'SMI130001', 'MAY5416', '2012/11/16', '2013/01/02', 'Lead', '213.5' );
Insert Into D_Project_Consultant Values ( 'MCL100001', 'MAY5416', '2012/11/16', '2013/01/02', 'Designer', '186.1' );
Insert Into D_Project_Consultant Values ( 'SAK120002', 'MAY5417', '2013/02/04', '2013/01/02', 'Hardware', '384.6' );
Insert Into D_Project_Consultant Values ( 'SMI130001', 'MAY5417', '2013/02/04', '2013/01/02', 'Designer', '54.6' );
Insert Into D_Project_Consultant Values ( 'SAK120002', 'MAY5418', '2013/05/30', NULL, 'Teset', '184.6' );
Insert Into D_Project_Consultant Values ( 'TRA010001', 'MAY5418', '2013/05/30', NULL, 'Designer', '97.65' );

Insert Into D_Project_Consultant Values ( 'SMI130001', 'EMS6219', '2011/08/03', '2013/01/02', 'Solo', '364.1' );
Insert Into D_Project_Consultant Values ( 'SAK120002', 'EMS6220', '2012/04/13', '2013/01/02', 'Solo', '486.6' );
Insert Into D_Project_Consultant Values ( 'TRA010001', 'EMS6221', '2012/09/24', '2013/01/02', 'Networker', '8.4' );
Insert Into D_Project_Consultant Values ( 'MCL100001', 'EMS6221', '2012/09/24', '2013/01/02', 'Designer', '394.5' );
Insert Into D_Project_Consultant Values ( 'SMI130001', 'EMS6222', '2013/04/19', NULL, 'Programmer', '138.6' );
Insert Into D_Project_Consultant Values ( 'TRA010001', 'EMS6222', '2013/04/19', NULL, 'Designer', '239.1' );

Insert Into D_Project_Consultant Values ( 'MCL100001', 'WRS7248', '2012/11/16', '2013/01/02', 'Networker', '387.6' );
Insert Into D_Project_Consultant Values ( 'SMI130001', 'WRS7248', '2012/11/16', '2013/01/02', 'Designer', '186.5' );
Insert Into D_Project_Consultant Values ( 'WAT120001', 'WRS7249', '2013/06/08', NULL, 'Networker', '586.3' );
Insert Into D_Project_Consultant Values ( 'SMI130001', 'WRS7249', '2013/06/08', NULL, 'Designer', '698.4' );

Insert Into D_Project_Consultant Values ( 'MCL100001', 'SPL2476', '2011/06/17', '2013/01/02', 'Designer', '287.6' );
Insert Into D_Project_Consultant Values ( 'TRA010001', 'SPL2476', '2011/06/17', '2013/01/02', 'Programmer', '239.4' );
Insert Into D_Project_Consultant Values ( 'WAT120001', 'SPL2477', '2012/11/16', '2013/01/02', 'Networker', '168.2' );
Insert Into D_Project_Consultant Values ( 'SMI130001', 'SPL2477', '2012/11/16', '2013/01/02', 'Designer', '128.4' );
Insert Into D_Project_Consultant Values ( 'MCL100001', 'SPL2478', '2013/04/05', NULL, 'Designer', '349.6' );
Insert Into D_Project_Consultant Values ( 'WAT120001', 'SPL2478', '2013/04/05', NULL, 'Programmer', '234.6' );
Insert Into D_Project_Consultant Values ( 'TRA010001', 'SPL2478', '2013/04/05', NULL, 'Networker', '197.4' );

Create Table If Not Exists D_Project_Skill
(
 Project_Number				Char(7)		Not Null,
 Skill_ID					Char(10)	Not Null,
 NuD_Req_Consultants			SmallInt	Not Null,
 Constraint Project_Skill_pk Primary Key (Project_Number, Skill_ID),
 Constraint Project_Skill_Project_fk Foreign Key (Project_Number) References D_Project (Project_No),
 Constraint Project_Skill_Skill_fk Foreign Key (Skill_ID) References D_Skill (Skill_ID)
) Engine=InnoDB Default Charset=utf8;

Insert Into D_Project_Skill Values ( 'MAY5416', 'CAD01', 2 );
Insert Into D_Project_Skill Values ( 'MAY5416', 'ELE01', 3 );
Insert Into D_Project_Skill Values ( 'MAY5417', 'JAV01', 1 );
Insert Into D_Project_Skill Values ( 'MAY5417', 'ELE01', 4 );
Insert Into D_Project_Skill Values ( 'MAY5418', 'CAD01', 3 );
Insert Into D_Project_Skill Values ( 'MAY5418', 'CON01', 2 );

Insert Into D_Project_Skill Values ( 'EMS6219', 'NET01', 1 );
Insert Into D_Project_Skill Values ( 'EMS6219', 'CAD01', 3 );
Insert Into D_Project_Skill Values ( 'EMS6220', 'ELE01', 3 );
Insert Into D_Project_Skill Values ( 'EMS6220', 'JAV01', 2 );
Insert Into D_Project_Skill Values ( 'EMS6221', 'CAD01', 1 );
Insert Into D_Project_Skill Values ( 'EMS6221', 'NET01', 2 );
Insert Into D_Project_Skill Values ( 'EMS6222', 'ELE01', 4 );
Insert Into D_Project_Skill Values ( 'EMS6222', 'CON01', 3 );
Insert Into D_Project_Skill Values ( 'WRS7248', 'CAD01', 2 );
Insert Into D_Project_Skill Values ( 'WRS7248', 'JAV01', 1 );
Insert Into D_Project_Skill Values ( 'WRS7249', 'ELE01', 3 );
Insert Into D_Project_Skill Values ( 'WRS7249', 'NET01', 2 );

Insert Into D_Project_Skill Values ( 'SPL2476', 'CON01', 1 );
Insert Into D_Project_Skill Values ( 'SPL2476', 'CAD01', 3 );
Insert Into D_Project_Skill Values ( 'SPL2477', 'JAV01', 2 );
Insert Into D_Project_Skill Values ( 'SPL2477', 'NET01', 5 );
Insert Into D_Project_Skill Values ( 'SPL2478', 'ELE01', 2 );
Insert Into D_Project_Skill Values ( 'SPL2478', 'NET01', 3 );


Create Table If Not Exists D_Consultant_Skill
(
 Consultant_Id					Char(9)		Not Null,
 Skill_ID						Char(10)	Not Null,
 Skill_Proficiency				Enum('Beginner', 'Intermediate', 'Advanced')	Not Null,
 Constraint Consultant_Skill_pk Primary Key (Consultant_Id, Skill_ID),
 Constraint Consultant_Skill_Consultant_fk Foreign Key (Consultant_Id) References D_Consultant (Consultant_Id),
 Constraint Consultant_Skill_Skill_fk Foreign Key (Skill_ID) References D_Skill (Skill_ID)
) Engine=InnoDB Default Charset=utf8;

Insert Into D_Consultant_Skill Values ( 'SMI130001', 'ELE01', 'Advanced' );
Insert Into D_Consultant_Skill Values ( 'SMI130001', 'NET01', 'Beginner' );
Insert Into D_Consultant_Skill Values ( 'SMI130001', 'CON01', 'Intermediate' );

Insert Into D_Consultant_Skill Values ( 'TRA010001', 'JAV01', 'Intermediate' );
Insert Into D_Consultant_Skill Values ( 'TRA010001', 'NET01', 'Advanced' );
Insert Into D_Consultant_Skill Values ( 'TRA010001', 'CON01', 'Beginner' );

Insert Into D_Consultant_Skill Values ( 'MCL100001', 'JAV01', 'Advanced' );
Insert Into D_Consultant_Skill Values ( 'MCL100001', 'CAD01', 'Beginner' );

Insert Into D_Consultant_Skill Values ( 'SAK120002', 'ELE01', 'Advanced' );
Insert Into D_Consultant_Skill Values ( 'SAK120002', 'NET01', 'Advanced' );

Insert Into D_Consultant_Skill Values ( 'WAT120001', 'ELE01', 'Intermediate' );
Insert Into D_Consultant_Skill Values ( 'WAT120001', 'NET01', 'Advanced' );
Insert Into D_Consultant_Skill Values ( 'WAT120001', 'CAD01', 'Advanced' );


