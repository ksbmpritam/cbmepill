<?php
//error_reporting(0);
 
/**
 * Class to handle all db operations
 * This class will have CRUD methods for database tables
 *
 * @author Ravi Tamada
 */
class DbHandler {
 
    private $conn;
 
    function __construct() {
        //require_once dirname(__FILE__) . 'config/DbConnect.php';
        require_once 'DbConnect.php';
        // opening db connection
        $db = new DbConnect();
        $this->conn = $db->connect();
    }
    
    /**
     * create book history
     */
    public function createBookHistory($book_id, $user_id, $page_no) {

        $response = array();
 
        // First check if book history already existed in db
        if (!$this->isBookHistoryExists($book_id,$user_id))
        {
            
            // Generating API key
            $api_key = $this->generateApiKey();
 
            // insert query
            $stmt = $this->conn->prepare("INSERT INTO book_read_history(book_id, user_id, page_no, api_key) values(?, ?, ?, ?)");
            $stmt->bind_param("ssss", $book_id, $user_id,$page_no,$api_key);
 
            $result = $stmt->execute();
 
            $stmt->close();
 
            // Check for successful insertion
            if ($result) {
                // Book History successfully inserted
                return BOOK_HISTORY_CREATED_SUCCESSFULLY;
            } else {
                // Failed to create book history
                return BOOK_HISTORY_CREATE_FAILED;
            }
        } 
        else {
            // Book with same book_id already existed in the db
            //$update_book = $this->updateBookHistory($book_id, $user_id, $page_no);
            return BOOK_HISTORY_ALREADY_EXISTED;
        }
 
        //return $response;
    }
    
    /* get if already exists */
    private function isBookHistoryExists($book_id,$user_id) {
        $stmt = $this->conn->prepare("SELECT book_id,user_id from book_read_history WHERE book_id = ? AND user_id=?");
        $stmt->bind_param("ss", $book_id,$user_id);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }
    
    
    public function isValidApiKey($api_key) {
        $stmt = $this->conn->prepare("SELECT * from book_read_history WHERE api_key = ?");
        $stmt->bind_param("s", $api_key);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }
 
    /**
     * Generating random Unique MD5 String for user Api key
     */
    private function generateApiKey() {
        return md5(uniqid(rand(), true));
    }
    
    /* update the book history */
    public function updateBookHistory($page_no,$user_id) {
        date_default_timezone_set('Asia/Kolkata');
        $cur_date=date('Y-m-d h:i:s');
        $stmt = $this->conn->prepare("UPDATE book_read_history SET page_no=?,updated_date='$cur_date' WHERE user_id = ?");
        $stmt->bind_param("si",$page_no, $user_id);
        $stmt->execute();
        $num_affected_rows = $stmt->affected_rows;
        $stmt->close();
        
        return $num_affected_rows > 0;
        
    }
    
  
  /* get all books */
    public function getAllBooks() {
        $stmt = $this->conn->prepare("SELECT * FROM books_master where book_status='Active' ");
        $stmt->execute();
        $books = $stmt->get_result();
        $stmt->close();
        return $books;
    }
    
  /* get Book pages */
  public function getBookPages($book_id) {
        $stmt = $this->conn->prepare("SELECT * FROM book_contents where book_id='$book_id'");
        $stmt->execute();
        $pages = $stmt->get_result();
        $stmt->close();
        return $pages;
    }
 /* get last page no */
  public function getLastPage($book_id,$user_id) {
        $stmt = $this->conn->prepare("SELECT page_no from book_read_history where book_id='$book_id' AND user_id='$user_id'");
        $stmt->execute();
        $last_pages = $stmt->get_result();
        $stmt->close();
        return $last_pages;
    }
    
 /* get Book by Book ID */
  public function getBookDetails($book_id) {
        $stmt = $this->conn->prepare("SELECT book_id,book_title,author_name,book_category,book_cover_image,book_description,book_publisher,book_price,book_validity,created_date  FROM books_master where book_status='Active' AND book_id=?");
        $stmt->bind_param("s", $book_id);
        if ($stmt->execute()) {
            $res = array();
            $stmt->bind_result($book_id,$book_title,$author_name,$book_category,$book_cover_image,$book_description,$book_publisher,$book_price,$book_validity,$created_date);
            // TODO
            // $task = $stmt->get_result()->fetch_assoc();
            $stmt->fetch();
            $res["book_id"] = $book_id;
            $res["book_title"] = $book_title;
            $res["author_name"] = $author_name;
            $res["book_category"] = $book_category;
            $res["book_cover_image"] = $book_cover_image;
            $res["book_description"] = $book_description;
            $res["book_publisher"] = $book_publisher;
            $res["book_price"] = $book_price;
            $res["book_validity"] = $book_validity;
            $res["created_date"] = $created_date;
            
         
            
            $stmt->close();
            return $res;
        } else {
            return NULL;
        }
    }
    
    
    /* get book_validity by book_id */
    public function getBookValidity($book_id)
    {
        //$sql1="SELECT book_validity from books_master where book_id='$book_id'";
        $stmt=$this->conn->prepare("SELECT book_validity from books_master where book_id=?");
        $stmt->bind_param("s",$book_id);
        $stmt->execute();
        $stmt->bind_result($book_validity);
        $stmt->fetch();
        $rest["book_validity"] = $book_validity;
        $stmt->close();
        return $rest;
    }
    
