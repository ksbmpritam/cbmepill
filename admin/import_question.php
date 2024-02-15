<meta http-equiv="Content-Type" content="text/html; charset=utf8" />



<?php
include("includes/connection.php");
//   include("includes/session_check.php");
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
        <title>Angira Live</title>
        <link rel="stylesheet" type="text/css" href="assets/css/vendor.css">
        <link rel="stylesheet" type="text/css" href="assets/css/flat-admin.css">

        <!-- Theme -->
        <link rel="stylesheet" type="text/css" href="assets/css/theme/blue-sky.css">
        <link rel="stylesheet" type="text/css" href="assets/css/theme/blue.css">
        <link rel="stylesheet" type="text/css" href="assets/css/theme/red.css">
        <link rel="stylesheet" type="text/css" href="assets/css/theme/yellow.css">

        <script src="assets/ckeditor/ckeditor.js"></script>

    </head>
    <body>
        <div class="app app-default">
            <aside class="app-sidebar" id="sidebar">
                <div class="sidebar-header"> <a class="sidebar-brand" href="home.php"><img src="images/logo.png" alt="app logo" style="width: 21391%;" /></a>
                    <button type="button" class="sidebar-toggle"> <i class="fa fa-times"></i> </button>
                </div>
                <div class="sidebar-menu">
                    <ul class="sidebar-nav">
                        <li <?php if ($currentFile == "home.php") { ?>class="active"<?php } ?>> <a href="home.php">
                                <div class="icon"> <i class="fa fa-dashboard" aria-hidden="true"></i> </div>
                                <div class="title">Dashboard</div>
                            </a> 
                        </li>
                        <li <?php if ($currentFile == "topbanner.php") { ?>class="active"<?php } ?>> <a href="topbanner.php">
                                <div class="icon"> <i class="fa fa-dashboard" aria-hidden="true"></i> </div>
                                <div class="title">Top Banner</div>
                            </a> 
                        </li>
                        <li <?php if ($currentFile == "footerbanner.php") { ?>class="active"<?php } ?>> <a href="footerbanner.php">
                                <div class="icon"> <i class="fa fa-dashboard" aria-hidden="true"></i> </div>
                                <div class="title">Footer Banner</div>
                            </a> 
                        </li>
                        <li <?php if ($currentFile == "manage_category.php" or $currentFile == "add_category.php") { ?>class="active"<?php } ?>> <a href="manage_category.php">
                                <div class="icon"> <i class="fa fa-sitemap" aria-hidden="true"></i> </div>
                                <div class="title">Course</div>
                            </a> 
                        </li>

                        <li <?php if ($currentFile == "coupons.php" or $currentFile == "coupons.php") { ?>class="active"<?php } ?>> <a href="coupons.php">
                                <div class="icon"> <i class="fa fa-sitemap" aria-hidden="true"></i> </div>
                                <div class="title">Coupons</div>
                            </a> 
                        </li>
                        <li <?php if ($currentFile == "all_cources.php") { ?>class="active"<?php } ?>> <a href="all_cources.php">
                                <div class="icon"> <i class="fa fa-bell" aria-hidden="true"></i> </div>
                                <div class="title">Subject</div>
                            </a> 
                        </li>
                        <li <?php if ($currentFile == "manage_videos.php" or $currentFile == "add_video.php" or $currentFile == "edit_video.php") { ?>class="active"<?php } ?>> <a href="manage_videos.php">
                                <div class="icon"> <i class="fa fa-film" aria-hidden="true"></i> </div>
                                <div class="title">Videos</div>
                            </a> 
                        </li>

                        <li <?php if ($currentFile == "manage_pdf.php" or $currentFile == "add_pdf.php" or $currentFile == "edit_pdf.php") { ?>class="active"<?php } ?>> <a href="manage_pdf.php">
                                <div class="icon"> <i class="fa fa-film" aria-hidden="true"></i> </div>
                                <div class="title">PDF</div>
                            </a> 
                        </li>

                        <li <?php if ($currentFile == "manage_exam.php" or $currentFile == "add_exam.php" or $currentFile == "manage_exam.php") { ?>class="active"<?php } ?>> <a href="manage_exam.php">
                                <div class="icon"> <i class="fa fa-film" aria-hidden="true"></i> </div>
                                <div class="title">Exam</div>
                            </a> 
                        </li>

                        <li <?php if ($currentFile == "eventadd.php") { ?>class="active"<?php } ?>> <a href="eventadd.php">
                                <div class="icon"> <i class="fa fa-bell" aria-hidden="true"></i> </div>
                                <div class="title">Event</div>
                            </a> 
                        </li>

                        <li <?php if ($currentFile == "IMEI.php") { ?>class="active"<?php } ?>> <a href="IMEI.php">
                                <div class="icon"> <i class="fa fa-bell" aria-hidden="true"></i> </div>
                                <div class="title">IMEI Change</div>
                            </a> 
                        </li>



                        <li <?php if ($currentFile == "send_notification.php") { ?>class="active"<?php } ?>> <a href="send_notification.php">
                                <div class="icon"> <i class="fa fa-bell" aria-hidden="true"></i> </div>
                                <div class="title">Notification</div>
                            </a> 
                        </li>


                        <li <?php if ($currentFile == "query.php") { ?>class="active"<?php } ?>> <a href="query.php">
                                <div class="icon"> <i class="fa fa-bell" aria-hidden="true"></i> </div>
                                <div class="title">Inquiry</div>
                            </a> 
                        </li>

                        <li <?php if ($currentFile == "all_user.php") { ?>class="active"<?php } ?>> <a href="all_user.php">
                                <div class="icon"> <i class="fa fa-exchange" aria-hidden="true"></i> </div>
                                <div class="title">All User's</div>
                            </a> 
                        </li>
                        <li <?php if ($currentFile == "books_master.php") { ?>class="active"<?php } ?>> <a href="books_master.php">
                                <div class="icon"> <i class="fa fa-book" aria-hidden="true"></i> </div>
                                <div class="title">All Books</div>
                            </a> 
                        </li>
                        <li <?php if ($currentFile == "books_contents.php") { ?>class="active"<?php } ?>> <a href="books_contents.php">
                                <div class="icon"> <i class="fa fa-book" aria-hidden="true"></i> </div>
                                <div class="title">Book Contents</div>
                            </a> 
                        </li>




