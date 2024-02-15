<?php
require("includes/function.php");

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=mcqs.csv');
$output = fopen("php://output", "w");

$data = array(
    'MCQ Id', 
    'Category', 
    'Sub Category', 
    'Question', 
    'Options', 
    'Right Answer', 
    );

fputcsv($output, $data);

$query = "SELECT m.id,tc.category_name,sc.name,m.title_text,m.options,m.right_option FROM mcq m JOIN tbl_category tc JOIN sub_categories sc WHERE m.c_id=tc.cid AND m.sc_id=sc.id";
$result = mysqli_query($mysqli, $query);

while ($row = mysqli_fetch_assoc($result)) {
    fputcsv($output, $row);
}
fclose($output);

?>