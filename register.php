<!DOCTYPE html>
<html>
<head>
    <title>Patient Registration</title>
    <link href="./Bootstrap/registerSTYLE.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>" enctype="multipart/form-data">
            <h2>PATIENT REGISTRATION</h2>
            <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" name="first_name" required>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name:</label>
                <input type="text" name="last_name" required>
            </div>
            <div class="form-group">
                <label for="age">Age:</label>
                <input type="number" name="age" required>
            </div>
            <div class="form-group">
                <label for="sex">Sex:</label>
                <input type="text" name="sex" required>
            </div>
            <div class="form-group">
                <label for="contact_number">Contact Number:</label>
                <input type="text" name="contact_number" required>
            </div>
            <div class="form-group">
                <label for="co_morbidities">Co-morbidities:</label>
                <input type="text" name="co_morbidities">
            </div>
            <div class="form-group">
                <label for="allergies">Allergies:</label>
                <input type="text" name="allergies">
            </div>
            <div class="form-group">
                <label for="headshot">Patient Photo:</label>
                <input type="file" name="headshot">
            </div>
            <input type="submit" value="REGISTER">
        </form>
    </div>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $first_name = $_POST["first_name"];
        $last_name = $_POST["last_name"];
        $age = $_POST["age"];
        $sex = $_POST["sex"];
        $contact_number = $_POST["contact_number"];
        $co_morbidities = $_POST["co_morbidities"];
        $allergies = $_POST["allergies"];

        // File upload handling
        $target_dir = "./uploads/";
        $target_file = $target_dir . basename($_FILES["headshot"]["name"]);
        $file_upload_success = move_uploaded_file($_FILES["headshot"]["tmp_name"], $target_file);

        if (!$file_upload_success) {
            echo "Sorry, there was an error uploading the file.";
        } else {
            // Database credentials
            $servername = "localhost";
            $username = "jerrmonddentalcl_sean";
            $password = "5ipFwFDgVR^8";
            $dbname = "jerrmonddentalcl_proj1";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "INSERT INTO Patients (first_name, last_name, age, sex, contact_number, co_morbidities, allergies, headshot_imagepath)
            VALUES ('$first_name', '$last_name', '$age', '$sex', '$contact_number', '$co_morbidities', '$allergies', '$target_file')";

            if ($conn->query($sql) === TRUE) {
                echo "Data inserted successfully!";
            } else {
                echo "Error inserting data: " . $conn->error;
            }

            $conn->close();
        }
    }
    ?>
</body>
</html>
