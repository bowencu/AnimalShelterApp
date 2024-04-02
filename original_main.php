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
  
  RUN WITH LINK: https://www.students.cs.ubc.ca/~hbhutta3/oracle-test.php

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
  <h2>Reset</h2> <!-- Done, no change needed -->
  <p>If you wish to reset the table press on the reset button. If this is the first time you're running this page, you MUST use reset</p>
  <form method="POST" action="main.php"> 
		<input type="hidden" id="resetTablesRequest" name="resetTablesRequest">
		<p><input type="submit" value="Reset" name="reset"></p>
  </form>

	<hr />

	<!--
	Finished by Haad, using this insert query from M2:
	INSERT 
	INTO AnimalStayInfo(animalName, animalBranchTag)
	VALUES (‘Bella’, ‘zxcvbnmas’);
	-->
	<h2>Insert Values into AnimalStayInfo</h2> 
	<form method="POST" action="main.php">
    	<input type="hidden" id="insertQueryRequest" name="insertQueryRequest">

    	Animal Name: 	   <input type="text" name="animalName"> <br /><br/>
    	Animal Branch Tag: <input type="text" name="animalBranchTag"> <br /><br/>

		<input type="submit" value="Insert" name="insertSubmit"></p>
	</form>

	<hr />

	


	<!--
	Finished by Bowen, using this update query:
	UPDATE AnimalMedicalHistory
	SET animalName = 'Bowen',
		administeringHospital = 'Vancouver General Hospital'
	WHERE medicalRecordNumber = '123'
	-->
	<h2>Update Animal Name/Administering Hospital in MedicalHistory</h2>
	<p>The medical record number must match a record in our database. Otherwise, the update statement will not do anything.</p>

	<form method="POST" action="main.php">
		<input type="hidden" id="updateQueryRequest" name="updateQueryRequest">
		Medical Record Number: <input type="text" name="medicalRecordNumber"> <br /><br />
		New Animal Name: <input type="text" name="animalName"> <br /><br />
		New Administering Hospital: <input type="text" name="administeringHospital"> <br /><br />
		<input type="submit" value="Update" name="updateSubmit"></p>
	</form>

	<hr />

	<!--
		Use this query for debugging to check if your delete and insert statements are working.
		The number of entries in the chosen table should increase and decrease appropriately.

		For example, if we perform three insert queries into AnimalStayInfo,
		the count should increase be 3.
	-->
	<h2>Count the Tuples in AnimalStayInfo</h2>
	<form method="GET" action="main.php">
		<input type="hidden" id="countTupleRequest" name="countTupleRequest">
		<input type="submit" name="countTuples"></p>
	</form>

	<hr />

	<!--
	Finished by Haad using this query:
	SELECT *
	FROM AnimalStayInfo
	-->
	<h2>Display tuples in AnimalStayInfo</h2>
	<form method="GET" action="main.php">
		<input type="hidden" id="displayTuplesRequest" name="displayTuplesRequest">
		<input type="submit" name="displayTuples"></p>
	</form>


	<?php
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

		if (!$statement) {
			echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
			$e = OCI_Error($db_conn);
			echo htmlentities($e['message']);
			$success = False;
		}

		foreach ($list as $tuple) {
			foreach ($tuple as $bind => $val) {
				//echo $val;
				//echo "<br>".$bind."<br>";
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

	function printResult($result)
	{ //prints results from a select statement
		echo "<br>Retrieved data from table demoTable:<br>";
		echo "<table>";
		echo "<tr><th>ID</th><th>Name</th></tr>";

		while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {
			echo "<tr><td>" . $row["ID"] . "</td><td>" . $row["NAME"] . "</td></tr>"; //or just use "echo $row[0]"
		}

		echo "</table>";
	}

	function connectToDB() // no change needed
	{
		global $db_conn;
		global $config;

		// Your username is ora_(CWL_ID) and the password is a(student number). For example,
		// ora_platypus is the username and a12345678 is the password.
		// $db_conn = oci_connect("ora_cwl", "a12345678", "dbhost.students.cs.ubc.ca:1522/stu");
		// dbuser, dbpassword and dbserver are already specified in the config
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

	function disconnectFromDB() // no changed needed
	{
		global $db_conn;

		debugAlertMessage("Disconnect from Database");
		oci_close($db_conn);
	}

  function handleUpdateRequest() // Change table name based on update statement (Bowen)
  {
		global $db_conn;

		$medical_record_number = $_POST['medicalRecordNumber'];
		$animal_name = $_POST['animalName'];
		$administering_hospital = $_POST['administeringHospital'];

    // you need to wrap the medical record number, animal name, and administering hospital values with single quotations
    executePlainSQL("UPDATE AnimalMedicalHistory SET animalName='" . $animal_name . "', administeringHospital='" . $administering_hospital . "' WHERE medicalRecordNumber='" . $medical_record_number . "'");
    oci_commit($db_conn);
	}


	function handleResetRequest() // NEEDS TO BE CHANGED
	{
		global $db_conn;
		// Drop old table
		executePlainSQL("DROP TABLE demoTable");

		// Create new table
		echo "<br> creating new table <br>";
		executePlainSQL("CREATE TABLE demoTable (id int PRIMARY KEY, name char(30))");
		oci_commit($db_conn);
	}

	/*
	INSERT
	INTO AnimalStayInfo(animalName, animalBranchTag)
	VALUES (‘Bella’, ‘zxcvbnmas’);
	*/
	function handleInsertRequest() // Finished by Haad
	{
		global $db_conn;

		//Getting the values from user and insert data into the table
		$tuple = array(
			":bind1" => $_POST['Bella'],
			":bind2" => $_POST['zxcvbnmas']
		);

		$alltuples = array(
			$tuple
		);

		executeBoundSQL("insert into AnimalStayInfo(animalName, animalBranchTag) values (:bind1, :bind2)", $alltuples);
		oci_commit($db_conn);
	}

	
	function handleCountRequest() // NEEDS TO BE CHANGED
	{
		global $db_conn;

		$result = executePlainSQL("SELECT Count(*) FROM AnimalStayInfo");

		if (($row = oci_fetch_row($result)) != false) {
			echo "<br> The number of tuples in AnimalStayInfo: " . $row[0] . "<br>";
		}
	}

	// How to select specific columns/attributes? Does
	function handleProjectRequest() 
	{
		global $db_conn;
		// One option is to hard-code the attributes we want from the projection
		$result = executePlainSQL("SELECT animalBranchTag FROM AnimalStayInfo"); // this line will be different from the display request
		printResult($result);
	}

	/*
	SELECT *
	FROM AnimalStayInfo
	*/
	function handleDisplayRequest() // Finished by Haad
	{
		global $db_conn;
		$result = executePlainSQL("SELECT * FROM AnimalStayInfo");
		printResult($result);
	}

	// HANDLE ALL POST ROUTES
	// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
	function handlePOSTRequest()
	{
		/*	
		List of queries associated with POST request:
		- Insert
		- Update
		- 
		-
		-

		*/
		if (connectToDB()) {
			if (array_key_exists('resetTablesRequest', $_POST)) {
				handleResetRequest();
			} else if (array_key_exists('updateQueryRequest', $_POST)) {
				handleUpdateRequest();
			} else if (array_key_exists('insertQueryRequest', $_POST)) {
				handleInsertRequest();
			}

			disconnectFromDB();
		}
	}

	// HANDLE ALL GET ROUTES
	// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
	function handleGETRequest()
	{
		/*	
		Typically the queries associated the GET request will have the line printResult($result); at the end of their handlers.

		List of queries associated with GET request:
		- Select 
		- Project 
		*/
		if (connectToDB()) {
			if (array_key_exists('countTuples', $_GET)) { // count handler
				handleCountRequest(); // (optional) count statement, was already included in the template file
			} elseif (array_key_exists('displayTuples', $_GET)) { // select handler
				handleDisplayRequest(); // Select statement
			} elseif (array_key_exists('projectTuples', $_GET)) { // project handler
				handleProjectRequest(); 
			} 
			disconnectFromDB();
		}
	}
    /*
	GET and POST ids have to match the ids specified above in the queries
	*/
	if (isset($_POST['reset']) || isset($_POST['updateSubmit']) || isset($_POST['insertSubmit'])) {
		handlePOSTRequest();
	} else if (isset($_GET['countTupleRequest']) || isset($_GET['displayTuplesRequest'])) {
		handleGETRequest();
	}

	// End PHP parsing and send the rest of the HTML content
	?>
</body>

</html>