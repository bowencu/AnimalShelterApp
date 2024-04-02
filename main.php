<!-- 
Authors:
Haad Bhutta
Bowen Cui
Triston Tsui

Refer to the GitHub README.md file for function documentation.
-->

<?php
// Connection
include 'connection.php';
displayErrors();
$db_conn = getDatabaseConnection();
$config = createConfig("ora_hbhutta3", "a78030533");

// Utils and execution
include 'utils.php';

// Handlers
include 'routers.php';
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
	
	<?php
    /*
	GET and POST ids have to match the ids specified above in the queries
	*/
	if (isset($_POST['insertSubmit'])) {
		handlePOSTRequest();
	} else if (isset($_GET['displayVeterinariansRequest']) || isset($_GET['displayHospitalsRequest']) ) {
		handleGETRequest();
	}

	// End PHP parsing and send the rest of the HTML content
	?>
</body>

</html>