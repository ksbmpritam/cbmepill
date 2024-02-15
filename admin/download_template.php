<?php
 $con=mysqli_connect("localhost","wwwangir_angiralive","Angiralive","wwwangir_angiralive");
if(mysqli_connect_errno()){
	echo "faild to connect to mysql".mysqli_connect_errno();
}
   session_start();
?>

<?php if($_GET['downlaod']=='user_template'){
	$file="employee_detail.xls";
	header('Content-Type: text/html');
	$table = $_POST['tablehidden'];//i get this from another php file.It is HTML table
	header("Content-type: application/x-msexcel"); //tried adding  charset='utf-8' into header
	header("Content-Disposition: attachment; filename=$file");
	echo $table;
} if($_GET['downlaod']=='user_template'){
?>
                    	  <table width="100%" cellpadding="0" cellspacing="0" border="1px">
                            <tr>
                                    <th width="70">Emp id</th>
                          			<th width="232">Emp Name</th>
                                    <th width="306">Login Name</th>
                                    <th width="306">Employee No</th>
                                    <th width="232">Password</th>
                                    <th width="232">Email id</th>
                                    <th width="232">First name</th>
                                    <th width="232">Last name</th>
                                    <th width="232">doj</th>
                                    <th width="232">Father name/Husband Name</th>
                                    <th width="232">Gender</th>
                                     <th width="232">Dob</th>
                                    <th width="257">Phone no</th>
                                    <th width="257">Mobile no</th>
                                    <th width="306">Dep id</th>
                                    <th width="306">Current Address.</th>
                                    <th width="306">Permanent Address</th>
                                    <th width="306">Designation</th>
                                    <th width="306">Qualification</th>
                                  </tr>
	</table>
    <?php } 
	if($_GET['downlaod']=='partner_csv'){
	$file="business_partner.xls";
	header('Content-Type: text/html');
	$table = $_POST['tablehidden'];//i get this from another php file.It is HTML table
	header("Content-type: application/x-msexcel"); //tried adding  charset='utf-8' into header
	header("Content-Disposition: attachment; filename=$file");
	echo $table;
	}
	if($_GET['downlaod']=='partner_csv'){?>
    <table width="100%" cellpadding="0" cellspacing="0" border="1px">
                            <tr>
                                    <th width="70">Form Image</th>
                                    <th width="70">Partner Image</th>
                                    <th width="70">Full Name</th>
                          			<th width="232">Partner Id</th>
                                    <th width="306">Password</th>
                                    <th width="306">Email Id</th>
                                    <th width="232">Form Name</th>
                                    <th width="232">Company Name</th>
                                    <th width="232">Company's Director Name</th>
                                    <th width="232">Phone Number</th>
                                    <th width="232">Mobile Number</th>
                                    <th width="232">PAN No.</th>
                                    <th width="232">Election Card No.</th>
                                     <th width="232">Aadhar No </th>
                                    <th width="257">Current Address</th>
                                    <th width="257">Permanent Address</th>
                                    <th width="306">Holder's Name </th>
                                    <th width="306">IFSC Code</th>
                                    <th width="306">Account No</th>
                                    <th width="306">Bank Branch</th>
                                    <th width="306">Bank Name</th>
                                    
                                  </tr>
	</table>
    <?php } 
	
	if($_GET['downlaod']=='question'){
	$file="question.xls";
	header('Content-Type: text/html');
	$table = $_POST['tablehidden'];//i get this from another php file.It is HTML table
	header("Content-type: application/x-msexcel"); //tried adding  charset='utf-8' into header
	header("Content-Disposition: attachment; filename=$file");
	echo $table;
	}
	if($_GET['downlaod']=='question'){?>
    <table width="100%" cellpadding="0" cellspacing="0" border="1px">
                            <tr>
                          			<th width="232">Image Name</th>
                                    <th width="306">Patient Name</th>
                                    <th width="306">Patient Id</th>
                                    <th width="232">Password</th>
                                    <th width="232">Email Id</th>
                                    <th width="232">HUSBAND'S/ FATHER'S NAME</th>
                                    <th width="232">Gender</th>
                                    <th width="232">DOB</th>
                                    <th width="232">Phone/Landline</th>
                                    <th width="232">Mobile</th>
                                     <th width="232">Category</th>
                                    <th width="257">Permanent Address</th>
                                    <th width="257">Current Address</th>
                                  </tr>
	</table>
    <?php }
	if($_GET['downlaod']=='doctor_csv'){
	$file="doctor_detail.xls";
	header('Content-Type: text/html');
	$table = $_POST['tablehidden'];//i get this from another php file.It is HTML table
	header("Content-type: application/x-msexcel"); //tried adding  charset='utf-8' into header
	header("Content-Disposition: attachment; filename=$file");
	echo $table;
	}
	if($_GET['downlaod']=='doctor_csv'){?>
    <table width="100%" cellpadding="0" cellspacing="0" border="1px">
                             <tr>
                                    <th width="70">Id</th>
                                    <th width="70">Doctor Image Name</th>
                                    <th width="70">Clinic Image Name</th>
                          			<th width="232">Doctor Name</th>
                                    <th width="306">Password</th>
                                    <th width="306">Doctor Id</th>
                                    <th width="232">Email Id</th>
                                    <th width="232">Father's Name</th>
                                    <th width="232">Gender</th>
                                    <th width="232">DOB</th>
                                    <th width="232">Phone/Landline</th>
                                    <th width="232">Mobile</th>
                                    <th width="232">Clinic Name</th>
                                     <th width="232">Designation</th>
                                    <th width="257">Qualification</th>
                                    <th width="257">Current Address</th>
                                    <th width="306">Permanent Address</th>
                                    <th width="306">Duration By year</th>
                                    <th width="306">Last Company Name</th>
                                    <th width="306">Holder's Name </th>
                                    <th width="306">IFSC Code</th>
                                    <th width="306">Bank Branch</th>
                                    <th width="306">Bank Name</th>
                                    <th width="306">Account No</th>
                                  </tr>
	</table>
    <?php } 	
	
	if($_GET['downlaod']=='tests_data_csv'){
	$file="Tests.xls";
	header('Content-Type: text/html');
	$table = $_POST['tablehidden'];//i get this from another php file.It is HTML table
	header("Content-type: application/x-msexcel"); //tried adding  charset='utf-8' into header
	header("Content-Disposition: attachment; filename=$file");
	echo $table;
	}
	if($_GET['downlaod']=='tests_data_csv'){?>
    <table width="100%" cellpadding="0" cellspacing="0" border="1px">
                            <tr>
                                    <th width="70">Test id</th>
                          			<th width="232">Test Name</th>
                                    <th width="306">Test Price</th>
                                    
                                  </tr>
								 
							    <?php
							$i=1; 
							$table_name=user_detail;
							//$details= getResponse::getDataByGlobalVar($table_name);
							//traceObject($details);
							$count = count($details);
							$Count=count($details);
							if($Count>0){ 
							foreach($details as $value){
 							?>
                            <tr>
                                    <th width="70">Emp id</th>
                          			<th width="232">Emp Name</th>
                                    <th width="306">Login Name</th>
                                    <th width="306">Employee No</th>
                                    <th width="232">Password</th>
                                    <th width="232">Email id</th>
                                    <th width="232">First name</th>
                                    <th width="232">Last name</th>
                                    <th width="232">doj</th>
                                    <th width="232">Father name/Husband Name</th>
                                    <th width="232">Gender</th>
                                     <th width="232">Dob</th>
                                    <th width="257">Phone no</th>
                                    <th width="257">Mobile no</th>
                                    <th width="306">Dep id</th>
                                    <th width="306">Current Address.</th>
                                    <th width="306">Permanent Address</th>
                                    <th width="306">Designation</th>
                                    <th width="306">Qualification</th>
                                  </tr>
                    		
                            <?php $i++;} }else{ ?>
                            <tr>
                           <td class="style1" align="center" colspan="13" >There Are No Records</td>
                           </tr>
                          <?php } ?>
                          </table>
							 
<?php } 

