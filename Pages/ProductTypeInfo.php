<!DOCTYPE html>
<html>

<?php $path = "../";
include($path."include/config_header_top.php");
include 'css.php';
$page_key ='3_2';
$sql     = " SELECT *
FROM tb_producttype
where productTypeID ='".$productTypeID."' ";

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
							<h2><?php echo $txt;?>ข้อมูลประเภทสินค้า</h2>
						</div>
						<form id="frm-input" method="post" enctype="multipart/form-data" action="process/ProductType_process.php" >
							<input type="hidden" id="proc" name="proc" value="<?php echo $proc;?>">
							<input type="hidden" id="productTypeID" name="productTypeID" value="<?php echo $productTypeID;?>">
							<input type="hidden" id="form_page" name="form_page" value="<?php echo  $form_page?>">
							<input type="hidden" id="chk" name="chk" value="0">
							<input type="hidden" id="chk2" name="chk2" value="0">
							<input type="hidden" id="chk3" name="chk3" value="0">
							<div class="body">
								<div class="row clearfix">
									<div class="col-sm-12 align-right"><b><span style="color:red">* กรอกข้อมูลให้ครบทุกช่อง</span></b>
									</div>
								</div>
								<div class="row clearfix">
									<div class="col-sm-4">
										<b>รหัสประเภทสินค้า</b>
										<div class="form-group">
											<div class="form-line">
												<input type="text" oninput="this.value=this.value.replace(/\s/g, '');" maxlength="2" onkeyup="chkCode();" name="productTypeCode" id="productTypeCode" class="form-control" placeholder="รหัสประเภทสินค้า" value="<?php echo $rec['productTypeCode'];?>"<?php echo $_SESSION["userType"] == "2" ? $readonly : '';?>>
											</div>
											<div class="help-info">กรอกได้ไม่เกิน2ตัวอักษร</div>
											<label id="productTypeCode-error" class="error" for="productTypeCode">กรุณาระบุ รหัสประเภทสินค้า</label>
											<label id="productTypeCode2-error" class="error" for="productTypeCode">มีรหัสประเภทสินค้านี้แล้ว</label>
										</div>
									</div>
									<div class="col-sm-4">
										<b>ชื่อประเภทสินค้า</b>
										<div class="form-group">
											<div class="form-line">
												<input type="text " onkeyup="chkName();" onchange="chkEdit();" name="productTypeName" id="productTypeName" class="form-control" placeholder="ชื่อประเภทสินค้า" value="<?php echo $rec['productTypeName'];?>"<?php echo $_SESSION["userType"] == "2" ? $readonly : '';?>>
											</div>
											<label id="productTypeName-error" class="error" for="productTypeName">กรุณาระบุ ชื่อประเภทสินค้า</label>
											<label id="productTypeName2-error" class="error" for="productTypeName">มีชื่อประเภทสินค้านี้แล้ว</label>
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
									<div class="row clearfix">
										<div class="col-sm-12 icon-and-text-button-demo align-right">
											<a class="btn btn-primary waves-effect" onClick="popup();"><span>เลือกคุณลักษณะ</span><i class="material-icons">add_box</i></a>
										</div>
										<div class="col-sm-12">
											<div class="form-group">
												<?php
												$i=0;
												$sql_attr  = " SELECT tb_typeattr.*,tb_attribute.attrName FROM tb_typeattr join tb_attribute
												on tb_typeattr.attrID = tb_attribute.attrID
												where productTypeID ='".$productTypeID."'";

												$query_attr = $db->query($sql_attr);
												$nums_attr = $db->db_num_rows($query_attr);             
												?>
												<table class="table table-bordered table-striped table-hover  dataTable " id="tb_data_attr" >
													<thead>
														<tr>
															<th width="10%">ลำดับ</th>
															<th width="50%">คุณลักษณะ</th>
															<th width="30%">การจัดเรียง</th>
															<th width="10%">จัดการ</th>   
														</tr>
													</thead>
													<tbody>
														<?php 
														if($nums_attr>0){
															while ($rec_attr = $db->db_fetch_array($query_attr)) {
																$i++;
																$del = '<a class="btn bg-red btn-xs waves-effect"  href="javascript:void(0);" onClick="delDataTB(this,'.$rec_attr['attrID'].');">'.$img_del.'</a>';
																?>
																<tr>
																	<td align="center"><?php echo $i; ?>
																	<input type="hidden" name="attrID[]" id="attrID_<?php echo $i;?>" value="<?php echo $rec_attr['attrID'];?>"></td>                               
																	<td><?php echo $rec_attr['attrName']; ?></td>
																	<td>
																		<div class="form-line">
																			<input type="text" class="form-control" name="seq[]" id="seq<?php echo $i;?>" value="<?php echo $rec_attr['seq'];?>" >
																		</div>
																	</td>
																	<td style="text-align: center;">
																		<?php echo $del;?>
																	</td>
																</tr>
															<?php   }
														}else{
															echo '<tr id="nodata"><td align="center" colspan="7">ไม่พบข้อมูล</td></tr>';
														} ?>
													</tbody>
												</table>
												<label id="tb_data_attr-error" class="error" for="tb_data_attr">กรุณาเลือกคุณลักษณะ</label>
											</div>
										</div>
										<input type="hidden" id="rowid" value="<?php echo $i;?>">
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

	<div class="modal fade" id="ModalAttribute" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="largeModalLabel">คุณลักษณะ</h4>
					<form>
						<br><br><br>
						<div class="row">
							<div class="col-sm-9 col-sm-offset-1">
								<div class="form-group">
									<div class="input-group">
										<div class="form-line">
											<input type="text " name="s_attrName" id="s_attrName" class="form-control" placeholder="ชื่อคุณลักษณะ" value="<?php echo $s_attrName;?>">
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-2">
								<div class="form-group">
									<div class="text-center">
										<a  class="btn btn-success waves-effect"onclick="get_search();" ><span>ค้นหา</span><?php echo $img_view;?></a>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="modal-body">
					<table class="table table-bordered table-striped table-hover  dataTable "> <!--js-basic-example-->
						<thead>
							<tr>
								<th align="center" width="10%">ลำดับ</th>
								<th width="45%">ชื่อคุณลักษณะ</th>
								<th width="10%">เลือก</th>
							</tr>
						</thead>
						<tbody  id="ModalDATA">
						</tbody>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-success waves-effect" onclick="onsubmitModal();">เลือก</button>
					<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">ปิด</button>
				</div>
			</div>
		</div>
	</div>


	<script>
		function OnCancel()
		{

			$(location).attr('href',"<?php echo  $form_page?>");
		}

		function chkinput(){

			if($('#productTypeCode').val()==''){
				$('#productTypeCode-error').show();
				$('#productTypeCode').focus();
				return false;
			}else{
				$('#productTypeCode-error').hide();
			}

			if($('#chk').val()==1){
				$('#productTypeCode-error').show();
				$('#productTypeCode').focus();
				return false;
			}else{
				$('#productTypeCode-error').hide();
			}



			if($('#chk2').val()==1){
				$('#productTypeName2-error').show();
				$('#productTypeName').focus();
				return false;
			}else{
				$('#productTypeName2-error').hide();
			}

			if($('#productTypeName').val()==''){
				$('#productTypeName-error').show();
				$('#productTypeName').focus();
				return false;
			}else{
				$('#productTypeName-error').hide();
			}

			if($('#chk3').val()==1){
				return false;
			}

			if($('#rowid').val() == 0){
				debugger
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

			// if($('#proc').val()=='add'){
			// 	var productTypeCode ='';
			// 	$.ajaxSetup({async: false});
			// 	$.post('process/get_process.php',{proc:'get_productTypeCode'},function(data){
			// 		productTypeCode =  data['name'];
			// 	},'json');
			// 	$('#productTypeCode').val(productTypeCode);
			// }

		});

		function popup(){
			$('#ModalAttribute').modal('show');
			get_search();
		}

		function get_search() {
			$('#ModalDATA').html('');
			var name  =  $('#s_attrName').val();
			var html ='';
			var i = 1;
			$.ajaxSetup({async: false});
			$.post('process/get_process.php',{proc:'get_attribute',name:name},function(data){
				if(data != ''){
					$.each(data,function(index,value){
						html += '<tr>';
						html += '<td align="center">'+i+'</td>';
						html += '<td>'+value['attrName']+'</td>';
						html += '<td align="center">';
						html += '<input type="checkbox" id="F_attrID_'+index+'"  value="'+value['attrID']+'"  class="filled-in" >';
						html += '<label for="F_attrID_'+index+'"></label>';
						html += '<input type="hidden" id="F_attrName_'+index+'" value="'+value['attrName']+'">';
						html += '</td>';
						html += '</tr>';
						i++;
					});
				}else{
					html += '<tr>';
					html += '<td colspan="3" align="center">ไม่พบข้อมูล</td>';
					html += '</tr>';
				}
			},'json');
			$('#ModalDATA').html(html);
		}

		function onsubmitModal(){
			var html = '';
			var rowid = parseInt($('#rowid').val());

			if (rowid == 0) {
				$("#tb_data_attr tbody").html("");
			}

			var arr_attr_id = $('input[id^=F_attrID_]');
			var arr_attr_name = $('input[id^=F_attrName_]');
			if(arr_attr_id.length>0){
				for (var i = 0; i < arr_attr_id.length; i++) {

					if (arr_attr_id[i].checked){
						rowid = rowid+1;

						html += '<tr>';
						html += '<td style="text-align:center">'+rowid+'<input type="hidden" name="attrID[]" id="attrID_'+rowid+'" value="'+arr_attr_id[i].value+'"></td>';
						html += '<td>'+arr_attr_name[i].value+'</td>';
						html += '<td>';
						html += '<div class="form-line">';
						html += '   <input type="text" class="form-control numb" name="seq[]" id="seq'+rowid+'" value="'+rowid+'" >';
						html += '</div>';
						html += '</td>';
						html += '<td style="text-align: center;">';
						html += '<a class=\"btn bg-red btn-xs waves-effect\"  href=\"javascript:void(0);\" onClick=\"delDataTB(this,0,0);\"><?php echo $img_del;?> </a>';
						html += '</td>';
						html += '</tr>';


						var obj_id = $("#tb_data_attr tbody tr");
						$.each(obj_id, function(){
							if(($(this).find('td:eq(1)').text()).toString() == (arr_attr_name[i].value).toString()){
								html = "";
								alert("มีคุณลักษณะนี้แล้ว");
								return false;
							}
						});
					}
				}
			}

			if(html != ""){
				$(".numb").inputFilter(function(value) {
					return /^\d*$/.test(value);
				});
				$('#ModalAttribute').modal('hide');
				$('#tb_data_attr tbody').append(html);
				$('#rowid').val(rowid);
				$('#tb_data_attr-error').hide();
			}

		}
		function delDataTB(obj){
			if(confirm("ยืนยันการลบคุณลักษณะ ?")){
				var row = parseInt($('#tb_data_attr tbody tr').length);
				if (row != 1) {
          //$('#nodata').show();
          $(obj).parent().parent().remove();
          get_total();
      }else{
      	alert('ไม่สามารถลบข้อมูลได้ เนื่องจากต้องมีคุณลักษณะอย่างน้อย1รายการ');
      }
  }
}

