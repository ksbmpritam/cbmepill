<?php

//import.php
error_reporting(E_ALL);
ini_set('display_errors', 1);


include 'excel/vendor/autoload.php';

$connect = new PDO("mysql:host=localhost;dbname=wwwangir_angiralive", "wwwangir_angiralive", "Angiralive");


if(isset($_POST['importsss'])){
if($_FILES["import_excel"]["name"] != '')
{
 $allowed_extension = array('xls', 'csv', 'xlsx');
 $file_array = explode(".", $_FILES["import_excel"]["name"]);
 $file_extension = end($file_array);
//print_r($file_extension);die;
 if(in_array($file_extension, $allowed_extension))
 {
  $file_name = time() . '.' . $file_extension;
  move_uploaded_file($_FILES['import_excel']['tmp_name'], $file_name);
  $file_type =\PhpOffice\PhpSpreadsheet\IOFactory::identify($file_name);
  $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($file_type);

  $spreadsheet = $reader->load($file_name);

  unlink($file_name);

  $data = $spreadsheet->getActiveSheet()->toArray();


print_r($data);die;
  foreach($data as $row)
  {
   $insert_data = array(
    ':first_name'  => $row[0],
    ':last_name'  => $row[1],
    ':created_at'  => $row[2],
    ':updated_at'  => $row[3]
   );

   $query = "
   INSERT INTO sample_datas 
   (first_name, last_name, created_at, updated_at) 
   VALUES (:first_name, :last_name, :created_at, :updated_at)
   ";

   $statement = $connect->prepare($query);
   $statement->execute($insert_data);
  }
  $message = '<div class="alert alert-success">Data Imported Successfully</div>';

 }
 else
 {
  $message = '<div class="alert alert-danger">Only .xls .csv or .xlsx file allowed</div>';
 }
}
else
{
 $message = '<div class="alert alert-danger">Please Select File</div>';
}

echo $message;
}
?>