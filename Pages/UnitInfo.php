<!DOCTYPE html>
<html>

<?php $path = "../";
include($path."include/config_header_top.php");
include 'css.php';
$page_key ='3_1';
$sql     = " SELECT *
FROM tb_unit
where unitID ='".$unitID."' ";

$query = $db->query($sql);
$nums = $db->db_num_rows($query);
$rec = $db->db_fetch_array($query);
$proc = ($proc=='')?"add":$proc;
$txt =  ($proc=='add')?"เพิ่ม":"แก้ไข";
$readonly = "readonly";

?>

<body class="theme-red">
	<?php include 'MasterPage.php';?>

	<section class="content">
		<div class="container-fluid">
			<div class="row clearfix">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="card">
						<div class="header">
							<h2><?php echo $txt;?>ข้อมูลหน่วยสินค้า</h2>
						</div>
						<form id="frm-input" method="post" enctype="multipart/form-data" action="process/unit_process.php" >
							<input type="hidden" id="proc" name="proc" value="<?php echo $proc;?>">
							<input type="hidden" id="unitID" name="unitID" value="<?php echo $unitID;?>">
							<input type="hidden" id="form_page" name="form_page" value="<?php echo  $form_page?>">
							<input type="hidden" id="chk" name="chk" value="0">
							<input type="hidden" id="chk2" name="chk2" value="0">
							<input type="hidden" id="chk3" name="chk3" value="0">
							<input type="hidden" id="chk1" name="chk1" value="0">
							<div class="body">
								<div class="row clearfix">
									<div class="col-sm-12 align-right"><b><span style="color:red">* กรอกข้อมูลให้ครบทุกช่อง</span></b>
									</div>
								</div>
								<div class="row clearfix">
									<div class="col-sm-4">
										<b>รหัสหน่วยสินค้า</b>
										<div class="form-group">
											<div class="form-line">
												<input type="text" name="unitCode" id="unitCode" class="form-control" placeholder="รหัสหน่วยสินค้า" value="<?php echo $rec['unitCode'];?>"<?php echo $readonly;?>>
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<b>ชื่อหน่วยสินค้า</b>
										<div class="form-group">
											<div class="form-line">
												<input type="text " onkeyup="chkName();" onchange="chkEdit();" name="unitName" id="unitName" class="form-control" placeholder="ชื่อหน่วยสินค้า" value="<?php echo $rec['unitName'];?>"<?php echo $_SESSION["userType"] == "2" ? $readonly : '';?>>
											</div>
											<label id="unitName-error" class="error" for="unitName">กรุณาระบุ ชื่อหน่วยสินค้า</label>
											<label id="unitName2-error" class="error" for="unitName">มีชื่อหน่วยสินค้านี้แล้ว</label>
										</div>
									</div>
									<div class="col-sm-4">
										<b>การใช้งานข้อมูล</b>
										<div class="form-group form-float">
											<select name="status" id="status" class="form-control show-tick" data-live-search="true" <?php echo $_SESSION["userType"] == "2"  ? 'disabled' : '';?> onchange="delData(this.value,'hdfstatus');">
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
										<button type="button" class="btn btn-success waves-effect" onclick="chkinput();">บันทึก</button>
										<button type="button" class="btn btn-warning waves-effect" onclick="OnCancel();">ยกเลิก</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</section>
		<?php include 'js.php';?>
	</body>

	</html>

	<script>
		function OnCancel()
		{

			$(location).attr('href',"<?php echo  $form_page?>");
		}

		function chkinput(){

			if($('#proc').val()=='edit'){
				var unitID = $('#unitID').val();
				$.ajaxSetup({async: false});
				$.post('process/get_process.php',{proc:'chk_editunit',unitID:unitID},function(data){
					if(data > 0){
						alert('ไม่สามารถแก้ไขข้อมูลได้ เนื่องจากหน่วยสินค้านี้มีการใช้ข้อมูลนี้อยู่');
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

			if($('#unitCode').val()==''){
				$('#unitCode-error').show();
				$('#unitCode').focus();
				return false;
			}else{
				$('#unitCode-error').hide();
			}

			if($('#chk').val()==1){
				$('#unitCode-error').show();
				$('#unitCode').focus();
				return false;
			}else{
				$('#unitCode-error').hide();
			}



			if($('#chk2').val()==1){
				$('#unitName2-error').show();
				$('#unitName').focus();
				return false;
			}else{
				$('#unitName2-error').hide();
			}

			if($('#unitName').val()==''){
				$('#unitName-error').show();
				$('#unitName').focus();
				return false;
			}else{
				$('#unitName-error').hide();
			}

			if($('#chk3').val()==1){
				return false;
			}

			if($('#rowid').val() == 0){
				
				$('#tb_data_attr-error').show();
				return false;
			}else{
				$('#tb_data_attr-error').hide();
			}


			if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
				$("#frm-input").submit();
			}
		}

		$(document).ready(function() {
			$('.form-line').removeClass('focused');
			$('.error').hide();
			$(".numb").inputFilter(function(value) {
				return /^\d*$/.test(value);
			});

			if($('#proc').val()=='add'){
				var unitCode ='';
				$.ajaxSetup({async: false});
				$.post('process/get_process.php',{proc:'get_unitCode'},function(data){
					unitCode =  data['name'];
				},'json');
				$('#unitCode').val(unitCode);
			}

		});

		function popup(){
			$('#ModalAttribute').modal('show');
			get_search();
		}

		function chkName(){
			var unitName= $('#unitName').val();
			var unitID= $('#unitID').val();
			$.ajaxSetup({async: false});
			$.post('process/get_process.php',{proc:'chk_unitName',unitName:unitName,unitID:unitID},function(data){
				$('.error').hide();
				if(data==1){
					$('#unitName2-error').show();
					$('#chk2').val(1);
				}else{
					$('#unitName2-error').hide();
					$('#chk2').val(0);

				}

			},'json');
		}

		function chkCode(){

			var unitCode= $('#unitCode').val();
			var unitID= $('#unitID').val();
			$.ajaxSetup({async: false});
			$.post('process/get_process.php',{proc:'chk_unitCode',unitCode:unitCode,unitID:unitID},function(data){
				$('.error').hide();
				if(data==1){
					$('#unitCode2-error').show();
					$('#chk').val(1);
				}else{
					$('#unitCode2-error').hide();
					$('#chk').val(0);

				}

			},'json');
		}
		function delData(id,hdf_id){
	// var unitID = $('#unitID').val();
	// $.ajaxSetup({async: false});
	// $.post('process/get_process.php',{proc:'chkDelData_Unit',unitID:unitID},function(data){
	// 	if(data > 0){
	// 		alert('ไม่สามารถยกเลิกข้อมูลได้ เนื่องจากหน่วยสินค้านี้มีการใช้ข้อมูลนี้อยู่');
	// 		$('#status').val(1);
	// 		$('#chk3').val(1);
	// 		return false;
	// 	}else{
	// 		$('#'+hdf_id).val(id);
	// 		$('#chk3').val(0);
	// 	}
	// },'json');
	
	$('#'+hdf_id).val(id);

}
//username2
</script>
