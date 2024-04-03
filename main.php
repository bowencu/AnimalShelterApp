<?php
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
	<title>CPSC 304: Animal Shelter App</title>
</head>

<body>
	<h2>Reset</h2>
	<p>If you wish to reset the table press on the reset button. If this is the first time you're running this page, you MUST use reset</p>

	<form method="POST" action="main.php">
		<!-- "action" specifies the file or page that will receive the form data for processing. As with this example, it can be this same file. -->
		<input type="hidden" id="resetTablesRequest" name="resetTablesRequest">
		<p><input type="submit" value="Reset" name="reset"></p>
	</form>

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

	<!-- ======================= BEGIN INSERT ======================= -->
	<h2>Create new entry for a veterinarian</h2> <!--Insert Values into VeterinarianWorkInfo-->
	<p><i>This will modify the VeterinarianWorkInfo table.</i></p>
	<form method="POST" action="main.php">
    	<input type="hidden" id="insertQueryRequest" name="insertQueryRequest">

    	Veterinarian SIN:  <input type="text" name="vetSIN"> <br /><br/>
    	Hospital Address: <input type="text" name="hospitalAddress"> <br /><br/>

		<input type="submit" value="Insert" name="insertSubmit"></p>
	</form>
	<!-- ======================= END INSERT ======================= -->

	<hr />


	<!-- ======================= BEGIN JOIN ======================= -->	
	<h2>Finding the medical history of an owned animal after a given year of record:</h2> 
	<form method="POST" action="main.php">
    	<input type="hidden" id="joinQueryRequest" name="joinQueryRequest">
    	Year of record:  <input type="text" name="year"> <br /><br/>
		<input type="submit" value="Join and display" name="joinSubmit"></p>
	</form>
	<!-- ======================= END JOIN ======================= -->	

	<hr />

	<!-- ======================= BEGIN NESTED AGGREGATION WITH GROUP BY ======================= -->	
	<h2>Nested aggregation with group by:</h2> 
	<form method="POST" action="main.php">
    	<input type="hidden" id="nestedAggregationQueryRequest" name="nestedAggregationQueryRequest">
    	Year of record:  <input type="text" name="year"> <br /><br/>
		<input type="submit" value="Display	" name="nestedAggregationSubmit"></p>
	</form>
	<!-- ======================= END NESTED AGGREGATION WITH GROUP BYIN ======================= -->	

	<hr />

	<!-- ======================= BEGIN DIVISON ======================= -->	
	<h2>Find the veterinarians who have worked at all the hospitals</h2> <!-- divison  -->
	<p>The values are case sensitive and if you enter in the wrong case, the update statement will not do anything.</p>
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
		echo "<br>Retrieved data from table demoTable:<br>";
		echo "<table>";
		echo "<tr><th>ID</th><th>Name</th></tr>";

		while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {
			echo "<tr><td>" . $row["YEAROFRECORD "] . "</td><td>"; //or just use "echo $row[0]"
		}

		echo "</table>";
	}

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

	function handleUpdateRequest()
	{
		global $db_conn;

		$old_name = $_POST['oldName'];
		$new_name = $_POST['newName'];

		// you need the wrap the old name and new name values with single quotations
		executePlainSQL("UPDATE demoTable SET name='" . $new_name . "' WHERE name='" . $old_name . "'");
		oci_commit($db_conn);
	}

	function handleResetRequest()
	{
		global $db_conn;
		// Drop old table
		executePlainSQL("DROP TABLE demoTable");

		// Create new table
		echo "<br> creating new table <br>";
		executePlainSQL("CREATE TABLE demoTable (id int PRIMARY KEY, name char(30))");
		oci_commit($db_conn);
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

		executeBoundSQL("INSERT INTO VeterinarianWorkInfo (vetSIN, hospitalAddress) VALUES (:bind1, :bind2)", $alltuples);
		oci_commit($db_conn);
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

	function printHospitals($result)
	{ //prints results from a select statement
		echo "<br>Hospitals currently in the database:<br>";
		echo "<table>";
		echo "<tr><th>Hospital Name</th><th>Hospital Address</th></tr>";

		while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {
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
			echo "<tr><td>" . $row["VETSIN"] . "</td><td>" . $row["SPECIALTY"] . "</td><td>" . $row["NAME"] . "</td></tr>"; //or just use "echo $row[0]"
		}

		echo "</table>";
	}

	function handleCountRequest()
	{
		global $db_conn;

		$result = executePlainSQL("SELECT Count(*) FROM demoTable");

		if (($row = oci_fetch_row($result)) != false) {
			echo "<br> The number of tuples in demoTable: " . $row[0] . "<br>";
		}
	}

	function handleDisplayRequest()
	{
		global $db_conn;
		$result = executePlainSQL("SELECT * FROM demoTable");
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

	function handleSelectRequest() 
	{
		global $db_conn;

	}

	function handleJoinRequest()
    {
        global $db_conn;

        // Getting the values from user and insert data into the table
        $tuple = array(
            ":bind1" => $_POST['year']
        );

        $alltuples = array(
            $tuple
        );
        echo $tuple[":bind1"]; // works, prints out value that was posted

        // this query works in sqlplus in the terminal for a specific yearOfRecord value
        $result = executePlainSQL("SELECT * FROM AnimalMedicalHistory H, OwnedAnimal O WHERE H.animalName = O.animalName");
        printJoinResult($result);
		// oci_commit($db_conn);
    }

	function handleNestedAggregationWithGroupByRequest() 
	{
		global $db_conn;
	}

	function handleDivisonRequest() 
	{
		global $db_conn;
	}

	function handleDisplayTablesRequest()
	{
		global $db_conn;
		$table = $_GET['tableName'];

		$query = executePlainSQL("SELECT * FROM " . $table);
		$column = oci_field_name($result, 1);
		$query = executePlainSQL("SELECT * FROM " . $table . " ORDER BY " . $column . " ASC");

		$cmdstr = "table <b>" . $table . "</b>";
		printTables($query, $cmdstr);
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
			} elseif (array_key_exists('displayHospitalsRequest', $_GET)) {
				handleDisplayHospitalsRequest();
			} elseif (array_key_exists('displayVeterinariansRequest', $_GET)) {
				handleDisplayVeterinariansRequest();
			} elseif (array_key_exists('displayTables', $_GET)) {
				handleDisplayTablesRequest();
			} elseif (array_key_exists('displayTables', $_GET)) {
				handleDisplayTablesRequest();
			} elseif (array_key_exists('displayTables', $_GET)) {
				handleNestedAggregationWithGroupByRequest();
			} 

			disconnectFromDB();
		}
	}

	if (isset($_POST['reset']) || isset($_POST['updateSubmit']) || isset($_POST['insertSubmit']) || isset($_POST['joinSubmit']) || isset($_POST['insertSubmit'])) {
		handlePOSTRequest();
	} else if (isset($_GET['countTupleRequest']) || isset($_GET['displayHospitalsRequest']) || isset($_GET['displayVeterinariansRequest']) || isset($_GET['displayTablesRequest']))  {
		handleGETRequest();
	}

	// End PHP parsing and send the rest of the HTML content
	?>
</body>

</html>
