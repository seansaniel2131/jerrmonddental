<?php
// Replace the database connection details with your own
$servername = "localhost";
$username = "jerrmonddentalcl_sean";
$password = "5ipFwFDgVR^8";
$dbname = "jerrmonddentalcl_proj1";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["AppointmentID"])) {
  $appointmentID = $_POST["AppointmentID"];

  // Create a new mysqli instance
  $mysqli = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
  }

  // Prepare and execute the DELETE statement
  $stmt = $mysqli->prepare("DELETE FROM Appointments WHERE AppointmentID = ?");
  $stmt->bind_param("i", $appointmentID);
  $stmt->execute();

  // Check if any rows were affected
  if ($stmt->affected_rows > 0) {
    echo "Appointment with ID $appointmentID deleted successfully.";
  } else {
    echo "Failed to delete appointment.";
  }

  // Close the database connection
  $mysqli->close();
} else {
  echo "Invalid request.";
}
?>
