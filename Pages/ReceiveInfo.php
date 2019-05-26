<!DOCTYPE html>
<html>

<?php
$path = "../";
include($path."include/config_header_top.php");
include 'css.php';
$page_key ='5_1';

?>

<body class="theme-red">
	<?php include 'MasterPage.php';?>

	<section class="content">
		<div class="container-fluid">
			<div class="row clearfix">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="card">
						<div class="header">
							<h2>ข้อมูลรับเข้าสินค้า</h2>
						</div>
						<div class="body table-responsive">
							<form id="frm-input" method="POST" action="process/receive_process.php">
								<input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
								<input type="hidden" id="form_page" name="form_page" value="<?php echo  $form_page; ?>">
								<!-- <input type="hidden" id="poID" name="poID" value="<?php echo $poID; ?>"> -->

								<div class="row table-responsive">
									<div class="col-sm-6 col-sm-offset-2">
										<div class="form-group">
											<b>เรียกจากใบสั่งซื้อ</b>
											<div class="form-line">
												<input type="text" id="poID" name="poID" class="form-control" placeholder="EX: PO-19010001" oninput="this.value=this.value.replace(/\s/g, '');" onkeypress="chkEnter(event)" value="<?php echo $poID; ?>">
											</div>
											<label id="poID_error" class="error" for="poID">ไม่พบข้อมูลใบสั่งซื้อ</label>
											<label id="poID2_error" class="error" for="poID">ใบสั่งซื้อนี้ถูกยกเลิก</label>
											<label id="poID3_error" class="error" for="poID">ใบสั่งซื้อนี้รับสินค้าครบแล้ว	
											</label>
										</div>
									</div>
									<div class="col-sm-1">
										<div class="form-group">
											<button type="button" class="btn btn-primary" onclick="getPOInfo();">
												<span>ค้นหา <?php echo $img_view;?></span>
											</button>
										</div>
									</div>
								</div>

								<div id="receive-load"></div>

								<div id="btn-submit" class="align-center" hidden>
									<button class="btn btn-success waves-effect" type="button" onclick="confirmSubmit()">บันทึก</button>
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
		$('.error').hide();
		$('.form-line').removeClass('focused');

		$(".numb").inputFilter(function(value) {
			return /^\d*$/.test(value); });
		
		if ($("#poID").val() != "") {
			getPOInfo()
		}
	});

	function chkEnter(e){
		if (e.keyCode == 13) {
			e.preventDefault();
			getPOInfo();
	        //return false;
	    }
	}

	function getPOInfo(){
		var id = $("#poID").val();
		$.post( "process/ajax_response.php", { func: "getPOInfo", id: id  }, function( data ) {

			//console.log(data);
			//PO-19010001

			if(data["po_head"].poID != null){
				if(data["po_head"].poStatus == 99){
					var html = "";
					$("#receive-load").html(html);
					$("#btn-submit").hide();
					$('#poID_error').hide();
					$('#poID3_error').hide();
					$('#poID2_error').show();
				}else if(data["po_head"].poStatus == 3){
					var html = "";
					$("#receive-load").html(html);
					$("#btn-submit").hide();
					$('#poID_error').hide();
					$('#poID2_error').hide();
					$('#poID3_error').show();
				}else{
					var html = "";

					html += '<div class="form-group">';
					html += '<table id="tb-data" class="table table-bordered">';
					html += '<thead>';
					html += '<tr>';
					//html += '<th width="5%">ลำดับ</th>';
					html += '<th align="center">รหัสสินค้า</th>';
					html += '<th align="center"">ชื่อสินค้า</th>';
					html += '<th align="center">ประเภทสินค้า</th>';
					html += '<th align="center"">ยี่ห้อ</th>';
					html += '<th width="11%" align="center">คุณลักษณะ</th>';
					html += '<th align="center">จำนวน</th>';
					html += '<th align="center">รับแล้ว</th>';
					html += '<th align="center">ค้างรับ</th>';
					html += '<th width="8%" align="center">รับเข้า</th>';
					html += '<th width="11%" align="center">ประเภทตำแหน่งเก็บ</th>';
					html += '<th align="center">ตำแหน่งเก็บ</th>';
					html += '</tr>';
					html += '</thead>';
					html += '<tbody>';

					var qty = 0;

					if(data["po_desc"]){
						for(var i = 0; i < data["po_desc"].length; i++ ){
							var received_qty = (data["po_desc"][i].received_qty) ? data["po_desc"][i].received_qty : 0 ;
							var pending = data["po_desc"][i].qty - data["po_desc"][i].received_qty;
							var receive = pending;


							html += '<tr>';
							//html += '<td align="center">'+(i+1)+'</td>';
							html += '<td>'+data["po_desc"][i].productCode+'</td>';
							html += '<td>'+data["po_desc"][i].productName+'</td>';
							html += '<td>'+data["po_desc"][i].productTypeName+'</td>';
							html += '<td>'+data["po_desc"][i].brandName+'</td>';
							html += '<td>'+data["po_desc"][i].attr+'</td>';
							html += '<td align="right">'+addCommas(data["po_desc"][i].qty)+'</td>';
							html += '<td align="right">'+addCommas(received_qty)+'</td>';
							html += '<td align="right">'+addCommas(pending)+'</td>';
							html += '<td align="right"><div class="form-line"><input type="text" maxlength="'+addCommas(pending).length+'" value="'+addCommas(receive)+'" id="qty['+data["po_desc"][i].productID+']" name="qty['+data["po_desc"][i].productID+']" class="form-control text-right numb" onblur="checkReceiveQTY(this);NumberFormat(this);" required></div></td>';
							// html += '<td><input type="hidden" id="locationTypeID" name="locationTypeID" value="'+data["po_desc"][i].locationTypeID+'">'+data["po_desc"][i].locationTypeName+'</td>';
							html += '<td align="right">';
							html += '<select onchange="get_location(this.value,\'locationID_'+data["po_desc"][i].productID+'\');" name="locationTypeID['+data["po_desc"][i].productID+']" class="form-control show-tick" data-live-search="true">';
							for (var j = 0; j < data["locationType"].length; j++) {
								html += '<option value="'+data["locationType"][j].locationTypeID+'">'+data["locationType"][j].locationTypeName+'</option>';
							}
							html += '</select>';
							html += '</td>';
							html += '<td align="right">';
							html += '<select id="locationID_'+data["po_desc"][i].productID+'" name="locationID['+data["po_desc"][i].productID+']" class="form-control show-tick" data-live-search="true">';
							for (var j = 0; j < data["location"].length; j++) {
								html += '<option value="'+data["location"][j].locationID+'">'+data["location"][j].locationName+'</option>';
							}
							html += '</select>';
							html += '</td>';

							// if (data["locationType"]) {
							// 	var count = 0;
							// 	let result = [];
							// 	for (var j = 0; j < data["locationType"].length; j++) {
							// 		if (data["po_desc"][i].tempID == data["locationType"][j].tempID){
							// 			// count += (parseInt(data["location"][j].locationQty)-parseInt(data["location"][j].total));

							// 			// html += '<input type="hidden" id="qty['+data["po_desc"][i].productID+']"value="'+count+'">';
							// 			result.push(data["location"][j]);
							// 		}
							// 		// }else if (data["po_desc"][i].locationTypeID == 2 && data["location"][j].locationTypeID == 2){
							// 		// 	count += (parseInt(data["location"][j].locationQty)-parseInt(data["location"][j].total));
							// 		// 	html += '<input type="hidden" id="qty['+data["po_desc"][i].productID+']"value="'+count+'">';
							// 		// 	result.push(data["location"][j]);

							// 		// }
							// 	}
							// 	if (result.length == 0) {
							// 		if(confirm('ไม่มีตำแหน่งที่จัดเก็บได้ กรุณาเพิ่มตำแหน่งเก็บของ'+data["po_desc"][i].productName)){
							// 			window.location.href = "LocationInfo.php??locationTypeID="+data["po_desc"][i].locationTypeID;
							// 		}else{
							// 			window.location.href = "ReceiveList.php";
							// 		}								
							// 		return;
							// 	}

							// 	html += '<td align="right">';
							// 	html += '<select name="locationID['+data["po_desc"][i].productID+']" class="form-control show-tick" data-live-search="true">';
							// 	for (var a = 0; a < result.length; a++) {
							// 		html += '<option value="'+result[a].locationID+'">'+result[a].locationName+'</option>';
							// 	}	
							// 	html += '</select></td>';

							// }else{
							// 	if(confirm('ไม่มีตำแหน่งที่จัดเก็บได้ กรุณาเพิ่มตำแหน่งเก็บของ'+data["po_desc"][i].productName)){
							// 		window.location.href = "LocationInfo.php??locationTypeID="+data["po_desc"][i].locationTypeID;
							// 	}else{
							// 		window.location.href = "ReceiveList.php";
							// 	}								
							// 	return;
							//}
							html += '</tr>';
						}
					}
					else {
						html += '<tr>';
						html += '<td colspan="6" align="center">ไม่พบข้อมูล</td>';
						html += '</tr>';
					}

					html += '</tbody>';

					html += '</table>';
					html += '<label id="tb_data-error" class="error" for="tb_data">จำนวนรับเข้ามากกว่าจำนวนที่ค้างรับ</label>';
					html += '</div>';

					$("#receive-load").html(html);
					$("#btn-submit").show();

					$('.error').hide();
					$('select').selectpicker({
						"liveSearch": true,
						"showTick" : true
					});
				}
			}
			else {
				var html = "";
				$("#receive-load").html(html);
				$("#btn-submit").hide();
				$('#poID_error').show();
				$('#poID2_error').hide();
			}
			$(".numb").inputFilter(function(value) {
				return /^\d*$/.test(value); });

		}, "json");
}

