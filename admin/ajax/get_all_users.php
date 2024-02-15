<?php
include("../includes/connection.php");
global $mysqli;
function user_list_ajax( )
    {
  global $mysqli;
    $draw = $_REQUEST['draw'];
    $row = $_REQUEST['start'];
    $searchValue = $_REQUEST['search']['value'];
    $rowperpage = $_REQUEST['length']; // Rows display per page
    $order = $_REQUEST['order'][0]['dir'];
    $columnIndex = $_REQUEST['order'][0]['column']; // Column index
    $columnName = $_REQUEST['columns'][$columnIndex]['data']; // Column name
    $columnSortOrder = $_REQUEST['order'][0]['dir']; // asc or desc
    $searchQuery = '';

    $join_sql="  ";

    $where_sql=" Where 1=1 ";
    if(isset($searchValue) && $searchValue!=""){
      $where_sql.=' and ( u.name LIKE "%'.$searchValue.'" OR  u.mobile  LIKE "'.$searchValue.'%"  OR  u.email  LIKE "'.$searchValue.'%"  )';
    }
    $sql=" SELECT * FROM users as u ".$where_sql;
    
    $resultd=mysqli_query($mysqli,$sql)or die(mysqli_error($mysqli));
    $all__request_data_total=mysqli_fetch_all($resultd, MYSQLI_ASSOC);
   $totalFiltered=count($all__request_data_total);
      
    $sql_limit= $sql .' limit '.$row .','. $rowperpage;
       $query = mysqli_query($mysqli,$sql_limit)or die(mysqli_error($mysqli));
     
    $data_list=mysqli_fetch_all($query, MYSQLI_ASSOC);
      $custom_array=array();
      $totalData =count($data_list);
      foreach ($data_list as $value) {
         $id=base64_encode($value['user_id'] );
         // $edit_url='';
          // $edit_url=' <a  class="add_I_id btn btn-sm btn-danger btn-sm"   data_id="'.$id.'"  >AddOns</a> '; 
          if($value['status']=='1'){
          $view_url=' <a href="all_user.php?status='.$id.'" class="btn btn-sm btn-info" >Active</a>';
          }else{
          $view_url=' <a href="all_user.php?status='.$id.'" class="btn btn-sm btn-info" >Deactive</a>';
          }
          $remove_url=' <a href="all_user.php?user='.$id.'" class="remove_I_id btn btn-sm btn-danger btn-sm"   data_id="'.$id.'"  >Delete</a> '; 
          $action= $attechment.  $edit_url .   $view_url .$remove_url; 
    
      $single=array(
                      $value['id'],
                      $value['modified_at'],
                      $value['display_name'],
                      $value['mobile'],
                      $value['email'],
                      $value['gender'],
                      "<img src=".$value['profile_pic_url'].">",
                      $value['status']==1 ? 'Active': 'Deactivate',
                      $action,
	 	 		       );

      $custom=array_push($custom_array , $single);
      }

    $json_data = array(
    "draw"            => intval( $_REQUEST['draw'] ),
    "recordsTotal"    => intval( $totalData ),
    "recordsFiltered" => intval( $totalFiltered ),
    "data"            => $custom_array
    );

    echo json_encode($json_data);
}
echo user_list_ajax();
