<?php 
include connection.php;
$db_conn = getDatabaseConnection();

function handleSelectRequest() {
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

    executeBoundSQL("SELECT * FROM AnimalHelpedAdopt2 WHERE age > :bind1", $alltuples);
    oci_commit($db_conn);


}
?>