<?php include("includes/header.php");

  require("includes/function.php");
  require("language/language.php");

///////
function push_notification($DeviceToken,$title,$body,$image){
  //$time_tag=" ".date('Y-m-d h:i A'); 
  //echo "<Br>".$DeviceToken."</BR>";
  $data = array(
          'body' => $body,
          'title' => $title,
          'image'=>$image,
          'vibrate' => 1,
          'sound' => "default",
          'badge' => '1',
      );
  //    print_r($data);
 // $notification = array('title' =>$title , 'body' => $body, 'sound' => 'default', 'badge' => '1');
  // $arrayToSend = array('to' => $token, 'notification' => $notification,'priority'=>'high');
 //$FCMFields = array('to' => $DeviceToken,  'data' => $data  , 'android' => $icon);
  $FCMFields = array('to' => $DeviceToken, 'notification' => $data, 'data' => $data);
  //FCM API end-point
  $url = 'https://fcm.googleapis.com/fcm/send';
  //api_key in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
 // $server_key = 'AAAAQBd2LYI:APA91bHVQkWV7kVAyyBsp5mjMazCLQ2-jfRpUBvwp4MyNX9XWIIt-jCFbszHWfFVsffzARpaogpiKpMZ7qdpQps1pp-WcMB5iKMUyw4oWNQDfMRSciNuLoSwQfYnE22TcQ-ARsQldnHR';
 $server_key = 'AAAAq6-fH04:APA91bG7FKq3HJNrjspQbMQhC0NPJaMAypHYzfKRRswUXvB0Cqz4429NI3czWj2BU3G50BkEN5LNklZX9hNRtxs91bO2Kc4gLQtPMGXs-_u1lSjWL1PH2gcqc6SALU5tzxVzcePSd1Cw';
  
  //header with content_type api key
  $headers = array(
      'Content-Type:application/json',
      'Authorization:key='.$server_key
  );
  //CURL request to route notification to FCM connection server (provided by Google)
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($FCMFields) );
  $result = curl_exec($ch);
  if ($result === FALSE) {
      die('Oops! FCM Send Error: ' . curl_error($ch));
  }
  curl_close($ch);
  return true;
}


//////

  //'filters' => array(array('Area' => '=', 'value' => 'ALL')),

    if(isset($_REQUEST['pbl']))
    {
        $id=base64_decode($_REQUEST['pbl']); 
        $qry="select * from notification where id='$id'";
		$qry_o=mysqli_query($mysqli,$qry);
		$qry_fet=mysqli_fetch_assoc($qry_o);
		$title="";$body="";$image="";
		$title=$qry_fet['title']; 
		$body=$qry_fet['discription']; 
		$base_url='http://angirasuratgarhlive.com/ksbmadmin';
		if($qry_fet['image']!=""){
		$image=$base_url.'/images/notification/'.$qry_fet['image']; 
		}
		if($qry_fet['published']=='1')
		{
		    $published='0';
		    $quser=mysqli_query($mysqli,"select * from user where paid='0'");
		    while($row=mysqli_fetch_assoc($quser))
		    {
		        $insnoti=mysqli_query($mysqli,"delete from notificationseen where `userid`='".$row['user_id']."' and `notiification`='$id'");
		    }
		}
		if($qry_fet['published']=='0')
		{
		    $published='1';
		    $quser=mysqli_query($mysqli,"select * from user where paid='0'");
		    
		    while($row=mysqli_fetch_assoc($quser))
		    {
		        
		        $insnoti=mysqli_query($mysqli,"insert into notificationseen(`userid`, `notiification`,`status`) values('".$row['user_id']."','$id','0')");
		        //
		        if($row['device_token']!="" && !empty($title)){
		       echo push_notification($row['device_token'],$title,$body,$image);
		        }
		    }
		}
		
		$qry="update notification set published='$published' where id='$id'";
		$qry_result=mysqli_query($mysqli,$qry);
		$_SESSION['msg']="11";
    }
    
    if(isset($_REQUEST['pbl1']))
    {
        $id=base64_decode($_REQUEST['pbl1']); 
        $qry="select * from notification where id='$id'";
		$qry_o=mysqli_query($mysqli,$qry);
		$qry_fet=mysqli_fetch_assoc($qry_o);
		$title="";$body="";$image="";
		$title=$qry_fet['title']; 
		$body=$qry_fet['discription']; 
		$base_url='http://angirasuratgarhlive.com/ksbmadmin';
		if($qry_fet['image']!=""){
		$image=$base_url.'/images/notification/'.$qry_fet['image']; 
		}
		if($qry_fet['paid_published']=='1')
		{
		    $paid_published='0';
		    $quser=mysqli_query($mysqli,"select * from user where paid='1'");
		    while($row=mysqli_fetch_assoc($quser))
		    {
		        $insnoti=mysqli_query($mysqli,"delete from notificationseen where `userid`='".$row['user_id']."' and `notiification`='$id'");
		        if($row['device_token']!="" && !empty($title)){
		        push_notification($row['device_token'],$title,$body,$image);
		        }
		    }
		}
		if($qry_fet['paid_published']=='0')
		{
		    $paid_published='1';
		    $quser=mysqli_query($mysqli,"select * from user where paid='1'");
		    while($row=mysqli_fetch_assoc($quser))
		    {
		        
		        $insnoti=mysqli_query($mysqli,"insert into notificationseen(`userid`, `notiification`,`status`) values('".$row['user_id']."','$id','0')");
		        if($row['device_token']!="" && !empty($title)){
		        push_notification($row['device_token'],$title,$body,$image);
		        }
		        
		    }
		}
		
		$qry="update notification set paid_published='$paid_published' where id='$id'";
		$qry_result=mysqli_query($mysqli,$qry);
		$_SESSION['msg']="11";
    }
    
    if(isset($_REQUEST['del']))
    {
     $id=base64_decode($_REQUEST['del']);
     $qry="delete from notification where id='$id'";
	 $qry_o=mysqli_query($mysqli,$qry);
	 $_SESSION['msg']="12";
    }
 
  
   

