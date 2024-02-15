<meta http-equiv="Content-Type" content="text/csv;charset=UTF-8">
<?php
include("includes/connection.php");


header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=result_file.csv");
header("Pragma: no-cache");
header("Expires: 0");


outputCSV();

function outputCSV() {
    
    $filename = "Questions_" . date('Y-m-d') . ".csv"; 
    $delimiter = ",";
    $output = fopen("php://output", "w");
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
   
    fclose($lineData);
}
?>