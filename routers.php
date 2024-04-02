<?php

// Connection
include 'connection.php';
displayErrors();
$db_conn = getDatabaseConnection();
$config = createConfig("ora_hbhutta3", "a78030533");

// Handlers
include 'insert.php';  // POST (since user chooses/provides values)
include 'delete.php';  // POST (since user chooses/provides values)
include 'update.php';  // POST (since user chooses/provides values)
include 'select.php';  // POST (since user chooses/provides values)
include 'project.php'; // POST (since user chooses/provides values)
include 'join.php'; // POST (since user chooses/provides values)
include 'aggregation_with_group_by.php'; // ???
include 'aggregation_with_having.php'; // ???
include 'nested_aggregation_with_group_by.php'; // ???
include 'division.php'; // ???

// HANDLE ALL POST ROUTES
// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
function handlePOSTRequest()
{
    if (connectToDB()) {
        if (array_key_exists('insertQueryRequest', $_POST)) {
            handleInsertRequest();
        } // ...
        disconnectFromDB();
    }
}

// HANDLE ALL GET ROUTES
// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
function handleGETRequest()
{
    if (connectToDB()) {
        if (array_key_exists('displayVeterinarians', $_GET)) { 
            handleDisplayVeterinariansRequest(); 
        } elseif (array_key_exists('displayHospitals', $_GET)) {  
            handleDisplayHospitalsRequest(); 
        } // ...
        disconnectFromDB();
    }
}
?>