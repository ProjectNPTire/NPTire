<!DOCTYPE html>
<html>

<?php
$path = "../";
include($path."include/config_header_top.php");
include 'css.php';
$page_key ='3_3';
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
							<h2><?php echo $txt;?>ข้อมูลตำแหน่งจัดเก็บสินค้า</h2>
						</div>
						<div class="body">
							<form id="frm-input" action="process/location_process.php" method="POST">
<!-- 								<?php $_GET['brandID'];$_GET['productTypeID']; ?>
-->							<input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
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
									<div class="col-sm-4">
										<b>รหัสตำแหน่งจัดเก็บ</b>
										<div class="form-group">
											<div class="form-line">
												<input type="text" readonly oninput="this.value=this.value.replace(/\s/g, '');" maxlength="10" onkeyup="chkShort();" name="locationCode" id="locationCode" class="form-control" placeholder="รหัสตำแหน่งจัดเก็บ" value="<?php echo $rec['locationCode'];?>" <?php echo $_SESSION["userType"] == "2" ? $readonly : '';?>>
											</div>
											<div class="help-info">ไม่เกิน8ตัวอักษร</div>
											<label id="locationCode-error" class="error" for="locationCode">กรุณาระบุ รหัสตำแหน่งจัดเก็บ</label>
											<label id="locationCode2-error" class="error" for="locationCode">มีรหัสตำแหน่งจัดเก็บนี้แล้ว</label>
										</div>
									</div>
									<div class="col-sm-4">
										<b>ชื่อตำแหน่งจัดเก็บสินค้า</b>
										<div class="form-group">
											<div class="form-line">
												<input type="text" onkeyup="chkName();" id="locationName" name="locationName" class="form-control" placeholder="ชื่อตำแหน่งจัดเก็บสินค้า" value="<?php echo $rec["locationName"]; ?>" <?php echo $_SESSION["userType"] == "2" ? $readonly : '';?>>
											</div>
											<label id="locationName-error" class="error" for="locationName">กรุณาระบุ ตำแหน่งจัดเก็บสินค้า</label>
											<label id="locationName2-error" class="error" for="locationName">มีตำแหน่งจัดเก็บสินค้นี้แล้ว</label>
										</div>
									</div>
									<div class="col-sm-4">
										<b>ประเภทตำแหน่งจัดเก็บ</b>
										<div class="form-group form-float">
											<select name="locationTypeID" id="locationTypeID" class="form-control show-tick" data-live-search="true" <?php echo $_SESSION["userType"] == "2"  ? 'disabled' : '';?> onchange="ShowAndHide();">                   
												<!-- <option value="">เลือก</option> -->
												<?php   foreach ($arr_locationType as $key => $value) {?>
													<option value="<?php echo $key;?>"  <?php echo ($rec['locationTypeID']==$key)?"selected":"";?>> <?php echo $value;?></option>
												<?php }  ?>
											</select>
											<input type="hidden" name="hdflocationTypeID" id="hdflocationTypeID" value="<?php echo $rec['locationTypeID'] ?>">
											<label id="locationTypeID-error" class="error" for="locationTypeID">กรุณาเลือก ประเภทตำแหน่งจัดเก็บ</label>
										</div>
									</div>
								</div>
								<div class="row clearfix">
									<div class="col-sm-4">
										<b>กว้าง</b>
										<div class="form-group">
											<div class="form-line">
												<input type="text" onkeyup="chkzero(this.value,1);" id="width" name="width" class="form-control numb" placeholder="จำนวนสินค้าที่วาง" maxlength="2" value="<?php echo $rec["width"]; ?>" <?php echo $_SESSION["userType"] == "2" ? $readonly : '';?>>
											</div>
											<div class="help-info">กรอกได้เฉพาะตัวเลขไม่เกิน2ตัวอักษรและต้องมีค่ามากกว่า0</div>
											<label id="width_error" class="error" for="width">กรุณาระบุ ความกว้าง</label>
											<label id="width2_error" class="error" for="width">ความกว้างต้องมากกว่า 0</label>
										</div>
									</div>
									<div class="col-sm-4">
										<b>สูง</b>
										<div class="form-group">
											<div class="form-line">
												<input type="text" onkeyup="chkzero(this.value,2);" id="high" name="high" class="form-control numb" placeholder="จำนวนชั้น" maxlength="2" value="<?php echo $rec["high"]; ?>" <?php echo $_SESSION["userType"] == "2" ? $readonly : '';?>>
											</div>
											<div class="help-info">กรอกได้เฉพาะตัวเลขไม่เกิน2ตัวอักษรและต้องมีค่ามากกว่า0</div>
											<label id="high_error" class="error" for="high">กรุณาระบุ ความสูง</label>
											<label id="high2_error" class="error" for="high">ความสูงต้องมากกว่า 0</label>
										</div>
									</div>
									<div class="col-sm-4" id="productType">
										<b>ประเภทสินค้า</b>
										<div class="form-group form-float">
											<select onchange="get_hdf(this.value,'hdfproductTypeID',1);" name="productTypeID" id="productTypeID" class="form-control show-tick" data-live-search="true" <?php echo $_SESSION["userType"] == "2"  ? 'disabled' : '';?>>
												<option value="">เลือก</option>
												<?php
												$s_pdtype=" SELECT * from tb_producttype where productTypeID NOT IN (1,2) and isEnabled = 1 order by productTypeName asc";
												$q_pdtype = $db->query($s_pdtype);
												$n_pdtype = $db->db_num_rows($q_pdtype);
												while($r_pdtype = $db->db_fetch_array($q_pdtype)){

													?>
													<option value="<?php echo $r_pdtype['productTypeID'];?>"  <?php echo ($rec['productTypeID']==$r_pdtype['productTypeID'])?"selected":"";?>> <?php echo $r_pdtype['productTypeName'];?></option>

												<?php }  ?>
											</select>
											<input type="hidden" name="hdfproductTypeID" id="hdfproductTypeID" value="<?php echo $rec['productTypeID'] ?>">
											<label id="productTypeID-error" class="error" for="productTypeID">กรุณาเลือก ประเภทสินค้า</label>
										</div>
									</div>
									<div class="col-sm-4" id="brand">
										<b>ยี่ห้อสินค้า</b>
										<div class="form-group form-float">
											<select onchange="get_hdf(this.value,'hdfbrandID',2);" name="brandID" id="brandID" class="form-control show-tick" data-live-search="true" <?php echo $_SESSION["userType"] == "2"  ? 'disabled' : '';?>>
												<option value="">เลือก</option>
												<?php
												$s_brand=" SELECT * from tb_brand 
												join tb_producttype on tb_brand.productTypeID = tb_producttype.productTypeID
												where tb_brand.productTypeID IN (1,2)
												order by brandName asc";
												$q_brand = $db->query($s_brand);
												$n_brand = $db->db_num_rows($q_brand);
												while($r_brand = $db->db_fetch_array($q_brand)){
													?>
													<option value="<?php echo $r_brand['brandID'];?>"  <?php echo ($rec['brandID']==$r_brand['brandID'])?"selected":"";?>> <?php echo $r_brand['brandName'];?></option>
												<?php }  ?>
											</select>
											<input type="hidden" name="hdfbrandID" id="hdfbrandID" value="<?php echo $rec['brandID'] ?>">
											<label id="brandID-error" class="error" for="brandID">กรุณาเลือก ยี่ห้อสินค้า</label>
										</div>
									</div>
								</div>
								<div class="row clearfix">
									<div class="col-sm-4">
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
			ShowAndHide();
        //$('.idcard').inputmask('9-9999-99999-99-9', { placeholder: '_-____-_____-__-_' });
        //$('.mobile').inputmask('999-999-9999', { placeholder: '___-___-____' });
        //$('.focused').removeClass('focused');
        $('.form-line').removeClass('focused');
        $('.error').hide();
        $(".numb").inputFilter(function(value) {
        	return /^\d*$/.test(value); }); 
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
    // if($('#locationCode').val()==''){
    // 	$('#locationCode-error').show();

    // 	return false;
    // }else{
    // 	$('#locationCode-error').hide();
    // }

    if($('#chk3').val()==1){
    	$('#locationCode2-error').show();
    	$('#locationCode').focus();
    	return false;
    }else{
    	$('#locationCode2-error').hide();
    }

    if($('#locationName').val()==''){
    	$('#locationName-error').show();
    	$('#locationName').focus();
    	return false;
    }else{
    	$('#locationName-error').hide();
    }

    if($('#chk2').val()==1){
    	$('#locationName2-error').show();
    	$('#locationName').focus();
    	return false;
    }else{
    	$('#locationName2-error').hide();
    }
    
    if($('#locationTypeID').val()==''){
    	$('#locationTypeID-error').show();
    	$('#locationTypeID').focus();
    	return false;
    }else{
    	$('#locationTypeID-error').hide();
    }

    if($('#width').val()==''){
    	$('#width_error').show();
    	$('#width').focus();
    	return false;
    }else{
    	$('#width_error').hide();
    }

    if($('#width').val()==0){
    	$('#width2_error').show();
    	$('#width').focus();
    	return false;
    }else{
    	$('#width2_error').hide();
    }

    if($('#high').val()==''){
    	$('#high_error').show();
    	$('#high').focus();
    	return false;
    }else{
    	$('#high_error').hide();
    }

    if($('#high').val()==0){
    	$('#high2_error').show();
    	$('#high').focus();
    	return false;
    }else{
    	$('#high2_error').hide();
    }

    if($('#locationTypeID').val()==2){
    	if($('#productTypeID').val()==''){
    		$('#productTypeID-error').show();
    		$('#productTypeID').focus();
    		return false;
    	}else{
    		$('#productTypeID-error').hide();
    	}
    }

    if($('#locationTypeID').val()==1){
    	if($('#brandID').val()==''){
    		$('#brandID-error').show();
    		$('#brandID').focus();
    		return false;
    	}else{
    		$('#brandID-error').hide();
    	}
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
		$('.error').hide();
			//alert(data);
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
	var locationCode= $('#locationCode').val();
	var locationID= $('#locationID').val();
	$.ajaxSetup({async: false});
	$.post('process/get_process.php',{proc:'chk_locationCode',locationCode:locationCode,locationID:locationID},function(data){
		$('.error').hide();
		if(data==1){
			$('#locationCode2-error').show();
			$('#chk3').val(1);
		}else{
			$('#locationCode2-error').hide();
			$('#chk3').val(0);

		}

	},'json');
}