function checkReceiveQTY(obj)
{
		//PO-19010001
		var remain_receive = parseInt(($(obj).parent().parent().parent().find('td:eq(7)').text()).replace(/,/g,""));
		// alert(remain_receive);
		var receive = parseInt($(obj).parent().parent().parent().find('td:eq(8) input').val());
		if(receive > remain_receive){
			// alert("ไม่สามารถรับสินค้าเกินจำนวนที่ค้างรับได้");
			$(obj).val(remain_receive);
			$('#tb_data-error').show();
			return false;
		}
	}

	function get_location(parent_id,id){
		console.log(id);
		var locationTypeID = parent_id;
		var html;
		$.ajaxSetup({async: false});
		$.post('process/get_process.php',{proc:'get_location',locationTypeID:locationTypeID},function(data){
			//console.log(data);
			$.each(data,function(index,value){
				html += "<option value='"+value['DATA_VALUE']+"'>"+value['DATA_NAME']+"</option>";
			});
			$('#'+id).html(html);
			$('#'+id).selectpicker('refresh');

		},'json');
	}

	// function checkLocationQTY(obj,productTypeName,brandName,productTypeID,brandID)
	// {
	// 	var locationQty = parseInt($(obj).parent().parent().parent().find('td:eq(9)').val());
	// 	var receive = parseInt($(obj).parent().parent().parent().find('td:eq(8) input').val());
	// 	if(receive > locationQty){
	// 		$(obj).val(locationQty);


	// 		if(confirm('พื้นที่ตำแหน่งเก็บไม่เพียงพอ กรุณาเพิ่มตำแหน่งเก็บของ'+data["po_desc"][i].brandName)){
	// 			window.location.href = "LocationInfo.php??locationTypeID="+data["po_desc"][i].locationTypeID+"&productTypeID="+data["po_desc"][i].productTypeID+"&brandID="+data["po_desc"][i].brandID;
	// 		}else{
	// 			window.location.href = "ReceiveList.php";
	// 		}								
	// 		return;

	// 		//alert("ไม่สามารถรับสินค้าเกินจำนวนที่ค้างรับได้");
	// 		//$('#tb_data-error').show();
	// 		return false;
	// 	}
	// }

	function confirmSubmit(){

		// if($('#supID').val() == ''){
	    //     $('#supID').show();
	    //     return false;
	    // }

		// $("#frm-input").attr("action", "process/receive_process.php");
		if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
			$("#frm-input").submit();
		}
	}

	function OnCancel(){
		$(location).attr('href',"<?php echo  $form_page?>");
	}

</script>
