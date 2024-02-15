<?php
include ("includes/header.php");
require ("includes/function.php");
require ("language/language.php");
require_once ("thumbnail_images.class.php");




if (isset($_POST['submit'])) {
    
 
  
     $data = array(
         'first_h' => $_POST['first_h'],
        'first_p' => $_POST['first_p'],
        'about_first_p' => $_POST['about_first_p'],
        'about_second_p' => $_POST['about_second_p'],
        'phar_p' => $_POST['phar_p'],
        'phar_line_first' => $_POST['phar_line_first'],
        'phar_line_second' => $_POST['phar_line_second'],
        'phar_line_third' => $_POST['phar_line_third'],
        'phar_line_four' => $_POST['phar_line_four'],
        'feature_p' => $_POST['feature_p'],
        'install_p' => $_POST['install_p'],
        'account_p' => $_POST['account_p'],
        'easy_play_p' => $_POST['easy_play_p'],
        'play_store_url' => $_POST['play_store_url'],
      );
      
                 
        $home_page = Update('index_data', $data, "WHERE id = 1");
     
            $_SESSION['msg'] = "Update Success";

    
}



    $qry = "SELECT * FROM index_data where id='1'";
    $result = mysqli_query($mysqli, $qry);
    $row = mysqli_fetch_assoc($result);
   
           ?>
           
<link rel="stylesheet" href="assets/css/custom.css">

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

                    <div class="page_title">Home Index</div>

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
                                
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div>
                                        <label>First Container Heading</label>
                                        
                                         <textarea class="form-control" name="first_h" id="first_h" rows="1" ><?=$row['first_h']?></textarea>
                                    </div>
                                </div>
                                
                                
                                <div class="col-lg-12 col-md-12 col-sm-12 top_margin">
                                    <div>
                                        <label for="first_p">First Container Paragraph</label>
                                        <textarea class="form-control" name="first_p" id="first_p" rows="3"><?=$row['first_p']?></textarea>
                                    </div>
                                </div>
                                
                                 <div class="col-lg-12 col-md-12 col-sm-12 top_margin">
                                    <div>
                                        <label for="first_p">About Container First Paragraph </label>
                                        <textarea class="form-control" name="about_first_p" id="about_first_p" rows="3"><?=$row['about_first_p']?></textarea>
                                    </div>
                                </div> 
                                
                                     <div class="col-lg-12 col-md-12 col-sm-12 top_margin">
                                    <div>
                                        <label for="about_second_p">About Container Second Paragraph</label>
                                        <textarea class="form-control" name="about_second_p" id="about_second_p" rows="3"><?=$row['about_second_p']?></textarea>
                                    </div>
                                </div> 
                                
                                 <div class="col-lg-12 col-md-12 col-sm-12 top_margin">
                                    <div>
                                        <label for="phar_p">Pharmacology Container</label>
                                        <textarea class="form-control" name="phar_p" id="phar_p" rows="3"><?=$row['phar_p']?></textarea>
                                    </div>
                                </div> 
                                
                                  <div class="col-lg-12 col-md-12 col-sm-12 top_margin">
                                    <div>
                                        <label for="phar_line_first">Pharmacology Container</label>
                                        <textarea class="form-control" name="phar_line_first" id="phar_line_first" rows="1"><?=$row['phar_line_first']?></textarea>
                                    </div>
                                </div> 
                                
                                  <div class="col-lg-12 col-md-12 col-sm-12 top_margin">
                                    <div>
                                        <label for="phar_line_second">Pharmacology Container Second Line</label>
                                        <textarea class="form-control" name="phar_line_second" id="phar_line_second" rows="1"><?=$row['phar_line_second']?></textarea>
                                    </div>
                                </div> 
                                
                                  <div class="col-lg-12 col-md-12 col-sm-12 top_margin">
                                    <div>
                                        <label for="phar_line_third">Pharmacology Container Third Line</label>
                                        <textarea class="form-control" name="phar_line_third" id="phar_line_third" rows="1"><?=$row['phar_line_third']?></textarea>
                                    </div>
                                </div>
                                
                                 <div class="col-lg-12 col-md-12 col-sm-12 top_margin">
                                    <div>
                                        <label for="phar_line_four">Pharmacology Container Fourth Line</label>
                                        <textarea class="form-control" name="phar_line_four" id="phar_line_four" rows="1"><?=$row['phar_line_four']?></textarea>
                                    </div>
                                </div>
                                
                                   <div class="col-lg-12 col-md-12 col-sm-12 top_margin">
                                    <div>
                                        <label for="feature_p">Feature Container</label>
                                        <textarea class="form-control" name="feature_p" id="feature_p" rows="1"><?=$row['feature_p']?></textarea>
                                    </div>
                                </div>
                                
                                 <div class="col-lg-12 col-md-12 col-sm-12 top_margin">
                                    <div>
                                        <label for="install_p">Install Container </label>
                                        <textarea class="form-control" name="install_p" id="install_p" rows="3"><?=$row['install_p']?></textarea>
                                    </div>
                                </div>
                                
                                 <div class="col-lg-12 col-md-12 col-sm-12 top_margin">
                                    <div>
                                        <label for="account_p">Set Up Container </label>
                                        <textarea class="form-control" name="account_p" id="account_p" rows="3"><?=$row['account_p']?></textarea>
                                    </div>
                                </div>
                                
                                 <div class="col-lg-12 col-md-12 col-sm-12 top_margin">
                                    <div>
                                        <label for="easy_play_p">Easy Play Container </label>
                                        <textarea class="form-control" name="easy_play_p" id="easy_play_p" rows="3"><?=$row['easy_play_p']?></textarea>
                                    </div>
                                </div>
                                
                                 <div class="col-lg-12 col-md-12 col-sm-12 top_margin">
                                    <div>
                                        <label for="play_store_url">Play Store URL</label>
                                        <input class="form-control" name="play_store_url" id="play_store_url" value="<?=$row['play_store_url']?>">
                                    </div>
                                </div>


                                
                                
                                <div class="col-lg-12 col-md-12 col-sm-12 px-2" id="submit">
                                    <div>
                                        <button type="submit" name="submit" class="btn btn-primary" style="margin-top: 10px;">Save</button>
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

<script>
    const getSubCategory = async () => {
        try {
            let val = document.querySelector("#category").value;
            console.log(val);
            let url = `getsubcategory.php?id=${val}`;
            let response = await fetch(url);
            let data = await response.text();
            document.querySelector('#subCategory').innerHTML = data;
        } catch (error) {
            console.log(`The Error is ${error}`);
        }
    }
    
    const addCell = () => {
        let html = document.querySelector("#main_cell").innerHTML;
        document.querySelector("#submit").insertAdjacentHTML('beforebegin',html);
    }
    
    // This is on load
    
    window.addEventListener('DOMContentLoaded', (event) => {
        getSubCategory();
    });
    
    // This is for choosen
    // $(".chosen-select").chosen({no_results_text: "Oops, nothing found!"});
    
</script>

<?php include ("includes/footer.php"); ?>       
<script>


</script>
