<?php
include("includes/connection.php");
$date = mysqli_real_escape_string($mysqli,$_GET['date']);


if(!empty($date)){
    $sql = "SELECT * FROM `users` WHERE created_at LIKE '%$date%'";
}else{
    $sql = "SELECT * FROM `users`";
}
    $query = mysqli_query($mysqli,$sql);

    $sno = 1;
    while($row = mysqli_fetch_assoc($query)){
        ?>
            <tr>
                <td><?=$sno++?></td>
                <td><?=$row['created_at']?></td>
                <td><?=$row['display_name']?></td>
                <td><?=$row['mobile']?></td>
                <td><?=$row['email']?></td>
                <td><?=$row['gender']?></td>
                <td>
                    <img src="<?=$row['profile_pic_url']?>">
                </td>
                <td>
                    <?php 
                        if($row['status'] == 1){
                            echo "Active";
                        }else{
                            echo "Deactivate";
                        }
                    ?>
                </td>
                <td>
                    <?php 
                        if($row['status'] == 1){
                            ?>
                                <a href="all_user.php?status=<?=$row['id']?>" class="btn btn-sm btn-info" >Active</a>
                            <?php
                        }else{
                            ?>
                                <a href="all_user.php?status=<?=$row['id']?>" class="btn btn-sm btn-info" >Deactive</a>
                            <?php
                        }
                        
                        ?>
                            <a href="all_user.php?user=<?=$row['id']?>" class="remove_I_id btn btn-sm btn-danger btn-sm" data_id="'.$id.'"  >Delete</a>
                        <?php
                    ?>
                </td>
            </tr>
        <?php
    }
?>