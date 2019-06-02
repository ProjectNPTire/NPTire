<!DOCTYPE html>
<html>

<?php
$path = "../";
include($path."include/config_header_top.php");
include 'css.php';
$page_key ='3_5';
$form_page = $form_page;

$sql     = " SELECT *
FROM tb_location
where locationID ='".$locationID."' ";

$query = $db->query($sql);
$nums = $db->db_num_rows($query);
$rec = $db->db_fetch_array($query);
$proc = ($proc=='')?"add":$proc;
$txt =  ($proc=='add')?"เพิ่ม":"แก้ไข";
if($proc=='edit'){
	$readonly = "readonly";
}

?>

<body class="theme-red">
	<?php include 'MasterPage.php';?>

	<section class="content">
		<div class="container-fluid">
			<div class="row clearfix">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="card">
						<div class="header">
							<h2><?php echo $txt;?>ข้อมูลประเภทตำแหน่งจัดเก็บสินค้า</h2>
						</div>
						<div class="body">
							<form id="frm-input" action="process/location_process.php" method="POST">
								<input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
								<input type="hidden" id="form_page" name="form_page" value="<?php echo  $form_page; ?>">
								<input type="hidden" id="locationID" name="locationID" value="<?php echo $locationID; ?>">
								<input type="hidden" id="chk2" name="chk2" value="0">
								<input type="hidden" id="chk3" name="chk3" value="0">
                                <input type="hidden" id="chk1" name="chk1" value="0">
								<div class="row clearfix">
									<div class="col-sm-12 align-right"><b><span style="color:red">* กรอกข้อมูลให้ครบทุกช่อง</span></b>
									</div>
								</div>
								<!--<div class="form-group">
									<b>รหัสตำแหน่งจัดเก็บสินค้า <span style="color:red"> *</span></b>
									<div class="form-line">
										<input type="text" id="locationID" name="locationID" class="form-control" placeholder="รหัสตำแหน่งจัดเก็บสินค้า" value="<?php echo $rec["locationID"]; ?>">
									</div>
									<label id="locationID_error" class="error" for="locationID">กรุณาระบุ</label>
								</div>-->
								<div class="row clearfix">
									<div class="col-sm-6">
										<b>รหัสตำแหน่งจัดเก็บ</b>
										<div class="form-group">
											<div class="form-line">
												<input type="text" name="locationCode" id="locationCode" class="form-control" placeholder="รหัสตำแหน่งจัดเก็บ" value="<?php echo $rec['locationCode'];?>" <?php echo $readonly;?>>
											</div>
											<div class="help-info">กรอกอัตโนมัติ</div>
											<label id="locationCode-error" class="error" for="locationCode">มีรหัสตำแหน่งจัดเก็บนี้แล้ว</label>
										</div>
									</div>
									<div class="col-sm-6">
										<b>ชื่อตำแหน่งจัดเก็บสินค้า</b>
										<div class="form-group">
											<div class="form-line">
												<input type="text" onkeyup="chkName();" id="locationName" name="locationName" class="form-control" placeholder="ชื่อตำแหน่งจัดเก็บสินค้า" value="<?php echo $rec["locationName"]; ?>" <?php echo $_SESSION["userType"] == "2" ? $readonly : '';?>>
											</div>
											<label id="locationName-error" class="error" for="locationName">กรุณาระบุ ชื่อตำแหน่งจัดเก็บสินค้า</label>
											<label id="locationName-error2" class="error" for="locationName">มีชื่อตำแหน่งจัดเก็บสินค้านี้แล้ว</label>
										</div>
									</div> 			
								</div>
								<div class="row clearfix">
									<div class="col-sm-6">
										<b>ชื่อประเภทตำแหน่งจัดเก็บ</b>
										<div class="form-group form-float">
											<select name="locationTypeID" id="locationTypeID" class="form-control show-tick" data-live-search="true" <?php echo $_SESSION["userType"] == "2"  ? 'disabled' : '';?> onchange="get_hdflocationType(this.value,'hdflocationTypeID');">
												<option value="">เลือก</option>a                 
												<?php
												$s_pdtype=" SELECT * from tb_locationtype order by locationTypeID asc";
												$q_pdtype = $db->query($s_pdtype);
												$n_pdtype = $db->db_num_rows($q_pdtype);
												while($r_pdtype = $db->db_fetch_array($q_pdtype)){
													?>
													<option value="<?php echo $r_pdtype['locationTypeID'];?>" <?php echo ($rec['locationTypeID']==$r_pdtype['locationTypeID'])?"selected":"";?>> <?php echo $r_pdtype['locationTypeName'];?></option>

												<?php }  ?>
											</select>
											<input type="hidden" name="hdflocationTypeID" id="hdflocationTypeID" value="<?php echo $rec['locationTypeID'] ?>">
											<label id="locationTypeID-error" class="error" for="locationTypeID">กรุณาเลือก ประเภทตำแหน่งจัดเก็บ</label>
										</div>
									</div>		
									<div class="col-sm-6">
										<b>การใช้งานข้อมูล</b>
										<div class="form-group form-float">
											<select name="status" id="status" class="form-control show-tick" data-live-search="true" <?php echo $_SESSION["userType"] == "2"  ? 'disabled' : '';?> onchange="delData('status',this.value,'hdfstatus');">
												<?php asort($arr_active);
												foreach ($arr_active as $key => $value) {?>
													<option value="<?php echo $key;?>"  
														<?php 
														if(($rec['isEnabled']  != "")){
															echo ($rec['isEnabled']==$key)?"selected":"";
														}
														?>><?php echo $value;?></option>
													<?php }  ?>
												</select>
												<input type="hidden" name="hdfstatus" id="hdfstatus" value="<?php echo $proc == "edit"  ? $rec['isEnabled'] : '1';?>">
											</div>
										</div>
									</div>				
									<div class="align-center">
										<button class="btn btn-success waves-effect" type="button" onclick="chkinput();">บันทึก</button>
										<button class="btn btn-default waves-effect" type="button" onclick="OnCancel();">ยกเลิก</button>
									</div>
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
			$('.form-line').removeClass('focused');
			$('.error').hide();

			if($('#proc').val()=='add'){	
				var newcode ='';
				$.ajaxSetup({async: false});
				$.post('process/get_process.php',{proc:'get_locationCode'},function(data){
					newcode =  data['name'];
				},'json');
				$('#locationCode').val(newcode);		
			}
		});

		function OnCancel(){
			$(location).attr('href',"<?php echo  $form_page?>");
		}

		function chkinput(){

			if($('#proc').val()=='edit'){
				var locationID= $('#locationID').val();
				$.ajaxSetup({async: false});
				$.post('process/get_process.php',{proc:'chk_editlocation',locationID:locationID},function(data){
					if(data > 0){
						alert('ไม่สามารถแก้ไขข้อมูลได้ เนื่องจากตำแหน่งเก็บนี้มีการใช้ข้อมูลนี้อยู่');
						$('#chk1').val(1);
						return false;
					}else{
						$('#chk1').val(0);
					}
				},'json');		
			}

			if($('#chk1').val()==1){
				return false;
			}

			if($('#chk3').val()==1){
				$('#locationCode-error').show();
				$('#locationCode').focus();
				return false;
			}else{
				$('#locationCode-error').hide();
			}

			if($('#locationName').val()==''){
				$('#locationName-error').show();
				$('#locationName').focus();
				return false;
			}else{
				$('#locationName-error').hide();
			}

			if($('#chk2').val()==1){
				$('#locationName-error2').show();
				$('#locationName').focus();
				return false;
			}else{
				$('#locationName-error2').hide();
			}

			if($('#locationTypeID').val()==''){
				$('#locationTypeID-error').show();
				$('#locationTypeID').focus();
				return false;
			}else{
				$('#locationTypeID-error').hide();
			}

			if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
				$("#frm-input").submit();
			}
		}

		function chkName(id){
			var locationName= $('#locationName').val();
			var locationID= $('#locationID').val();
			$.ajaxSetup({async: false});
			$.post('process/get_process.php',{proc:'chk_LocationName',locationName:locationName,locationID:locationID},function(data){
				$('.error').hide();
			//alert(data);
			if(data==1){
				$('#locationName-error2').show();
				$('#chk2').val(1);
			}else{
				$('#locationName-error2').hide();
				$('#chk2').val(0);

			}

		},'json');
		}

		function chkCode(){
			var locationCode= $('#locationCode').val();
			var locationID= $('#locationID').val();
			$.ajaxSetup({async: false});
			$.post('process/get_process.php',{proc:'chk_locationCode',locationCode:locationCode,locationID:locationID},function(data){
				$('.error').hide();
				if(data==1){
					$('#locationCode-error').show();
					$('#chk3').val(1);
				}else{
					$('#locationCode-error').hide();
					$('#chk3').val(0);

				}

			},'json');
		}

		function delData(parent_id,id,hdf_id){
			var locationID = $('#locationID').val();
			$.ajaxSetup({async: false});
			$.post('process/get_process.php',{proc:'chkDelData_Location',locationID:locationID},function(data){
				if(data > 0){
					alert('ไม่สามารถยกเลิกข้อมูลได้ เนื่องจากมีการใช้ข้อมูลตำแหน่งจัดเก็บนี้อยู่');
					$('#'+parent_id).val(1);
					return false;
				}else{
					$('#'+hdf_id).val(id);
				}
			},'json');

		}
		function get_hdflocationType(id,hdf_id){
			var locationTypeID = id;
			if (locationTypeID != "") {
				$('#'+hdf_id).val(locationTypeID);
			}
		}
	</script>