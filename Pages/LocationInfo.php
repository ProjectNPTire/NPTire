<!DOCTYPE html>
<html>

<?php
$path = "../";
include($path."include/config_header_top.php");
include 'css.php';
$page_key ='2_4';
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
}else{

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
							<h2><?php echo $txt;?>ข้อมูลตำแหน่งจัดเก็บสินค้า</h2>
						</div>
						<div class="body">
							<form id="frm-input" action="process/location_process.php" method="POST">
								<input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
                                <input type="hidden" id="form_page" name="form_page" value="<?php echo  $form_page; ?>">
                                <input type="hidden" id="locationID" name="locationID" value="<?php echo $locationID; ?>">
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
										<b>รหัสตำแหน่งจัดเก็บ</b>
										<div class="form-group">
											<div class="form-line">
												<input type="text" oninput="this.value=this.value.replace(/\s/g, '');" maxlength="5" onkeyup="chkShort();" name="locationCode" id="locationCode" class="form-control" placeholder="รหัสตำแหน่งจัดเก็บ" value="<?php echo $rec['locationCode'];?>" <?php echo $proc == "edit" ? $readonly : '';?>>
											</div>
											<div class="help-info">กรอกได้ไม่เกิน5ตัวอักษร</div>
											<label id="locationCode-error" class="error" for="locationCode">กรุณาระบุ รหัสตำแหน่งจัดเก็บ</label>
											<label id="locationCode2-error" class="error" for="locationCode">มีรหัสตำแหน่งจัดเก็บนี้แล้ว</label>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<b>ตำแหน่งจัดเก็บสินค้า</b>
											<div class="form-line">
												<input type="text" onkeyup="chkName();" id="locationName" name="locationName" class="form-control" placeholder="ตำแหน่งจัดเก็บสินค้า" value="<?php echo $rec["locationName"]; ?>" <?php echo $_SESSION["userType"] == "2" ? $readonly : '';?>>
											</div>
											<label id="locationName_error" class="error" for="locationName">กรุณาระบุ ตำแหน่งจัดเก็บสินค้า</label>
											<label id="locationName2_error" class="error" for="locationName">มีตำแหน่งจัดเก็บสินค้นี้แล้ว</label>
										</div>
									</div>
								</div>
								<!-- <div class="row clearfix">
									<div class="col-sm-12">
										<b>รายละเอียด </b>
										<div class="form-group">
											<div class="form-line">
												<textarea  class="form-control" placeholder="รายละเอียด" id="locationDetail" name="locationDetail"> <?php echo $rec['locationDetail'];?> </textarea>
											</div>
										</div>
									</div>
								</div> -->

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
        //$('.idcard').inputmask('9-9999-99999-99-9', { placeholder: '_-____-_____-__-_' });
        //$('.mobile').inputmask('999-999-9999', { placeholder: '___-___-____' });
        //$('.focused').removeClass('focused');
        $('.form-line').removeClass('focused');
        $('.error').hide();
        // $('.datepickers').bootstrapMaterialDatePicker();
});

function OnCancel(){
    $(location).attr('href',"<?php echo  $form_page?>");
}

function chkinput(){
    /*if($('#locationID').val()==''){
        $('#locationID_error').show();
        return false;
    }*/
    if($('#locationCode').val()==''){
			$('#locationCode-error').show();

			return false;
		}else{
			$('#locationCode-error').hide();
		}
		
		if($('#chk3').val()==1){
			$('#locationCode2-error').show();
			$('#locationCode').focus();
			return false;
		}else{
			$('#locationCode2-error').hide();
		}
    if($('#locationName').val()==''){
        $('#locationName_error').show();
    $('#locationName').focus();
        return false;
    }else{
		$('#locationName-error').hide();
	}
    if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
      $("#frm-input").submit();
    }
}

function chkName(){

		var locationName= $('#locationName').val();
		var locationID= $('#locationID').val();
		$.ajaxSetup({async: false});
		$.post('process/get_process.php',{proc:'chk_LocationName',locationName:locationName,locationID:locationID},function(data){
			if(data==1){
				$('#locationName2-error').show();
				$('#chk2').val(1);
			}else{
				$('#locationName2-error').hide();
				$('#chk2').val(0);

			}

		},'json');
	}
	function chkShort(){
			debugger
		var locationCode= $('#locationCode').val();
		var locationID= $('#locationID').val();
		$.ajaxSetup({async: false});
		$.post('process/get_process.php',{proc:'chk_locationCode',locationCode:locationCode,locationID:locationID},function(data){
			if(data==1){
				$('#locationCode2-error').show();
				$('#chk3').val(1);
			}else{
				$('#locationCode2-error').hide();
				$('#chk3').val(0);

			}

		},'json');
	}
</script>
