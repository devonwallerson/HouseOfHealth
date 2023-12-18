<?php
    error_reporting(E_ALL);
    ini_set('display_errors','1');
    include("connection.php");
    session_start();


    $error = null;



    if (isset($_POST["submit"])) {
        $firstName = $_POST["firstName"];
        $lastName = $_POST['lastName'];
        $patientID = $_POST['patientID'];
        // Check if the patient exists
        $patientExists = checkIfPatientExists($firstName, $lastName, $patientID, $con);

        $_SESSION['firstName'] = $firstName;
        $_SESSION['lastName'] = $lastName;
        $_SESSION['patientID'] = $patientID;
        if ($patientExists) {
            header("Location: scheduleAppt.php");           
            exit();
        } else {
            // Patient does not exist, send an error message
            echo '<script>
            alert("Patient not found. Redirecting to patient creation page.");
            window.location.href = "createNewPatient.php"
            </script>';
            exit();
        }
    }


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
    <form id="updatePatientRecord" action="verifyPatient.php" method="POST" onsubmit="return validateForm()">
        <div class="container">
            <div class="header">
                <h2> Verify Patient Information</h2>
            </div>
            <div class="UserInput">
                <div class="enter1">
                    <p>Input First Name</p>
                    <input type="text" name="firstName" placeholder="Insert First Name" style="color: black">
                    <p><strong>REQUIRED</strong></p>
                </div>
                <div class="enter2">
                    <p>Input Last Name:</p>
                    <input type="text" name="lastName" placeholder="Insert Last Name" style="color: black">
                    <p><strong>REQUIRED</strong></p>
                </div>
                <div class="enter3">
                    <p>Input Patient ID:</p>
                    <input type="text" name="patientID" id = "patientID" placeholder="Insert Patient ID" style="color: black">
                    <p><strong>REQUIRED</strong></p>
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
                    }

                    function validateForm() {
                    // Validate patientID on the client side
                    const patientID = document.getElementById('patientID').value;
                    const isNumeric = /^\d+$/.test(patientID);
                    const isFiveDigits = patientID.length === 5;

                    // Display error message if validation fails
                    if (!isNumeric || !isFiveDigits) {
                        alert("Please enter a valid 5-digit code");
                        return false; // Prevent form submission
                    } else {
                        return true; // Allow form submission

                    }
                }
            </script>
</body>
</html>


