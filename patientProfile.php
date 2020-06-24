<?php 
    require 'config/config.php';
    require_once(__DIR__.'/includes/classes/Doctor.php');
    require_once(__DIR__.'/includes/classes/Patient.php');


    $patientID = "";
    $docID = "";


    //Get Patient info
    $patient = new Patient($con, $patientID);

    $patient_Name = $patient->getName();



    //Get doctor info
    $doc = new Doctor($con, $patientID, $docID);
    
    $doc_Name = $doc->getName();
    $doc_Lname = $doc->getLname();





?>