<!-- <li <?php if ($currentFile == "settings.php") { ?>class="active"<?php } ?>> <a href="settings.php">*/
   <div class="icon"> <i class="fa fa-cog" aria-hidden="true"></i> </div>
   <div class="title">Settings</div>
   </a> 
 </li>
                        -->

       <!-- <li <?php if ($currentFile == "api_urls.php") { ?>class="active"<?php } ?>> <a href="api_urls.php">
          <div class="icon"> <i class="fa fa-exchange" aria-hidden="true"></i> </div>
          <div class="title">API URLS</div>
          </a> 
        </li>*/
                        -->

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
                                <li class="logo"> <a class="navbar-brand" href="#"><?php echo APP_NAME; ?></a> </li>
                                <li>
                                    <button type="button" class="navbar-toggle">
                                        <?php if (PROFILE_IMG) { ?>               
                                            <img class="profile-img" src="images/<?php echo PROFILE_IMG; ?>">
                                        <?php } else { ?>
                                            <img class="profile-img" src="assets/images/profile.png">
                                        <?php } ?>

                                    </button>
                                </li>
                            </ul>
                            <ul class="nav navbar-nav navbar-left">
                                <li class="navbar-title">Angira Live</li>

                            </ul>
                            <ul class="nav navbar-nav navbar-right">
                                <li class="dropdown profile"> <a href="profile.php" class="dropdown-toggle" data-toggle="dropdown"> <?php if (PROFILE_IMG) { ?>               
                                            <img class="profile-img" src="images/<?php echo PROFILE_IMG; ?>">
                                        <?php } else { ?>
                                            <img class="profile-img" src="assets/images/profile.png">
                                        <?php } ?>
                                        <div class="title">Profile</div>
                                    </a>
                                    <div class="dropdown-menu">
                                        <div class="profile-info">
                                            <h4 class="username">Admin</h4>
                                        </div>
                                        <ul class="action">
                                            <li><a href="profile.php">Profile</a></li>                  
                                            <li><a href="logout.php">Logout</a></li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>



                <?php
                ini_set('display_errors', 1);

