<!DOCTYPE html>
<html>

<head>
  <title>Appointments - Jerrmond's Dental System</title>
    <!-- Bootstrap CSS -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
	<link href="./Bootstrap/scheduledStyle.css" rel="stylesheet">
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
	      <li class="nav-item active">
	        <a class="nav-link" href="https://jerrmonddentalclinic.online/scheduled.php">Appointments</a>
	      </li>
	      <li class="nav-item">
	        <a class="nav-link" href="https://jerrmonddentalclinic.online/patients.php">Patients</a>
	      </li>
	    </ul>
	  </div>
	</nav>

  <div class="container mt-4">
    <h2>Scheduled Appointments</h2>
    <table class="table table-striped mt-3">
      <thead>
        <tr>
          <th>First Name</th>
          <th>Contact Number</th>
          <th>HMO Benefactor</th>
          <th>HMO Partner</th>
          <th>Appointment Date</th>
          <th>Appointment Time</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Replace the database connection details with your own
        $servername = "localhost";
        $username = "jerrmonddentalcl_sean";
        $password = "5ipFwFDgVR^8";
        $dbname = "jerrmonddentalcl_proj1";
        
        // Create a new mysqli instance
        $mysqli = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($mysqli->connect_error) {
          die("Connection failed: " . $mysqli->connect_error);
        }

        // Fetch appointments from the database
        $sql = "SELECT AppointmentID, FirstName, ContactNumber, HMO_Benefactor, HMO_Partner, AppointmentDate, AppointmentTime FROM Appointments";
        $result = $mysqli->query($sql);

        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["FirstName"] . "</td>";
            echo "<td>" . $row["ContactNumber"] . "</td>";
            echo "<td>" . $row["HMO_Benefactor"] . "</td>";
            echo "<td>" . $row["HMO_Partner"] . "</td>";
            echo "<td>" . $row["AppointmentDate"] . "</td>";
            echo "<td>" . $row["AppointmentTime"] . "</td>";
            echo "<td><form action='deleteAppointment.php' method='POST'><input type='hidden' name='AppointmentID' value='" . $row["AppointmentID"] . "'><button type='submit' class='btn btn-danger btn-sm'>Delete</button></form></td>";
            echo "</tr>";

          }
        } else {
          echo "<tr><td colspan='7'>No appointments found</td></tr>";
        }

        // Close the database connection
        $mysqli->close();
        ?>
      </tbody>
    </table>
  </div>

  <script src="./Bootstrap/jquery.min.js"></script>
  <script src="./Bootstrap/bootstrap.min.js"></script>
</body>


</html>
