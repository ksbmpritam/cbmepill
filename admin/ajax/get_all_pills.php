<?php
include("../includes/connection.php");
global $mysqli;
function user_list_ajax( ){
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
      $where_sql.=' and ( p.pill LIKE "%'.$searchValue.'" OR  p.pill  LIKE "'.$searchValue.'%"  OR  p.pill  LIKE "'.$searchValue.'%"  )';
    }
    $sql=" SELECT * FROM pills as p ".$where_sql;
    
    $resultd=mysqli_query($mysqli,$sql)or die(mysqli_error($mysqli));
    $all__request_data_total=mysqli_fetch_all($resultd, MYSQLI_ASSOC);
   $totalFiltered=count($all__request_data_total);
      
    $sql_limit= $sql .' limit '.$row .','. $rowperpage;
       $query = mysqli_query($mysqli,$sql_limit)or die(mysqli_error($mysqli));
    
    $sno = 1;
    $data_list=mysqli_fetch_all($query, MYSQLI_ASSOC);
      $custom_array=array();
      $totalData =count($data_list);
      foreach ($data_list as $value) {
         $id=$value['id'];
         // $edit_url='';
          $edit_url=' <a  class="add_I_id btn btn-sm btn-info btn-sm"   data_id="'.$id.'"  >Edit</a> '; 
          if($value['status']=='1'){
        //   $view_url=' <a href="all_user.php?status='.$id.'" class="btn btn-sm btn-info" >Active</a>';
          }else{
        //   $view_url=' <a href="all_user.php?status='.$id.'" class="btn btn-sm btn-info" >Deactive</a>';
          }
          $remove_url=' <a href="all_pill.php?id='.$id.'" class="remove_I_id btn btn-sm btn-danger btn-sm"   data_id="'.$id.'"  >Delete</a> '; 
          $action= $attechment.  $edit_url .   $view_url .$remove_url; 
            
        $delete = "<input type='checkbox' class='checkbox' name='checkbox[]'' value='$id' id='$id'>";    
            
      $single=array(
                  $sno++,
                  $value['pill'],
                  $action,
                  $delete
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