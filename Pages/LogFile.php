<!DOCTYPE html>
<html>

<?php
$path = "../";
include($path."include/config_header_top.php");
include 'css.php';
$page_key ='99999';

$filter = '';
if($s_userID){
	$filter .= " and userID ='".$s_userID."'";
}
if($birthday){
	$filter .= " and log_dt like '%".conv_date_db($birthday)."%'";
}

$field = "* ";
$table = "tb_logfiles";
$pk_id = "logID";
$wh = "1=1  {$filter}";
$orderby = "order by logID DESC";
// $limit =" LIMIT ".$goto ." , ".$page_size ;
$sql = "select ".$field." from ".$table." where ".$wh ." ".$orderby;

$query = $db->query($sql);
$nums = $db->db_num_rows($query);
$total_record = $db->db_num_rows($db->query("select ".$field." from ".$table." where ".$wh));


?>

<body class="theme-red">
	<?php include 'MasterPage.php';?>
	<section class="content">
		<div class="container-fluid">
			<div class="row clearfix">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="card">
						<div class="header">
							<h2>
								ข้อมูลเข้าใช้ระบบ
							</h2>
						</div>
						<div class="body table-responsive">
							<form id="frm-search" method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
								<input type="hidden" id="proc" name="proc" value="">
								<input type="hidden" id="form_page" name="form_page" value="ProductTypeList.php">
								<input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size;?>">
								<input type="hidden" id="page" name="page" value="<?php echo $page;?>">

								<div class="row clearfix">
									<div class="col-sm-5">
										<div class="form-group">
											<b>ผู้ใช้งาน</b>
											<div class="form-group form-float">
												<select name="s_userID" id="s_userID" class="form-control show-tick" data-live-search="true"  >
													<option value="">เลือก</option>
													<?php
													$s_p=" SELECT * from tb_user order by firstname asc";
													$q_p = $db->query($s_p);
													$n_p = $db->db_num_rows($q_p);
													while($r_p = $db->db_fetch_array($q_p)){?>
														<option value="<?php echo $r_p['userID'];?>"<?php echo ($s_userID==$r_p['userID'])?"selected":"";?>> <?php echo $r_p['firstname'].' '.$r_p['lastname'];?></option>

													<?php }  ?>
												</select>
											</div>
										</div>
									</div>
									<div class="col-md-5">
										<div class="form-group">
											<b>วันที่</b>
											<div class="form-line">
												<input type="text" class="form-control datepicker" name="birthday" id="birthday" value="<?php echo $birthday;?>">
											</div>
										</div>
									</div>
									<div class="col-md-2">
										<div class="icon-and-text-button-demo align-center">
											<button  class="btn btn-success waves-effect" onClick="searchData();"><span>ค้นหา</span><?php echo $img_view;?></button>
										</div>
									</div> 
								</div> 

								
								<div class="row"><?php //echo ($nums>0) ? startPaging("frm-search",$total_record):""; ?></div>
								<table width="100%" id="table1" class="table table-bordered table-striped table-hover  dataTable">
									<thead>
										<tr>
											<th  width="10%">ลำดับ</th>
											<th  width="30%">ชื่อ</th>
											<th  width="40%">รายการ</th>
											<th style="text-align: center;" width="30%">วันที่</th>
										</tr>
									</thead>

									<?php
									if($nums>0){
										$i=0;
										while ($rec = $db->db_fetch_array($query)) {
											$i++;

										//  $info = ' <a class="btn btn-info btn-xs waves-effect" onClick="infoData('.$rec['userID'].');">'.$img_info.'</a>';  //  data-toggle="modal" data-target="#largeModal" id="btn_info" data-toggle="tooltip" data-placement="top" title="ข้อมูล"
											?>
											<tr>
												<td style="text-align: center;"><?php echo $i+$goto;?></td>
												<td><?php echo get_user_name($rec['userID']);?></td>
												<td><?php echo $rec['detail'];?></td>
												<td><?php echo conv_date($rec['log_dt'],'',1);?></td>
											</tr>
										<?php }
									}else{
										echo '<tr><td colspan="5">ไม่พบข้อมูล</td></tr>';
									}
									?>
								</tbody>
							</table>
							<!-- <?php echo ($nums > 0) ? endPaging("frm-search", $total_record) : ""; ?> -->
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php include 'js.php';?>
</body>

</html>
<script>
	$(document).ready(function() {
		$("#table1").DataTable({
			"ordering": false,
     		"searching": false,
		})
	});
</script>
