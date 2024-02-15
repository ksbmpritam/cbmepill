<meta http-equiv="Content-Type" content="text/csv;charset=UTF-8">
<?php 
// Load the database configuration file 
include("includes/connection.php"); 

$id=$_GET['id'];
$e_id=base64_decode($id);
 
$filename = "Questions_" . date('Y-m-d') . ".csv"; 
$delimiter = ","; 
 
// Create a file pointer 
$f = fopen('php://memory', 'w');

// Set column headers 
$fields = array('QuestionName', 'Question1', 'Question2', 'Question3', 'Question4', 'ANSWER'); 
fputcsv($f, $fields, $delimiter); 
 
// Get records from the database 
$sql="SELECT * FROM question where e_id='$e_id'"; 
mysqli_set_charset($mysqli,"utf8");
$result = mysqli_query($mysqli, $sql);
$rowcount=mysqli_num_rows($result);

if($rowcount > 0){ 
    // Output each row of the data, format line as csv and write to file pointer 
    while($row = mysqli_fetch_assoc($result)){ 
        $lineData = array($row['Question'], $row['option_1'], $row['option_2'], $row['option_3'], $row['option_4'], $row['answer']); 
        fputcsv($f, $lineData, $delimiter); 
    } 
} 
 
// Move back to beginning of file 
fseek($f, 0); 
 
// Set headers to download file rather than displayed 
// header('Content-Type: text/csv'); 
header('Content-Disposition: attachment; filename="' . $filename . '";'); 
header("content-type:application/csv;charset=UTF-8");


// Output all remaining data on a file pointer 
fpassthru($f); 
 
// Exit from file 
exit();
?>