<?php
 
require_once 'config/DbHandler.php';

            $response = array();
            $db = new DbHandler();

            // fetching all Coupons 
            $result = $db->getAllCoupons();

            //$response["error"] = false;
            $response["coupons"] = array();

            // looping through result and preparing tasks array
            while ($coupons = $result->fetch_assoc()) {
                $tmp = array();
                $tmp["coupons_name"] = $coupons["coupons_name"];
                $tmp["coupons_flat_type"] = $coupons["coupons_flat_type"];
                $tmp["coupons_flat_value"] = $coupons["coupons_flat_value"];
                $tmp["apply_flat_min"] = $coupons["apply_flat_min"];
                $tmp["apply_flat_max"] = $coupons["apply_flat_max"];
                $tmp["coupons_attempts"] = $coupons["coupons_attempts"];
                $tmp["coupons_from"] = $coupons["coupons_from"];
                $tmp["coupons_to"] = $coupons["coupons_to"];
                $tmp["coupons_details"] = $coupons["coupons_details"];
                $tmp["created_date"] = $coupons["created_date"];
                $tmp["updated_date"] = $coupons["updated_date"];
                
                array_push($response["coupons"], $tmp);
            }

            // echoRespnse(200, $response);
            
            echo json_encode($response);
            

?>