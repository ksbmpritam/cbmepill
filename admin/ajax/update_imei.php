<?php
include("../includes/connection.php");
global $mysqli;

$id=base64_decode($_REQUEST['id']);

$upsqli="Update user set `token`='' where user_id='$id'";
$updata=mysqli_query($mysqli,$upsqli);

$sqli="SELECT * from user where user_id='$id'";
$data=mysqli_query($mysqli,$sqli);
$user=mysqli_fetch_assoc($data);
//print_r($user);	



	
?>
        
          <div class="row" style="display:none;">
                    <div class="col-md-1"> 
                    </div>
                    <div class="col-md-6"> 
                          User Name  : <?php echo $user['name']; ?>
                        <BR/>Moblie : <?php echo $user['mobile']; ?>
                        <BR/>Email  : <?php echo $user['email']; ?></h2>
                        <BR/>Token  : <?php echo $user['token']; ?></h2>
                
                    </div>
                
                
                    
                    <div class="col-md-5"> 
                    
                 
                    </div>     
            </div>
          <div class="row" >
                    <div class="col-md-12">
                        User Token empty 
                    </div>
            
          </div>  
            <hr/>
            
          