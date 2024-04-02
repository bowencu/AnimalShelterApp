<?php
include 'connection.php';
$db_conn = getDatabaseConnection();

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
?>