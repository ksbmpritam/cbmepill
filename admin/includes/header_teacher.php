<?php include("includes/connection.php");

      include("includes/session_check.php");
   
      
      //Get file name

      $currentFile = $_SERVER["SCRIPT_NAME"];

      $parts = Explode('/', $currentFile);

      $currentFile = $parts[count($parts) - 1];       

       
?>

<!DOCTYPE html>

<html >

<head>

<meta name="author" content="">

<meta name="description" content="">

<meta http-equiv="Content-Type"content="text/html;charset=UTF-8"/>

<meta name="viewport"content="width=device-width, initial-scale=1.0">

<title><?php echo SITE_NAME?></title>

<link rel="stylesheet" type="text/css" href="assets/css/vendor.css">

<link rel="stylesheet" type="text/css" href="assets/css/flat-admin.css">

<link rel = "icon" href = "images/logo.jpeg" type = "https://cbmepill.com/assets1/images/logo.png">

<!-- Theme -->

<link rel="stylesheet" type="text/css" href="assets/css/theme/blue-sky.css">

<link rel="stylesheet" type="text/css" href="assets/css/theme/blue.css">

<link rel="stylesheet" type="text/css" href="assets/css/theme/red.css">

<link rel="stylesheet" type="text/css" href="assets/css/theme/yellow.css">
<link rel="stylesheet" type="text/css" href="assets/css/theme/cropper.css">

<script src="assets/ckeditor/ckeditor.js"></script>
</head>

<body>

<div class="app app-default">

  <aside class="app-sidebar" id="sidebar">

    <div class="sidebar-header"> <a class="sidebar-brand" href="home_teacher.php"><img src="http://cbmepill.com/assets1/images/logo.png

