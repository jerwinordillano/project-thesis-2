<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 9/28/2018
 * Time: 3:30 PM
 */

$dbcon = new mysqli("localhost", "root", "", "bottle_db");
$result = $dbcon->query("select point from point_ order by P_ID desc limit 1");

$result2 = $dbcon->query("select sum(bottle_) as 'Bottles' from history_ where datetimereg_ like concat('".date("Y")."', '%')");
?>

<span>Current points per bottle: <b><?php echo $result->fetch_assoc()["point"] ?> points</b></span><br>
<span>Total bottles this year: <b><?php echo $result2->fetch_assoc()["Bottles"] ?> bottles</b></span>
