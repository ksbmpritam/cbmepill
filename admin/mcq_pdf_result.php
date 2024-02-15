<?php
require_once __DIR__ . '/mpdf/vendor/autoload.php';
require("includes/function.php");

$mpdf = new \Mpdf\Mpdf();
$template = file_get_contents("result_template.php");


$user_id = $_GET['user_id'];
$cid = $_GET['cid'];
$sc_id = $_GET['sc_id'];

#This is for count total question
$sql = "SELECT m.title_text,m.title_img,m.options,m.right_option,md.answer ,m.why_ans_mcq FROM mcq m JOIN mcq_data md WHERE m.id=md.mcq_id AND md.user_id='$user_id' AND m.c_id='$cid' AND m.sc_id='$sc_id'";
$query = mysqli_query($mysqli,$sql);
$total_question = mysqli_num_rows($query);

#This is for right answer
$sql = "SELECT m.title_text,m.title_img,m.options,m.right_option,md.answer ,m.why_ans_mcq FROM mcq m JOIN mcq_data md WHERE m.id=md.mcq_id AND md.user_id='$user_id' AND m.c_id='$cid' AND m.sc_id='$sc_id' AND md.answer=1";
$query = mysqli_query($mysqli,$sql);
$total_right_answer = mysqli_num_rows($query);

#This is for wrong answer
$sql = "SELECT m.title_text,m.title_img,m.options,m.right_option,md.answer ,m.why_ans_mcq FROM mcq m JOIN mcq_data md WHERE m.id=md.mcq_id AND md.user_id='$user_id' AND m.c_id='$cid' AND m.sc_id='$sc_id' AND md.answer=0";
$query = mysqli_query($mysqli,$sql);
$total_wrong_answer = mysqli_num_rows($query);

#This is for wrong answer
$sql = "SELECT m.title_text,m.title_img,m.options,m.right_option,md.answer ,m.why_ans_mcq FROM mcq m JOIN mcq_data md WHERE m.id=md.mcq_id AND md.user_id='$user_id' AND m.c_id='$cid' AND m.sc_id='$sc_id' AND md.answer=-1";
$query = mysqli_query($mysqli,$sql);
$total_skip_questions = mysqli_num_rows($query);

#This is for get time
$sql = "SELECT md.id,md.timestamp FROM mcq m JOIN mcq_data md WHERE m.id=md.mcq_id AND md.user_id='$user_id' AND m.c_id='$cid' AND m.sc_id='$sc_id' ORDER BY md.id DESC LIMIT 1";
$query = mysqli_query($mysqli,$sql);
$time_data = mysqli_fetch_assoc($query);
$time = $time_data['timestamp'];

#This is Main Query
$sql = "SELECT m.title_text,m.title_img,m.options,m.right_option,md.answer,md.selected ,m.why_ans_mcq FROM mcq m JOIN mcq_data md WHERE m.id=md.mcq_id AND md.user_id='$user_id' AND m.c_id='$cid' AND m.sc_id='$sc_id'";
$query = mysqli_query($mysqli,$sql);

$sno = 1;

// This is extra part of PDF
$content .= "<p style='text-align:center;'><img src='https://cbmepill.com/assets1/images/logo.png' style='height:150px;'/></p>";
$content .= "<h1 style='text-align:center;'>CBME Pill</h1>";
$content .= "Date / Time : $time <br/>";
$content .= "Total Questions : $total_question <br/>";
$content .= "Total Right Answers : $total_right_answer <br/>";
$content .= "Total Wrong Answers : $total_wrong_answer <br/>";
$content .= "Total Skip Questions : $total_skip_questions <br/>";

while($row = mysqli_fetch_assoc($query)){
    $options = explode("|",$row['options']);
    $right_option = $row['right_option'];
    $answer = $row['answer'];
    $selected = $row['selected'];
    
    $options_txt  = "";
    $osn = 1;
    
    
    $count = count($options);    
    for($i=0;$i<$count;$i++){
        
        
        if($right_option == $i+1){
            #This is for check right option
            if($answer == 1 or $right_option = $i+1){
                $color = "style='color:#0f0;'";
                $img_color = "<span $color>Right Answer</span>";
            }elseif($answer == 0){
                $color = "style='color:#f00;'";
                $img_color = "<span $color>Wrong Answer</span>";
            }else{
                $color = "";
                $img_color = "";
            }
            
        }else{
            
            if($selected == $i+1){
                $color = "style='color:#f00;'";
                $img_color = "<span $color>Wrong Answer</span>";
            }elseif($selected == 0){
                $color = "";
                $img_color = "";
                $skipped = "(Skipped)";
            }
            else{
                $color = "";
                $img_color = "";
                $skipped = "";
            }
            
        }
        
        #This is for images
        
        $image = end(explode(".",$options[$i]));
        
        if($image == "png" || $image == "jpeg" || $image == "jpg"){
            
            $options_txt .= "
                <div class='ans ml-2'>
                    <label class='radio'>
                      <span>$osn. <img src='https://cbmepill.com/chillwithpill-admin/mcq_images/$options[$i]' style='height:100px;width:150px;'/>
                      $img_color  
                      </span>
                    </label>
                  </div>
            ";
            
        }else{
            $options_txt .= "
                <div class='ans ml-2'>
                    <label class='radio'>
                      <span>$osn. <span $color>$options[$i] </span></span>
                    </label>
                  </div>
            ";
        }
        
        $osn++;
    }
    
    
    
    $content .= "
        <div class='question bg-white p-3 border-bottom'>
          <div class='d-flex flex-row align-items-center question-title'>
            <h3 class='text-danger'>Q $sno. ".$row['title_text']." $skipped</h3>
          </div>
            
          ".$options_txt."
         <div class='d-flex flex-row align-items-center question-title'>
            <h3 class='text-danger'>Why ans is right :- ".$row['why_ans_mcq']."</h3>
          </div> 
        </div>
         
    ";
    
    
    
    $sno++;
}


$mpdf->WriteHTML($content);

$mpdf->Output();


?>