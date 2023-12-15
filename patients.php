<?php
$servername = "localhost";
$username = "jerrmonddentalcl_sean";
$password = "5ipFwFDgVR^8";
$dbname = "jerrmonddentalcl_proj1";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Patient Information System</title>
    <link rel="stylesheet" type="text/css" href="./Bootstrap/patientStyle.css">
    	<!-- Bootstrap CSS -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
	<link href="./Bootstrap/patientStyle.css" rel="stylesheet">
    	<!-- Bootstrap CSS -->
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
	  <a class="navbar-brand" href="#">Jerrmond's Dental System</a>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
	    <span class="navbar-toggler-icon"></span>
	  </button>
	  
	  <div class="collapse navbar-collapse" id="navbarNav">
	    <ul class="navbar-nav">
	      <li class="nav-item">
	        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
	      </li>
	      <li class="nav-item">
	        <a class="nav-link" href="https://jerrmonddentalclinic.online/scheduled.php">Appointments</a>
	      </li>
	      <li class="nav-item active">
	        <a class="nav-link" href="https://jerrmonddentalclinic.online/patients.php">Patients</a>
	      </li>
	    </ul>
	  </div>
	</nav>

    <div class="container">
        <h3>Search Patient by ID</h3>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="patient_id">Patient ID:</label>
            <input id="patient_id" name="patient_id" required="" type="text">
            <input name="search" type="submit" value="Search">
        </form>
        
        <button onclick="openRegisterPopup()" type="button">Register Patient</button>

        <?php
        // SEARCH
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["search"])) {
            // Get the patient ID from the search form
            $searchPatientId = $_POST["patient_id"];

            // FETCH DETAILS
            $sql = "SELECT * FROM Patients WHERE patient_id='$searchPatientId'";
            $result = $conn->query($sql);

            // PATIENT CHECK
            if ($result->num_rows > 0) {
                $patient = $result->fetch_assoc();
                $firstName = $patient['first_name'];
                $lastName = $patient['last_name'];
                $age = $patient['age'];
                $sex = $patient['sex'];
                $contactNumber = $patient['contact_number'];
                $coMorbidities = $patient['co_morbidities'];
                $allergies = $patient['allergies'];
                $imagePath = $patient['headshot_imagepath'];
                ?>
                <div class="patient-info">
                    <h2>Patient Details</h3>
                    <div class="patient-details-container">
                        <div class="image-container">
                            <img src="<?php echo $imagePath; ?>" alt="Patient Image">
                        </div>
                        <div class="patient-details">
                            First Name: <?php echo $firstName; ?><br>
                            Last Name: <?php echo $lastName; ?><br>
                            Age: <?php echo $age; ?><br>
                            Sex: <?php echo $sex; ?><br>
                            Contact Number: <?php echo $contactNumber; ?><br>
                        </div>
                    </div>

                    <div class="comorbidities-allergies">
                        <table class="comorbidities">
                            <tr>
                                <th>Co-Morbidity</th>
                            </tr>
                            <tr>
                                <td><?php echo $coMorbidities; ?></td>
                            </tr>
                        </table>
                        <table class="allergies">
                            <tr>
                                <th>Allergy</th>
                            </tr>
                            <tr>
                                <td><?php echo $allergies; ?></td>
                            </tr>
                        </table>
                    </div>

                    <button onclick="openEditMedicalPopup(<?php echo $patient['patient_id']; ?>)">Edit Medical Information</button>
                    <br><br><button onclick="openAddTreatmentPopup(<?php echo $patient['patient_id']; ?>)">Add New Treatment</button>
                    
                    <?php
                    $sql = "SELECT * FROM TreatmentHistory WHERE patient_id='$searchPatientId'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        ?>
                        <h2>Treatment History</h3>
                        <table>
                            <tr>
                                <th>Treatment Date</th>
                                <th>Treatment Details</th>
                                <th>Prescriptions</th>
                                <th></th>
                                <th></th>
                            </tr>
                            <?php
                            while ($row = $result->fetch_assoc()) {
                                $treatmentId = $row['treatment_id'];
                                $treatmentDate = $row['treatment_date'];
                                $treatmentDetails = $row['treatment_details'];
                                $prescriptions = $row['prescriptions'];

                                echo "<tr>";
                                echo "<td>" . $treatmentDate . "</td>";
                                echo "<td>" . $treatmentDetails . "</td>";
                                echo "<td>" . $prescriptions . "</td>";
                                echo "<td><button onclick=\"openEditTreatmentPopup($treatmentId, $searchPatientId)\">Edit</button></td>";
                                echo "<td><button onclick='deleteTreatment($treatmentId)'>Delete</button></td>";
                                echo "</tr>";
                            }
                            ?>
                        </table>
                              
                        <?php
                    } 
                        else {
                            echo "No Treatment History Found";
                        }
            } 
                        else {
                        echo "Patient ID Not Found";
                        }
        }
                        ?>
                    
                    

    <script>
        function openAddTreatmentPopup(patientId) {
            var addTreatmentUrl = "addtreatment.php?patient_id=" + patientId;
            window.open(addTreatmentUrl, "Add New Treatment", "width=600,height=400,resizable=yes,scrollbars=yes");
        }

        function openEditTreatmentPopup(treatmentId, patientId) {
            var editTreatmentUrl = "editreatment.php?treatment_id=" + treatmentId + "&patient_id=" + patientId;
            window.open(editTreatmentUrl, "Edit Treatment", "width=600,height=400,resizable=yes,scrollbars=yes");
        }

        function deleteTreatment(treatmentId) {
            if (confirm("Are you sure you want to delete this treatment?")) {
                window.location.href = "deletetreatment.php?treatment_id=" + treatmentId;
            }
        }

        function openEditMedicalPopup(patientId) {
            var editUrl = "editmedical.php?patient_id=" + patientId;
            window.open(editUrl, "Edit Medical Information", "width=600,height=400,resizable=yes,scrollbars=yes");
        }
        
        function openRegisterPopup() {
            var width = 600;
            var height = 900;
            var left = (screen.width - width) / 2;
            var top = (screen.height - height) / 2;
            
            window.open("register.php", "", "width=" + width + ",height=" + height + ",left=" + left + ",top=" + top);
        }
    </script>
</body>
</html>