<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Set some parameters

// Database access configuration
$config["dbuser"] = "ora_cuibowen";			// change "cwl" to your own CWL
$config["dbpassword"] = "a49604481";	// change to 'a' + your student number
$config["dbserver"] = "dbhost.students.cs.ubc.ca:1522/stu";
$db_conn = NULL;	// login credentials are used in connectToDB()
$success = true;	// keep track of errors so page redirects only if there are no errors
$show_debug_alert_messages = False; // show which methods are being triggered (see debugAlertMessage())
?>

<html>

<head>
	<title>CPSC 304: Animal Shelter App</title>
	<style>
        body {
			font-family: Arial, Helvetica, sans-serif;
			background-color: #f9f9f9; /* Light gray background */
			margin: 0; /* Remove default margin */
			padding: 20px; /* Add some padding for content */
			color: #333; /* Dark text color */
			line-height: 1.6; /* Improved readability */
		}

		.container {
			max-width: 800px; /* Limit content width */
			margin: 0 auto; /* Center content */
		}

		h1 {
			font-size: 28px; /* Larger heading size */
			color: #004d40; /* Dark green heading color */
			margin-bottom: 20px; /* Add some space below heading */
		}

		p {
			font-size: 16px; /* Normal paragraph font size */
			margin-bottom: 16px; /* Add some space below paragraphs */
			color: #666; /* Dark gray paragraph color */
		}

    </style>
</head>