?>
<div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title">Notification List</div>
            </div>
            
            <div class="col-md-7 col-xs-12">
              <div class="search_list">
                  <div class="search_block">
                      <form  method="post" action="">
                        <input class="form-control input-sm" onkeyup="search(this.value.toLowerCase())"  placeholder="Search here..." aria-controls="DataTables_Table_0" type="search" name="search_value" required>
                        <button type="submit" name="data_search" class="btn-search"><i class="fa fa-search"></i></button>
                  </form>  
                </div>
              </div>
            </div>
            
          </div>
          <div class="clearfix"></div>
          <div class="row mrg-top">
            <div class="col-md-12">
               
              <div class="col-md-12 col-sm-12">
                <?php if(isset($_SESSION['msg'])){?> 
                 <div class="alert alert-success alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                  <?php echo $client_lang[$_SESSION['msg']] ; ?></a> </div>
                <?php unset($_SESSION['msg']);}?> 
              </div>
            </div>
          </div>
          <div class="card-body mrg_bottom"> 
            <table class="table table-bordered" id="mytable">
    <thead>
      <tr>
        <th>S. no</th>
        <th>Title</th>
        <th>Discription</th>
        <th>Image</th>
        <th>Delete</th>
      </tr>
    </thead>
    <tbody>
        <?php 
        
        if(isset($_POST['data_search'])){
            $search_value = $_POST['search_value'];
            $qry="select * from notification WHERE title LIKE '%$search_value%' OR discription LIKE '%$search_value%' order by id desc"; 
        }else{
            $qry="select * from notification order by id desc"; 
        }
        
        
		$qry_result=mysqli_query($mysqli,$qry);
		if(mysqli_num_rows($qry_result)>0)
		{
		    $s=1;
		    while($row=mysqli_fetch_assoc($qry_result))
		    {
		        $id=base64_encode($row['id']);
        ?>
      <tr>
        <td><?=$s++;?></td>
        <td><?=$row['title'];?></td>
        <td><?=$row['discription'];?></td>
        <td><img src="<?=$row['image'];?>" style="width: 100px !important;"></td>
        <td><button class="btn btn-sm btn-danger" onclick="window.location.href='notification_list.php?del=<?=$id?>'">Delete</button></td>
      </tr>
      <?php } }?>
    </tbody>
  </table>
          </div>
        </div>
      </div>
    </div>
        
<script>
    const search = (input) => {
        let table = document.querySelector('#mytable');
        let table_row = table.querySelectorAll('tr');
        let table_column = table_row[1].querySelectorAll('td'); //This is Total No. Of Column

        for (let i = 1; i < table_row.length; i++) {
            for(let j = 0; j < table_column.length; j++){
                let field_Value = table_row[i].querySelectorAll('td')[j]; //this is for field
                if (field_Value.innerText.toLowerCase().indexOf(input) > -1) {
                    table_row[i].style.display = "";
                    break;
                } else {
                    table_row[i].style.display = "none";
                }
            }                   
        }
    }
</script>
        
<?php include("includes/footer.php");?>       
