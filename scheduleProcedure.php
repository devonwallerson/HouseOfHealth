<?php
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    include("connection.php");
    session_start();

    $error = null;

    if (isset($_POST["submit"])) {

        $procedureDate = $_POST['procedureDate'];
        $procedureType = $_POST['procedureType'];
        $appointmentID = $_POST['appointmentID'];
        $appointmentExists = checkIfAppointmentExists($appointmentID, $con);
        $procedureExists = checkIfProcedureExists($appointmentID, $con);
        $ProcedureID = generateRan($con);
        $DoctorName = getDoctorName($appointmentID, $con);
        $patientID = getPatientID($appointmentID, $con);


        // Check if the appointment exists


        if (!$appointmentExists) {
            // Patient does not exist, send an error message
            echo '<script>
            alert("Appointment not found. Please scheudle a pre-procedure appointment.");
            window.location.href = "scheduleAppt.php"
            </script>';
            exit();
        }

        if ($procedureExists){
            // Patient does not exist, send an error message
            echo '<script>
            alert("Procedure already exists. Delete Procedure to continue, or enter new ID>");
            window.location.href = "scheduleProcedure.php"
            </script>';
            exit();
        }

        echo '<script>

        const confirmation = confirm("Are you sure that you want to scehedule an procedure?");


        if (!confirmation) {
            alert("Update Cancelled");
        } else {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "scheduleProcedure.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");


            // Add other form data to the request if needed
            const formData = new FormData(document.getElementById("scheduleProcedure"));
            xhr.send(formData);


            // Handle the response from the server-side PHP file
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert(xhr.responseText); // Display the response from PHP
                }
            };
        }
        </script>';
    

        try {
            // Start a transaction
            $con->begin_transaction();
        
            // Insert into Procedures table
            $query = "INSERT INTO Procedures (ProcedureID, ProcedureDate, ProcedureType, DoctorName, PatientID, PreAppointmentID) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $con->prepare($query);
            $stmt->bind_param("isssii", $ProcedureID, $procedureDate, $procedureType, $DoctorName, $patientID, $appointmentID);
            $stmt->execute();
        
            if ($stmt->error) {
                throw new Exception("Query 1 failed: " . $stmt->error);
            }
        
            $stmt->close();
        
            // Update patientAppts table
            $query = "UPDATE patientAppts SET procedureDate = ?, procedureID = ?, procedureType = ? WHERE appointmentID = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param("sisi", $procedureDate, $ProcedureID, $procedureType, $appointmentID);
            $stmt->execute();
        
            if ($stmt->error) {
                throw new Exception("Query 2 failed: " . $stmt->error);
            }
        
            $stmt->close();
        
            // Commit the transaction if everything is successful
            $con->commit();
        } catch (Exception $e) {
            // An error occurred, rollback the transaction
            $con->rollback();
        
            echo "Transaction failed: " . $e->getMessage();
        }
        
        

        echo '<script>
        alert("Procedure Appointment Scheduled.");
        //window.location.href = "scheduleProcedure.php";
        </script>';

    }

    // Function to check if the patient exists
    function checkIfAppointmentExists($appointmentID, $con) {
        $query = "SELECT appointmentID FROM patientAppts WHERE appointmentID = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $appointmentID);
        $stmt->execute();
        $stmt->store_result();
        $rowCount = $stmt->num_rows;
        $stmt->close();
        return $rowCount > 0;
    }
    function checkIfProcedureExists($appointmentID, $con) {
        $query = "SELECT procedureID FROM patientAppts WHERE appointmentID = ? AND procedureID IS NOT NULL";
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $appointmentID);
        $stmt->execute();
        $stmt->store_result();
        $rowCount = $stmt->num_rows;
        $stmt->close();
        return $rowCount > 0;
    }
    function generateRan($con) {
        $randomNumber = rand(100000, 999999);

        $query = "SELECT ProcedureID FROM Procedures WHERE ProcedureID = ?";
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
    function getDoctorName($appointmentID, $con) {
        $DoctorName = null;

           if ($stmt = $con->prepare("SELECT physicianName FROM patientAppts WHERE appointmentID = ?")) {
            $stmt->bind_param("i", $appointmentID);
            $stmt->execute();
            $stmt->bind_result($DoctorName);
            $stmt->fetch();
            $stmt->close();
            return $DoctorName;
            } else {
                // Output the MySQL error for debugging
                echo "Error in SQL query: " . $con->error;
                return null;
        }
    }
    function getPatientID($appointmentID, $con) {
        $PatientID = null;

           if ($stmt = $con->prepare("SELECT PatientID FROM patientAppts WHERE appointmentID = ?")) {
            $stmt->bind_param("i", $appointmentID);
            $stmt->execute();
            $stmt->bind_result($PatientID);
            $stmt->fetch();
            $stmt->close();
            return $PatientID;
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
    <form id="scheduleProcedure" action="scheduleProcedure.php" method="POST" onsubmit="return validateForm()">
        <div class="container">
            <div class="header">
                <h2>Schedule New Procedure </h2>
            </div>
            <div class="UserInput">
                <div class="enter1">
                    <p>Input Procedure Date</p>
                    <input type="text" name="procedureDate" id = 'procedureDate' placeholder="Input Procedure Date (2023-02-23) Format" style="color: black">
                    <p><strong>REQUIRED</strong></p>
                </div>
                <div class="enter2">
                    <p>Input Procedure Type</p>
                    <input type="text" name="procedureType" id = 'procedureType' placeholder="Insert Procedure Type" style="color: black">
                    <p><strong>REQUIRED</strong></p>
                </div>
                <div class="enter3">
                    <p>Input Pre Appointment ID:</p>
                    <input type="text" name="appointmentID" id = "appointmentID" placeholder="Insert Appointment ID" style="color: black">
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
                        exit();
                    }

                    function validateForm() {
                    // Validate date on the client side
                    const dateInput = document.getElementsByName('procedureDate')[0].value;
                    const dateRegex = /^\d{4}-\d{2}-\d{2}$/;
                    

                    // Display error message if validation fails
                    if (!dateRegex.test(dateInput)) {
                        alert("Please enter a valid date in the format YYYY-MM-DD");
                        return false; // Prevent form submission
                    }
                     // Validate date on the client side
                    const IDInput = document.getElementsByName('appointmentID')[0].value;
                    const IDRegex = /^\d{3}$/;


                    // Display error message if validation fails
                    if (!IDRegex.test(IDInput)) {
                        alert("Please enter a valid ID in the format of 3 digit integer value");
                        return false; // Prevent form submission
                    } else {
                        return true; // Allow form submission
                    }
                }
            </script>
</body>
</html>