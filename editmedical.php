<?php
$servername = "localhost";
$username = "jerrmonddentalcl_sean";
$password = "5ipFwFDgVR^8";
$dbname = "jerrmonddentalcl_proj1";

// Establishing database connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve patient ID from request
if (isset($_GET["patient_id"])) {
    $patient_id = $_GET["patient_id"];
} else {
    echo "No patient ID provided.";
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["submit"])) {
    // Get the updated co-morbidities and allergies from the form
    $co_morbidities = $_POST["co_morbidities"];
    $allergies = $_POST["allergies"];

    // Update the co-morbidities and allergies in the database
    $sql = "UPDATE Patients SET co_morbidities='$co_morbidities', allergies='$allergies' WHERE patient_id='$patient_id'";
    if ($conn->query($sql) === TRUE) {
        echo "Patient information updated successfully.";
    } else {
        echo "Error updating patient information: " . $conn->error;
    }
}

// Retrieve the patient's existing co-morbidities and allergies from the database
$sql = "SELECT co_morbidities, allergies FROM Patients WHERE patient_id='$patient_id'";
$result = $conn->query($sql);

// Check if a patient with the given ID exists
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $co_morbidities = $row["co_morbidities"];
    $allergies = $row["allergies"];
} else {
    echo "Patient not found for the provided ID.";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Patient Information</title>
</head>
<body>
    <h2>Edit Patient Information</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?patient_id=" . $patient_id; ?>">
        <label for="co_morbidities">Co-morbidities:</label><br>
        <textarea name="co_morbidities" id="co_morbidities" rows="4" cols="50"><?php echo htmlspecialchars($co_morbidities); ?></textarea><br><br>
        <label for="allergies">Allergies:</label><br>
        <textarea name="allergies" id="allergies" rows="4" cols="50"><?php echo htmlspecialchars($allergies); ?></textarea><br><br>
        <input type="submit" name="submit" value="Update">
    </form>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