   /* make transaction */
   public function createTransaction($book_id, $user_id,$transaction_id,$amount) {
       
            $b_val=$this->getBookValidity($book_id);
            
            $vday=explode(' ',$b_val['book_validity']);
            $validate_days= $vday[0];
            //echo $validate_days;
            date_default_timezone_set('Asia/Kolkata');
            $date=date('Y-m-d h:i:s');
            $expired_date=date('Y-m-d h:i:s', strtotime($date. ' +'. $validate_days .'days'));
            
            $sql="INSERT INTO book_transaction(book_id,user_id,transaction_id,amount,expired_date) values('$book_id', '$user_id', '$transaction_id', '$amount','$expired_date')";
            // echo $sql;
            // exit;
            // insert query
            //$stmt = $this->conn->prepare("INSERT INTO book_transaction(book_id,user_id,transaction_id,amount,expired_date) values(?, ?, ?, ?,?)");
            $stmt = $this->conn->prepare($sql);
            //$stmt->bind_param("ssssi", $book_id, $user_id,$transaction_id,$amount,$expired_date);
            $result = $stmt->execute();
            $stmt->close();
 
            // Check for successful insertion
            if ($result) {
                return OK;
            } else {
                // Failed to create book transcation
                echo 'ERROR';
            }
    }
    
    
  /* get transaction and expired by using book_id and user_id */
  public function getTransactionStatus($book_id, $user_id) {
            $stmt=$this->conn->prepare("SELECT transaction_id,expired_date from book_transaction where book_id=? AND user_id=?");
            $stmt->bind_param("ss",$book_id,$user_id);
            $stmt->execute();
            $stmt->bind_result($transaction_id,$expired_date);
            $stmt->fetch();
            $rest["transaction_id"] = $transaction_id;
            $rest["expired_date"] = $expired_date;
            $stmt->close();
            return $rest;
    }
  
  
 /* get user coupon attempts */
 
 public function getUserCouponAttempts($user_id,$coupons_name)
 {
        $stmt=$this->conn->prepare("SELECT coupons_attempts FROM coupons_history WHERE user_id=? AND coupons_name=?");
        $stmt->bind_param("ss",$user_id,$coupons_name);
        $stmt->execute();
        $stmt->bind_result($coupons_attempts);
        $stmt->fetch();
        $rest["coupons_attempts"] = $coupons_attempts;
        $stmt->close();
        return $rest['coupons_attempts'];
 }
  
 /* verify Coupons */
    public function verify_coupon($user_id,$coupons_name,$amount) {
       
        $response=array();
        date_default_timezone_set('Asia/Kolkata');
        $current_time = date('Y-m-d H:i:s');
        
        $user_attempts=$this->getUserCouponAttempts($user_id,$coupons_name); 
       
        $stmt = $this->conn->prepare("SELECT * FROM coupons_master where status='Active' AND coupons_name='$coupons_name' ");
        $stmt->execute();
        $coup = $stmt->get_result();
        $stmt->close();
        //return $coup;
    
        $response = array();
        $coupons_name='';
        $coupons_apply_min='';
        $coupons_apply_max='';
        $coupons_from='';
        $coupons_to='';
        $total_attempts='';
        $coupons_flat_type='';
        $coupons_flat_value=0;
        $coupon_amount=0;
        while ($coupons = $coup->fetch_assoc()) {
                $coupons_name = $coupons["coupons_name"];
                $coupons_apply_min=$coupons["apply_flat_min"];
                $coupons_apply_max=$coupons["apply_flat_max"];
                $coupons_from=$coupons["coupons_from"];
                $coupons_to=$coupons["coupons_to"];
                $total_attempts=$coupons["coupons_attempts"];
                $coupons_flat_type=$coupons["coupons_flat_type"];
                $coupons_flat_value=$coupons["coupons_flat_value"];
                
            }
            
            $response['coupons_name']=$coupons_name;
            
            //$response['coupons_amount']=$coupons_flat_type;
            if($coupons_flat_type=='Flat Amount')
            {
                $response['coupons_flat_value']=$coupons_flat_value;
                
            }
            if($coupons_flat_type=='Flat Percentage')
            {
                $coupon_amount=$amount*($coupons_flat_value/100);
                $response['coupons_flat_value']=$coupon_amount;
            }
            //$response['user_coupon_attempts']=$user_attempts;
            
            if(!$coupons_name)
            {
                echo json_encode(array("status"=>"false","error"=>"Invalid Coupon Name !"));
            }
            elseif($amount<$coupons_apply_min)
            {
             echo json_encode(array("status"=>"false","error"=>"This Coupon is applicable if amount is minimum $coupons_apply_min !"));   
            }
            elseif($amount>$coupons_apply_max)
            {
             echo json_encode(array("status"=>"false","error"=>"This Coupon is applicable if amount is maximum $coupons_apply_max !"));   
            }
            elseif($current_time<$coupons_from)
            {
                echo json_encode(array("status"=>"false","error"=>"This Coupon is applicable from Date $coupons_from"));
            }
            elseif($current_time>$coupons_to)
            {
                echo json_encode(array("status"=>"false","error"=>"This Coupon is applicable upto Date $coupons_to!"));
            }
            elseif($user_attempts>$total_attempts)
            {
                echo json_encode(array("status"=>"false","error"=>"You have use this coupon  of all attempts !"));
            }
            else
            {
                 echo json_encode(array("status"=>"true","response"=>$response));
            }
        
        

    }  
  

    
/* get all Coupons */
    public function getAllCoupons() {
        $stmt = $this->conn->prepare("SELECT * FROM coupons_master where status='Active' ");
        $stmt->execute();
        $coupons = $stmt->get_result();
        $stmt->close();
        return $coupons;
    }
    
/* get all Subjects */
    public function getAllSubject() {
        $stmt = $this->conn->prepare("SELECT * FROM subject ");
        $stmt->execute();
        $subjects = $stmt->get_result();
        $stmt->close();
        return $subjects;
    }
    
}
 
 ?>