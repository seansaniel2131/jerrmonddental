<?php
    $servername = "localhost";
    $username = "jerrmonddentalcl_sean";
    $password = "5ipFwFDgVR^8";
    $dbname = "jerrmonddentalcl_proj1";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    if ($_SERVER["REQUEST_METHOD"] === "GET") {
        // Get the treatment ID from the query string
        $treatmentId = $_GET["treatment_id"];
    
        // Perform the deletion in your database
        $sql = "DELETE FROM TreatmentHistory WHERE treatment_id='$treatmentId'";
    
        // Execute the deletion query using your database connection $conn
        if ($conn->query($sql) === TRUE) {
            echo "Treatment deleted successfully";
        } else {
            echo "Error deleting treatment: " . $conn->error;
        }
    }
?>