<?php
$servername = "localhost";
$username = "jerrmonddentalcl_sean";
$password = "5ipFwFDgVR^8";
$dbname = "jerrmonddentalcl_proj1";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["AppointmentID"])) {
  $appointmentID = $_POST["AppointmentID"];

  $mysqli = new mysqli($servername, $username, $password, $dbname);

  if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
  }

  $stmt = $mysqli->prepare("DELETE FROM Appointments WHERE AppointmentID = ?");
  $stmt->bind_param("i", $appointmentID);
  $stmt->execute();

  if ($stmt->affected_rows > 0) {
    echo "Appointment with ID $appointmentID deleted successfully.";
  } else {
    echo "Failed to delete appointment.";
  }

  $mysqli->close();
} else {
  echo "Invalid request.";
}
?>
