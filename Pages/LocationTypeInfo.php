<!DOCTYPE html>
<html>

<?php
$path = "../";
include($path."include/config_header_top.php");
include 'css.php';
$page_key ='3_4';
$form_page = $form_page;

$sql     = " SELECT *
FROM tb_locationtype
where locationTypeID ='".$locationTypeID."' ";

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
							<form id="frm-input" action="process/locationtype_process.php" method="POST">
								<input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
								<input type="hidden" id="form_page" name="form_page" value="<?php echo  $form_page; ?>">
								<input type="hidden" id="locationTypeID" name="locationTypeID" value="<?php echo $locationTypeID; ?>">
								<input type="hidden" id="chk2" name="chk2" value="0">
								<input type="hidden" id="chk3" name="chk3" value="0">
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
										<b>รหัสประเภทตำแหน่งจัดเก็บ</b>
										<div class="form-group">
											<div class="form-line">
												<input type="text" readonly oninput="this.value=this.value.replace(/\s/g, '');" onchange="chkCode();" name="locationTypeCode" id="locationTypeCode" class="form-control" placeholder="รหัสประเภทตำแหน่งจัดเก็บ" value="<?php echo $rec['locationTypeCode'];?>" <?php echo $readonly;?>>
											</div>
											<div class="help-info">กรอกอัตโนมัติ</div>
											<label id="locationTypeCode-error" class="error" for="locationTypeCode">รหัสประเภทตำแหน่งจัดเก็บ</label>
										</div>
									</div>
									<div class="col-sm-6">
										<b>ชื่อประเภทตำแหน่งจัดเก็บสินค้า</b>
										<div class="form-group">
											<div class="form-line">
												<input type="text" onchange="chkName();" id="locationTypeName" name="locationTypeName" class="form-control" placeholder="ชื่อประเภทตำแหน่งจัดเก็บสินค้า" value="<?php echo $rec["locationTypeName"]; ?>" <?php echo $_SESSION["userType"] == "2" ? $readonly : '';?>>
											</div>
											<label id="locationTypeName-error" class="error" for="locationTypeName">กรุณาระบุ ชื่อประเภทตำแหน่งจัดเก็บสินค้า</label>
											<label id="locationTypeName-error2" class="error" for="locationTypeName">ชื่อประเภทตำแหน่งจัดเก็บสินค้า</label>
										</div>
									</div>	
								</div>
								<div class="row clearfix"><!-- 
									<div class="col-sm-4">
										<b>จำนวนพื้นที่/ยูนิต</b>
										<div class="form-group">
											<div class="form-line">
												<input type="text" id="area" name="area" class="form-control numb" placeholder="จำนวนพื้นที่/ยูนิต" value="<?php echo $rec["area"]; ?>" <?php echo $_SESSION["userType"] == "2" ? $readonly : '';?>>
											</div>
											<label id="area-error" class="error" for="area">กรุณาระบุ จำนวนพื้นที่</label>
										</div>
									</div> -->	
									<div class="col-sm-6">
										<b>ประเภทตำแหน่งจัดเก็บ</b>
										<div class="form-group form-float">
											<select name="locationType" id="locationType" class="form-control show-tick" data-live-search="true" <?php echo $_SESSION["userType"] == "2"  ? 'disabled' : '';?> onchange="gen_code(this.value,'hdflocationType');">                   
												<option value="">เลือก</option>
												<?php   foreach ($arr_locationType as $key => $value) {?>
													<option value="<?php echo $key;?>"  <?php echo ($rec['locationType']==$key)?"selected":"";?>> <?php echo $value;?></option>
												<?php }  ?>
											</select>
											<input type="hidden" name="hdflocationType" id="hdflocationType" value="<?php echo $rec['locationType'] ?>">
											<label id="locationType-error" class="error" for="locationType">กรุณาเลือก ประเภทตำแหน่งจัดเก็บ</label>
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
			$(".numb").inputFilter(function(value) {
				return /^\d*$/.test(value); });
		});

		function OnCancel(){
			$(location).attr('href',"<?php echo  $form_page?>");
		}

		function chkinput(){

			// if($('#proc').val()=='edit'){
			// 	var locationTypeID= $('#locationTypeID').val();
			// 	$.ajaxSetup({async: false});
			// 	$.post('process/get_process.php',{proc:'chk_editlocationType',locationTypeID:locationTypeID},function(data){
			// 		if(data > 0){
			// 			alert('ไม่สามารถแก้ไขข้อมูลได้ เนื่องจากประเภทตำแหน่งเก็บนี้มีการใช้ข้อมูลนี้อยู่');
			// 			return false;
			// 		}
			// 	},'json');		
			// }

			if($('#chk3').val()==1){
				$('#locationTypeCode-error').show();
				$('#locationTypeCode').focus();
				return false;
			}else{
				$('#locationTypeCode-error').hide();
			}

			if($('#locationTypeName').val()==''){
				$('#locationTypeName-error').show();
				$('#locationTypeName').focus();
				return false;
			}else{
				$('#locationTypeName-error').hide();
			}

			if($('#chk2').val()==1){
				$('#locationTypeName-error2').show();
				$('#locationTypeName').focus();
				return false;
			}else{
				$('#locationTypeName-error2').hide();
			}

			if($('#locationType').val()==''){
				$('#locationType-error').show();
				$('#locationType').focus();
				return false;
			}else{
				$('#locationType-error').hide();
			}

			if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
				$("#frm-input").submit();
			}
		}

		function chkName(id){
			var locationTypeName= $('#locationTypeName').val();
			var locationTypeID= $('#locationTypeID').val();
			$.ajaxSetup({async: false});
			$.post('process/get_process.php',{proc:'chk_LocationTypeName',locationTypeName:locationTypeName,locationTypeID:locationTypeID},function(data){
				$('.error').hide();
			//alert(data);
			if(data==1){
				$('#locationTypeName-error2').show();
				$('#chk2').val(1);
			}else{
				$('#locationTypeName-error2').hide();
				$('#chk2').val(0);

			}

		},'json');
		}

		function chkCode(){
			var locationTypeCode= $('#locationTypeCode').val();
			var locationTypeID= $('#locationTypeID').val();
			$.ajaxSetup({async: false});
			$.post('process/get_process.php',{proc:'chk_locationTypeCode',locationTypeCode:locationTypeCode,locationTypeID:locationTypeID},function(data){
				$('.error').hide();
				if(data==1){
					$('#locationTypeCode-error').show();
					$('#chk3').val(1);
				}else{
					$('#locationTypeCode-error').hide();
					$('#chk3').val(0);

				}

			},'json');
		}

		function delData(parent_id,id,hdf_id){
			var locationTypeID = $('#locationTypeID').val();
			$.ajaxSetup({async: false});
			$.post('process/get_process.php',{proc:'chkDelData_LocationType',locationTypeID:locationTypeID},function(data){
				if(data > 0){
					alert('ไม่สามารถยกเลิกข้อมูลได้ เนื่องจากมีการใช้ข้อมูลประเภทตำแหน่งจัดเก็บนี้อยู่');
					$('#'+parent_id).val(1);
					return false;
				}else{
					$('#'+hdf_id).val(id);
				}
			},'json');

		}
		function gen_code(id,hdf_id){
			var locationType = id;
			var newcode ='';
			if (locationType != "") {
				$('#'+hdf_id).val(locationType);
				
				$.ajaxSetup({async: false});
				$.post('process/get_process.php',{proc:'get_locationTypeCode',locationType:locationType},function(data){
					newcode =  data['name'];
				},'json');
			}
			$('#locationTypeCode').val(newcode);
		}
	</script>
