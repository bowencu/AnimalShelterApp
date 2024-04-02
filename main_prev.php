<!-- Test Oracle file for UBC CPSC304
  Created by Jiemin Zhang
  Modified by Simona Radu
  Modified by Jessica Wong (2018-06-22)
  Modified by Jason Hall (23-09-20)
  This file shows the very basics of how to execute PHP commands on Oracle.
  Specifically, it will drop a table, create a table, insert values update
  values, and then query for values
  IF YOU HAVE A TABLE CALLED "demoTable" IT WILL BE DESTROYED

  The script assumes you already have a server set up All OCI commands are
  commands to the Oracle libraries. To get the file to work, you must place it
  somewhere where your Apache server can run it, and you must rename it to have
  a ".php" extension. You must also change the username and password on the
  oci_connect below to be your ORACLE username and password
-->

<?php
// The preceding tag tells the web server to parse the following text as PHP
// rather than HTML (the default)

// The following 3 lines allow PHP errors to be displayed along with the page
// content. Delete or comment out this block when it's no longer needed.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Set some parameters

// Database access configuration
$config["dbuser"] = "ora_hbhutta3";			// change "cwl" to your own CWL
$config["dbpassword"] = "a78030533";	// change to 'a' + your student number
$config["dbserver"] = "dbhost.students.cs.ubc.ca:1522/stu";
$db_conn = NULL;	// login credentials are used in connectToDB()

$success = true;	// keep track of errors so page redirects only if there are no errors

$show_debug_alert_messages = False; // show which methods are being triggered (see debugAlertMessage())

// The next tag tells the web server to stop parsing the text as PHP. Use the
// pair of tags wherever the content switches to PHP
?>

<html>

<head> 
  <title>Animal Shelter App</title> 
</head>

