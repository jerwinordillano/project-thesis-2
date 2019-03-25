<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10/7/2018
 * Time: 12:20 AM
 */



require "PhpOfficeSpreadsheet/vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;


if($_SERVER["REQUEST_METHOD"] == "POST"){
    $dept = $_POST["ddepartment"];

    if($dept == "EA"){
        $department = "Engineering and Architecture Department";
    }
    else if($dept == "ACC"){
        $department = "Accountancy Department";
    }
    else if($dept == "ABC"){
        $department = "Liberal Arts and Criminology Department";
    }
    else if($dept == "BHM"){
        $department = "Business and Hospitality Management Department";
    }
    else if($dept == "EDUC"){
        $department = "Education Department";
    }
    else if($dept == "CS"){
        $department = "Computer Studies Department";
    }
}

$spreadsheet = new createNewExcel();
$dbcon = new mysqli("localhost", "root", "", "bottle_db");
$spreadsheet->withText("A1:O2", "A1", Alignment::HORIZONTAL_CENTER, Alignment::VERTICAL_CENTER, "FFFFFF", "375623", "Divine Word College of Calapan");
$spreadsheet->withText("A3:O3", "A3", Alignment::HORIZONTAL_CENTER, Alignment::VERTICAL_CENTER, "FFFFFF", "538135", "Gov't. Infantado St. Calapan City");
$spreadsheet->whiteSpace("A4:O5", "A4");
$spreadsheet->withText("A6:O7", "A6", Alignment::HORIZONTAL_CENTER, Alignment::VERTICAL_CENTER, "FFFFFF", "538135", "Bottle-For-Fines");
$spreadsheet->whiteSpace("A8:O8", "A8");
$spreadsheet->withText("A9:O10", "A9", Alignment::HORIZONTAL_CENTER, Alignment::VERTICAL_CENTER, "FFFFFF", "375623", "Department: ".$department);
$spreadsheet->whiteSpace("A11:O11", "A11");
$spreadsheet->withText("A12:B13", "A12", Alignment::HORIZONTAL_CENTER, Alignment::VERTICAL_CENTER, "FFFFFF", "538135", "ID Number");
$spreadsheet->withText("C12:G13", "C12", Alignment::HORIZONTAL_CENTER, Alignment::VERTICAL_CENTER, "FFFFFF", "538135", "Name");
$spreadsheet->withText("H12:I13", "H12", Alignment::HORIZONTAL_CENTER, Alignment::VERTICAL_CENTER, "FFFFFF", "538135", "Total Bottle");
$spreadsheet->withText("J12:K13", "J12", Alignment::HORIZONTAL_CENTER, Alignment::VERTICAL_CENTER, "FFFFFF", "538135", "Points Recieved");
$spreadsheet->withText("L12:M13", "L12", Alignment::HORIZONTAL_CENTER, Alignment::VERTICAL_CENTER, "FFFFFF", "538135", "Points");
$spreadsheet->withText("N12:O13", "N12", Alignment::HORIZONTAL_CENTER, Alignment::VERTICAL_CENTER, "FFFFFF", "538135", "Total Points");

$result = $dbcon->query("select studID_ as 'ID', fullname_ as 'Name', coalesce(totalbottle_, '0') as 'Total Bottle', coalesce(totalpoints_, '0') as 'Total Points' from student_ where dept_ = '$dept'");

$lastnumber = 0;
if(mysqli_num_rows($result)){
    for($x = 14; $row = $result->fetch_assoc(); $x++){
        $spreadsheet->withText("A".$x.":B".$x."", "A".$x."", Alignment::HORIZONTAL_LEFT, Alignment::VERTICAL_CENTER, "000000", "FFFFFF", "".$row["ID"]);
        $spreadsheet->withText("C".$x.":G".$x."", "C".$x."", Alignment::HORIZONTAL_LEFT, Alignment::VERTICAL_CENTER, "000000", "FFFFFF", "".$row["Name"]);
        $spreadsheet->withText("H".$x.":I".$x."", "H".$x."", Alignment::HORIZONTAL_RIGHT, Alignment::VERTICAL_CENTER, "000000", "FFFFFF", "".$row["Total Bottle"]);
        $spreadsheet->withText("J".$x.":K".$x."", "J".$x."", Alignment::HORIZONTAL_RIGHT, Alignment::VERTICAL_CENTER, "000000", "FFFFFF", "".$row["Total Points"]);
        $spreadsheet->whiteSpace("L".$x.":M".$x."", "L".$x."");
        $spreadsheet->whiteSpace("N".$x.":O".$x."", "N".$x."");
        $lastnumber = $x;
    }
}
$spreadsheet->borderAll("A1:O".$lastnumber);
$spreadsheet->saveExcel("helloworld.xlsx");

class createNewExcel{

    public $spreadsheet;
    public $sheet;
    public $writer;

    function __construct()
    {
        $this->spreadsheet = new Spreadsheet();
        try{
            $this->sheet = $this->spreadsheet->getActiveSheet();
        }
        catch (Exception $x){

        }
    }

    function withText($pRange, $pCellCoordinate, $horizontalClass, $verticalClass, $fontColor, $HEXfill, $text){
        try{
            $this->sheet->mergeCells($pRange);
            $this->sheet->getStyle($pCellCoordinate)->getAlignment()->setHorizontal($horizontalClass);
            $this->sheet->getStyle($pCellCoordinate)->getAlignment()->setVertical($verticalClass);
            $this->sheet->getStyle($pCellCoordinate)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($HEXfill);
            $this->sheet->getStyle($pCellCoordinate)->getFont()->getColor()->setARGB($fontColor);
            $this->sheet->setCellValue($pCellCoordinate, $text);
        }
        catch (Exception $x){

        }
    }

    function whiteSpace($pRange, $pCellCoordinate){
        try{
            $this->sheet->mergeCells($pRange);
            $this->sheet->getStyle($pCellCoordinate)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB("FFFFFF");
        }
        catch (Exception $x){

        }
    }

    function borderAll($pRange){
        try{
            $this->sheet->getStyle($pRange)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        }
        catch (Exception $x){

        }
    }

    function saveExcel($filename){
        try{
            $this->writer = new Xlsx($this->spreadsheet);
            $this->writer->save($filename);
        }
        catch (Exception $x){

        }
    }
}
