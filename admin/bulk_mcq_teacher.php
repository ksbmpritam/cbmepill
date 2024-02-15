<?php
ini_set ('display_errors', 'on');
ini_set ('log_errors', 'on');
ini_set ('display_startup_errors', 'on');
ini_set ('error_reporting', E_ALL);

require ("excel/vendor/autoload.php");
include ("includes/header_teacher.php");
require ("includes/function.php");
require ("language/language.php");
require_once ("thumbnail_images.class.php");

if(isset($_POST["submit"])){
         
  $file = $_FILES['file']['tmp_name'];
  $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);   
  $sheet = $spreadsheet->getActiveSheet();
  
//   echo "<pre>";
  $data = array(1,$sheet->toArray(null,true,true,true)); 
  $data_row = $data[1];
//   print_r($data_row);
//   die;
  
  $count = count($data[1]);
  for($i=2;$i<=$count;$i++){
      
      $c_id = $data_row[$i]["A"];
      $sc_id = $data_row[$i]["B"];
      $title_text = $data_row[$i]["C"];
      $title_img = $data_row[$i]["D"];
      $option1 = $data_row[$i]["E"];
      $option2 = $data_row[$i]["F"];
      $option3 = $data_row[$i]["G"];
      $option4 = $data_row[$i]["H"];
      $right_option = $data_row[$i]["I"];
      $timing = $data_row[$i]["J"];
       $whyRight = $data_row[$i]["K"];
     
      
      $photo_new_name_array = array($option1,$option2,$option3,$option4);
      
      $data = array(
        'c_id' => $c_id,
        'sc_id' => $sc_id,
        'title_text' => $title_text,
        'title_img' => $title_img,
        'options' => implode("|",$photo_new_name_array),
        'right_option' => $right_option,
        'timer' => $timing,
        'why_ans_mcq' => $whyRight,
        );
    Insert('mcq', $data);
      
  }
  
  $_SESSION['msg'] = "Uploaded Success";
    
}

?>
<style>
    .top_margin{
        margin: 15px 0!important;
    }
</style>

<div class="row">

    <div class="col-md-12">

        <div class="card">

            <div class="page_title_block">

                <div class="col-md-5 col-xs-12">

                    <div class="page_title">Bulk Upload MCQ</div>

                </div>
                
                <div class="col-md-3 col-xs-12">
                  <div class="search_list">
                    <div class="add_btn_primary"> <a href="mcq_images.php" target=_blank>Upload Images</a> </div>
                  </div>
                </div>
                
                <div class="col-md-3 col-xs-12">
                  <div class="search_list">
                    <div class="add_btn_primary"> <a href="excel/bulk_upload.xlsx" download target=_blank>Demo File</a> </div>
                  </div>
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

                <form action="" name="addeditcategory" method="post" class="form form-horizontal" enctype="multipart/form-data">
                            
                            
                            <div class="row px-2">
                                
                                <div class="col-lg-6 col-md-6 col-sm-6 top_margin">
                                    <div>
                                        <label>Select File</label>
                                        <input type="file" accept=".csv,.xlsx"  class="form-control" name="file" required >
                                    </div>
                                </div>
                                
                                <div class="col-lg-12 col-md-12 col-sm-12 px-2" id="submit">
                                    <div>
                                        <button type="submit" name="submit" class="btn btn-primary" style="margin-top: 10px;">Upload</button>
                                    </div>
                                </div>
                            </div>
                            
                            
                               <div class="col-md-12 mrg-top">
                <div class="row">

                    <div class="table-responsive">
                        <table id="mytable"  class="table table-bordered table-striped table-hover table-sm ">
                            <thead>
                                <tr>
                                    <th>C.id</th>
                                    <th>Category</th>
                                    <th>S.id</th>
                                    <th>Sub Category</th>
                                </tr>
                            </thead>
                            <tbody >
                                
                                <?php         
                                        
                                    $sql = "SELECT c.cid ,c.category_name,sc.name as sub_cat_name , sc.id as sub_id FROM sub_categories sc JOIN tbl_category c ON sc.category_id = c.cid  WHERE FIND_IN_SET('$userValue', sc.teacher_id)";
                                
                                $query = mysqli_query($mysqli,$sql);
                                $sno = 1;
                                while($row = mysqli_fetch_assoc($query)){
                                    ?>
                                        <tr>
                                            <td><?=$row['cid']?></td>
                                            <td><?=$row['category_name']?></td>
                                            <td><?=$row['sub_id']?></td>
                                            <td><?=$row['sub_cat_name']?></td>
                                        </tr>
                                    <?php
                                }
                                
                                ?>
                                
                            </tbody>
                        </table>
                    </div>


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