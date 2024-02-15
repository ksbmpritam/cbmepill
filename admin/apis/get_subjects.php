<?php
 
require_once 'config/DbHandler.php';

            $response = array();
            $db = new DbHandler();

            // fetching all subjects 
            $result = $db->getAllSubject();

            //$response["error"] = false;
            $response["subjects"] = array();

            // looping through result and preparing tasks array
            while ($subjects = $result->fetch_assoc()) {
                $tmp = array();
                $tmp["course_id"] = $subjects["course_id"];
                $tmp["subject_name"] = $subjects["subject_name"];
                $tmp["subject_image"] = $subjects["subject_image"];
                $tmp["banner_image"] = $subjects["banner_image"];
                $tmp["desc"] = $subjects["desc"];
                $tmp["amount"] = $subjects["amount"];
                $tmp["date"] = $subjects["date"];
                $tmp["rid"] = $subjects["rid"];
                
                
                array_push($response["subjects"], $tmp);
            }

            // echoRespnse(200, $response);
            
            echo json_encode($response);
            

?>