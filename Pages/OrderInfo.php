<!DOCTYPE html>
<html>

<?php
$path = "../";
include($path."include/config_header_top.php");
include 'css.php';
$page_key ='3_1';

$proc = ($proc=='')?"add":$proc;
chk_role($page_key,'isAdd',1);
?>

<body class="theme-red">
	<?php include 'MasterPage.php';?>

	<section class="content">
		<div class="container-fluid">
			<div class="row clearfix">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="card">
						<div class="header">
							<h2>ข้อมูลสั่งซื้อสินค้า</h2>
						</div>
						<div class="body">
							<form id="frm-input" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
								<input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
								<input type="hidden" id="form_page" name="form_page" value="<?php echo  $form_page; ?>">
								<input type="hidden" id="poID" name="poID" value="<?php echo $poID; ?>">

								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<b>ชื่อคู่ค้า/บริษัท <span style="color:red"> *</span></b>
											<div class="form-group form-float">
												<select name="supID" id="supID" class="form-control show-tick" data-live-search="true" onchange="getSupInfo(this.value);">
													<option value="">เลือก</option>
													<?php
													$sql_sup=" SELECT * from tb_supplier order by sup_name asc";
													$query_sup = $db->query($sql_sup);
													//$num_sup = $db->db_num_rows($query_sup);
													while($rec_sup = $db->db_fetch_array($query_sup)){?>
														<option value="<?php echo $rec_sup['supID'];?>"  <?php echo ($rec['supID']==$rec_sup['supID'])?"selected":"";?>> <?php echo $rec_sup['sup_name'];?></option>

													<?php }  ?>
												</select>
											</div>
											<label id="supID_error" class="error" for="supID_error">กรุณาระบุ</label>
										</div>
									</div>
									<div class="col-sm-8">
										<div class="form-group">
											<b>ที่อยู่ </b>
											<div class="form-line">
												<input type="text" class="form-control" id="sup_address" name="sup_address" value="" readonly>
											</div>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<b>จังหวัด </b>
											<div class="form-line">
												<input type="text" class="form-control" id="province_name_th" name="province_name_th" value="" readonly>
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<b>เขต/อำเภอ </b>
											<div class="form-line">
												<input type="text" class="form-control" id="district_name_th" name="district_name_th" value="" readonly>
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<b>แขวง/ตำบล </b>
											<div class="form-line">
												<input type="text" class="form-control" id="subDistrict_name_th" name="subDistrict_name_th" value="" readonly>
											</div>
										</div>
									</div>
								</div>

								<div class="icon-and-text-button-demo align-right">
									<button type="button" class="btn btn-primary waves-effect" onclick="openModal();">
										<span>เพิ่มสินค้า</span>
										<i class="material-icons">add_box</i>
									</button>
								</div>
								<div class="input-group">
									<table id="tb-data" class="table table-hover table-bordered">
										<thead>
											<tr>
												<th>รหัสสินค้า</th>
												<th>ชื่อสินค้า</th>
												<th>ยี่ห้อสินค้า</th>
												<th>รุ่นสินค้า</th>
												<th>ขนาดสินค้า</th>
												<th>ราคา/หน่วย</th>
												<th>จำนวน</th>
												<th width="10%">รวม</th>
												<th>จัดการ</th>
											</tr>
										</thead>
										<tbody>
											<td colspan="9" align="center">ยังไม่มีรายการสินค้า</td>
										</tr>
									</tbody>
								</table>
								<label id="tb_data-error" class="error" for="tb_data">จำนวนสินค้าต้องมากกว่า0</label>
							</div>
							<br>
							<div id="btn-submit" class="align-center" hidden>
								<button class="btn btn-success waves-effect" type="button" onclick="confirmSubmit()">บันทึก</button>
								<button class="btn btn-default waves-effect" type="button" onclick="OnCancel();">ยกเลิก</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<div id="modal-load"></div>

	</div>
</section>
<?php include 'js.php';?>
</body>

</html>

