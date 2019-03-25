<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 9/8/2018
 * Time: 6:26 PM
 */
include "index-header.php";
?>

<div id="main-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel-content">
                    <!--start col-5-->
                    <div class="col-md-4">
                        <!-- START FORM ADD STUDENT -->
                        <form action="addstudent.php" method="post">
                            <h1 class="heading"><i class="fa fa-square"></i>Add Student</h1>

                            <div class="form-group row">
                                <label for="idnumber" class="col-sm-3 col-form-label">ID Number:</label>
                                <div class="col-sm-7 col-md-8">
                                    <input name="idnumber" type="number" class="form-control" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="studentname" class="col-sm-3 col-form-label">Name:</label>
                                <div class="col-sm-7 col-md-8">
                                    <input name="studentname" type="text" class="form-control" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="department" class="col-sm-3 col-form-label">Department:</label>
                                <div class="col-sm-7 col-md-8">
                                    <select name="department" class="form-control">
                                        <option value="EA">EA</option>
                                        <option value="ACC">ACC</option>
                                        <option value="ABC">ABC</option>
                                        <option value="BHM">BHM</option>
                                        <option value="EDUC">EDUC</option>
                                        <option value="CS">CS</option>
                                    </select>
                                </div>
                            </div>

                            <input type="submit" value="Add Student" class="btn btn-primary">
                        </form>
                        <!-- END FORM ADD STUDENT-->

                        <br>
                        <br>
                        <h1 class="heading"><i class="fa fa-square"></i>Over-all Tally</h1>
                        <div id="txthint2"></div>
                        <br>
                        <br>
                        <h1 class="heading"><i class="fa fa-square"></i>Point Settings</h1>

                        <form action="points.php" method="post">
                            <div class="form-group row">
                                <label for="point" class="col-sm-3 col-form-label">Point:</label>
                                <div class="col-sm-7 col-md-8">
                                    <input name="point" type="text" class="form-control" required>
                                </div>
                            </div>
                            <input type="submit" value="Change Points" class="btn btn-primary">
                        </form>
                        <br>
                        <br>

                        <!-- start form download excel file-->
                        <form action="excel.php" method="post">
                            <h1 class="heading"><i class="fa fa-square"></i>Downloadables</h1>

                            <div class="form-group row">
                                <label for="ddepartment" class="col-sm-3 col-form-label">Department:</label>
                                <div class="col-sm-7 col-md-8">
                                    <select name="ddepartment" class="form-control">
                                        <option value="EA">EA</option>
                                        <option value="ACC">ACC</option>
                                        <option value="ABC">ABC</option>
                                        <option value="BHM">BHM</option>
                                        <option value="EDUC">EDUC</option>
                                        <option value="CS">CS</option>
                                    </select>
                                </div>
                            </div>

                            <input type="submit" class="btn btn-primary" value="Download Excel File">
                        </form>

                        <!--end form download excel -->
                    </div>
                    <!-- end col-5-->

                    <!--start col-7-->
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="sname" class="col-sm-3 col-form-label">ID Number:</label>
                                    <div class="col-sm-7 col-md-8">
                                        <input type="text" class="form-control" name="sname"">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="sdepartment" class="col-sm-3 col-form-label">Department:</label>
                                    <div class="col-sm-7 col-md-8">
                                        <select name="sdepartment" class="form-control">
                                            <option value="ALL">ALL</option>
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
                        </div>

                        <div id="tablestudents"></div>
                    </div>
                    <!--end col-7-->
                </div>
            </div>
        </div>
    </div>
</div>


<?php
include "index-footer.php";
?>
