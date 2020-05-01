<?php 

$type = "";
$id = "";

if(isset($_POST['register_button'])) {

        $id = strip_tags($_POST['reg_ssn']); //Remove html tags
        $id = str_replace(' ', '', $id); //remove spaces
        $id = ucfirst(strtolower($id)); //Uppercase first letter

        $check_database_query = mysqli_query($con, "SELECT position FROM employees WHERE ssn='$id'");
        $check_login_query = mysqli_num_rows($check_database_query);

        if($check_login_query == 1){
            $row = mysqli_fetch_assoc($check_database_query);
            if($row["position"] === "1"){
                $type = "doctor";
            } else {
                $type = "receptionist";
            }
        } else{
            $check_database_query = mysqli_query($con, "SELECT * FROM patients WHERE id='$id'");
            $check_login_query = mysqli_num_rows($check_database_query);

            if($check_login_query == 1){
                $type = "patient";
            } else {
                echo "you are not registered in the system, please visit the receptionist's desk to get registered.";
            }
        }
    }


?>
