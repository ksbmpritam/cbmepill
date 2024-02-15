<?php
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Methods: POST, PUT, DELETE, UPDATE");
header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require "../jwt/vendor/autoload.php";
include("../adnroid/db.php");
include("../includes/function.php");

use \Firebase\JWT\JWT;

$method = $_SERVER['REQUEST_METHOD'];


if($method=='POST'){
    $user_id = $_POST['user_id'];
    
    $response=[];
    $res=[];
    
        $sql = "SELECT tc.category_name,sc.name,tc.cid,sc.id,md.user_id ,m.sc_id  FROM mcq_data md JOIN mcq m JOIN tbl_category tc JOIN sub_categories sc WHERE md.mcq_id=m.id AND m.c_id=tc.cid AND m.sc_id=sc.id AND md.user_id='$user_id' GROUP BY m.sc_id";
         
         
    
    // $sql = "SELECT md.*,m.sc_id , FROM mcq_data md LEFT JOIN mcq m ON m.id = md.mcq_id AND md.user_id='$user_id' GROUP BY m.sc_id";
    
    $query = mysqli_query($con,$sql);
    
    // $all_mcq_data = mysqli_fetch_all($query);
    
    // This is main variable
    
    while( $row = mysqli_fetch_assoc($query) ){
        
        $total = 0;
        $currect = 0;
        $wrong = 0;
        $skip = 0;
        $score = 0;
        
        $arr = [];
        
          
        $sc_id = $row['sc_id'];
        $sql1 = "SELECT id FROM `mcq` WHERE sc_id='$sc_id'";
        $query1 = mysqli_query($con,$sql1);
       
        
        while($row1 = mysqli_fetch_assoc($query1)){
          
             
            $mcq_id = $row1['id'];
            // Check with mcq id and user id
            $row2 = "SELECT * FROM `mcq_data` WHERE user_id='$user_id' AND mcq_id='$mcq_id'";
            $query2 = mysqli_query($con,$row2);
            
            while($row2 = mysqli_fetch_assoc($query2)){
                
                if($row2['answer'] == 1){
                    $currect++;
                    $score++;
                }
                
                if($row2['answer'] == 0){
                    $wrong++;
                }
                
                if($row2['answer'] == -1){
                    $skip++;
                }
                
                $total++;
                $arr["date"] = explode(" ",$row2["timestamp"])[0];
                $arr["time"] = explode(" ",$row2["timestamp"])[1];
                
            }
            
            
        }
        
        if($total != 0){
             $arr["sc_id"] = $row['sc_id'];
              $arr["cid"] = $row['cid'];
              
            $arr["total"] = $total;
            $arr["currect"] = $currect;
            $arr["wrong"] = $wrong;
            $arr["skip"] = $skip;
            $arr["score"] = $score;
            
            array_push($res,$arr);
            
        }
        
        
    }
    
    $response["data"] = $res;
    
    #This is for know the user status
    $sql = "SELECT status FROM `users` WHERE id='$user_id'";
    $query = mysqli_query($con,$sql);
    $row = mysqli_fetch_assoc($query);
    $status = $row['status'];
    $status = $status == 1 ? true : false;
    
    $response["active"] = $status ;
    
    echo json_encode($response);
    
}    
else{
    echo json_encode(array("success" => "false",'message'=>'invalid method'));

}