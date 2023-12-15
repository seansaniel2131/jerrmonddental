<?php
$servername = "localhost";
$username = "jerrmonddentalcl_sean";
$password = "5ipFwFDgVR^8";
$dbname = "jerrmonddentalcl_proj1";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM Appointments";
$result = $conn->query($sql);

$appointments = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $startTime = date('H:i', strtotime($row["AppointmentTime"]));
        $endTime = date('H:i', strtotime($row["AppointmentTime"] . '+1 hour')); 
        $appointment = array(
            'id' => $row["AppointmentID"],
            'title' => $row["PatientName"],
            'start' => $row["AppointmentDate"] . 'T' . $startTime,
            'end' => $row["AppointmentDate"] . 'T' . $endTime
        );
        $appointments[] = $appointment;
    }
}

$conn->close();

echo json_encode($appointments);
?>
