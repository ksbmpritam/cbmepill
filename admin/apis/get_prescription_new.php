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


if($method=='POST')
{
    $cat_id = $_POST['category_id'];
    $sub_id = $_POST['sub_id'];
    
    $response = [];
    
    $query = "SELECT id as prescription_id,kase,options,right_options,suggestions,right_suggestions,description FROM prescription_new WHERE c_id='$cat_id' AND sc_id='$sub_id'";
    $result = mysqli_query($con, $query);
    
    if(mysqli_num_rows($result)>0){
        
        $res = [];
        
        
        
        while($row = mysqli_fetch_assoc($result)){
            $options = [];
            $right_options = [];
            #THIS IS FOR MEDICINES OPTIONS
            $medicines = explode('|',$row['options']);
            foreach($medicines as $m){
                $m_sql = "SELECT pill,photo,p.id as pill_id,mt.name as type FROM pills p JOIN medicine_type mt WHERE p.type=mt.id AND p.id='$m'";
                $m_query = mysqli_query($con,$m_sql);
                
                while($m_row = mysqli_fetch_assoc($m_query)){
                    $m_row['photo'] = url()."/medicines/".$m_row['photo'];
                    array_push($options,$m_row);
                }
                
            }
            $row['options'] = $options;
            #MEDICINES OPTIONS PART ENDED HERE
            
            #THIS IS FOR RIGHT OPTIONS
            $right_options_array = explode("|",$row['right_options']);
            foreach($right_options_array as $re){
                $m_sql = "SELECT pill,photo,p.id as pill_id,mt.name as type FROM pills p JOIN medicine_type mt WHERE p.type=mt.id AND p.id='$re'";
                $m_query = mysqli_query($con,$m_sql);
                
                while($m_row = mysqli_fetch_assoc($m_query)){
                    $m_row['photo'] = url()."/medicines/".$m_row['photo'];
                    array_push($right_options,$m_row);
                }
                
            }
            
            $row['right_options'] = $right_options;
            #RIGHT OPTIONS PART ENDED HERE
            
            #this is for suggestion
            $row['suggestions'] = explode(",",$row['suggestions']);
            $row['right_suggestions'] = explode(",",$row['right_suggestions']);
            
            
            
            $res[] = $row;            
        }
        
        $response["prescriptions"] = $res;
        echo json_encode($response);
        
    }else{
        echo json_encode(array("success" => "false",'message'=>'no prescription available'));
    }
    
    
}
else{
    echo json_encode(array("success" => "false",'message'=>'invalid method'));
}