<script>

	$(document).ready(function() {
		$('.error').hide();

		$(".numb").inputFilter(function(value) {
			return /^\d*$/.test(value); });
	});

	function getSupInfo(id){
		$.post( "process/ajax_response.php", { func: "getSupInfo", id: id }, function( data ) {

			$("#sup_address").val((data).sup_address);
			$("#province_name_th").val((data).province_name_th);
			$("#district_name_th").val((data).district_name_th);
			$("#subDistrict_name_th").val((data).subDistrict_name_th);

		}, "json");
	}

	function openModal(){
		var code = '';
		var name = '';
		$.post( "process/ajax_response.php", { func: "getProduct", code: code, name: name  }, function( data ) {
			var html = "";

			html += '<div class="modal fade" id="frm-modal" tabindex="-1" role="dialog">';
			html += '<div class="modal-dialog modal-lg" role="document">';
			html += '<div class="modal-content">';

			html += '<div class="modal-header">';
			html += '<h4 class="modal-title" id="largeModalLabel">ค้นหาสินค้า</h4>';
			html += '<form>';

			html += '<br><br><br>';
			html += '<div class="row">';

			html += '<div class="col-sm-4 col-sm-offset-1">';
			html += '<div class="form-group">';
			html += '<b>รหัสสินค้า</b>';
			html += '<div class="form-line">';
			html += '<input type="text" placeholder="รหัสสินค้า" id="s_productCode" name="s_productCode" class="form-control">';
			html += '</div>';
			html += '</div>';
			html += '</div>';

			html += '<div class="col-sm-4">';
			html += '<div class="form-group">';
			html += '<b>ชื่อสินค้า</b>';
			html += '<div class="form-line">';
			html += '<input type="text" placeholder="ชื่อสินค้า" id="s_productName" name="s_productName" class="form-control">';
			html += '</div>';
			html += '</div>';
			html += '</div>';

			html += '<div class="col-sm-2">';
			html += '<div class="form-group">';
			html += '<div class="text-center">';
			html += '<button type="button" class="btn btn-success waves-effect" onclick="searchData();"><span>ค้นหา</span><?php echo $img_view;?></button>';
			html += '</div>';
			html += '</div>';
			html += '</div>';

			html += '</div>';

			html += '</form>';
			html += '</div>';

			html += '<div class="modal-body">';
			html += '<div class="table-responsive">';
			html += '<table class="table table-bordered" id="tb-search">';
			html += '<thead>';
			html += '<tr>';
			html += '<th>รหัส</th>';
			html += '<th>ชื่อสินค้า</th>';
			html += '<th>ยี่ห้อ</th>';
			html += '<th>รุ่น</th>';
			html += '<th>ขนาด</th>';
			html += '<th>จัดการ</th>';
			html += '</tr>';
			html += '</thead>';
			html += '<tbody>';

			if(data){
				for(var i = 0; i < data.length; i++ ){
					html += '<tr>';
					html += '<td align="center">'+data[i].productCode+'</td>';
					html += '<td>'+data[i].productName+'</td>';
					html += '<td>'+data[i].brandID+'</td>';
					html += '<td>'+data[i].modelName+'</td>';
					html += '<td>'+data[i].productSize+'</td>';
					// html += '<td align="center"><button type="button" class="btn bg-grey waves-effect" onclick="addProduct(\''+data[i].productID+'\', \''+data[i].productCode+'\', \''+data[i].productName+'\', \''+data[i].brandID+'\', \''+data[i].modelName+'\', \''+data[i].productSize+'\');"><i class="material-icons">done</i></button></td>';
					html += '<td align="center"><button type="button" class="btn bg-grey waves-effect" onclick="addProduct(\''+data[i].productID+'\', \''+data[i].productCode+'\', \''+data[i].productName+'\', \''+data[i].brandID+'\', \''+data[i].modelName+'\', \''+data[i].productSize+'\');">เลือก</button></td>';
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
			html += '</div>';
			html += '</div>';

			html += '</div>';
			html += '</div>';
			html += '</div>';

			$("#modal-load").html(html);
			$("#tb-search").html(html);
			$("#frm-modal").modal('show');

		}, "json");

	}

	function searchData(){

		var code = $("#s_productCode").val();
		var name = $("#s_productName").val();
		$.post( "process/ajax_response.php", { func: "getProduct", code: code, name: name  }, function( data ) {

			var html = "";

			html += '<div class="table-responsive">';
			html += '<table class="table table-bordered" id="tb-search">';
			html += '<thead>';
			html += '<tr>';
			html += '<th>รหัส</th>';
			html += '<th>ชื่อสินค้า</th>';
			html += '<th>ยี่ห้อ</th>';
			html += '<th>รุ่น</th>';
			html += '<th>ขนาด</th>';
			html += '<th>จัดการ</th>';
			html += '</tr>';
			html += '</thead>';
			html += '<tbody>';

			if(data){
				for(var i = 0; i < data.length; i++ ){
					html += '<tr>';
					html += '<td align="center">'+data[i].productCode+'</td>';
					html += '<td>'+data[i].productName+'</td>';
					html += '<td>'+data[i].brandID+'</td>';
					html += '<td>'+data[i].modelName+'</td>';
					html += '<td>'+data[i].productSize+'</td>';
					// html += '<td align="center"><button type="button" class="btn bg-grey waves-effect" onclick="addProduct(\''+data[i].productID+'\', \''+data[i].productCode+'\', \''+data[i].productName+'\', \''+data[i].brandID+'\', \''+data[i].modelName+'\', \''+data[i].productSize+'\');"><i class="material-icons">done</i></button></td>';
					html += '<td align="center"><button type="button" class="btn bg-grey waves-effect" onclick="addProduct(\''+data[i].productID+'\', \''+data[i].productCode+'\', \''+data[i].productName+'\', \''+data[i].brandID+'\', \''+data[i].modelName+'\', \''+data[i].productSize+'\');">เลือก</button></td>';
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
			html += '</div>';

			$("#tb-search").html(html);

		}, "json");

	}

	function addProduct(productID, productCode, productName, brandID, modelName, productSize){

		var html = "";

		if($("#tb-data tbody tr td").attr("colspan")){
			$("#tb-data tbody").html("");
			$("#btn-submit").show();

			var tfoot_html = "";
			tfoot_html += '<tr>';
			tfoot_html += '<td colspan="7" align="center">รวมสุทธิ</td>';
			tfoot_html += '<td align="right"></td>';
			tfoot_html += '<td><input type="hidden" id="total" name="total"></td>';
			tfoot_html += '</tr>';
			$("#tb-data tfoot").html(tfoot_html);
		}

		html += '<tr>';
		html += '<td align="center">'+productCode+'<input type="hidden" name="productID['+productID+']" value="'+productID+'"></td>';
		html += '<td>'+productName+'</td>';
		html += '<td>'+brandID+'</td>';
		html += '<td>'+modelName+'</td>';
		html += '<td>'+productSize+'</td>';
		html += '<td><div class="form-line"><input type="text" value="1" name="price['+productID+']" class="form-control text-right numb" onblur="NumberFormat(this);calUnitPrice(this);" required></div></td>';
		html += '<td><div class="form-line"><input type="text" value="1" id="qty['+productID+']" name="qty['+productID+']" class="form-control text-right numb" onblur="NumberFormat(this);calUnitPrice(this);get_nozero(this);" required></div></td>';
		// html += '<td><div class="form-line"><input type="text" value="1.00" name="amount['+productID+']" class="form-control text-right" readonly></div></td>';
		html += '<td align="right">1.00</td>';
		html += '<td align="center"><button type="button" class="btn bg-red waves-effect" onclick="removeProduct(this);"><i class="material-icons">delete_forever</i></button></td>';
		html += '</tr>';

		var obj_id = $("#tb-data tbody tr");
		$.each(obj_id, function(){
			if(($(this).find('td:eq(0)').text()).toString() == (productCode).toString()){
				html = "";
				alert("มีสินค้านี้ในรายการสั่งซื้อแล้ว");
				return false;
			}
		});

		if(html != "") $("#frm-modal").modal('hide');
		$("#tb-data tbody").append(html);

		$(".numb").inputFilter(function(value) {
			return /^\d*$/.test(value); });
		calTotal();
	}

	function removeProduct(obj){
		$(obj).parent().parent().remove();

		if($("#tb-data tbody tr").length < 1){
			var html = "";
			html += '<tr><td colspan="9" align="center">ยังไม่มีรายการสินค้า</td></tr>';
			$("#tb-data tbody").html(html);
			$("#tb-data tfoot").html("");
			$("#btn-submit").hide();
		}
	}

	function calUnitPrice(obj){
		var price = $(obj).parent().parent().parent().find('td:eq(5) input').val();
		var qty = $(obj).parent().parent().parent().find('td:eq(6) input').val();
		var amount = price*qty;
		// $(obj).parent().parent().parent().find('td:eq(7) input').val((amount).toFixed(2));
		$(obj).parent().parent().parent().find('td:eq(7)').text(addCommas((amount).toFixed(2)));
		calTotal();
	}

	function calTotal(){
		// var obj_amount = $("input[name^='amount[']");
		var obj_amount = $("#tb-data tbody tr").find("td:eq(7)");
		var total = 0;
		$.each(obj_amount, function(){
			// alert($(this).val());
			// alert($(this).text());
			// total += parseFloat($(this).val());
			total += parseFloat(($(this).text().replace(/,/g,"")));
		});
		$("#tb-data tfoot td:eq(1)").text(addCommas((total).toFixed(2)));
		$("#total").val((total));
	}

	function confirmSubmit(){

		if($('#supID').val() == ''){
			$('#supID_error').show();
			  return false;
    }else{
		$('#supID_error').hide();
	}

		var arr = $('input[id^=qty]');
		for (var i = 0; i < arr.length; i++) {
			var num = parseInt($(arr[i]).val().trim().replace(/,/g,''));
			if (num == 0) {
				$('#tb_data-error').show();
				return false;
			}
		}

		$("#frm-input").attr("action", "process/order_process.php");
		if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
			$("#frm-input").submit();
		}
	}

	function OnCancel(){
		$(location).attr('href',"<?php echo  $form_page?>");
	}
	function  get_nozero(odj){
		// var arr = $('input[id^=qty]');
		// for (var i = 0; i < arr.length; i++) {
			var num = parseInt($(odj).val().trim().replace(/,/g,''));
			if (num == 0) {
				$('#tb_data-error').show();
				return false;
			}
		// }
	}

</script>
