<?php
  include("db.php");
  if($_POST['userid']=='')
  {
      echo json_encode(array("status"=>"0","Response"=>"Userid balnk"));
  }
  else
  {
    date_default_timezone_set("Asia/Calcutta");   
    $today=date('d-m-Y');  
    $query=mysqli_query($con,'select * from payment where user_id="'.$_POST['userid'].'" order by  date asc');
    if(mysqli_num_rows($query)>0)
    {
           $row=mysqli_fetch_assoc($query);
            echo "<pre>";
            print_r($row);
            echo "</pre>";
    /*
        
        $row=mysqli_fetch_assoc($query);
        $time = strtotime($row['date']);
        $final = date("d-m-Y", strtotime("+6 month", $time));
        if($final==$today)
        {
            echo "<pre>";
            print_r($row);
            echo "</pre>";
            if($row['type']=='1')
            {
                echo $row['course_id'];
            }
            elseif($row['type']=='2')
            {
                
            }
            elseif($row['type']=='3')
            {
                
            }
            elseif($row['type']=='4')
            {
                
            }
            elseif($row['type']=='5')
            {
                
            }
        }
    */}
    else
    {
        echo json_encode(array("status"=>"0","Response"=>"Data Not Exist"));
    }
  
  }
?>