<?php
include ("includes/header.php");
require ("includes/function.php");
require ("language/language.php");
require_once ("thumbnail_images.class.php");

if (isset($_POST['submit'])) {
    $image_id = filter($_POST['image_id']);
    $pill_id = $_POST['pill_id'];
    
    $count = count($pill_id);
    
    for($i=0;$i<$count;$i++){
        
        $qry1 = "SELECT * FROM games_pills where image_id='" . $image_id . "' and pill_id='" . $pill_id[$i] . "'";
        $result = mysqli_query($mysqli, $qry1);
        $row = mysqli_num_rows($result);
        
        if ($row == 0) {
            $data = array('image_id' => $image_id, 'pill_id' => $pill_id[$i],);
            Insert('games_pills', $data);
        }
        
    }
    
    $_SESSION['msg'] = "Pill assigned success";
    header("Location:all_asign_pills.php");
    exit;
    
    // if ($row == 0) {
    //     $data = array('image_id' => $image_id, 'pill_id' => $pill_id,);
    //     Insert('games_pills', $data);
    //     $_SESSION['msg'] = "Pill assigned success";
    //     header("Location:all_asign_pills.php");
    //     exit;
    // } else {
    //     $_SESSION['msg'] = "Pill already assigned";
    //     header("Location:all_asign_pills.php");
    //     exit;
    // }
}
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>

<div class="row">

    <div class="col-md-12">

        <div class="card">

            <div class="page_title_block">

                <div class="col-md-5 col-xs-12">

                    <div class="page_title">Assign Pill</div>

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
                
                <img src="images/no_image_selected.png" id="img" style="width:200px!important;margin: 0 0 20px;">
                
                <form action="" name="addeditcategory" method="post" class="form form-horizontal" enctype="multipart/form-data">

                            <div class="row">

                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <label>Select Image</label>
                                    <select class="form-control" name="image_id" onchange="show_img(this.value)">
                                    <option value="">Select</option>
                                    <?php
                                        $sql = "SELECT id,photos FROM `game_photos` ORDER BY id DESC ";
                                        $query = mysqli_query($mysqli, $sql);
                                        while ($row = mysqli_fetch_assoc($query)) {
                                    ?>
                                        <option value="<?=$row['id'] ?>"><?=$row['photos'] ?></option>
                                    <?php
                                    }
                                    ?>
                                    </select>

                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <label>Select Pill</label>
                                    <select class="form-control chosen-select" multiple name="pill_id[]">
                                    <?php
                                    $sql = "SELECT id,pill FROM `pills`";
                                    $query = mysqli_query($mysqli, $sql);
                                    while ($row = mysqli_fetch_assoc($query)) {
                                    ?>
                                    <option value="<?=$row['id'] ?>"><?=$row['pill'] ?></option>
                                    <?php
                                    }
                                    ?> 
                                            </select>                           </div>
                                            <div class="form-group">

<div class="col-md-6 col-md-offset-1">

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
     $(".chosen-select").chosen({no_results_text: "Oops, nothing found!"});
</script>

<script>
    
    const show_img = async (t) => {
        try {
            let val = t;
            let url = `get_img_src.php?id=${val}`;
            let response = await fetch(url);
            let data = await response.text();
            if(data.indexOf(".vish") > -1){
                document.querySelector('#img').src = "images/no_image_selected.png";
            }else{
                document.querySelector('#img').src = data;
            }
        } catch (error) {
            console.log(`The Error is ${error}`);
        }
    }
    
    
    
</script>

<?php include ("includes/footer.php"); ?>       