function chkEdit(){
	if($('#proc').val()=='edit'){
		debugger
		var productTypeID = $('#productTypeID').val();
		$.ajaxSetup({async: false});
		$.post('process/get_process.php',{proc:'chkDelData_ProductType',productTypeID:productTypeID},function(data){
			if(data > 0){
				alert('ไม่สามารถแก้ไขข้อมูลได้ เนื่องจากประเภทสินค้านี้มีการใช้ข้อมูลนี้อยู่');
				$('#productTypeName').val(<?php echo $productTypeName ?>);
				return false;
			}
		},'json');
	}
	console.log(<?php echo $productTypeName ?>);
}

function chkName(){
	var productTypeName= $('#productTypeName').val();
	var productTypeID= $('#productTypeID').val();
	$.ajaxSetup({async: false});
	$.post('process/get_process.php',{proc:'chk_productTypeName',productTypeName:productTypeName,productTypeID:productTypeID},function(data){
		$('.error').hide();
		if(data==1){
			$('#productTypeName2-error').show();
			$('#chk2').val(1);
		}else{
			$('#productTypeName2-error').hide();
			$('#chk2').val(0);

		}

	},'json');
}

function chkCode(){
	debugger
	var productTypeCode= $('#productTypeCode').val();
	var productTypeID= $('#productTypeID').val();
	$.ajaxSetup({async: false});
	$.post('process/get_process.php',{proc:'chk_productTypeCode',productTypeCode:productTypeCode,productTypeID:productTypeID},function(data){
		$('.error').hide();
		if(data==1){
			$('#productTypeCode2-error').show();
			$('#chk').val(1);
		}else{
			$('#productTypeCode2-error').hide();
			$('#chk').val(0);

		}

	},'json');
}
function delData(id,hdf_id){
	var productTypeID = $('#productTypeID').val();
	$.ajaxSetup({async: false});
	$.post('process/get_process.php',{proc:'chkDelData_ProductType',productTypeID:productTypeID},function(data){
		if(data > 0){
			alert('ไม่สามารถยกเลิกข้อมูลได้ เนื่องจากประเภทสินค้านี้มีการใช้ข้อมูลนี้อยู่');
			$('#status').val(1);
			$('#chk3').val(1);
			return false;
		}else{
			$('#'+hdf_id).val(id);
			$('#chk3').val(0);
		}
	},'json');

}
//username2
</script>
