<?php
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    include("connection.php");
    session_start();

    $error = null;

    if (isset($_POST["submit"])) {
        $firstName = $_SESSION["firstName"];
        $lastName = $_SESSION['lastName'];
        $patientID = $_SESSION['patientID'];

        $appointmentDate = $_POST['appointmentDate'];
        $appointmentType = $_POST['appointmentType'];
        $physicianName = $_POST['physicianName'];
        $appointmentID = generateRan($con);
        $DoctorID = getDoctorID($physicianName, $con);
        $procedureNecessary = isset($_POST["procedure"]);



        // Check if the patient exists
        $patientExists = checkIfPatientExists($firstName, $lastName, $patientID, $con);

        // Check if the doctor exists
        $doctorExists = checkIfDoctorExists($physicianName, $DoctorID, $con);

        if (!$patientExists) {
            // Patient does not exist, send an error message
            echo '<script>
            alert("Patient not found. Redirecting to patient creation page.");
            window.location.href = "createNewPatient.php"
            </script>';
            exit();
        }

        if (!$doctorExists) {
            // Doctor does not exist, send an error message
            echo '<script>
            alert("Doctor not found. Please check the physician name.");
            window.location.href = "createNewPatient.php"
            </script>';
            exit();
        }

        echo '<script>
        const confirmation = confirm("Are you sure that you want to scehedule an appointment?");


        if (!confirmation) {
            alert("Update Cancelled");
        } else {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "scheduleAppt.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");


            // Add other form data to the request if needed
            const formData = new FormData(document.getElementById("updatePatientRecord"));
            xhr.send(formData);


            // Handle the response from the server-side PHP file
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert(xhr.responseText); // Display the response from PHP
                }
            };
        }
        </script>';
    

        $query = "INSERT INTO patientAppts (appointmentDate, appointmentType, physicianName, DoctorID, PatientID, AppointmentID) VALUES (?, ?, ?, ?, ?,?)";
        $stmt = $con->prepare($query);

        // Generate random appointment ID

        // Bind parameters
        $stmt->bind_param("sssiii", $appointmentDate, $appointmentType, $physicianName, $DoctorID, $patientID, $appointmentID);

        if( $stmt -> execute()){

        if ($procedureNecessary == false) {
            // Successful insertion
            echo '<script>
            alert("Appointment scheduled successfully! Your Appointment ID is ' . $appointmentID . '");
            window.location.href = "scheduleAppt.php";
            </script>';
            exit();
        } else if ($procedureNecessary == true) {
            echo '<script>
            alert("Appointment scheduled successfully! Redirecting to Procedure Page. Your Appointment ID is ' . $appointmentID . '");
            window.location.href = "scheduleProcedure.php";
            </script>';
            exit();
        } else {
            // Failed insertion
            echo '<script>
            alert("Error scheduling appointment. Please try again.");
            </script>';
        }
    }}


    // Function to check if the patient exists
    function checkIfPatientExists($firstName, $lastName, $patientID, $con) {
        $query = "SELECT firstName, lastName, patientID FROM patient WHERE firstName = ? AND lastName = ? AND patientID = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("ssi", $firstName, $lastName, $patientID);
        $stmt->execute();
        $stmt->store_result();
        $rowCount = $stmt->num_rows;
        $stmt->close();
        return $rowCount > 0;
    }

    // Function to check if the doctor exists
    function checkIfDoctorExists($physicianName, $DoctorID, $con) {
        $query = "SELECT DoctorName, DoctorID FROM Doctors WHERE DoctorName = ? AND DoctorID = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("si", $physicianName, $DoctorID);
        $stmt->execute();
        $stmt->store_result();
        $rowCount = $stmt->num_rows;
        $stmt->close();
        return $rowCount > 0;
    }

    function generateRan($con) {
        $randomNumber = rand(100, 900);

        $query = "SELECT appointmentID FROM patientAppts WHERE appointmentID = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $randomNumber);
        $stmt->execute();
        $stmt->store_result();
        $rowCount = $stmt->num_rows;
        $stmt->close();

        if ($rowCount > 0) {
            // Recursively call generateRan until a unique ID is found
            return generateRan($con);
        } else {
            return $randomNumber;
        }
    }
    // Function to check if the doctor exists and retrieve DoctorID
    function getDoctorID($physicianName, $con) {
        $DoctorID = null;

           if ($stmt = $con->prepare("SELECT DoctorID FROM Doctors WHERE DoctorName = ?")) {
            $stmt->bind_param("s", $physicianName);
            $stmt->execute();
            $stmt->bind_result($DoctorID);
            $stmt->fetch();
            $stmt->close();
            return $DoctorID;
            } else {
                // Output the MySQL error for debugging
                echo "Error in SQL query: " . $con->error;
                return null;
            }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Schedule Patient Appointment</title>
    <link rel="stylesheet" href="newStyle.css">
</head>
<body>
    <div class = "navbar"></div>
    <nav>
        <a href="searchReceptionist.php">Search Receptionist</a>
        <a href="updateInfo.php">Update Patient Information</a>
        <a href="verifyPatient.php">Schedule Patient Appoin`tment</a>
        <a href="cancelAppt.php">Cancel Patient Appointment</a>
        <a href="scheduleProcedure.php">Schedule Patient Procedure</a>
        <a href="cancelProcedure.php">Cancel A Patient Procedure</a>
        <a href="createNewPatient.php">Create A New Patient</a>
        <a href="databasemain.html">Access Database Main</a>
    </nav>    
    </div> 
    <form id="updatePatientRecord" action="scheduleAppt.php" method="POST" onsubmit="return validateForm()">
        <div class="container">
            <div class="header">
                <h2>Create New Appointment</h2>
            </div>
            <div class="UserInput">
                <div class="enter1">
                    <p>Input Appointment Date</p>
                    <input type="text" name="appointmentDate" id = 'appointmentDate' placeholder="Input Appointment Date (2023-02-23) Format" style="color: black">
                    <p><strong>REQUIRED</strong></p>
                </div>
                <div class="enter2">
                    <p>Input Appointment Type</p>
                    <input type="text" name="appointmentType" id = 'appointmentType' placeholder="Insert Appoinment Type" style="color: black">
                    <p><strong>REQUIRED</strong></p>
                </div>
                <div class="enter3">
                    <p>Input Physician Name:</p>
                    <input type="text" name="physicianName" id = "physicianName" placeholder="Insert Physician Name" style="color: black">
                    <p><strong>REQUIRED</strong></p>
                </div>
                <div class = "enter7">
                    <label for = "procedure"><b>Procedure Necessary?<b></label>
                    <input type = "checkbox" id = "procedure" name="procedure">
                </div>
            <div class="footer">
                <button type="submit" class="btn" name = "submit">Submit</button>
                <button type="reset" class="btn">Reset</button>
                <button id = "homeButton" class = "btn" onclick = "redirect()">Home Button</button>
               
               
            </div>
        </div>
    </form>
            <script>
                    function redirect() {
                        // Redirect to the Doctors Receptionist Database page
                        window.location.href = "main.html";
                        exit();
                    }


                    function validateForm() {
                    // Validate date on the client side
                    const dateInput = document.getElementsByName('appointmentDate')[0].value;
                    const dateRegex = /^\d{4}-\d{2}-\d{2}$/;
                    }

                    // Display error message if validation fails
                    if (!dateRegex.test(dateInput)) {
                        alert("Please enter a valid date in the format YYYY-MM-DD");
                        return false; // Prevent form submission
                    } else {
                        return true; // Allow form submission
                    }
            </script>
</body>
</html>