// include("includes/header.php");
// ini_set('display_errors',1);


                require("includes/function.php");
                require("language/language.php");
                $statusMsg = '';
                $id = $_GET['id'];
                $e_id = base64_decode($id);

                if (isset($_POST["import"])) {
                    $i = 0;
                    $success = 0;
                    $error = 0;

                    foreach ($_FILES['import_file']['name'] as $image) {
                        $target_dir = "images/ExamAns/";
                        $target_file = $target_dir . basename($_FILES["import_file"]["name"][$i]);
                        if (move_uploaded_file($_FILES["import_file"]["tmp_name"][$i], $target_file)) {
                            $success = 1;
                        } else {
                            $error = 1;
                        }
                        $i++;
                    }
                    if ($error != 1) {
                        $type = "success";
                        $statusMsgData = "Image uploaded successfully!";
                    } else {
                        $type = "error";
                        $statusMsgData = "Error occur in image uploading..!";
                    }

                    // Allowed mime types
                    /* $csvMimes = array('text/x-comma-separated-values','xlsx','xls', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
                      // Validate whether selected file is a CSV file

                      //  echo $csvMimes;

                      if(!empty($_FILES['import_file']['name']) && in_array($_FILES['import_file']['type'], $csvMimes))
                      {
                      // If the file is uploaded
                      $filename=$_FILES["import_file"]["tmp_name"];
                      if($_FILES["import_file"]["size"] > 0)
                      {
                      $file = fopen($filename, "r");
                      $column = fgetcsv($file);


                      $TotalRow=count($column)-1;

                      $i=0;
                      //mysqli_set_charset($mysqli, 'utf8');
                      while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
                      {

                      if($i!=0){
                      // mysqli_set_charset($mysqli,"utf8");
                      $mysqli->set_charset("utf8");
                      // print_r($getData);die;
                      $sql = "INSERT into question (e_id,Question,option_1,option_2,option_3,option_4,answer)
                      values ('$e_id','".trim(addslashes($getData[1]))."','".trim(addslashes($getData[2]))."','".trim(addslashes($getData[3]))."','".trim(addslashes($getData[4]))."','".trim(addslashes($getData[5]))."','".trim(addslashes($getData[6]))."')";

                      //  echo $sql."<br>"; die;

                      $result = mysqli_query($mysqli, $sql);



                      if($result)
                      {
                      //echo 'Successfully inserted';
                      $type = "success";
                      $statusMsg = "CSV File has been successfully Imported !";
                      //$insertrow=$insertrow+1;
                      }
                      else
                      {
                      $type = "error";
                      $statusMsg = "Invalid File:Some Error in CSV file please check again !";
                      }
                      }
                      $i++;

                      //echo $result;die();

                      // if(!isset($result))
                      // {
                      //     $type = "error";
                      //     $statusMsg = "Invalid File:Please Upload CSV File !";
                      // }
                      // else if(mysqli_error($mysqli))
                      // {
                      //   $type = "error";
                      //   $statusMsg = "Invalid File:Some Error in CSV file please check again !";
                      // }
                      // else{
                      //     //echo 'Successfully inserted';
                      //     $type = "success";
                      //     $statusMsg = "CSV File has been successfully Imported !";
                      //     $insertrow=$insertrow+1;
                      // }


                      //     }

                      //       fclose($file);
                      //       header( 'Content-Type: text/html; charset=utf-8' );
                      //  }

                      }
                      //   die();
                      //   else
                      //   {
                      //       $statusMsg = "Invalid File: Please upload only CSV File !";
                      //   }

                      }

                      } */
                }
                ?>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
                <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/i18n/defaults-*.min.js"></script>


                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="page_title_block">
                                <div class="col-md-5 col-xs-12">
                                    <div class="page_title">Import Questions</div>
                                </div>

                            </div>
                            <div class="clearfix"></div>
                            <div class="row mrg-top">
                                <div class="col-md-12">
                                    <div class="col-md-12 col-sm-12">
                                        <?php if ($statusMsg) { ?> 
                                            <div class="alert alert-success alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                <?php echo $statusMsg; ?></a> </div>
                                            <?php
                                            unset($statusMsg);
                                        }
                                        ?>	

                                        <?php if ($statusMsgData) { ?> 
                                            <div class="alert alert-success alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                <?php echo $statusMsgData; ?></a> </div>
                                            <?php
                                            unset($statusMsgData);
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body mrg_bottom"> 


                                <form class="form-horizontal" method="POST"  enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Choose File :</label>
                                        <div class="col-sm-4">
                                            <input type="file" class="form-control" name="import_file[]" required="required" multiple>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-9 col-md-offset-1">
                                            <button type="submit" name="import" class="btn btn-sm btn-primary"><i class="fa fa-upload" aria-hidden="true"></i>Upload</button>
                                            <button type="reset"  class="btn btn-sm btn-danger">Reset</button>
                                            <a href="manage_exam.php" class="btn btn-sm btn-success">Back</a>
                                        </div>
                                    </div>
                                </form>
                            </div>



                            <?php
                            if (isset($_POST["importData"])) {

                                $url = 'localhost';
                                $username = 'wwwangir_angiralive';
                                $password = 'Angiralive';
                                $conn = mysqli_connect($url, $username, $password, "wwwangir_angiralive");
                                if (!$conn) {
                                    die('Could not Connect My Sql:' . mysqli_error());
                                }
                                $file = $_FILES['file']['tmp_name'];
                                $handle = fopen($file, "r");
                                $c = 0;
                                $resultData = false;
                                while (($filesop = fgetcsv($handle, 1000, ",")) !== false) {
                                    if ($c != 0) {
                                        //$e_id = $filesop[0];
                                        $Question = trim($filesop[1]);
                                        $option_1 = trim($filesop[2]);
                                        $option_2 = trim($filesop[3]);
                                        $option_3 = trim($filesop[4]);
                                        $option_4 = trim($filesop[5]);
                                        $answer = trim($filesop[6]);
//                                        $image = trim($filesop[7]);
//                                        $image_opt1 = trim($filesop[8]);
//                                        $image_opt2 = trim($filesop[9]);
//                                        $image_opt3 = trim($filesop[10]);
//                                        $image_opt4 = trim($filesop[11]);
                                        $image = '';
                                        $image_opt1 = '';
                                        $image_opt2 = '';
                                        $image_opt3 = '';
                                        $image_opt4 = '';
                                        $points = (isset($filesop[7]) && $filesop[7] != "") ? trim($filesop[7]) : 0;
                                        $is_negative = (isset($filesop[8]) && $filesop[8] != "") ? trim($filesop[8]) : 0;
                                        if ($is_negative == 1) {
                                            $negative_points = (isset($filesop[9])  && $filesop[9] != "") ? trim($filesop[9]) : 0;
                                        } else {
                                            $negative_points = 0;
                                        }
                                        $conn->set_charset('utf8');
                                        mysqli_set_charset($conn, "utf8");

                                        //   $sql = "insert into excel(fname,lname) values ('$fname','$lname')";
//                                        echo "<script>console.log(" . trim($e_id) . ")</script>";
                                        $sqlData = 'INSERT into question (e_id,Question,option_1,option_2,option_3,option_4,answer,image,image_opt1,image_opt2,image_opt3,image_opt4,points,is_negative,negative_points) 
                                                values ("' . $e_id . '","' . $Question . '","' . $option_1 . '","' . $option_2 . '",'
                                                . '"' . $option_3 . '","' . $option_4 . '","' . $answer . '","' . $image . '","' . $image_opt1 . '",'
                                                . '"' . $image_opt2 . '","' . $image_opt3 . '","' . $image_opt4 . '","' . $points . '","' . $is_negative . '","' . $negative_points . '")';
                                        $resultData = mysqli_query($conn, $sqlData);

                                        //   $stmt = mysqli_prepare($conn,$sql);
                                        //   $result=mysqli_stmt_execute($stmt);
                                    }
                                    $c = $c + 1;
                                }
                                if ($resultData) {
                                    //echo 'Successfully inserted';
                                    $type = "success";
                                    $statusMsgData = "CSV File has been successfully Imported !";
                                    //$insertrow=$insertrow+1;
                                } else {
                                    $type = "error";
                                    $statusMsgData = "Invalid File:Some Error in CSV file please. check again !";
                                }
                            }
                            ?>



                            <div class="card-body mrg_bottom"> 
                                <form class="form-horizontal" method="POST" enctype="multipart/form-data">
                                    <label>Excel Import :-</label>
                                    <div class="form-group">
                                        <?php if ($statusMsgData) { ?> 
                                            <div class="alert alert-success alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                <?php echo $statusMsgData; ?></a> </div>
                                            <?php
                                            unset($statusMsgData);
                                        }
                                        ?>	
                                        <label class="col-sm-2 control-label">Choose File :</label>
                                        <div class="col-sm-4">
                                            <input type="file" class="form-control" name="file" required="required">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-9 col-md-offset-1">
                                            <button type="submit" name="importData" class="btn btn-sm btn-primary"><i class="fa fa-upload" aria-hidden="true"></i>Upload</button>
                                            <button type="reset"  class="btn btn-sm btn-danger">Reset</button>
                                            <a href="manage_exam.php" class="btn btn-sm btn-success">Back</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <?php include("includes/footer.php"); ?>       
