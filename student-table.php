<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 9/8/2018
 * Time: 8:29 PM
 */

if($_SERVER["REQUEST_METHOD"] == "GET"){
    $dbcon = new mysqli("localhost", "root", "", "bottle_db");
    if(isset($_GET["mode"])){
        if($_GET["mode"] == "keyup"){
            if(isset($_GET["search"])){
                $rt = $_GET["search"];
                $result = $dbcon->query("select studID_ as 'ID', dept_ as 'Department', fullname_ as 'Name', coalesce(totalbottle_, '0') as 'Total Bottle', coalesce(totalpoints_, '0') as 'Total Points' from student_ where studID_ like CONCAT('$rt','%')");
            }
            else{
                $result = $dbcon->query("select studID_ as 'ID', dept_ as 'Department', fullname_ as 'Name', coalesce(totalbottle_, '0') as 'Total Bottle', coalesce(totalpoints_, '0') as 'Total Points' from student_");
            }
        }
        else{
            if(isset($_GET["search"]) && $_GET["search"] != "ALL"){
                $rt = $_GET["search"];
                $result = $dbcon->query("select studID_ as 'ID', dept_ as 'Department', fullname_ as 'Name', coalesce(totalbottle_, '0') as 'Total Bottle', coalesce(totalpoints_, '0') as 'Total Points' from student_ where dept_ = '$rt'");
            }
            else{
                $result = $dbcon->query("select studID_ as 'ID', dept_ as 'Department', fullname_ as 'Name', coalesce(totalbottle_, '0') as 'Total Bottle', coalesce(totalpoints_, '0') as 'Total Points' from student_");
            }
        }
    }
    else{
        $result = $dbcon->query("select studID_ as 'ID', dept_ as 'Department', fullname_ as 'Name', coalesce(totalbottle_, '0') as 'Total Bottle', coalesce(totalpoints_, '0') as 'Total Points' from student_");
    }

    echo "<table class='table table-hover'>";
    echo "<thead>";
    $colname = $result->fetch_fields();
    echo "<tr>";
    for($x=0;$x<count($colname);$x++){
        echo "<th>" . $colname[$x]->name ."</th>";
    }
    echo "<tr>";
    echo "</thead>";

    while ($row_users = mysqli_fetch_array($result)) {
        //output a row here
        echo "<tr class='click-row' data-idnum='".$row_users[0]."' data-name='".$row_users[2]."' data-dept='".$row_users[1]."' data-toggle='modal' data-target='#large-modal'>";
        for($x=0;$x<count($colname);$x++){
            echo "<td>$row_users[$x]</td>";
        }
        echo "</tr>";
    }

    echo "</table>";
    $_GET["search"] = null;
    $dbcon->close();
}
?>

<div id="large-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Edit Student Profile</h4>
            </div>
            <form action="editstudent.php" method="post">
                <div class="modal-body">

                    <div class="form-group row">
                        <label for="id2number" class="col-sm-3 col-form-label">ID Number:</label>
                        <div class="col-sm-7 col-md-8">
                            <input type="text" class="form-control" name="id2number" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="student2name" class="col-sm-3 col-form-label">Name:</label>
                        <div class="col-sm-7 col-md-8">
                            <input name="student2name" type="text" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="department2" class="col-sm-3 col-form-label">Department:</label>
                        <div class="col-sm-7 col-md-8">
                            <select name="department2" class="form-control">
                                <option value="EA">EA</option>
                                <option value="ACC">ACC</option>
                                <option value="ABC">ABC</option>
                                <option value="BHM">BHM</option>
                                <option value="EDUC">EDUC</option>
                                <option value="CS">CS</option>
                            </select>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary"><i class="fa fa-check-circle"></i> Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>