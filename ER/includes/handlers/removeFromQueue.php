<?php

$flag = 'f';
$reset = 0;
$reset_a = 0;
$reset_b = 0;
$reset_c = 0;
$reset_d = 0;

$a = 0;
$b = 0;
$c = 0;
$d = 0;

//Connect to the database
require '../../../config/config.php';

if(isset($_POST['remove_Patient'])){

    $query = mysqli_query($con, "SELECT * FROM er_a");
    if(!$query){
        echo "Error: (category a) " . mysqli_error($con);
    }
    $a_count = mysqli_num_rows($query);


    $query = mysqli_query($con, "SELECT * FROM er_b");
    if(!$query){
        echo "Error: (category b) " . mysqli_error($con);
    }
    $b_count = mysqli_num_rows($query);

    $query = mysqli_query($con, "SELECT * FROM er_c");
    if(!$query){
        echo "Error: (category c) " . mysqli_error($con);
    }
    $c_count = mysqli_num_rows($query);

    $query = mysqli_query($con, "SELECT * FROM er_d");
    if(!$query){
        echo "Error: (category d) " . mysqli_error($con);
    }
    $d_count = mysqli_num_rows($query);



    $query = mysqli_query($con, "SELECT * FROM er_queue");
    if(!$query){
        echo "Error: (Which category) " . mysqli_error($con);
    }

    $row = mysqli_fetch_array($query);

    $a = (int) $row['a'];
    $b = (int) $row['b'];
    $c = (int) $row['c'];
    $d = (int) $row['d'];

/*
    if($a >= 4 and $b >= 2 and $c >= 1 and $d >= 1){
        $reset = 1;
    }
    elseif($a_count == 0 and $b >= 2 and $c >= 1 and $d >= 1)
    {
        $reset = 1;
    }
    elseif($b_count == 0 and $a >= 4 and $c >= 1 and $d >= 1)
    {
        $reset = 1;
    }
    elseif($c_count == 0 and $b >= 2 and $a >= 4 and $d >= 1)
    {
        $reset = 1;
    }
    elseif($d_count == 0 and $b >= 2 and $c >= 1 and $a >= 4)
    {
        $reset = 1;
    }
    else{
        $reset = 0;
    }

*/

    if($a >= 4 or $a_count == 0){
        $reset_a = 1;
        echo "reset a\n";
    }
    if($b >= 2 or $b_count == 0)
    {
        $reset_b = 1;
        echo "reset b\n";
    }
    if($c >= 1 or $c_count == 0)
    {
        $reset_c = 1;
        echo "reset c\n";
    }
    if($d >= 1 or $d_count == 0)
    {
        $reset_d = 1;
        echo "reset d\n";
    }
    
    if($reset_a and $reset_b and $reset_c and $reset_d )
    {
        $reset = 1;
        echo "Reset all\n";
    }
    else{
        $reset = 0;
    }

    if($reset){
        $a = 0;
        $b = 0;
        $c = 0;
        $d = 0;
        $query = mysqli_query($con, "UPDATE er_queue SET a='$a', b='$b', c='$c', d='$d' WHERE flag='$flag'");

        if(!$query){
            echo "Error (reset categories): " . mysqli_error($con);
        }

        $reset_a = 0;
        $reset_b = 0;
        $reset_c = 0;
        $reset_d = 0;

        if($a_count == 0){
        $reset_a = 1;
        }
        if($b_count == 0)
        {
            $reset_b = 1;
        }
        if($c_count == 0)
        {
            $reset_c = 1;
        }
        if($d_count == 0)
        {
            $reset_d = 1;
        }
    }

/*
    if(($a < 4 and $a_count > 0) or ($a_count > 0 and $b_count == 0 and $c_count == 0 and $d_count == 0 )){
        $a = $a + 1;
        $category = 'a';
    }
    elseif(($b < 2 and $b_count > 0 ) or ($b_count > 0 and $a_count == 0 and $c_count == 0 and $d_count == 0 )){
        $b = $b + 1;
        $category = 'b';
    }
    elseif(($c < 1 and $c_count > 0) or ($c_count > 0 and $b_count == 0 and $a_count == 0 and $d_count == 0 )){
        $c = $c + 1;
        $category = 'c';
    }
    elseif(($d < 1 and $d_count > 0) or ($d_count > 0 and $b_count == 0 and $c_count == 0 and $a_count == 0 )){
        $d = $d + 1;
        $category = 'd';
    }

    */

    if(!$reset_a){
        $a = $a + 1;
        $category = 'a';
        echo "picked a\n";
    }
    elseif(!$reset_b){
        $b = $b + 1;
        $category = 'b';
        echo "picked b\n";
    }
    elseif(!$reset_c){
        $c = $c + 1;
        $category = 'c';
        echo "picked c\n";
    }
    elseif(!$reset_d){
        $d = $d + 1;
        $category = 'd';
        echo "picked d\n";
    }

    $query = mysqli_query($con, "UPDATE er_queue SET a='$a', b='$b', c='$c', d='$d' WHERE flag='$flag'");

    if(!$query){
        echo "Error (update categories): " . mysqli_error($con);
    }

    //Delete patient from the doctor's queue
	$query = mysqli_query($con, "DELETE FROM er_q WHERE category='$category' ORDER BY ts ASC LIMIT 1");

}

header("Location: ../../doctor.php");
exit();



?>


