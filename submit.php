<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 9/28/2018
 * Time: 3:44 PM
 */

$db = new mysqli("localhost", "root", "", "bottle_db");
$now = new DateTime();
$db->query("insert into history_ (bottle_,studID_, datetimereg_) values ('".$_GET["b"]."','".$_GET["i"]."','".$now->format('Y-m-d H:i:s')."')");
$result = $db->query("select point from point_ order by P_ID desc limit 1");

$x = $result->fetch_assoc()["point"];

$totalpoints = ($_GET["b"] * $x) + $db->query("select coalesce(totalpoints_, '0') as 'Total Points' from student_ where studID_ = '".$_GET["i"]."'")->fetch_assoc()["Total Points"];
$totalbottle = $_GET["b"] + $db->query("select coalesce(totalbottle_, '0') as 'Total Bottles' from student_ where studID_ = '".$_GET["i"]."'")->fetch_assoc()["Total Bottles"];

$db->query("update student_ set totalbottle_ = '".$totalbottle."', totalpoints_ = '".$totalpoints."' where studID_ = '".$_GET["i"]."'");

echo "Successfully Saved!";
?>