if($_GET['downlaod']=='leaving_csv'){
	$file="leaving_certif_detail.xls";
	header('Content-Type: text/html');
	$table = $_POST['tablehidden'];//i get this from another php file.It is HTML table
	header("Content-type: application/x-msexcel"); //tried adding  charset='utf-8' into header
	header("Content-Disposition: attachment; filename=$file");
	echo $table;
	}
	if($_GET['downlaod']=='leaving_csv'){?>
    <table width="100%" cellpadding="0" cellspacing="0" border="1px">
                             <tr>
                                    <th width="70">Emp id</th>
                          			<th width="232">Emp Name</th>
                                    <th width="306">Login Name</th>
                                    <th width="306">Employee No</th>
                                    <th width="232">Password</th>
                                    <th width="232">Email id</th>
                                    <th width="232">First name</th>
                                    <th width="232">Last name</th>
                                    <th width="232">doj</th>
                                    <th width="232">Father name/Husband Name</th>
                                    <th width="232">Gender</th>
                                     <th width="232">Dob</th>
                                    <th width="257">Phone no</th>
                                    <th width="257">Mobile no</th>
                                    <th width="306">Dep id</th>
                                    <th width="306">Current Address.</th>
                                    <th width="306">Permanent Address</th>
                                    <th width="306">Designation</th>
                                    <th width="306">Qualification</th>
                                  </tr>
	</table>
    <?php } 	
	if($_GET['downlaod']=='salary_fix_amount_csv'){
	$file="salary_fix_amount.xls";
	header('Content-Type: text/html');
	$table = $_POST['tablehidden'];//i get this from another php file.It is HTML table
	header("Content-type: application/x-msexcel"); //tried adding  charset='utf-8' into header
	header("Content-Disposition: attachment; filename=$file");
	echo $table;
	}
	if($_GET['downlaod']=='salary_fix_amount_csv'){?>
    <table width="100%" cellpadding="0" cellspacing="0" border="1px">
                            <tr>
                                    <th width="70">Emp id</th>
                          			<th width="232">Emp Name</th>
                                    <th width="306">Login Name</th>
                                    <th width="306">Employee No</th>
                                    <th width="232">Password</th>
                                    <th width="232">Email id</th>
                                    <th width="232">First name</th>
                                    <th width="232">Last name</th>
                                    <th width="232">doj</th>
                                    <th width="232">Father name/Husband Name</th>
                                    <th width="232">Gender</th>
                                     <th width="232">Dob</th>
                                    <th width="257">Phone no</th>
                                    <th width="257">Mobile no</th>
                                    <th width="306">Dep id</th>
                                    <th width="306">Current Address.</th>
                                    <th width="306">Permanent Address</th>
                                    <th width="306">Designation</th>
                                    <th width="306">Qualification</th>
                                  </tr>
								 
							<?php
							$i=1;
							$table_name=user_detail;
							$details= getResponse::getDataByGlobalVar($table_name);
							//traceObject($details);
							$count = count($details);
							$Count=count($details);
							if($Count>0){ 
							foreach($details as $value){
 							?>
                             <tr>
                                    <th width="70">Emp id</th>
                          			<th width="232">Emp Name</th>
                                    <th width="306">Login Name</th>
                                    <th width="306">Employee No</th>
                                    <th width="232">Password</th>
                                    <th width="232">Email id</th>
                                    <th width="232">First name</th>
                                    <th width="232">Last name</th>
                                    <th width="232">doj</th>
                                    <th width="232">Father name/Husband Name</th>
                                    <th width="232">Gender</th>
                                     <th width="232">Dob</th>
                                    <th width="257">Phone no</th>
                                    <th width="257">Mobile no</th>
                                    <th width="306">Dep id</th>
                                    <th width="306">Current Address.</th>
                                    <th width="306">Permanent Address</th>
                                    <th width="306">Designation</th>
                                    <th width="306">Qualification</th>
                                  </tr>
                    		
                            <?php $i++;} }else{ ?>
                            <tr>
                           <td class="style1" align="center" colspan="13" >There Are No Records</td>
                           </tr>
                          <?php } ?>
                          </table>
    <?php } 		
	if($_GET['downlaod']=='leave_assign_csv'){
	$file="leave_employee_details.xls";
	header('Content-Type: text/html');
	$table = $_POST['tablehidden'];//i get this from another php file.It is HTML table
	header("Content-type: application/x-msexcel"); //tried adding  charset='utf-8' into header
	header("Content-Disposition: attachment; filename=$file");
	echo $table;
	}
	if($_GET['downlaod']=='leave_assign_csv'){?>
    <table width="100%" cellpadding="0" cellspacing="0" border="1px">
                             <tr>
                                    <th width="70">Emp id</th>
                          			<th width="232">Emp Name</th>
                                    <th width="306">Login Name</th>
                                    <th width="306">Employee No</th>
                                    <th width="232">Password</th>
                                    <th width="232">Email id</th>
                                    <th width="232">First name</th>
                                    <th width="232">Last name</th>
                                    <th width="232">doj</th>
                                    <th width="232">Father name/Husband Name</th>
                                    <th width="232">Gender</th>
                                     <th width="232">Dob</th>
                                    <th width="257">Phone no</th>
                                    <th width="257">Mobile no</th>
                                    <th width="306">Dep id</th>
                                    <th width="306">Current Address.</th>
                                    <th width="306">Permanent Address</th>
                                    <th width="306">Designation</th>
                                    <th width="306">Qualification</th>
                                  </tr>
								 
							<?php
							$i=1;
							$table_name=user_detail;
							$details= getResponse::getDataByGlobalVar($table_name);
							//traceObject($details);
							$count = count($details);
							$Count=count($details);
							if($Count>0){ 
							foreach($details as $value){
 							?>
                             <tr>
                                    <th width="70">Emp id</th>
                          			<th width="232">Emp Name</th>
                                    <th width="306">Login Name</th>
                                    <th width="306">Employee No</th>
                                    <th width="232">Password</th>
                                    <th width="232">Email id</th>
                                    <th width="232">First name</th>
                                    <th width="232">Last name</th>
                                    <th width="232">doj</th>
                                    <th width="232">Father name/Husband Name</th>
                                    <th width="232">Gender</th>
                                     <th width="232">Dob</th>
                                    <th width="257">Phone no</th>
                                    <th width="257">Mobile no</th>
                                    <th width="306">Dep id</th>
                                    <th width="306">Current Address.</th>
                                    <th width="306">Permanent Address</th>
                                    <th width="306">Designation</th>
                                    <th width="306">Qualification</th>
                                  </tr>
                    		
                            <?php $i++;} }else{ ?>
                            <tr>
                           <td class="style1" align="center" colspan="13" >There Are No Records</td>
                           </tr>
                          <?php } ?>
                          </table>
    <?php }
	if($_GET['downlaod']=='class_csv'){
	$file="class.xls";
	header('Content-Type: text/html');
	$table = $_POST['tablehidden'];//i get this from another php file.It is HTML table
	header("Content-type: application/x-msexcel"); //tried adding  charset='utf-8' into header
	header("Content-Disposition: attachment; filename=$file");
	echo $table;
	}
	if($_GET['downlaod']=='class_csv'){?>
    <table width="100%" cellpadding="0" cellspacing="0" border="1px">
                             <tr>
                                    <th width="70">Emp id</th>
                          			<th width="232">Emp Name</th>
                                    <th width="306">Login Name</th>
                                    <th width="306">Employee No</th>
                                    <th width="232">Password</th>
                                    <th width="232">Email id</th>
                                    <th width="232">First name</th>
                                    <th width="232">Last name</th>
                                    <th width="232">doj</th>
                                    <th width="232">Father name/Husband Name</th>
                                    <th width="232">Gender</th>
                                     <th width="232">Dob</th>
                                    <th width="257">Phone no</th>
                                    <th width="257">Mobile no</th>
                                    <th width="306">Dep id</th>
                                    <th width="306">Current Address.</th>
                                    <th width="306">Permanent Address</th>
                                    <th width="306">Designation</th>
                                    <th width="306">Qualification</th>
                                  </tr>
								
                           
                          </table>
							 
<?php } 
	if($_GET['downlaod']=='section_csv'){
	$file="section.xls";
	header('Content-Type: text/html');
	$table = $_POST['tablehidden'];//i get this from another php file.It is HTML table
	header("Content-type: application/x-msexcel"); //tried adding  charset='utf-8' into header
	header("Content-Disposition: attachment; filename=$file");
	echo $table;
	}
	if($_GET['downlaod']=='section_csv'){?>
    <table width="100%" cellpadding="0" cellspacing="0" border="1px">
                             <tr>
                                    <th width="70">Emp id</th>
                          			<th width="232">Emp Name</th>
                                    <th width="306">Login Name</th>
                                    <th width="306">Employee No</th>
                                    <th width="232">Password</th>
                                    <th width="232">Email id</th>
                                    <th width="232">First name</th>
                                    <th width="232">Last name</th>
                                    <th width="232">doj</th>
                                    <th width="232">Father name/Husband Name</th>
                                    <th width="232">Gender</th>
                                     <th width="232">Dob</th>
                                    <th width="257">Phone no</th>
                                    <th width="257">Mobile no</th>
                                    <th width="306">Dep id</th>
                                    <th width="306">Current Address.</th>
                                    <th width="306">Permanent Address</th>
                                    <th width="306">Designation</th>
                                    <th width="306">Qualification</th>
                                  </tr>
                          </table>
							 
<?php }
	if($_GET['downlaod']=='transport_category_csv'){
	$file="transport_category.xls";
	header('Content-Type: text/html');
	$table = $_POST['tablehidden'];//i get this from another php file.It is HTML table
	header("Content-type: application/x-msexcel"); //tried adding  charset='utf-8' into header
	header("Content-Disposition: attachment; filename=$file");
	echo $table;
	}
	if($_GET['downlaod']=='transport_category_csv'){?>
    <table width="100%" cellpadding="0" cellspacing="0" border="1px">
                            <tr>
                                    <th width="70">Emp id</th>
                          			<th width="232">Emp Name</th>
                                    <th width="306">Login Name</th>
                                    <th width="306">Employee No</th>
                                    <th width="232">Password</th>
                                    <th width="232">Email id</th>
                                    <th width="232">First name</th>
                                    <th width="232">Last name</th>
                                    <th width="232">doj</th>
                                    <th width="232">Father name/Husband Name</th>
                                    <th width="232">Gender</th>
                                     <th width="232">Dob</th>
                                    <th width="257">Phone no</th>
                                    <th width="257">Mobile no</th>
                                    <th width="306">Dep id</th>
                                    <th width="306">Current Address.</th>
                                    <th width="306">Permanent Address</th>
                                    <th width="306">Designation</th>
                                    <th width="306">Qualification</th>
                                  </tr>
                          </table>
							 
<?php }
	if($_GET['downlaod']=='department_details'){
	$file="department_details.xls";
	header('Content-Type: text/html');
	$table = $_POST['tablehidden'];//i get this from another php file.It is HTML table
	header("Content-type: application/x-msexcel"); //tried adding  charset='utf-8' into header
	header("Content-Disposition: attachment; filename=$file");
	echo $table;
	}
	if($_GET['downlaod']=='department_details'){?>
    <table width="100%" cellpadding="0" cellspacing="0" border="1px">
                             <tr>
                                    <th width="70">Emp id</th>
                          			<th width="232">Emp Name</th>
                                    <th width="306">Login Name</th>
                                    <th width="306">Employee No</th>
                                    <th width="232">Password</th>
                                    <th width="232">Email id</th>
                                    <th width="232">First name</th>
                                    <th width="232">Last name</th>
                                    <th width="232">doj</th>
                                    <th width="232">Father name/Husband Name</th>
                                    <th width="232">Gender</th>
                                     <th width="232">Dob</th>
                                    <th width="257">Phone no</th>
                                    <th width="257">Mobile no</th>
                                    <th width="306">Dep id</th>
                                    <th width="306">Current Address.</th>
                                    <th width="306">Permanent Address</th>
                                    <th width="306">Designation</th>
                                    <th width="306">Qualification</th>
                                  </tr>
                          </table>
							 
<?php } if($_GET['downlaod']=='library_csv'){
	$file="library_csv.xls";
	header('Content-Type: text/html');
	$table = $_POST['tablehidden'];//i get this from another php file.It is HTML table
	header("Content-type: application/x-msexcel"); //tried adding  charset='utf-8' into header
	header("Content-Disposition: attachment; filename=$file");
	echo $table;
	}
	if($_GET['downlaod']=='library_csv'){?>
    <table width="100%" cellpadding="0" cellspacing="0" border="1px">
                            <tr>
                                    <th width="70">Emp id</th>
                          			<th width="232">Emp Name</th>
                                    <th width="306">Login Name</th>
                                    <th width="306">Employee No</th>
                                    <th width="232">Password</th>
                                    <th width="232">Email id</th>
                                    <th width="232">First name</th>
                                    <th width="232">Last name</th>
                                    <th width="232">doj</th>
                                    <th width="232">Father name/Husband Name</th>
                                    <th width="232">Gender</th>
                                     <th width="232">Dob</th>
                                    <th width="257">Phone no</th>
                                    <th width="257">Mobile no</th>
                                    <th width="306">Dep id</th>
                                    <th width="306">Current Address.</th>
                                    <th width="306">Permanent Address</th>
                                    <th width="306">Designation</th>
                                    <th width="306">Qualification</th>
                                  </tr>
	</table>
							 
<?php } ?>
	
	
	