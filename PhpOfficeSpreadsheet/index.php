<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 9/4/2018
 * Time: 7:35 PM
 */

require "vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


$spreadsheet = new Spreadsheet();

try{
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->getColumnDimension('A')->setWidth('20');
    $sheet->setCellValue('A1', 'Hello World !');

    $writer = new Xlsx($spreadsheet);
    $writer->save('hello world.xlsx');
    echo "Saved successfully";
}
catch (\PhpOffice\PhpSpreadsheet\Exception $x){
    echo "" . $x;
}



