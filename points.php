<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 9/24/2018
 * Time: 8:42 PM
 */

session_start();
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = new mysqli("localhost", "root", "", "bottle_db");
    date_default_timezone_set('Asia/Manila');
    $date = date('h:i:s', time());
    $db->query("insert into point_ (point, datesubmitted) values ('" . $_POST["point"] . "', '" . $date . "')");
    header("location:student.php");
}

?>