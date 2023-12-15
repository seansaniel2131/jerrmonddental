<?php
$servername = "localhost";
$username = "jerrmonddentalcl_sean";
$password = "5ipFwFDgVR^8";
$dbname = "jerrmonddentalcl_proj1";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['patient_id']) && isset($_GET['treatment_id'])) {
    $patientId = $_GET['patient_id'];
    $treatmentId = $_GET['treatment_id'];
} else {
    echo "No patient ID or treatment ID provided.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["submit"])) {
    $updatedTreatmentDate = $_POST["treatment_date"];
    $updatedTreatmentDetails = $_POST["treatment_details"];
    $updatedPrescriptions = $_POST["prescriptions"];

    $sql = "UPDATE TreatmentHistory SET treatment_date='$updatedTreatmentDate', treatment_details='$updatedTreatmentDetails', prescriptions='$updatedPrescriptions' WHERE treatment_id='$treatmentId'";
    if ($conn->query($sql) === TRUE) {
        echo "Treatment history updated successfully.";
    } else {
        echo "Error updating treatment history: " . $conn->error;
    }
}

$sql = "SELECT treatment_date, treatment_details, prescriptions FROM TreatmentHistory WHERE patient_id='$patientId' AND treatment_id='$treatmentId'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $treatmentDate = $row["treatment_date"];
    $treatmentDetails = $row["treatment_details"];
    $prescriptions = $row["prescriptions"];
} else {
    echo "Treatment history not found for the provided IDs.";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Treatment History</title>
</head>
<body>
    <h2>Edit Treatment History</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?patient_id=" . $patientId . "&treatment_id=" . $treatmentId; ?>">
        <label for="treatment_date">Treatment Date:</label><br>
        <input type="date" id="treatment_date" name="treatment_date" value="<?php echo $treatmentDate; ?>" required><br><br>
        
        <label for="treatment_details">Treatment Details:</label><br>
        <textarea name="treatment_details" id="treatment_details" rows="4" cols="50" required><?php echo htmlspecialchars($treatmentDetails); ?></textarea><br><br>
        
        <label for="prescriptions">Prescriptions:</label><br>
        <textarea name="prescriptions" id="prescriptions" rows="4" cols="50" required><?php echo htmlspecialchars($prescriptions); ?></textarea><br><br>
        
        <input type="submit" name="submit" value="Update">
    </form>
</body>
</html>

<?php
$conn->close();
?>
