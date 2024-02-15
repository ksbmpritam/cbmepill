<?php
require("includes/function.php");

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=pills.csv');
$output = fopen("php://output", "w");

$data = array(
    'Pill Id', 
    'Pill Name', 
    'Pill Code', 
    'Pill Description', 
    'Pill Benefits', 
    );

fputcsv($output, $data);

$query = "SELECT * FROM `pills`";
$result = mysqli_query($mysqli, $query);

while ($row = mysqli_fetch_assoc($result)) {
    fputcsv($output, $row);
}
fclose($output);

?>