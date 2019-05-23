<!DOCTYPE html>
<html>

<?php $path = "../";
include($path."include/config_header_top.php");
include 'css.php';
$page_key ='3_1';
$sql     = " SELECT *
FROM tb_attribute
where attrID ='".$attrID."' ";

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
							<h2><?php echo $txt;?>ข้อมูลคุณลักษณะ</h2>
						</div>
						<form id="frm-input" method="post" enctype="multipart/form-data" action="process/attribute_process.php" >
							<input type="hidden" id="proc" name="proc" value="<?php echo $proc;?>">
							<input type="hidden" id="attrID" name="attrID" value="<?php echo $attrID;?>">
							<input type="hidden" id="form_page" name="form_page" value="<?php echo  $form_page?>">
							<input type="hidden" id="chk" name="chk" value="0">
							<div class="body">
								<div class="row clearfix">
									<div class="col-sm-12 align-right"><b><span style="color:red">* กรอกข้อมูลให้ครบทุกช่อง</span></b></div>
								</div>
								<div class="row clearfix">
									<div class="col-sm-6">
										<b>ชื่อคุณลักษณะ</b>
										<div class="form-group">
											<div class="form-line">
												<input type="text " onkeyup="chk1();" name="attrName" id="attrName" class="form-control" placeholder="คุณลักษณะ" value="<?php echo $rec['attrName'];?>" <?php echo $_SESSION["userType"] == "2" ? $readonly : '';?>>
											</div>
											<label id="attrName-error" class="error" for="attrName">กรุณาระบุ คุณลักษณะ</label>
											<label id="attrName2-error" class="error" for="attrName">มีคุณลักษณะนี้แล้ว</label>
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

			if($('#attrName').val()==''){
				$('#attrName-error').show();
				$('#attrName').focus();
				return false;
			}else{
				$('#attrName-error').hide();
			}

			if($('#chk').val()==1){
				return false;
			}

			if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
				$("#frm-input").submit();
			}
		}

		$(document).ready(function() {
			$('.form-line').removeClass('focused');
			$('.error').hide();
		});

		function chk1(){
			var attrName= $('#attrName').val();
			var attrID= $('#attrID').val();
			$.ajaxSetup({async: false});
			$.post('process/get_process.php',{proc:'chk_attrName',attrName:attrName,attrID:attrID},function(data){
				$('.error').hide();
				if(data==1){
					$('#attrName2-error').show();
					$('#chk').val(1);
				}else{
					$('#attrName2-error').hide();
					$('#chk').val(0);

				}

			},'json');
		}

		function delData(parent_id,id,hdf_id){
			var attrID = $('#attrID').val();
			$.ajaxSetup({async: false});
			$.post('process/get_process.php',{proc:'chkDelData_Brand',attrID:attrID},function(data){
				if(data > 0){
					alert('ไม่สามารถยกเลิกข้อมูลได้ เนื่องจากคุณลักษณะนี้มีการใช้ข้อมูลนี้อยู่');
					$('#'+parent_id).val(1);
					return false;
				}else{
					$('#'+hdf_id).val(id);
				}
			},'json');

		}

//username2
</script>
