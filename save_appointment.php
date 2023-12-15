<?php
// Database connection
$servername = "localhost";
$username = "jerrmonddentalcl_sean";
$password = "5ipFwFDgVR^8";
$dbname = "jerrmonddentalcl_proj1";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Capture form data
$firstName = $_POST['firstName'];
$contactNumber = $_POST['contactNumber'];
$hmoBenefactor = $_POST['hmoBenefactor'];
$hmoPartner = $_POST['hmoPartner'];
$appointmentDate = date("Y-m-d", strtotime($_POST['appointmentDate']));
$appointmentTime = date("H:i:s", strtotime($_POST['appointmentTime']));

// Prepare and execute the SQL statement
$sql = "INSERT INTO Appointments (FirstName, ContactNumber, HMO_Benefactor, HMO_Partner, AppointmentDate, AppointmentTime) 
        VALUES ('$firstName', '$contactNumber', '$hmoBenefactor', '$hmoPartner', '$appointmentDate', '$appointmentTime')";
        
if ($conn->query($sql) === TRUE) {
    // Close the database connection
    $conn->close();
    
    // Redirect back to the schedule page
    header("Location: schedule.php");
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

?>
