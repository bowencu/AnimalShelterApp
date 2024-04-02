<?php
// The preceding tag tells the web server to parse the following text as PHP
// rather than HTML (the default)

// The following 3 lines allow PHP errors to be displayed along with the page
// content. Delete or comment out this block when it's no longer needed.
function displayErrors()
{
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

function createConfig($dbuser, $dbpassword)
{
    $config["dbuser"] = $dbuser;			// change "cwl" to your own CWL
    $config["dbpassword"] = $dbpassword;	// change to 'a' + your student number
    $config["dbserver"] = "dbhost.students.cs.ubc.ca:1522/stu";
    return $config;
}

function initializeDatabaseConnection() 
{
    $config = createConfig("ora_hbhutta3", "a78030533");
    $db_conn = NULL;	// login credentials are used in connectToDB()
    $success = true;	// keep track of errors so page redirects only if there are no errors
    $show_debug_alert_messages = False; // show which methods are being triggered (see debugAlertMessage())

    return $db_conn;
}

function connectToDB() // no change needed
	{
		global $db_conn = initializeDatabaseConnection();
		global $config = createConfig("ora_hbhutta3", "a78030533");

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

function disconnectFromDB() 
	{
		$db_conn = initializeDatabaseConnection();
		debugAlertMessage("Disconnect from Database");
		oci_close($db_conn);
	}
?>