<?php
include ("includes/header.php");
require ("includes/function.php");
require ("language/language.php");
require_once ("thumbnail_images.class.php");
date_default_timezone_set('Asia/Kolkata');



if (isset($_POST['submit'])) {
    
     $mobile = '+91'.filter($_POST['mobile']);
    $email = filter($_POST['email']);
    $display_name = filter($_POST['display_name']);
    $name = filter($_POST['name']);
    $gender = filter($_POST['gender']);
    $playerScore = 0.00;
    // $image = filter($_POST['profile_pic_url']);
    $image = 'https://cbmepill.com/assets1/images/logo.png';
    $status = filter($_POST['status']);
    $pass = filter($_POST['pass']);
    $currentDate = date('Y-m-d H:i:s');

    
     $sqli = "SELECT * FROM `users` WHERE mobile ='$mobile' OR  email ='$email' ";
    $data = mysqli_query($mysqli, $sqli);
   
    if(mysqli_num_rows($data) >0){
          $_SESSION['msg'] = "Email or mobile all ready in exist..";
        //   header("Refresh:0");
  
    }else{
          // $file_name = time().$image;
    // move_uploaded_file($file['tmp_name'][$i],"mcq_images/".$file_name);
    //  echo $file_name;die;
 
    $data = array(
        'name' => $name,
        'display_name' => $display_name,
        'email' => $email,
        'mobile' => $mobile,
        'date' => $currentDate, 
        'profile_pic_url' => $image, 
        'gender' => $gender,
        'playerScore' => $playerScore ,
        'status' => $status ,
        'device_token'=> '',
        'password' => $pass ,
        );
    Insert('users', $data);
    
    $_SESSION['msg'] = "Add Teacher added successfuly..";
    header("Location:all_user.php");
    exit;
    }
 
   
  
}

?>

<style>
    .margin_top{
        margin:20px 0 0 0!important;
    }
</style>

<div class="row">

    <div class="col-md-12">

        <div class="card">

            <div class="page_title_block">

                <div class="col-md-5 col-xs-12">

                    <div class="page_title">Add Teachers</div>

                </div>

            </div>

            <div class="clearfix"></div>

            <div class="row mrg-top">

                <div class="col-md-12">



                    <div class="col-md-12 col-sm-12">

                        <?php if (isset($_SESSION['msg'])) { ?> 

                            <div class="alert alert-success alert-dismissible" role="alert"> 
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>

                                <?php echo $_SESSION['msg']; ?></a> </div>

                            <?php unset($_SESSION['msg']);
                            }
                            ?> 

                    </div>

                </div>

            </div>

            <div class="card-body mrg_bottom"> 
            
                
                <form action="" name="addteacher" method="post" class="form form-horizontal" enctype="multipart/form-data">

                            <div class="row">
                              <div class="col-lg-12 col-md-12 col-sm-12 margin_top">
                                    <label>Name</label>
                                    <input class="form-control" name="name" type="text" required >
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 margin_top">
                                    <label>Display Name</label>
                                    <input class="form-control" name="display_name" type="text" required >
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 margin_top">
                                    <label>Email</label>
                                    <input class="form-control" name="email" type="email" required >
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 margin_top">
                                    <label>Mobile</label>
                                    <input class="form-control" name="mobile"   type="number" required >
                                    </div>
                                    
                                      <div class="col-lg-12 col-md-12 col-sm-12 margin_top">
                                    <label>Password</label>
                                    <input class="form-control" name="pass" min="6" max="16" type="text" required >
                                    </div>
    
                                    <!--<div class="col-lg-12 col-md-12 col-sm-12 margin_top">-->
                                    <!--<label>Profile Image Url</label>-->
                                    <!--<input class="form-control" name="profile_pic_url" type="text" placeholder="https://cbmepill.com/assets1/images/logo.png" required >-->
                                    <!--</div>-->
                                  
                                 <div class="col-lg-12 col-md-12 col-sm-12 margin_top">
                                    <label>Gender</label>
                                    <select class="form-control" name="gender">
                                        <option value="male" >Male</option>
                                        <option value="female" >Female</option>
                                    </select>                           
                                </div>
                                
                                  <div class="col-lg-12 col-md-12 col-sm-12 margin_top">
                                    <label>Status</label>
                                    <select class="form-control" name="status">
                                        <option value="1" >Active</option>
                                        <option value="0" >Deactive</option>
                                    </select>                           
                                </div>
                           
                                            
                                <div class="col-md-6">
                                    <button type="submit" name="submit" class="btn btn-primary" style="margin-top: 10px;">Save</button>
                                </div>
                                            
                                
                                
                            </div>
                            
                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>



<?php include ("includes/footer.php"); ?>       