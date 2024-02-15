<?php 
    include'db.php';
    if(isset($_POST['e_id'])  || isset($_GET['e_id']) )
    {
        
        if(isset($_POST['e_id'])){
            
            $e_id = $_POST['e_id'];
            
        }else{
            
            $e_id = $_GET['e_id'];
   
        }
            
        $data=array();
        
         $sql="select Question as question,option_1 as option_a,option_2 as option_b,option_3 as option_c,option_4 as option_d,id as q_id,answer as correct_ans,image, image_opt1,image_opt2,image_opt3,image_opt4 from question where e_id='$e_id' order by id asc";
        mysqli_set_charset($con,"utf8");
        $query=mysqli_query($con,$sql);
        // echo $sql;
        // exit;
        if(mysqli_num_rows($query)>0)
        {
            mysqli_set_charset($con,"utf8");
            $time=mysqli_fetch_assoc(mysqli_query($con,"select exam_time from exam where id='".$e_id."'"))['exam_time']*60000;
            $percentage='18';
            $i=0;
            $all_data=array();
            
            while($row=mysqli_fetch_assoc($query))
            {  
                if($row['image']!='')
                {
                 $row['image']='http://angirasuratgarhlive.com/ksbmadmin/images/ExamAns/'.$row['image'];
                }
                
                 if($row['image_opt1']!='')
                {
                 $row['image_opt1']='http://angirasuratgarhlive.com/ksbmadmin/images/ExamAns/'.$row['image_opt1'];
                }
                if($row['image_opt2']!='')
                {
                 $row['image_opt2']='http://angirasuratgarhlive.com/ksbmadmin/images/ExamAns/'.$row['image_opt2'];
                }
                 if($row['image_opt3']!='')
                {
                 $row['image_opt3']='http://angirasuratgarhlive.com/ksbmadmin/images/ExamAns/'.$row['image_opt3'];
                }
                 if($row['image_opt4']!='')
                {
                 $row['image_opt4']='http://angirasuratgarhlive.com/ksbmadmin/images/ExamAns/'.$row['image_opt4'];
                }
               
                
                $all_data[]=$row;
                
                $row['question']=str_replace("&#39;","'",str_replace("&minus;","-",str_replace("&ndash;","-",str_replace("&amp;","",str_replace("&nbsp;","", str_replace("\n","\n",str_replace("\r","",$row['question']))))))); 
                $row['option_a']=str_replace("&#39;","'",str_replace("&minus;","-",str_replace("&ndash;","-",str_replace("&amp;","",str_replace("&nbsp;","",str_replace("\n","",str_replace("\r","",$row['option_a']))))))); 
                $row['option_b']=str_replace("&#39;","'",str_replace("&minus;","-",str_replace("&ndash;","-",str_replace("&amp;","",str_replace("&nbsp;","",str_replace("\n","",str_replace("\r","",$row['option_b'])))))));
                $row['option_c']=str_replace("&#39;","'",str_replace("&minus;","-",str_replace("&ndash;","-",str_replace("&amp;","",str_replace("&nbsp;","",str_replace("\n","",str_replace("\r","",$row['option_c'])))))));
                $row['option_d']=str_replace("&#39;","'",str_replace("&minus;","-",str_replace("&ndash;","-",str_replace("&amp;","",str_replace("&nbsp;","",str_replace("\n","",str_replace("\r","",$row['option_d'])))))));
                
                $data[]=$row;
            }
            
            $sent=array();
            $sent['Response']=$all_data;
            $sent['status']=1;
            $sent['time']=$time;
            $sent['Percentage']=$percentage;
            // print_r($all_data);
            $response= json_encode($sent, JSON_UNESCAPED_UNICODE);
           
            echo $response;
        }
        else
        {
            echo json_encode(array("status"=>"0","Response"=>"No Data Found"));
        }
    }
    else
    {
        echo json_encode(array("status"=>"0","Response"=>"Please Fill All Data"));
    }
?>