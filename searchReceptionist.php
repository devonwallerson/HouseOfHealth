<!DOCTYPE html>
<html lang = "en">
    <head>
        <meta charset = "UTF-8"/>
        <meta name="viewport" content="width=device-width">
        <title>House of Health</title>
        <link rel = "stylesheet" href = "database2.css" />
        <script src = "script2.js"></script>
        <header><h1>Receptionist Database</h1></header><br>
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
    
        <div class = "table">
        <table>
            <thead>
                <th>Receptionist Name </th>
                <th>Receptionist ID </th>
                <th>Receptionist Phone Number</th>
                <th>Receptionist Email</th>
                <th>Patient Name</th>
                <th>Patient ID</th>
                <th>Patient DOB</th>
                <th>Patient Age</th>
                <th>Patient Phone Number</th>
                <th>Patient Address</th>
                <th>Patient Shot Record</th>
                <th>Patient Illness Record</th>
                <th>Patient Appointment Dates</th>
                <th>Patient Appointment Type</th>
                <th>Patient Procedure Date</th>
                <th>Patient Procedure Type</th>
                <th>Physician Name</th>
                <th>Physician ID</th>


            </thead>
            <tbody> 
            <?php
                include "connection.php";
                session_start();

                $result = mysqli_query($con, "SELECT 
                    CONCAT(receptionist.firstName, ' ' , receptionist.lastName) AS ReceptionistName,
                    receptionist.id AS ReceptionistID,
                    receptionist.phoneNumber AS ReceptionistPhoneNumber,
                    receptionist.emailAddress AS ReceptionistEmailAddress,
                    CONCAT(patient.firstName ,' ' , patient.lastName) AS PatientName,
                    patient.patientID AS PatientID,
                    patientMedRecord.DOB AS PatientDOB,
                    patientMedRecord.age AS PatientAge,
                    patientMedRecord.phoneNumber AS PatientPhoneNumber,
                    patientMedRecord.address AS PatientAddress,
                    patientMedRecord.shotsGiven AS PatientShotRecord,
                    patientMedRecord.Illnesses AS PatientIllnesses,
                    patientAppts.appointmentDate AS AppointmentDate,
                    patientAppts.appointmentType AS AppointmentType,
                    patientAppts.procedureDate AS ProcedureDate,
                    patientAppts.procedureType AS ProcedureType,
                    Doctors.DoctorName AS DoctorName,
                    Doctors.DoctorID AS DoctorID

                FROM
                    receptionist
                LEFT JOIN  /* every receptionist has a patient, so join */
                    patient ON receptionist.id = patient.receptionistID 
                LEFT JOIN  /* left join so that we include the ones that match */
                    patientMedRecord ON patient.patientID = patientMedRecord.patientID
                LEFT JOIN 
                    Procedures ON patient.patientID = Procedures.PatientID
                LEFT JOIN
                    patientAppts ON patientAppts.patientID = patient.patientID
                LEFT JOIN
                    Doctors ON Doctors.DoctorID = patientAppts.DoctorID
                WHERE
                    receptionist.id = {$_SESSION['receptionistID']}
                    ");


                while ($row = mysqli_fetch_assoc($result)){
                    echo "<td>" . $row['ReceptionistName'] . "</td>";
                    echo "<td>" . $row['ReceptionistID'] . "</td>";
                    echo "<td>" . $row['ReceptionistPhoneNumber'] . "</td>";
                    echo "<td>" . $row['ReceptionistEmailAddress'] . "</td>";
                    echo "<td>" . $row['PatientName'] . "</td>";
                    echo "<td>" . $row['PatientID'] . "</td>";
                    echo "<td>" . $row['PatientDOB'] . "</td>";
                    echo "<td>" . $row['PatientAge'] . "</td>";
                    echo "<td>" . $row['PatientPhoneNumber'] . "</td>";
                    echo "<td>" . $row['PatientAddress'] . "</td>";
                    echo "<td>" . $row['PatientShotRecord'] . "</td>";
                    echo "<td>" . $row['PatientIllnesses'] . "</td>";
                    echo "<td>" . $row['AppointmentDate'] . "</td>";
                    echo "<td>" . $row['AppointmentType'] . "</td>";
                    echo "<td>" . $row['ProcedureDate'] . "</td>";
                    echo "<td>" . $row['ProcedureType'] . "</td>";
                    echo "<td>" . $row['DoctorName'] . "</td>";
                    echo "<td>" . $row['DoctorID'] . "</td></tr>";
                    echo "\n";
                }

            ?>

            </tbody>
        </table>
        </div>
    
    <footer class = "c">
        <button id = "homeButton" onclick = "redirect()">Home Button</button>;
    </footer>
    <script>
        function redirect() {
            // Redirect to the Doctors Receptionist Database page
            window.location.href = "main.html";
        }
    </script>
    </body>
</html>