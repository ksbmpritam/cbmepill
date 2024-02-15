<?php
            include("../adnroid/db.php");
            //require_once 'config/DbHandler.php';

            $response = array();
            // $db = new DbHandler();

            // // fetching all Book 
            // $result = $db->getAllBooks();

            //$response["error"] = false;
            $response["books"] = array();
               $query = "SELECT * FROM books_master where book_status='Active'";
   $dept = mysqli_query($con, $query);
 //if(mysqli_num_rows($dept)>0){
            while ($books = mysqli_fetch_assoc($dept))
            {
            // looping through result and preparing tasks array
           // while ($books = $result->fetch_assoc()) {
                $tmp = array();
                $tmp["book_id"] = $books["book_id"];
                $tmp["book_title"] = $books["book_title"];
                $tmp["author_name"] = $books["author_name"];
                $tmp["book_category"] = $books["book_category"];
                if($books["book_cover_image"]!=""){
                $tmp["book_cover_image"]= "http://angirasuratgarhlive.com/ksbmadmin/upload_books/cover/".$books["book_cover_image"];
                }else{
                $tmp["book_cover_image"] = $book_cover_image;    
                }
                
                $tmp["book_description"] = $books["book_description"];
                $tmp["book_publisher"] = $books["book_publisher"];
                $tmp["book_price"] = $books["book_price"];
                $tmp["book_validity"] = $books["book_validity"];
                $tmp["created_date"] = $books["created_date"];
                
                
                array_push($response["books"], $tmp);
            }

            // echoRespnse(200, $response);
            
            echo json_encode($response);
            

?>