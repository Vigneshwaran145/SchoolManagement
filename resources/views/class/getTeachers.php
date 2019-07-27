<?php 
    $con = new mysqli("localhost", "root", "", "student");
    if($con->connect_error)
    {
        die($con->connect_error);
    }
    echo "<option value='2'>Vicky!!</option>";

?>