<!--This remains unchanged, just allows us to reset anything the user inserts -->
<body>
  

	<!-- Display current veterinarians so user uses correct vetSIN when inserting -->
	<h2>Show current veterinarians</h2>
	<p>Use one of the given veterinarian SINs when adding a new veterinarian to a hospital.</p>
	<form method="GET" action="main.php">
		<input type="hidden" id="displayVeterinariansRequest" name="displayVeterinariansRequest">
		<input type="submit" name="displayVeterinarians" value="Display"></p>
	</form>


	<!-- Display current hospitals so user uses correct hospitalAddress when inserting -->
	<h2>Show current hospitals</h2>
	<p>Use one the the given hospital addresses when adding a new veterinarian to the hopsital.</p>
	<form method="GET" action="main.php">
		<input type="hidden" id="displayHospitalsRequest" name="displayHospitalsRequest">
		<input type="submit" name="displayHospitals" value="Display"></p>
	</form>

	<h2>Show the veterinarians who currently work at a hopsital</h2> <!-- select * from VeterinarianWorkInfo; -->
	<p>Use one the the given hospital addresses when adding a new veterinarian to the hopsital.</p>
	<p>Also use this to verify that a veterinarian's work address was updated properly.</p>
	<form method="GET" action="main.php">
		<input type="hidden" id="displayHospitalsRequest" name="displayHospitalsRequest">
		<input type="submit" name="displayHospitals" value="Display"></p>
	</form>



	<!--
	The user should be able to specify what values to insert. The insert operation should affect more than one table (i.e., an insert should occur on a table with a foreign key). The chosen query and table(s) should make sense given the context of the application.
	The INSERT operation should be able to handle the case where the foreign key value in the tuple does not exist in the table that is being referred to. This "handling" can either be that the tuple is rejected by the GUI with an appropriate error message or that the values that are being referred to are inserted.
	The tables that the insert operation will run on can be pre-chosen by the group.
	
	
	CREATE TABLE VeterinarianWorkInfo(
		vetSIN char(8),
		hospitalAddress varchar(200),
		PRIMARY KEY (vetSIN, hospitalAddress),
		FOREIGN KEY (hospitalAddress) REFERENCES AnimalHospital
			ON DELETE CASCADE,
		FOREIGN KEY (vetSIN) REFERENCES VeterinarianInfo
			ON DELETE CASCADE
	);
	-->
	<h2>Create new entry for a veterinarian</h2> <!--Insert Values into VeterinarianWorkInfo-->
	<form method="POST" action="main.php">
    	<input type="hidden" id="insertQueryRequest" name="insertQueryRequest">

    	Veterinarian SIN:  <input type="text" name="veterinarianSIN"> <br /><br/>
    	Hospital Address: <input type="text" name="hospitalAddress"> <br /><br/>

		<input type="submit" value="Insert" name="insertSubmit"></p>
	</form>

	<hr />

	<!-- Display current veterinarians so user uses correct vetSIN when inserting -->
	<h2>Current branch information for shelter workers:</h2>
	<p>Use this display to verify that any information was updated properly:</p>
	<form method="GET" action="main.php">
		<input type="hidden" id="displayBranchWorkerRequest" name="displayBranchWorkerRequest">
		<input type="submit" name="displayBranchWorkers" value="Display"></p>
	</form>

	<h2>Update the branch information of of a shelter worker:</h2> <!--UPDATE on WorkerWorksAt2 -->
	<p>The values are case sensitive and if you enter in the wrong case, the update statement will not do anything.</p>
	<p>Check the display of branch information to pick which shelter worker's information to update.</p>
	<form method="POST" action="main.php">
		<input type="hidden" id="updateQueryRequest" name="updateQueryRequest">

		<!-- Must check that branchName is a valid foreign key to WorkerWorksAt2 -->
		Old Branch Name: <input type="text" name="oldBranchName"> <br /><br />
		New Branch Name: <input type="text" name="newBranchName"> <br /><br />

		Old SIN: <input type="text" name="oldSIN"> <br /><br />
		New SIN: <input type="text" name="newSIN"> <br /><br />

		Old Name: <input type="text" name="oldName"> <br /><br />
		New Name: <input type="text" name="newName"> <br /><br />

		Old Role: <input type="text" name="oldRole"> <br /><br />
		New Role: <input type="text" name="newRole"> <br /><br />

		

		<input type="submit" value="Update" name="updateSubmit"></p>
	</form>

	<hr />

	<!--
	CREATE TABLE AnimalMedicalHistory(
		medicalRecordNumber char(9),
		animalName varchar(200) UNIQUE,
		administeringHospital varchar(200),
		yearOfRecord int,
	PRIMARY KEY (medicalRecordNumber),
	FOREIGN KEY (animalName) REFERENCES AnimalHelpedAdopt2
		ON DELETE CASCADE
	);

	CREATE TABLE OwnedAnimal(
		animalName varchar(200),
		ownershipStartDate varchar(200),
		PRIMARY KEY (animalName),
		FOREIGN KEY (animalName) REFERENCES AnimalHelpedAdopt2
			ON DELETE CASCADE
	);

	select * from AnimalMedicalHistory H, OwnedAnimal O where H.animalName = O.animalName and H.yearOfRecord > GIVEN_YEAR
	-->
	<!-- Join operation on OwnedAnimal and AnimalMedicalHistory -->
	
	<h2>Finding the medical history of an owned animal after a given year of record:</h2> 
	<p>Please specify a year of record:</p>
	<form method="POST" action="main.php">
    	<input type="hidden" id="joinQueryRequest" name="joinQueryRequest">
    	Year of record:  <input type="text" name="year"> <br /><br/>
		<input type="submit" value="Join and display" name="joinSubmit"></p>
	</form>

	

	<!--
	General: User Notification
	The user will receive a success or failure notification upon the completion of an insert, 
	update, delete action and will have a way to verify the action's effect on the database.
	-->
	<!-- <h2>Count the number of veterinarians in the database:</h2>
	<p>Verify the insertion and deletion of veterinarians by checking the current number of veterinarians in the database.</p>
	<form method="GET" action="main.php">
		<input type="hidden" id="countTupleRequest" name="countTupleRequest">
		<input type="submit" name="countTuples"></p>
	</form> -->

	<!-- <hr /> -->

	<!-- <h2>Display Tuples in DemoTable</h2>
	<form method="GET" action="oracle-template.php">
		<input type="hidden" id="displayTuplesRequest" name="displayTuplesRequest">
		<input type="submit" name="displayTuples"></p>
	</form> -->


	<?php
	// The following code will be parsed as PHP

	function debugAlertMessage($message)
	{
		global $show_debug_alert_messages;

		if ($show_debug_alert_messages) {
			echo "<script type='text/javascript'>alert('" . $message . "');</script>";
		}
	}

	function executePlainSQL($cmdstr)
	{ //takes a plain (no bound variables) SQL command and executes it
		//echo "<br>running ".$cmdstr."<br>";
		global $db_conn, $success;

		$statement = oci_parse($db_conn, $cmdstr);
		//There are a set of comments at the end of the file that describe some of the OCI specific functions and how they work
		echo $cmdstr;
		if (!$statement) {
			echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
			$e = OCI_Error($db_conn); // For oci_parse errors pass the connection handle
			echo htmlentities($e['message']);
			$success = False;
		}

		$r = oci_execute($statement, OCI_DEFAULT);
		if (!$r) {
			echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
			$e = oci_error($statement); // For oci_execute errors pass the statementhandle
			echo htmlentities($e['message']);
			$success = False;
		}

		return $statement;
	}

	function executeBoundSQL($cmdstr, $list)
	{
		/* Sometimes the same statement will be executed several times with different values for the variables involved in the query.
		In this case you don't need to create the statement several times. Bound variables cause a statement to only be
		parsed once and you can reuse the statement. This is also very useful in protecting against SQL injection.
		See the sample code below for how this function is used */

		global $db_conn, $success;
		$statement = oci_parse($db_conn, $cmdstr);
		echo $cmdstr;
		if (!$statement) {
			echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
			$e = OCI_Error($db_conn);
			echo htmlentities($e['message']);
			$success = False;
		}

		foreach ($list as $tuple) {
			foreach ($tuple as $bind => $val) {
				echo $val;
				// echo "<br>".$bind."<br>";
				oci_bind_by_name($statement, $bind, $val);
				unset($val); //make sure you do not remove this. Otherwise $val will remain in an array object wrapper which will not be recognized by Oracle as a proper datatype
			}

			$r = oci_execute($statement, OCI_DEFAULT);
			if (!$r) {
				echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
				$e = OCI_Error($statement); // For oci_execute errors, pass the statementhandle
				echo htmlentities($e['message']);
				echo "<br>";
				$success = False;
			}
		}
	}

	// function printResult($result)
	// { //prints results from a select statement
	// 	echo "<br>Retrieved data from table demoTable:<br>";
	// 	echo "<table>";
	// 	echo "<tr><th>ID</th><th>Name</th></tr>";

	// 	while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {
	// 		echo "<tr><td>" . $row["ID"] . "</td><td>" . $row["NAME"] . "</td></tr>"; //or just use "echo $row[0]"
	// 	}

	// 	echo "</table>";
	// }

	function printHospitals($result)
	{ //prints results from a select statement
		echo "<br>Displaying the hospitals currently in the database...<br>";
		echo "<table>";
		echo "<tr><th>Name</th><th>Hospital Address</th></tr>";

		while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {
			// echo $row[0]
			echo "<tr><td>" . $row["NAME"] . "</td><td>" . $row["HOSPITALADDRESS"] . "</td></tr>"; //or just use "echo $row[0]"
		}

		echo "</table>";

		echo "<script>";
    	echo "alert('Hospitals have been displayed successfully!');";
    	echo "</script>";
	}

	function printVeterinarians($result)
	{ //prints results from a select statement
		echo "<br>Displaying the veterinarians currently in the database...<br>";
		echo "<table>";
		echo "<tr><th>Veterinarian SIN</th><th>Specialty</th><th>Name</th></tr>";

		while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {
			// echo $row[0]
			echo "<tr><td>" . $row["VETSIN"] . "</td><td>" . $row["SPECIALTY"] . "</td><td>" . $row["NAME"] . "</td></tr>"; //or just use "echo $row[0]"
		}

		echo "</table>";

		echo "<script>";
    	echo "alert('Veterinarians have been displayed successfully!');";
    	echo "</script>";
	}

	function connectToDB()
	{
		global $db_conn;
		global $config;

		// Your username is ora_(CWL_ID) and the password is a(student number). For example,
		// ora_platypus is the username and a12345678 is the password.
		// $db_conn = oci_connect("ora_cwl", "a12345678", "dbhost.students.cs.ubc.ca:1522/stu");
		$db_conn = oci_connect($config["dbuser"], $config["dbpassword"], $config["dbserver"]);

		if ($db_conn) {
			debugAlertMessage("Database is Connected");
			return true;
		} else {
			debugAlertMessage("Cannot connect to Database");
			$e = OCI_Error(); // For oci_connect errors pass no handle
			echo htmlentities($e['message']);
			return false;
		}
	}

	function disconnectFromDB()
	{
		global $db_conn;

		debugAlertMessage("Disconnect from Database");
		oci_close($db_conn);
	}

	function handleUpdateRequest() // Update WorkerWorksAt2
	{
		global $db_conn;

		$old_branchName = $_POST[''];
		$new_branchName = $_POST[''];

		// ....

		// you need the wrap the old name and new name values with single quotations
		executePlainSQL("	UPDATE  SET vetSIN=    '" . $new_vetSIN . "' SET specialty=    '" . $new_specialty . "' SET name=    '" . $new_name . "'     WHERE vetSIN=    '" . $old_vetSIN . "'    WHERE specialty=    '" . $old_specialty . "'    WHERE name=    '" . $old_name . "'    ");
		oci_commit($db_conn);
	}

	// function handleResetRequest()
	// {
	// 	global $db_conn;
	// 	// Drop old table
	// 	executePlainSQL("DROP TABLE demoTable");

	// 	// Create new table
	// 	echo "<br> creating new table <br>";
	// 	executePlainSQL("CREATE TABLE demoTable (id int PRIMARY KEY, name char(30))");
	// 	oci_commit($db_conn);
	// }

	function handleInsertRequest()
	{
		global $db_conn;

		//Getting the values from user and insert data into the table
		$tuple = array(
			":bind1" => $_POST['veterinarianSIN'],
			":bind2" => $_POST['hospitalAddress']
		);

		$alltuples = array(
			$tuple
		);

		executeBoundSQL("INSERT INTO VeterinarianWorkInfo (vetSIN, hospitalAddress) VALUES (:bind1, :bind2);", $alltuples);
    	oci_commit($db_conn);
	}

	function handleCountRequest()
	{
		global $db_conn;

		$result = executePlainSQL("SELECT Count(*) FROM VeterinarianWorkInfo;");

		if (($row = oci_fetch_row($result)) != false) {
			echo "<br> The number of tuples in VeterinarianWorkInfo: " . $row[0] . "<br>";
		}
	}
	
	function handleDisplayHospitalsRequest() 
	{
		global $db_conn;
		$result = executePlainSQL("SELECT * FROM AnimalHospital");
		printHospitals($result);
	}

	function handleDisplayVeterinariansRequest() 
	{
		global $db_conn;
		$result = executePlainSQL("SELECT * FROM VeterinarianInfo");
		printVeterinarians($result);
	}

	function handleJoinRequest()
	{
		global $db_conn;

		// Getting the values from user and insert data into the table
		$year = $_POST['year'];
		$result = executePlainSQL("SELECT H.yearOfRecord FROM AnimalMedicalHistory H, OwnedAnimal O WHERE H.animalName = O.animalName AND H.yearOfRecord > {$year}");
		printResult($result);
	}

	// HANDLE ALL POST ROUTES
	// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
	function handlePOSTRequest()
	{
		if (connectToDB()) {
			else if (array_key_exists('updateQueryRequest', $_POST)) {
				handleUpdateRequest();
			} else if (array_key_exists('insertQueryRequest', $_POST)) {
				handleInsertRequest();
			} else if (array_key_exists('joinQueryRequest', $_POST)) {
				handleJoinRequest();
			}

			disconnectFromDB();
		}
	}

	// HANDLE ALL GET ROUTES
	// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
	function handleGETRequest()
	{
		if (connectToDB()) {
			if (array_key_exists('countTuples', $_GET)) {
				handleCountRequest();
			} 
			elseif (array_key_exists('displayHospitalsRequest', $_GET)) {
				handleDisplayHospitalsRequest();
			} elseif (array_key_exists('displayVeterinariansRequest', $_GET)) {
				handleDisplayVeterinariansRequest();
			}

			disconnectFromDB();
		}
	}

	if (isset($_POST['reset']) || isset($_POST['updateSubmit']) || isset($_POST['insertSubmit']) || isset($_POST['joinSubmit'])) {
		handlePOSTRequest();
	} else if (isset($_GET['countTupleRequest']) || isset($_GET['displayHospitalsRequest']) || isset($_GET['displayVeterinariansRequest']))  {
		handleGETRequest();
	}

	// End PHP parsing and send the rest of the HTML content
	?>
</body>

</html>
