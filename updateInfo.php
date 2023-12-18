<?php
    error_reporting(E_ALL);
    ini_set('display_errors','1');
    include("connection.php");


    $confirmation = null;
    $error = null;


    if (isset($_POST["submit"])) {
        $patientID = $_POST["patientID"];


        // Check if the patient exists
        $patientExists = checkIfPatientExists($patientID, $con);


        if ($patientExists) {
            // Patient exists, show confirmation
            echo '<script>
                    const confirmation = confirm("Are you sure that you want to update patient information?");


                    if (!confirmation) {
                        alert("Update Cancelled");
                    } else {
                        alert("Update Confirmed");
                        const xhr = new XMLHttpRequest();
                        xhr.open("POST", "updateInfo.php", true);
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
           
                $immunization = $_POST["immunization"];
                $illnesses = $_POST["illnesses"];
                $patientID = $_POST["patientID"];


                $newQuery = "UPDATE patientMedRecord SET shotsGiven = ?, Illnesses = ? WHERE patientID =?";
                $stmt2 = $con->prepare($newQuery);
                $stmt2->bind_param("ssi", $immunization, $illnesses, $patientID);
                $stmt2->execute();
                $stmt2->close();


                echo '<script>
                    alert("User successfully updated.");
                    window.location.href = "main.html";
                </script>';


        } else {
            // Patient does not exist, send an error message
            echo '<script>alert("Patient not found. Please enter a valid patient ID.");</script>';
        }
    }


    // Function to check if the patient exists
    function checkIfPatientExists($patientID, $con) {
        // Implement your logic to check if the patient exists in the database
        // Return true if the patient exists, false otherwise


        $query = "SELECT patientID FROM patientMedRecord WHERE patientID = ?";


        $stmt = $con->prepare($query);
        $stmt->bind_param("i",$patientID);
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
    <title>Update Patient Information</title>
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
    <form id="updatePatientRecord" action="updateInfo.php" method="POST">
        <div class="container">
            <div class="header">
                <h2>Update Patient Information</h2>
            </div>
            <div class="UserInput">
                <div class="enter1">
                    <p>Update Immunization:</p>
                    <input type="text" name="immunization" placeholder="Insert Shots" style="color: black">
                    <p><strong>REQUIRED</strong></p>
                </div>
                <div class="enter2">
                    <p>Update Illnesses:</p>
                    <input type="text" name="illnesses" placeholder="Insert Sicknesses" style="color: black">
                    <p><strong>REQUIRED</strong></p>
                </div>
                <div class="enter3">
                    <p>Input Patient ID:</p>
                    <input type="text" name="patientID" placeholder="Insert Patient ID" style="color: black">
                    <p><strong>REQUIRED</strong></p>
                </div>
            <div class="footer">
                <button type="submit" class="btn" name = "submit">Submit</button>
                <button type="reset" class="btn">Reset</button>
                <button id = "homeButton" onclick = "redirect()" class = "btn">Home Button</button>;
               
                <script>
                    function redirect() {
                        // Redirect to the Doctors Receptionist Database page
                        window.location.href = "main.html";
                    }
                </script>
            </div>
        </div>
    </form>
</body>
</html>


