<?php
if(isset($_POST["importData"]))
{

                $url='localhost';
                $username='wwwangir_angiralive';
                $password='Angiralive';
                $conn=mysqli_connect($url,$username,$password,"wwwangir_angiralive");
          if(!$conn){
          die('Could not Connect My Sql:' .mysqli_error());
		  }
          $file = $_FILES['file']['tmp_name'];
          $handle = fopen($file, "r");
          $c = 0;
          while(($filesop = fgetcsv($handle, 1000, ",")) !== false)
                    {
          $e_id = $filesop[0];
          $Question = $filesop[1];
          $option_1 = $filesop[2];
          $option_2 = $filesop[3];
          $option_3 = $filesop[4];
          $option_4 = $filesop[5];
          $answer = $filesop[6];

        //   $sql = "insert into excel(fname,lname) values ('$fname','$lname')";
          
           $sql = "INSERT into question (e_id,Question,option_1,option_2,option_3,option_4,answer) 
                   values ('$e_id','$Question','$option_1','$option_2','$option_3','$option_4','$answer')";
                
          
          $stmt = mysqli_prepare($conn,$sql);
          $result=mysqli_stmt_execute($stmt);

         $c = $c + 1;
           }

            if($result)
                {
                    //echo 'Successfully inserted';
                    $type = "success";
                    $statusMsg = "CSV File has been successfully Imported !";
                    //$insertrow=$insertrow+1;
                }
                else
                {
                  $type = "error";
                  $statusMsg = "Invalid File:Some Error in CSV file please check again !";    
                }
                

}
?>