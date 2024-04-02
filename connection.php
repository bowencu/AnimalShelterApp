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

function getDatabaseConnection() 
{
    $config["dbuser"] = "ora_hbhutta3";			// change "cwl" to your own CWL
    $config["dbpassword"] = "a78030533";	// change to 'a' + your student number
    $config["dbserver"] = "dbhost.students.cs.ubc.ca:1522/stu";
    $db_conn = NULL;	// login credentials are used in connectToDB()
    
    $success = true;	// keep track of errors so page redirects only if there are no errors
    
    $show_debug_alert_messages = False; // show which methods are being triggered (see debugAlertMessage())

    return $db_conn;
}

function disconnectFromDB() // no changed needed
	{
		$db_conn = getDatabaseConnection();

		debugAlertMessage("Disconnect from Database");
		oci_close($db_conn);
	}
?>