function chkzero(zero,type){
	var zero= zero;
	if (zero == 0) {
		if (type == 1) {
			$('#width2_error').show();

		}else if (type == 2) {
			$('#high2_error').show();

		}
	}else{
		if (type == 1) {
			$('#width2_error').hide();

		}else if (type == 2) {
			$('#high2_error').hide();

		}
	}	
}


function get_hdf(parent_id,hdf_id,type){
	debugger
	if (type == 1) {
		var productTypeID = parent_id;
		$('#'+hdf_id).val(productTypeID);
		

		var newcode ='';
		$.ajaxSetup({async: false});
		$.post('process/get_process.php',{proc:'get_locationtiontype',productTypeID:productTypeID},function(data){
			newcode =  data['name'];
			$('#locationCode').val(newcode);
		},'json');

	}else if (type == 2) {
		var brandID = parent_id;
		$('#'+hdf_id).val(brandID);

		var newcode ='';
		$.ajaxSetup({async: false});
		$.post('process/get_process.php',{proc:'get_locationbrand',brandID:brandID},function(data){
			newcode =  data['name'];
			$('#locationCode').val(newcode);
		},'json');
	}
}

function ShowAndHide(){
	debugger
	$('#productType').hide();
	$('#brand').hide();
	var locationTypeID = $('#locationTypeID').val();
	if(locationTypeID == 1){
		$('#brand').show();
		$('#brand').val(0);
	}else if(locationTypeID == 2){
		$('#productType').show();
		$('#productType').val(0);
	}
}

function delData(parent_id,id,hdf_id){
	var locationID = $('#locationID').val();
	$.ajaxSetup({async: false});
	$.post('process/get_process.php',{proc:'chkDelData_Location',locationID:locationID},function(data){
		if(data > 0){
			alert('ไม่สามารถยกเลิกข้อมูลได้ เนื่องจากตำแหน่งนี้มีสินค้าอยู่');
			$('#'+parent_id).val(1);
			return false;
		}else{
			$('#'+hdf_id).val(id);
		}
	},'json');

}
	// function get_brand(){
	// 	var html  = '<option value="">เลือก</option>';
	// 	var productTypeID = $('#productTypeID').val();
	// 	$.ajaxSetup({async: false});  
	// 	$.post('process/get_process.php',{proc:'get_brand',productTypeID:productTypeID},function(data){

	// 		$.each(data,function(index,value){
	// 			html += "<option value='"+value['DATA_VALUE']+"'>"+value['DATA_NAME']+"</option>";
	// 		});
	// 		$('#hdfproductTypeID').val(productTypeID);
	// 		$('#brandID').html(html);
	// 		$('#brandID').selectpicker('refresh');

	// 	},'json');
	// }
</script>