<body>
	<h1>CPSC304: Animal Shelter Database</h1>
	<hr />
	<!-- <h2>Reset</h2> -->
	<!-- <p>If you wish to reset the table press on the reset button. If this is the first time you're running this page, you MUST use reset</p> -->

	<!-- <form method="POST" action="main.php">
		<input type="hidden" id="resetTablesRequest" name="resetTablesRequest">
		<p><input type="submit" value="Reset" name="reset"></p>
	</form> -->

	<!-- <hr /> -->

	<!-- ======================= BEGIN TABLE DROPDOWN ======================= -->
	<h2>Choose a table to view</h2>
	<p><i>If you inserted values into a table or updated any entries, you will see it here.</i></p>
	<form method="GET" action="main.php">
		<input type="hidden" id="displayTablesRequest" name="displayTablesRequest">
		<select name="tableName">
			<?php dropDownAllTables(); ?>
		</select>
		<p><input type="submit" name="displayTables"></p>
	</form>

	<!-- ======================= END TABLE DROPDOWN ======================= -->

	<hr />

	<!-- ======================= BEGIN PROJECTION ======================= -->
	<h2>Choose attributes of an animal to view</h2>
	<p><i>Projection on AnimalHelpedAdopt2</i></p>
	<form method="GET" action="main.php">
    	<input type="hidden" id="projectionRequest" name="projectionRequest">

		<input type="checkbox" id="name" name="name">
		<label id="name">Name</label>

		<input type="checkbox" id="age" name="age">
		<label id="age">Age</label>

		<input type="checkbox" id="adoptionProcessDate" name="adoptionProcessDate">
		<label id="adoptionProcessDate">Adoption Process Date</label>

		<input type="checkbox" id="breed" name="breed">
		<label id="breed">Breed</label>

		<input type="checkbox" id="workerSIN" name="workerSIN">
		<label id="workerSIN">Worker SIN</label>

		<input type="checkbox" id="corporationName" name="corporationName">
		<label id="corporationName">Corporation Name</label>

		<input type="checkbox" id="branchName" name="branchName">
		<label id="branchName">Branch Name</label>

		<input type="checkbox" id="animalBranchTag" name="animalBranchTag">
		<label id="animalBranchTag">Animal Branch Tag</label>

		<div>
		<input type="submit" value="View" name="projectionSubmit"></p>
		</div>
	</form>
	<!-- ======================= END PROJECTION ======================= -->

	<hr />

	<!-- ======================= BEGIN INSERT ======================= -->
	<h2>Create new entry for a veterinarian work info</h2> <!--Insert Values into VeterinarianWorkInfo-->
	<p><i>This will modify the VeterinarianWorkInfo table.</i></p>
	<form method="POST" action="main.php">
    	<input type="hidden" id="insertQueryRequest" name="insertQueryRequest">

    	Veterinarian SIN:  <input type="text" name="vetSIN"> <br /><br/>
    	Hospital Address: <input type="text" name="hospitalAddress"> <br /><br/>

		<input type="submit" value="Insert" name="insertSubmit"></p>
	</form>
	<!-- ======================= END INSERT ======================= -->

	<hr />

	<!-- ======================= BEGIN UPDATE ======================= -->
    <h2>Update Animal Name/Administering Hospital in MedicalHistory</h2>
    <p>The medical record number must match a record in our database and the animal name must refer to an existing animal. Otherwise, the update statement will not do anything.</p>

    <form method="POST" action="main.php">
        <input type="hidden" id="updateQueryRequest" name="updateQueryRequest">
        Medical Record Number: <input type="text" name="medicalRecordNumber"> <br /><br />
        New Animal Name: <input type="text" name="animalName"> <br /><br />
        New Administering Hospital: <input type="text" name="administeringHospital"> <br /><br />
        Current Year: <input type="text" name="yearOfRecord"> <br /><br />
        <input type="submit" value="Update" name="updateSubmit"></p>
    </form>
    <!-- ======================= END UPDATE ======================= -->
    <hr />


	<!-- ======================= BEGIN DELETE ======================= -->
	<h2>Delete Animal From Database</h2>
    <p>The animal name must match a record in our database. Otherwise, the update statement will not do anything.</p>

    <form method="POST" action="main.php">
        <input type="hidden" id="deleteQueryRequest" name="deleteQueryRequest">
        Animal Name: <input type="text" name="animalName"> <br /><br />
        <input type="submit" value="Delete" name="deleteSubmit"></p>
    </form>
    <!-- ======================= END DELETE ======================= -->

    <hr />

	<!-- ======================= BEGIN JOIN ======================= -->	
	<h2>Find the animals whose medical history was recorded after the given year.</h2>
	<p><i>Join</i></p> 
	<form method="POST" action="main.php">
    	<input type="hidden" id="joinQueryRequest" name="joinQueryRequest">
    	Year of record:  <input type="text" name="year"> <br /><br/>
		<input type="submit" value="Display" name="joinSubmit"></p>
	</form>
	<!-- ======================= END JOIN ======================= -->	

	<hr />

	<!-- ======================= BEGIN NESTED AGGREGATION WITH GROUP BY ======================= -->	
	<!-- <h2>Nested aggregation with group by:</h2>  -->
	<h2>Find the SINs of the veterinarians who have worked at the fewest number of hospitals.</h2>
	<p><i>Nested aggregation with group by</i></p>
	<form method="GET" action="main.php">
    	<input type="hidden" id="nestedAggregationWithGroupByRequest" name="nestedAggregationWithGroupByRequest">
		<input type="submit" value="Display" name="nestedAggregationWithGroupByRequestSubmit"></p>
	</form>
	<!-- ======================= END NESTED AGGREGATION WITH GROUP BYIN ======================= -->	

	<hr />

	<!-- ======================= BEGIN AGGREGATION WITH GROUP BY ======================= -->	
	<h2>Find the number of animal medical records per year.</h2>
	<p><i>Aggregation with group by</i></p>
	<form method="GET" action="main.php">
    	<input type="hidden" id="aggregationWithGroupByRequest" name="aggregationWithGroupByRequest">
		<input type="submit" value="Display" name="aggregationWithGroupByRequestSubmit"></p>
	</form>
	<!-- ======================= END AGGREGATION WITH GROUP BY ======================= -->	

	<hr />

	<!-- ======================= BEGIN AGGREGATION WITH HAVING ======================= -->	
	<h2>Find the roles that only have one worker working in them.</h2>
	<p><i>Aggregation with having</i></p>
	<form method="GET" action="main.php">
    	<input type="hidden" id="aggregationWithHavingRequest" name="aggregationWithHavingRequest">
		<input type="submit" value="Display" name="aggregationWithHavingRequestSubmit"></p>
	</form>
	<!-- ======================= END AGGREGATION WITH HAVING ======================= -->	

	<hr />


	<!-- ======================= BEGIN DIVISON ======================= -->	
	<!-- divison  
	tables used:
	VeterinarianWorkInfo
	VeterinarianInfo
	AnimalHospital
	-->
	<h2>Find the veterinarians (by their SIN) who have worked at all the hospitals</h2> 
	<p><i>Division</i></p>
	<form method="GET" action="main.php">
		<input type="hidden" id="divisionQueryRequest" name="divisionQueryRequest">
		<input type="submit" name="divisionSubmit"></p>
	</form>
	<!-- ======================= END DIVISON ======================= -->	

	<hr />

	<?php
	// The following code will be parsed as PHP

	function dropDownAllTables() {
		if(connectToDB()) {
			$sql = "SELECT table_name FROM user_tables";
			$result = executePlainSQL($sql);
			while ($row = oci_fetch_assoc($result)) {
                echo '<option value="' . $row['TABLE_NAME'] . '">' . $row['TABLE_NAME'] . '</option>';
            }
			
			disconnectFromDB();
		}
	}

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

	function printTables($result, $str)
	{
		//prints results
		echo "<div id='resultContainer'>";
		echo "<br>Retrieved data from " . $str . ":<br>";
		echo "<br>";
		echo "<table>";
	
		// Fetch the column names from the result set
		$columns = [];
		$numberOfColumns = oci_num_fields($result);
	
		for ($i = 1; $i <= $numberOfColumns; $i++) {
			$column = oci_field_name($result, $i);
			$columns[] = $column;
		}
	
		// Print the table header with column names
		echo "<tr>";
		foreach ($columns as $column) {
			echo "<th>$column</th>";
		}
		echo "</tr>";
	
		// Loop through each row in the result set
		while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {
			// Print each row in an HTML table
			echo "<tr>";
			foreach ($columns as $column) {
				if (array_key_exists($column, $row)) {
					echo "<td>    " . $row[$column] . "    </td>";
				} else {
					echo "<td>" . "" . "</td>";
				}
				
			}
			echo "</tr>";
		}
		echo "</div>";
	}	

	function printJoinResult($result)
	{ //prints results from a select statement
		// echo "<br>Retrieved data from table demoTable:<br>";
		echo "<table>";
		echo "<tr><th>animalName</th><th>medicalRecordNumber</th></tr>";

		while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {
			echo "<tr><td>" . $row["ANIMALNAME"] . "</td><td>" . $row["MEDICALRECORDNUMBER"] . "</td><td>"; //or just use "echo $row[0]"
		}

		echo "</table>";
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

	function handleUpdateRequest() {
		global $db_conn;
	
		$medical_record_number = $_POST['medicalRecordNumber'];
		$animal_name = $_POST['animalName'];
		$administering_hospital = $_POST['administeringHospital'];
		$year = $_POST['yearOfRecord'];

		$exists = executePlainSQL("SELECT COUNT(*) FROM AnimalMedicalHistory WHERE medicalRecordNumber = '$medical_record_number'");
		$row = oci_fetch_array($exists, OCI_BOTH);
		if ($row[0] == 0) {
			echo '<script>alert("Could not update medical history. The medical record number does not exist in Veterinarian Info.");</script>';
			return;
		}

		if (!preg_match('/^\d{4}$/', $year)) {
			echo '<script>alert("Error: Year must be an 4-digit number.");</script>';
			return;
		}
	
		$animal_exists = executePlainSQL("SELECT COUNT(*) FROM AnimalHelpedAdopt2 WHERE name = '$animal_name'");
		$row = oci_fetch_array($animal_exists, OCI_BOTH);
	
		// If animalName does not exist, do nothing and return
		if ($row[0] == 0) {
			echo '<script>alert("Animal with name \'' . $animal_name . '\' does not exist in the referenced table. Update query aborted.");</script>';
			// echo "Animal with name '$animal_name' does not exist in the referenced table. Update query aborted.";
			return;
		}

		$exists = executePlainSQL("SELECT COUNT(*) FROM VeterinarianInfo WHERE vetSIN = '$VETSIN'");
		$row = oci_fetch_array($exists, OCI_BOTH);
		if ($row[0] == 0) {
			echo '<script>alert("Could not create a new veterinarian work info. The vet SIN does not exist in Veterinarian Info.");</script>';
			return;
		}
	
		// If animalName exists, proceed with the update query
		executePlainSQL("UPDATE AnimalMedicalHistory SET animalName='$animal_name', administeringHospital='$administering_hospital', yearOfRecord='$year' WHERE medicalRecordNumber='$medical_record_number'");
		oci_commit($db_conn);
		echo '<script>alert("Successfully updated medical history for \'' . $animal_name . '\'");</script>';
		echo "Successfully updated medical history for '$animal_name'";
	}


	function handleDeleteRequest() {
		global $db_conn;
	
		$animal_name = $_POST['animalName'];
	
		$animal_exists = executePlainSQL("SELECT COUNT(*) FROM AnimalHelpedAdopt2 WHERE name = '$animal_name'");
		$row = oci_fetch_array($animal_exists, OCI_BOTH);
	
		// If animalName does not exist, do nothing and return
		if ($row[0] == 0) {
			echo '<script>alert("Animal with name \'' . $animal_name . '\' does not exist in the database. Delete query aborted.");</script>';
			return;
		}
	
		// If animalName exists, proceed with the delete query
		executePlainSQL("DELETE FROM AnimalHelpedAdopt2 WHERE name='$animal_name'");
		oci_commit($db_conn);
		echo '<script>alert("Successfully deleted animal \'' . $animal_name . '\'");</script>';
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


	function handleProjectionRequest() 
	{
		global $db_conn;
		// Define the array to store selected attributes
		$selectedAttributes = [];

		// Check if each attribute checkbox is selected
		if(isset($_GET['name'])) {
			$selectedAttributes[] = 'name';
		}
		if(isset($_GET['age'])) {
			$selectedAttributes[] = 'age';
		}
		if(isset($_GET['adoptionProcessDate'])) {
			$selectedAttributes[] = 'adoptionProcessDate';
		}
		if(isset($_GET['breed'])) {
			$selectedAttributes[] = 'breed';
		}
		if(isset($_GET['workerSIN'])) {
			$selectedAttributes[] = 'workerSIN';
		}
		if(isset($_GET['corporationName'])) {
			$selectedAttributes[] = 'corporationName';
		}
		if(isset($_GET['branchName'])) {
			$selectedAttributes[] = 'branchName';
		}
		if(isset($_GET['animalBranchTag'])) {
			$selectedAttributes[] = 'animalBranchTag';
		}

		if (empty($selectedAttributes)) {
			$query = "SELECT * FROM AnimalHelpedAdopt2";
		} else {
			$query = "SELECT ";
			$query .= implode(", ", $selectedAttributes);
			$query .= " FROM AnimalHelpedAdopt2";
		}

		$result = executePlainSQL($query);

		printProjectionResult($result, $selectedAttributes);
		oci_commit($db_conn);
		// echo '<script>alert("Successfully projected on attributes in AnimalHelpedAdopt2");</script>';
	}

	function printProjectionResult($result, $selectedAttributes)
	{
		echo "<br>Projection result:<br>";
		echo "<table>";

		echo "<tr>";
		foreach ($selectedAttributes as $column) {
			echo "<th>" . $column . "</th>";
		}
		echo "</tr>";
	
		while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {
			echo "<tr>";
			foreach ($row as $val) {
				echo "<td>" . $val . "</td>";
			}
			echo "</tr>";
		}
	
		echo "</table>";
	}
	

	

	function handleInsertRequest()
	{
		global $db_conn;

		$VETSIN = $_POST['vetSIN'];
		$HOSPITALADDRESS = $_POST['hospitalAddress'];

		$tuple = array(
			":bind1" => $VETSIN,
			":bind2" => $HOSPITALADDRESS
		);

		$alltuples = array(
			$tuple
		);

		if (!preg_match('/^\d{8}$/', $VETSIN)) {
			echo '<script>alert("Error: VETSIN must be an 8-digit number.");</script>';
			return;
		}

		$exists = executePlainSQL("SELECT COUNT(*) FROM VeterinarianWorkInfo WHERE vetSIN = '$VETSIN' and hospitalAddress = '$HOSPITALADDRESS'");
		$row = oci_fetch_array($exists, OCI_BOTH);
		if ($row[0] > 0) {
			echo '<script>alert("Could not create a new veterinarian work info. The work info with the provided vet SIN and hospital address already exists.");</script>';
			return;
		}

		$exists = executePlainSQL("SELECT COUNT(*) FROM VeterinarianInfo WHERE vetSIN = '$VETSIN'");
		$row = oci_fetch_array($exists, OCI_BOTH);
		if ($row[0] == 0) {
			echo '<script>alert("Could not create a new veterinarian work info. The vet SIN does not exist in Veterinarian Info.");</script>';
			return;
		}

		$exists = executePlainSQL("SELECT COUNT(*) FROM AnimalHospital WHERE hospitalAddress = '$HOSPITALADDRESS'");
		$row = oci_fetch_array($exists, OCI_BOTH);
		if ($row[0] == 0) {
			echo '<script>alert("Could not create a new veterinarian work info. The hospital address does not exist in AnimalHospital table.");</script>';
			return;
		}

		executeBoundSQL("INSERT INTO VeterinarianWorkInfo (vetSIN, hospitalAddress) VALUES (:bind1, :bind2)", $alltuples);
		oci_commit($db_conn);
		echo '<script>alert("Successfully created a new veterinarian work info!");</script>';
	}

	function handleJoinRequest()
    {
        global $db_conn;

		$year = $_POST['year'];

		if (!preg_match('/^\d{4}$/', $year)) {
			echo '<script>alert("Error: year must be an 4-digit number.");</script>';
			return;
		}

        // this query works in sqlplus in the terminal for a specific yearOfRecord value
        $result = executePlainSQL("SELECT O.animalName, H.medicalRecordNumber FROM AnimalMedicalHistory H, OwnedAnimal O WHERE H.animalName = O.animalName AND H.yearOfRecord > " . $year . "");
        printJoinResult($result);
		oci_commit($db_conn);
		
    }

	// Find the veterinarians (by SIN) who work at the fewest number of hospitals
	/*
	Using VeterinarianInfo table:

	GROUP BY 
	*/
	function handleNestedAggregationWithGroupByRequest() 
	{
		global $db_conn;
		$nested_agg_query = "SELECT vetSIN
		FROM (
			SELECT vetSIN, COUNT(DISTINCT hospitalAddress) AS hospital_count
			FROM VeterinarianWorkInfo
			GROUP BY vetSIN
		) hospital_counts
		WHERE hospital_count = (
			SELECT MIN(hospital_count)
			FROM (
				SELECT COUNT(DISTINCT hospitalAddress) AS hospital_count
				FROM VeterinarianWorkInfo
				GROUP BY vetSIN
			) min_hospital_counts
		)";

		// SELECT vetSIN FROM (SELECT vetSIN, COUNT(DISTINCT hospitalAddress) AS hospital_count FROM VeterinarianWorkInfo GROUP BY vetSIN) hospital_counts WHERE hospital_count = (SELECT MIN(hospital_count) FROM (SELECT COUNT(DISTINCT hospitalAddress) AS hospital_count FROM VeterinarianWorkInfo GROUP BY vetSIN) min_hospital_counts);

		$result = executePlainSQL($nested_agg_query);
		printNestedAggregationResult($result);
		oci_commit($db_conn);
	}
	

	function printNestedAggregationResult($result) 
	{
		echo "<br>Retrieved result from nested aggregation with group by:<br>";
		echo "<table>";
		echo "<tr><th>vetSIN</th></tr>";

		while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {
			echo "<tr><td>" . $row["VETSIN"] . "</td></tr>"; //or just use "echo $row[0]"
		}

		echo "</table>";
	}



	function handleAggregationWithGroupByRequest() 
	{
		global $db_conn;
		$agg_query = "SELECT yearOfRecord, COUNT(*) AS NumberOfRecords
							FROM AnimalMedicalHistory
							GROUP BY yearOfRecord
							ORDER BY yearOfRecord";
		$result = executePlainSQL($agg_query);
		printAggregationGroupByResult($result);
		oci_commit($db_conn);
	}

	function printAggregationGroupByResult($result) {
		echo "<br>Aggregation result:<br>";
		echo "<table>";
		echo "<tr><th>Year</th><th>Number of Records</th></tr>";
	
		while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {
			echo "<tr><td>" . $row["YEAROFRECORD"] . "</td><td>" . $row["NUMBEROFRECORDS"] . "</td></tr>";
		}
	
		echo "</table>";
	}

	function handleAggregationWithHavingRequest() 
	{
		global $db_conn;
		$agg_query = "SELECT role
							FROM WorkerWorksAt2
							GROUP BY role
							HAVING COUNT(*) <= 1";
		$result = executePlainSQL($agg_query);
		printAggregationHavingResult($result);
		oci_commit($db_conn);
	}

	function printAggregationHavingResult($result) {
		echo "<br>Aggregation result:<br>";
		echo "<table>";
		echo "<tr><th>Role</th></tr>";
	
		while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {
			echo "<tr><td>" . $row["ROLE"] . "</td></tr>";
		}
	
		echo "</table>";
	}
	

	// Find the veterinarians (from VeterinarianInfo) who have worked at all hospitals (from AnimalHospital)
	function handleDivisionRequest() 
	{
		global $db_conn;
		$division_query = "SELECT DISTINCT VI.vetSIN, VI.name
		FROM VeterinarianInfo VI
		WHERE NOT EXISTS (
			SELECT AH.hospitalAddress
			FROM AnimalHospital AH
			WHERE NOT EXISTS (
				SELECT *
				FROM VeterinarianWorkInfo VW
				WHERE VW.vetSIN = VI.vetSIN
				AND VW.hospitalAddress = AH.hospitalAddress
			)
		)";
		$result = executePlainSQL($division_query);
		printDivisionResult($result);
		oci_commit($db_conn);
	}

	function printDivisionResult($result)
	{ //prints results from a select statement
		echo "<br>Retrieved division result:<br>";
		echo "<table>";
		echo "<tr><th>vetSIN</th><th>Name</th></tr>";

		while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {
			echo "<tr><td>" . $row["VETSIN"] . "</td><td>" . $row["NAME"] . "</td></tr>"; //or just use "echo $row[0]"
		}

		echo "</table>";
	}

	function handleDisplayTablesRequest()
	{
		global $db_conn;
		$table_name = $_GET['tableName'];


		$result = executePlainSQL("SELECT * FROM " . $table_name);
		$column = oci_field_name($result, 1);
		$result = executePlainSQL("SELECT * FROM " . $table_name . " ORDER BY " . $column . " ASC");

		$str = "table <b>" . $table_name . "</b>";
		printTables($result, $str);
	}
	

	// HANDLE ALL POST ROUTES
	// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
	function handlePOSTRequest()
	{
		if (connectToDB()) {
			if (array_key_exists('updateQueryRequest', $_POST)) {
				handleUpdateRequest();
			} else if (array_key_exists('insertQueryRequest', $_POST)) {
				handleInsertRequest();
			} else if (array_key_exists('joinQueryRequest', $_POST)) {
				handleJoinRequest();
			} else if (array_key_exists('deleteQueryRequest', $_POST)) {
				handleDeleteRequest();
			}

			disconnectFromDB();
		}
	}

	

	// HANDLE ALL GET ROUTES
	// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
	function handleGETRequest()
	{
		if (connectToDB()) {
			if (array_key_exists('displayTables', $_GET)) {
				handleDisplayTablesRequest();
			} else if (array_key_exists('divisionQueryRequest', $_GET)) {
				handleDivisionRequest();
			} elseif (array_key_exists('nestedAggregationWithGroupByRequest', $_GET)) {
				handleNestedAggregationWithGroupByRequest();
			} elseif (array_key_exists('projectionQueryRequest', $_GET)) {
				handleProjectionRequest($_GET['tableName']);
			} elseif (array_key_exists('aggregationWithGroupByRequest', $_GET)) {
				handleAggregationWithGroupByRequest();
			} elseif (array_key_exists('aggregationWithHavingRequest', $_GET)) {
				handleAggregationWithHavingRequest();
			} elseif (array_key_exists('projectionRequest', $_GET)) {
				handleProjectionRequest();
			}

			disconnectFromDB();
		}
	}

	if (isset($_POST['updateSubmit']) || isset($_POST['insertSubmit']) || isset($_POST['joinSubmit']) || isset($_POST['deleteSubmit'])) {
		handlePOSTRequest();
	} else if (isset($_GET['displayTablesRequest']) || isset($_GET['divisionQueryRequest']) || isset($_GET['nestedAggregationWithGroupByRequestSubmit']) || isset($_GET['aggregationWithGroupByRequestSubmit']) || isset($_GET['aggregationWithHavingRequestSubmit']) || isset($_GET['projectionSubmit']))  {
		handleGETRequest();
	}

	// End PHP parsing and send the rest of the HTML content
	?>
</body>

</html>