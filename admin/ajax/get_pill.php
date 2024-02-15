<?php
include("../includes/connection.php");
global $mysqli;

$id = $_REQUEST['id'];
$sqli = "SELECT * from pills where id='$id'";
$data = mysqli_query($mysqli, $sqli);
$pills = mysqli_fetch_assoc($data);
//print_r($user);	

?>

<div class="row">
    <div class="col-md-12"> 
        Edit Pill
    </div>

</div>
<hr/>
<form method="post">
    <input type="hidden" name="update_pill_id" value="<?php echo $pills['id']; ?>" >
    <div class="row">
        <div class="col-md-12"> 
            
            <div class="row">
                
                    <div class="col-md-6"> 
                        <p>
                            <lable>Pill Name</lable> 
                            <input type="text" class="form-control" name="pill" value="<?php echo $pills['pill']; ?>" >	          							 
                        </p>
                    </div>
                    
                    <div class="col-md-6"> 
                        <p>
                            <lable>Pill Code</lable> 
                            <input type="text" class="form-control" name="pill_code" value="<?php echo $pills['pill_code']; ?>" >	          							 
                        </p>
                    </div>
                    
                    <div class="col-md-12"> 
                        <p>
                            <lable>Pill Description</lable> 
                            <input type="text" class="form-control" name="pill_description" value="<?php echo $pills['pill_description']; ?>" >	          							 
                        </p>
                    </div>
                    
                    <div class="col-md-12"> 
                        <p>
                            <lable>Pill Benefits</lable> 
                            <input type="text" class="form-control" name="pill_benefits" value="<?php echo $pills['pill_benefits']; ?>" >	          							 
                        </p>
                    </div>
                    
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <p>
                            <select class="form-control" name="pillType" required>
                                <?php
                                    $type = ["Pill","Injection","Iv fluid","Receptor","Antibody","Bacteria","Virus"];
                                    
                                    
                                    $med_sql = "SELECT * FROM `medicine_type`";
                                    $med_query = mysqli_query($mysqli,$med_sql);
                                    
                                    while($med_row = mysqli_fetch_assoc($med_query)){
                                        
                                        if($med_row['id'] == $pills['type']){
                                            $sel = "selected";
                                        }else{
                                            $sel = "";
                                        }
                                        
                                        echo "<option ".$sel." value='".$med_row['id']."'>".$med_row['name']."</option>";
                                    }
                                    
                                    
                                ?>
                            </select>
                        </p>        
                    </div>
                    
            </div>
            
        </div>
    </div>
    <input type="submit" name="update_pill" clas="btn btn-danger" value="Update">
</form>