" alt="app logo"/></a>

      <button type="button" class="sidebar-toggle"> <i class="fa fa-times"></i> </button>

    </div>

    <div class="sidebar-menu">

      <ul class="sidebar-nav">

        <li <?php if($currentFile=="home_teacher.php"){?>class="active"<?php }?>> <a href="home_teacher.php">

          <div class="icon"> <i class="fa fa-dashboard" aria-hidden="true"></i> </div>

          <div class="title">Dashboard</div>

          </a> 

        </li>
    
        <li <?php if($currentFile=="all_cources_teacher.php"){?>class="active"<?php }?>> 
            <a href="all_cources_teacher.php">
    
                <div class="icon"> <i class="fa fa-bell" aria-hidden="true"></i> </div>
    
                <div class="title">Sub Category</div>
    
            </a>
        </li>
        
         <li <?php if($currentFile=="all_game_intro_teacher.php"){?>class="active"<?php }?>> <a href="all_game_intro_teacher.php">

        <div class="icon"> <i class="fa fa-bell" aria-hidden="true"></i> </div>

         <div class="title">Game Intro</div>

        </a>
        
        </li>
        <li <?php if ($currentFile == "all_lession_plan.php") { ?>class="active" <?php } ?>>
            <a href="all_lession_plan.php">
                <div class="icon"> <i class="fa fa-list" aria-hidden="true"></i> </div>
                <div class="title">Lesson Plan</div>
            </a>
        </li>
        
        <li <?php if ($currentFile == "one_minute_teacher.php" || $currentFile == "view_one_minute_teacher.php" || $currentFile == "edit_one_minute_teacher.php" ) { ?>class="active" <?php } ?>> <a href="one_minute_teacher.php">

                <div class="icon"> <i class="fa fa-list" aria-hidden="true"></i> </div>

                <div class="title">One Minute Paper</div>

            </a>
        </li>
        
        <li <?php if($currentFile=="all_pill_teacher.php"){?>class="active"<?php }?>> <a href="all_pill_teacher.php">

        <div class="icon"> <i class="fa fa-bell" aria-hidden="true"></i> </div>

         <div class="title">Pills</div>

        </a>
        </li>
        
         
        
        
        <li <?php if($currentFile=="add_game_teacher.php" || $currentFile=="all_games_teacher.php"){?>class="active"<?php }?>> 
        <a href="all_games_teacher.php">

         <div class="icon"><i class="fa fa-gamepad" aria-hidden="true"></i></div>

         <div class="title">Game</div>

         </a>
        </li>
        
        
          <li <?php if($currentFile=="mcq_images_teacher.php"){?>class="active"<?php }?>> 
        <a href="mcq_images_teacher.php">

         <div class="icon"><i class="fa fa-picture-o" aria-hidden="true"></i></div>

         <div class="title">Media</div>

         </a>

        </li>
        
        
        
        
          <li <?php if($currentFile=="all_pill_benefits_teacher.php"){?>class="active"<?php }?>> <a href="all_pill_benefits_teacher.php">

        <div class="icon"> <i class="fa fa-bell" aria-hidden="true"></i> </div>

         <div class="title">Pills Benefits</div>

        </a>
        </li>
        

        
        
         <li <?php if($currentFile=="all_asign_pills_teacher.php"){?>class="active"<?php }?>> <a href="all_asign_pills_teacher.php">

        <div class="icon"> <i class="fa fa-bell" aria-hidden="true"></i> </div>

         <div class="title">All Assign Pill</div>

        </a>
        </li>
        
        <!--  <li <?php if($currentFile=="all_medicine_teacher.php"){?>class="active"<?php }?>> <a href="all_medicine_teacher.php">-->

        <!--<div class="icon"> <i class="fa fa-bell" aria-hidden="true"></i> </div>-->

        <!-- <div class="title">Pills Type</div>-->

        <!--</a>-->
        <!--</li>-->
        
        
          <li <?php if($currentFile=="all_prescription_new_teacher.php"){?>class="active"<?php }?>> <a href="all_prescription_new_teacher.php">

        <div class="icon"> <i class="fa fa-bell" aria-hidden="true"></i> </div>

         <div class="title">Prescription</div>

        </a>
        </li>
        
           <li <?php if($currentFile=="think_higer_template_teacher.php" || $currentFile=="think_higer_template_teacher.php"){?>class="active"<?php }?>> 
        <a href="think_higer_template_teacher.php">

         <div class="icon"><i class="fa fa-slideshare" aria-hidden="true"></i></div>

         <div class="title">TH Template</div>

         </a>

        </li>
        
        
         <li <?php if($currentFile=="all_think_high_teacher.php"){?>class="active"<?php }?>> <a href="all_think_high_teacher.php">

        <div class="icon"> <i class="fa fa-bell" aria-hidden="true"></i> </div>

         <div class="title">Think High</div>

        </a>
        </li>
        
        
        
        <li <?php if($currentFile=="all_mcq_teacher.php"){?>class="active"<?php }?>> <a href="all_mcq_teacher.php">

        <div class="icon"> <i class="fa fa-bell" aria-hidden="true"></i> </div>

         <div class="title">MCQ</div>

        </a>
        </li>
        
        <li <?php if($currentFile=="teacher_rating.php"){?>class="active"<?php }?>> <a href="teacher_rating.php">

        <div class="icon"> <i class="fa fa-bell" aria-hidden="true"></i> </div>

         <div class="title">Rating</div>

        </a>
        </li>
        
        
        
        
       
    

         

      </ul>

    </div>

     

  </aside>   

  <div class="app-container">

    <nav class="navbar navbar-default" id="navbar">

      <div class="container-fluid">

        <div class="navbar-collapse collapse in">

          <ul class="nav navbar-nav navbar-mobile">

            <li>

              <button type="button" class="sidebar-toggle"> <i class="fa fa-bars"></i> </button>

            </li>

            <li class="logo"> <a class="navbar-brand" href="#"><?php echo APP_NAME;?></a> </li>

            <li>

              <button type="button" class="navbar-toggle">

                <?php if(defined(PROFILE_IMG)){?>               

                  <img class="profile-img" src="images/<?php echo PROFILE_IMG;?>">

                <?php }else{?>

                  <img class="profile-img" src="assets/images/profile.png">

                <?php }?>

                  

              </button>

            </li>

          </ul>

          <ul class="nav navbar-nav navbar-left">

            <li class="navbar-title"><?php echo SITE_NAME?></li>

             

          </ul>

          <ul class="nav navbar-nav navbar-right">

            <li class="dropdown profile"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> 

                <?php if(defined(PROFILE_IMG)){?>               

                  <img class="profile-img" src="images/<?php echo PROFILE_IMG;?>">

                <?php }else{?>

                  <img class="profile-img" src="assets/images/profile.png">

                <?php }?>

              <div class="title">Profile</div>

              </a>

              <div class="dropdown-menu">

                <div class="profile-info">

                  <h4 class="username">Teacher</h4>

                </div>

                <ul class="action">

                      

                  <li><a href="logout_teacher.php">Logout</a></li>

                </ul>

              </div>

            </li>

          </ul>

        </div>

      </div>

    </nav>