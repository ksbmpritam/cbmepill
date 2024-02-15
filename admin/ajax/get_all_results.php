<?php

include("../includes/connection.php");
global $mysqli;

function user_result_ajax() {
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

    $join_sql = "  ";

    $where_sql = " Where 1=1 ";
    if (isset($searchValue) && $searchValue != "") {
        $where_sql .= ' and ( u.name LIKE "%' . $searchValue . '" OR  u.mobile  LIKE "' . $searchValue . '%"  OR  u.email  LIKE "' . $searchValue . '%"  )';
    }
    $sql = " SELECT r.*,u.name as username,e.name as examname FROM result as r "
            . "LEFT JOIN user as u ON r.user_id = u.user_id 
                LEFT JOIN exam as e ON r.exam_id = e.id 
            " . $where_sql." Group by r.exam_id,r.user_id,r.track order by r.id desc";

    $resultd = mysqli_query($mysqli, $sql)or die(mysqli_error($mysqli));
    $all__request_data_total = mysqli_fetch_all($resultd, MYSQLI_ASSOC);
    $totalFiltered = count($all__request_data_total);

    $sql_limit = $sql . ' limit ' . $row . ',' . $rowperpage;
    $query = mysqli_query($mysqli, $sql_limit)or die(mysqli_error($mysqli));

    $data_list = mysqli_fetch_all($query, MYSQLI_ASSOC);
    $custom_array = array();
    $totalData = count($data_list);
    foreach ($data_list as $value) {
//        $id = base64_encode($value['user_id']);
//        // $edit_url='';
//        $edit_url = ' <a  class="add_I_id btn btn-sm btn-danger btn-sm"   data_id="' . $id . '"  >AddOns</a> ';
//        if ($value['status'] == '1') {
//            $view_url = ' <a href="all_user.php?status=' . $id . '" class="btn btn-sm btn-info" >Active</a>';
//        } else {
//            $view_url = ' <a href="all_user.php?status=' . $id . '" class="btn btn-sm btn-info" >Deactive</a>';
//        }
//        $remove_url = ' <a href="all_user.php?user=' . $id . '" class="remove_I_id btn btn-sm btn-danger btn-sm"   data_id="' . $id . '"  >Delete</a> ';
//        $action = $attechment . $edit_url . $view_url . $remove_url;
        $action = '<a href="result_pdf.php?id=' . $value['id'] . '" class="btn btn-sm btn-info">Export</a>';

        $single = array(
            $value['id'],
            $value['username'],
            $value['examname'],
            $value['datetime'],
//            $value['email'],
//            $value['educ_qual'],
//            $value['stream'],
//            $value['country'],
//            $value['state'],
            $action,
        );

        $custom = array_push($custom_array, $single);
    }

    $json_data = array(
        "draw" => intval($_REQUEST['draw']),
        "recordsTotal" => intval($totalData),
        "recordsFiltered" => intval($totalFiltered),
        "data" => $custom_array
    );

    echo json_encode($json_data);
}

echo user_result_ajax();
