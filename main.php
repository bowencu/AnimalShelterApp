<!-- 
Authors:
Haad Bhutta
Bowen Cui
Triston Tsui

Refer to the GitHub README.md file for function documentation.
-->

<?php
include 'connection.php';
displayErrors();
$db_conn = getDatabaseConnection();
?>

<html>

<head> 
  <title>Animal Shelter App</title> 
</head>

<body>

	<!-- ======================= BEGIN INSERT ======================= -->

	<!-- Display current veterinarians so user uses correct vetSIN when inserting -->
	<h2>Show current veterinarians</h2>
	<form method="GET" action="main.php">
		<input type="hidden" id="displayVeterinariansRequest" name="displayVeterinariansRequest">
		<input type="submit" name="displayVeterinarians" value="Display"></p>
	</form>

	<!-- Display current hospitals so user uses correct hospitalAddress when inserting -->
	<h2>Show current hospitals</h2>
	<form method="GET" action="main.php">
		<input type="hidden" id="displayHospitalsRequest" name="displayHospitalsRequest">
		<input type="submit" name="displayHospitals" value="Display"></p>
	</form>

	<!--Inserting into VeterinarianWorkInfo-->
	<h2>Create new entry for a veterinarian</h2> 
	<form method="POST" action="main.php">
    	<input type="hidden" id="insertQueryRequest" name="insertQueryRequest">

    	Veterinarian SIN:  <input type="text" name="VETSIN"> <br /><br/>
    	Hospital Address: <input type="text" name="HOSPITALADDRESS"> <br /><br/>

		<input type="submit" value="Insert" name="insertSubmit"></p>
	</form>

	<!-- ======================= END INSERT ======================= -->

	<hr />

	<!-- ======================= BEGIN UDPATE ======================= -->
	<h2>Update Name in VeterinarianInfo</h2>
	<p>The values are case sensitive and if you enter in the wrong case, the update statement will not do anything.</p> <!--leave this here-->
	<form method="POST" action="main.php">
		<input type="hidden" id="updateQueryRequest" name="updateQueryRequest">

		Old Veterinarian SIN: <input type="text" name="oldVeterinarianSIN"> <br /><br />
		New Veterinarian SIN: <input type="text" name="newVeterinarianSIN"> <br /><br />
		
		Old Specialty: <input type="text" name="oldSpecialty"> <br /><br />
		New Specialty: <input type="text" name="newSpecialty"> <br /><br />
		
		Name: <input type="text" name="oldName"> <br /><br />
		New Name: <input type="text" name="newName"> <br /><br />

		<input type="submit" value="Update" name="updateSubmit"></p>
	</form>
	<!-- ======================= END UPDATE ======================= -->

	<hr />

	<!-- ======================= BEGIN JOIN ======================= -->

	<h2>Join</h2>
	<p>Display the names of all animal hospitals where a veterinarian works:</p>
	<form method="GET" action="main.php">
		<input type="hidden" id="joinTuplesRequest" name="joinTuplesRequest">
		<input type="submit" name="joinTuples">
	</form>
	<!-- ======================= END JOIN ======================= -->

	<hr />

	<!-- ======================= BEGIN PROJECTION ======================= -->
	<!-- ======================= END PROJECTION ======================= -->



	<h2>Projection</h2>


	<!--
	[Tested and done, 24/03/2024]
	Selection (Haad)

	SELECT *
	FROM AnimalHospital
	-->
	<h2>Display tuples in AnimalHospital</h2>
	<form method="GET" action="main.php">
		<input type="hidden" id="displayTuplesRequest" name="displayTuplesRequest">
		<input type="submit" name="displayTuples"></p>
	</form>

	<hr />

	<!-- ======================= BEGIN COUNT ======================= -->
	<h2>Count the Tuples in VeterinarianWorkInfo</h2>
	<p>Use this to check if creating a new veterinarian worked.</p>
	<form method="GET" action="main.php">
		<input type="hidden" id="countTupleRequest" name="countTupleRequest">
		<input type="submit" name="countTuples"></p>
	</form>
	<!-- ======================= END COUNT ======================= -->

	<hr /> 
	<!-- ======================= BEGIN NESTED AGGREGATION WITH GROUP BY ======================= -->
	
	<!-- ======================= END NESTED AGGREGATION WITH GROUP BY ======================= -->

	<!-- ======================= BEGIN RESET ======================= -->
	<h2>Reset</h2> 
	<p>If you wish to reset the table press on the reset button. If this is the first time you're running this page, you MUST use reset</p>
	<form method="POST" action="main.php"> 
			<input type="hidden" id="resetTablesRequest" name="resetTablesRequest">
			<p><input type="submit" value="Reset" name="reset"></p>
	</form>
	<!-- ======================= END RESET ======================= -->

	<hr />

	<?php
	

	

	function printResult($result)
	{ //prints results from a select statement
		echo "<br>Retrieved data from table:<br>";
		echo "<table>";
		echo "<tr><th>Hospital Address</th><th>Name</th></tr>";

		while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {
			// echo $row[0]
			echo "<tr><td>" . $row["HOSPITALADDRESS"] . "</td><td>" . $row["NAME"] . "</td></tr>"; //or just use "echo $row[0]"
		}

		echo "</table>";
	}

	function printHospitals($result)
	{ //prints results from a select statement
		echo "<br>Hospitals currently in the database:<br>";
		echo "<table>";
		echo "<tr><th>Hospital Name</th><th>Hospital Address</th></tr>";

		while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {
			// echo $row[0]
			echo "<tr><td>" . $row["NAME"] . "</td><td>" . $row["HOSPITALADDRESS"] . "</td></tr>"; //or just use "echo $row[0]"
		}

		echo "</table>";
	}

	function printVeterinarians($result)
	{ //prints results from a select statement
		echo "<br>Veterinarians currently in the database:<br>";
		echo "<table>";
		echo "<tr><th>Veterinarian SIN</th><th>Specialty</th><th>Name</th></tr>";

		while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {
			// echo $row[0]
			echo "<tr><td>" . $row["VETSIN"] . "</td><td>" . $row["SPECIALTY"] . "</td><td>" . $row["NAME"] . "</td></tr>"; //or just use "echo $row[0]"
		}

		echo "</table>";
	}

	// function connectToDB() // no change needed
	// {
	// 	global $db_conn;
	// 	global $config;

	// 	// Your username is ora_(CWL_ID) and the password is a(student number). For example,
	// 	// ora_platypus is the username and a12345678 is the password.
	// 	// $db_conn = oci_connect("ora_cwl", "a12345678", "dbhost.students.cs.ubc.ca:1522/stu");
	// 	// dbuser, dbpassword and dbserver are already specified in the config
	// 	$db_conn = oci_connect($config["dbuser"], $config["dbpassword"], $config["dbserver"]);

	// 	if ($db_conn) {
	// 		debugAlertMessage("Database is Connected");
	// 		return true;
	// 	} else {
	// 		debugAlertMessage("Cannot connect to Database");
	// 		$e = OCI_Error(); // For oci_connect errors pass no handle
	// 		echo htmlentities($e['message']);
	// 		return false;
	// 	}
	// }

	

