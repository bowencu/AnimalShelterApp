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
?>