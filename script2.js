
var receptionistButton = document.getElementById("receptionistDatabase");
var patientButton = document.getElementById("patientDatabase");
var patientAppts = document.getElementById("patientAppts");
var patientMedRecord = document.getElementById("patientMedRecord");

receptionistButton.addEventListener("mouseover",function(){
    receptionistButton.style.backgroundColor = "black";
});

receptionistButton.addEventListener("mouseout",function(){
    receptionistButton.style.backgroundColor = "#007BFF";
});

receptionistButton.addEventListener("click",function(){
    window.location.href = "receptionist.php";
});


patientButton.addEventListener("mouseover",function(){
    patientButton.style.backgroundColor = "black";
});

patientButton.addEventListener("mouseout",function(){
    patientButton.style.backgroundColor = "#007BFF";
});

patientButton.addEventListener("click",function(){
    window.location.href = "patient.php";
});

patientAppts.addEventListener("mouseover",function(){
    patientAppts.style.backgroundColor = "black";
});

patientAppts.addEventListener("mouseout",function(){
    patientAppts.style.backgroundColor = "#007BFF";
});

patientAppts.addEventListener("click",function(){
    window.location.href = "patientAppts.php";
});

patientMedRecord.addEventListener("mouseover",function(){
    patientMedRecord.style.backgroundColor = "black";
});

patientMedRecord.addEventListener("mouseout",function(){
    patientMedRecord.style.backgroundColor = "#007BFF";
});

patientMedRecord.addEventListener("click",function(){
    window.location.href = "patientMedRecord.php";
});

