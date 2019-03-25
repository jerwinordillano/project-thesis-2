<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST["idnumber"]) && isset($_POST["studentname"]) && isset($_POST["department"])){
        $dbcon = new mysqli("localhost", "root", "", "bottle_db");
        $dbcon->query("INSERT INTO student_ values ('".$_POST["idnumber"]."','".$_POST["studentname"]."','".$_POST["department"]."',null,null)");
        header("location:student.php");
    }
}

?>