<?php

if (isset($_POST['submit'])) 
{
    mysql_set_charset('utf8');

 
//Import uploaded file to Database
$handle = fopen($_FILES['filename']['tmp_name'], "r");
 

 while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
 print_r($data);die;
 echo $data[0]." > ";
  echo $data[1]." > ";
   echo $data[2]." > ";
   echo $data[2]." > ";
 mysql_query("INSERT into hindii (user_name, first_name, last_name, date_added)
 values('$data[0]', '$data[1]', '$data[2]', NOW())");
 
 }
 
fclose($handle);
header( 'Content-Type: text/html; charset=utf-8' );

//print "Import done";
echo "<script type='text/javascript'>alert('Successfully Imported a CSV File for User!');</script>";
echo "<script>document.location='index.php'</script>";
//view upload form
}
?>
<html>
<head>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />

<body>
<form  method="post" name="upload_excel" enctype="multipart/form-data">
<div>
 <label>Import CSV/Excel File:</label>
 <input type="file" multiple name="filename" id="filename">
 <button type="submit" id="submit" name="submit" data-loading-text="Loading...">Upload</button>
</div>
</form>
<body>
</head>
</html>