//   function handleUpdateRequest() 
//   {
// 		global $db_conn;

// 		$old_hospital_address = $_POST['oldHospitalAddress'];
// 		$new_hospital_address = $_POST['newHospitalAddress'];
		
// 		$old_name = $_POST['oldName'];
// 		$new_name = $_POST['newName'];

// 		// you need the wrap the old name and new name values with single quotations
// 		$sql = "UPDATE AnimalHospital 
//             SET name='" . $new_name . "', hospitalAddress='" . $new_hospital_address . "' 
//             WHERE name='" . $old_name . "'";
// 		executePlainSQL($sql);
// 		oci_commit($db_conn);
// 	}


	function handleResetRequest() 
	{
		global $db_conn;
		// Drop old table
		executePlainSQL("DROP TABLE AnimalHospital");

		// Create new table
		echo "<br> creating new table <br>";
		executePlainSQL("CREATE TABLE AnimalHospital (hospitalAddress varchar(200) PRIMARY KEY, name varchar(200))");
		oci_commit($db_conn);
	}


	
	function handleInsertRequest()
	{
		global $db_conn;

		$VETSIN = $_POST['VETSIN'];
		$HOSPITALADDRESS = $_POST['HOSPITALADDRESS'];

		$tuple = array(
			":bind1" => $VETSIN,
			":bind2" => $HOSPITALADDRESS
		);

		$alltuples = array(
			$tuple
		);

		executeBoundSQL("INSERT INTO VeterinarianWorkInfo (vetSIN, hospitalAddress) VALUES (:bind1, :bind2)", $alltuples);
    	oci_commit($db_conn);
	}

	// function checkRecordExists($tableName, $columnName, $value) {
	// 	global $db_conn;

	// 	$query = "SELECT COUNT(*) FROM $tableName WHERE $columnName = :value";
	// 	$parsed = oci_parse($db_conn, $query);
	// 	oci_bind_by_name($statement, ":value", $value);
	// 	oci_execute($parsed);

	// 	$row = OCI_Fetch_Array($parsed, OCI_ASSOC);

	// 	// If count is non-zero, then record exists
	// 	return ($row['COUNT(*)'] > 0); // boolean
	// }

	/* Find the branch(s) that has/have the fewest number of distinct breeds: */
	function handlNestedGroupByRequest() 
	{
		global $db_conn;
		$result = executePlainSQL("SELECT branchName, COUNT(breed) as outer_count FROM AnimalHelpedAdopt2 GROUP BY branchName HAVING COUNT( breed) = (SELECT MIN(inner_count) FROM (SELECT branchName, COUNT(breed) as inner_count FROM AnimalHelpedAdopt2 GROUP BY branchName))"); 
		printResult($result);
	}
	
	function handleCountRequest() 
	{
		global $db_conn;

		$result = executePlainSQL("SELECT COUNT(*) FROM AnimalHospital");

		if (($row = oci_fetch_row($result)) != false) {
			echo "<br> The number of tuples in AnimalHospital: " . $row[0] . "<br>";
		}
	}

	function handleProjectRequest() 
	{
		global $db_conn;
		$result = executePlainSQL("SELECT hospitalAddress FROM AnimalHospital"); 
		printResult($result);
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
		$result = executePlainSQL("SELECT A.hospitalAddress, A.name FROM AnimalHospital A, VeterinarianWorkInfo V WHERE A.hospitalAddress = V.hospitalAddress");
		printResult($result);
	}

	// HANDLE ALL POST ROUTES
	// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
	function handlePOSTRequest()
	{
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
		if (connectToDB()) {
			if (array_key_exists('countTuples', $_GET)) { // count handler
				handleCountRequest(); // (optional) count statement, was already included in the template file
			} elseif (array_key_exists('projectTuples', $_GET)) { // project handler
				handleProjectRequest(); 
			} elseif (array_key_exists('joinTuples', $_GET)) { // join handler
				handleJoinRequest(); 
			} elseif (array_key_exists('displayVeterinarians', $_GET)) { // display vetinfo
				handleDisplayVeterinariansRequest(); 
			} elseif (array_key_exists('displayHospitals', $_GET)) {  // display animalhospital
				handleDisplayHospitalsRequest(); 
			} 

			
			disconnectFromDB();
		}

		
	}
    /*
	GET and POST ids have to match the ids specified above in the queries
	*/
	if (isset($_POST['reset']) || isset($_POST['updateSubmit']) || isset($_POST['insertSubmit'])) {
		handlePOSTRequest();
	} else if (isset($_GET['countTupleRequest']) || isset($_GET['joinTuplesRequest']) || isset($_GET['displayVeterinariansRequest']) || isset($_GET['displayHospitalsRequest']) ) {
		handleGETRequest();
	}

	// End PHP parsing and send the rest of the HTML content
	?>
</body>

</html>
