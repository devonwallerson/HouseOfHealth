<?php
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    include("connection.php");
    session_start();

    $error = null;

    if (isset($_POST["submit"])) {
        $firstName = $_POST["firstName"];
        $lastName = $_POST['lastName'];
        $patientID = $_POST['patientID'];
        $receptionistID = $_SESSION['receptionistID'];
        $patientExists = patientExists($patientID,$con);

        if ($patientExists) {
            // Patient does not exist, send an error message
            echo '<script>
            alert("Patient already exists. Use brand new ID.");
            window.location.href = "createNewPatient.php"
            </script>';
            exit();
        }

        echo '<script>
        const confirmation = confirm("Are you sure that you want to create a new patient");


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
    

        $query = "INSERT INTO patient (firstName, lastName, patientID, receptionistID) VALUES (?,?,?,?)";
        $stmt = $con->prepare($query);

        $stmt->bind_param("ssii", $firstName, $lastName, $patientID, $receptionistID);
        $stmt->execute();

        echo '<script>
            alert("Patient successfully added.");
            window.location.href = "createNewPatient.php"
            </script>';

    }
    // Function to check if the patient exists
    function patientExists($patientID, $con) {
        $query = "SELECT patientID FROM patient WHERE patientID = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $patientID);
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
    <title>Create New Patient</title>
    <link rel="stylesheet" href="newStyle.css">
     
</head>
<body>
    <div class = "navbar"></div>
    <nav>
        <a href="searchReceptionist.php">Search Receptionist</a>
        <a href="updateInfo.php">Update Patient Information</a>
        <a href="scheduleAppt.php">Schedule Patient Appoin`tment</a>
        <a href="cancelAppt.php">Cancel Patient Appointment</a>
        <a href="scheduleProcedure.php">Schedule Patient Procedure</a>
        <a href="cancelProcedure.php">Cancel A Patient Procedure</a>
        <a href="createNewPatient.php">Create A New Patient</a>
        <a href="databasemain.html">Access Database Main</a>
    </nav>    
    </div>  

    <form id="createNewPatient" action="createNewPatient.php" method="POST" onsubmit="return validateForm()">
        <div class="container">
            <div class="header">
                <h2>Create New Patient</h2>
            </div>
            <div class="UserInput">
                <div class="enter1">
                    <p>Input Patient First Name</p>
                    <input type="text" name="firstName" id = 'firstName' placeholder="Input First Name" style="color: black">
                    <p><strong>REQUIRED</strong></p>
                </div>
                <div class="enter2">
                    <p>Input Patient Last Name</p>
                    <input type="text" name="lastName" id = 'lastName' placeholder="Insert Last Name" style="color: black">
                    <p><strong>REQUIRED</strong></p>
                </div>
                <div class="enter3">
                    <p>Input Patient ID Number</p>
                    <input type="text" name="patientID" id = "patientID" placeholder="Insert Patient ID (5 digit number)" style="color: black">
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
                    const IDInput = document.getElementsByName('patientID')[0].value;
                    const IDRegex = /^\d{5}$/


                    // Display error message if validation fails
                    if (!IDRegex.test(IDInput)) {
                        alert("Please enter a valid ID in the format of 5 digit integer value");
                        return false; // Prevent form submission
                    } else {
                        return true; // Allow form submission
                    }
                }
            </script>
</body>
</html>