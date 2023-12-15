<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $patientId = $_POST["patient_id"];
        $treatmentDate = $_POST["treatment_date"];
        $treatmentDetails = $_POST["treatment_details"];
        $prescriptions = $_POST["prescriptions"];
    
        $servername = "localhost";
        $username = "jerrmonddentalcl_sean";
        $password = "5ipFwFDgVR^8";
        $dbname = "jerrmonddentalcl_proj1";
    
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    
        $stmt = $conn->prepare("INSERT INTO TreatmentHistory (patient_id, treatment_date, treatment_details, prescriptions) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $patientId, $treatmentDate, $treatmentDetails, $prescriptions);
    
        if ($stmt->execute()) {
            echo "Treatment record added successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }
    
        $stmt->close();
        $conn->close();
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Treatment</title>
</head>
<body>
    <h2>Add Treatment</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <input type="hidden" name="patient_id" value="<?php echo $_GET['patient_id']; ?>">
        <label for="treatment_date">Treatment Date:</label>
        <input type="date" name="treatment_date" required><br><br>
        <label for="treatment_details">Treatment Details:</label><br>
        <textarea name="treatment_details" rows="4" cols="50" required></textarea><br><br>
        <label for="prescriptions">Prescriptions:</label><br>
        <textarea name="prescriptions" rows="4" cols="50" required></textarea><br><br>
        <input type="submit" value="Add Treatment">
    </form>
</body>
</html>
