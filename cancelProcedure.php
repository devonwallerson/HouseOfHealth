<?php
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    include("connection.php");
    session_start();

    $error = null;

    if (isset($_POST["submit"])) {
        

        $procedureID = $_POST['procedureID'];
        $IDexists = checkIfProcedureExists($procedureID, $con);


        if (!$IDexists) {
            // Patient does not exist, send an error message
            echo '<script>
            alert("Procedure can not be found. Reenter valid information.");
            window.location.href = "cancelProcedure.php"
            </script>';
            exit();
        }
    
            echo '<script>
            const confirmation = confirm("Are you sure that you want to cancel an procedure?");

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

            $query = "DELETE FROM Procedures WHERE ProcedureID = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param("i", $procedureID);
            $stmt->execute();

            $query = "UPDATE patientAppts
            SET procedureDate = NULL, procedureID = NULL, procedureType = NULL WHERE procedureID = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param("i", $procedureID);
            $stmt->execute();

            

            echo '<script>
            alert("Procedure deleted successfully!");
            window.location.href = "cancelProcedure.php";
            </script>';
            
        }

    // Function to check if the patient exists

    function checkIfProcedureExists($procedureID, $con) {
        $query = "SELECT ProcedureID FROM Procedures WHERE ProcedureID = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $procedureID);
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
    <form id="cancelProcedure" action="cancelProcedure.php" method="POST" onsubmit="return validateForm()">
        <div class="container">
            <div class="header">
                <h2>Cancel Procedure</h2>
            </div>
            <div class="UserInput">
                <div class="enter1">
                    <p>Input Procedure ID</p>
                    <input type="text" name="procedureID" id = 'procedureID' placeholder="Input Procedure ID" style="color: black">
                    <p><strong>REQUIRED</strong></p>
                </div>
                <div class="enter2">
                    <button type="submit" class="btn" name = "submit">Submit</button>
                    <button type="reset" class="btn">Reset</button>
                    <button id = "homeButton" class = "btn" onclick = "redirect()">Home Button</button>
                </div>
        </div>
        <div class = "footer">
            <br>
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
                    const IDInput = document.getElementsByName('procedureID')[0].value;
                    const IDRegex = /^\d{6}$/
                    }


                    // Display error message if validation fails
                    if (!IDRegex.test(IDInput)) {
                        alert("Please enter a valid ID in the format of 6 digit integer value");
                        return false; // Prevent form submission
                    } else {
                        return true; // Allow form submission
                    }
            </script>
</body>
</html>