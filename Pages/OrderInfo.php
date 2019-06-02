<!DOCTYPE html>
<html>

<?php
$path = "../";
include($path."include/config_header_top.php");
include 'css.php';
$page_key ='4_1';


$getsupID =$_GET['supID'];
$getproductID =$_GET['productID'];
$getproductCode =$_GET['productCode'];
$getproductName =$_GET['productName'];
$getbrandName =$_GET['brandName'];
$getmodelName =$_GET['modelName'];
$getproductSize =$_GET['productSize'];

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
								<input type="hidden" id="hdfsupID" name="hdfsupID" value="<?php echo $getsupID; ?>">
								<input type="hidden" id="hdfproductID" name="hdfproductID" value="<?php echo $getproductID; ?>">
								<input type="hidden" id="hdfproductCode" name="hdfproductCode" value="<?php echo $getproductCode; ?>">
								<input type="hidden" id="hdfproductName" name="hdfproductName" value="<?php echo $getproductName; ?>">
								<input type="hidden" id="hdfbrandName" name="hdfbrandName" value="<?php echo $getbrandName; ?>">
								<input type="hidden" id="hdfmodelName" name="hdfmodelName" value="<?php echo $getmodelName; ?>">
								<input type="hidden" id="hdfproductSize" name="hdfproductSize" value="<?php echo $getproductSize; ?>">

								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<b>เลขที่ใบสั่งซื้อ </b>
											<div class="form-line">
												<input type="text" class="form-control" id="txt_po" name="txt_po" value="<?php echo $txt_po; ?>">
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<b>บริษัทคู่ค้า <span style="color:red"> *</span></b>
											<div class="form-group form-float">
												<select name="supID" id="supID" class="form-control show-tick" data-live-search="true" onchange="getSupInfo(this.value);">
													<option value="">เลือก</option>
													<?php
													$sql_sup=" SELECT * from tb_supplier order by sup_name asc";
													$query_sup = $db->query($sql_sup);
													//$num_sup = $db->db_num_rows($query_sup);
													while($rec_sup = $db->db_fetch_array($query_sup)){?>
														<option value="<?php echo $rec_sup['supID'];?>"  <?php echo ($rec_sup['supID']==$getsupID	)?"selected":"";?>> <?php echo $rec_sup['sup_name'];?></option>

													<?php }  ?>
												</select>
											</div>											
											<input type="hidden" name="hdfsupName" id="hdfsupName" value="">
											<label id="supID_error" class="error" for="supID_error">กรุณาเลือก บริษัทคู่ค้า</label>
										</div>
									</div>
								<!-- 	<div class="col-sm-8">
										<div class="form-group">
											<b>ที่อยู่ </b>
											<div class="form-line">
												<input type="text" class="form-control" id="sup_address" name="sup_address" value="" readonly>
											</div>
										</div>
									</div> -->
								</div>

							<!-- 	<div class="row">
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
								</div> -->

								<div class="icon-and-text-button-demo align-right">
									<button type="button" class="btn btn-primary waves-effect" onclick="openModal();">
										<span>เพิ่มสินค้า</span>
										<i class="material-icons">add_box</i>
									</button>
								</div>
								<div class="form-group">
									<table id="tb-data" class="table table-hover table-bordered">
										<thead>
											<tr>
												<th align="center">รหัสสินค้า</th>
												<th align="center">ชื่อสินค้า</th>
												<th align="center">ประเภท</th>
												<th align="center">ยี่ห้อ</th>
												<th width="15%" align="center">คุณลักษณะ</th>
												<th width="10%" align="right;">ราคา/หน่วย</th>
												<th width="10%" align="right;">จำนวน</th>
												<th width="10%" align="right;">รวม</th>
												<th></th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td colspan="9" align="center">ยังไม่มีรายการสินค้า</td>
											</tr>
										</tbody>
										<tfoot>
										</tfoot>
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
		var supID = $('#hdfsupID').val();
		var productID = $('#hdfproductID').val();
		var productCode = $('#hdfproductCode').val();
		var productName = $('#hdfproductName').val();
		var brandName = $('#hdfbrandName').val();
		var modelName = $('#hdfmodelName').val();
		var productSize = $('#hdfproductSize').val();
		if (supID != "") {
			getSupInfo(supID);
			addProduct(productID, productCode, productName, brandName, modelName, productSize);
		}
		$('.error').hide();

		$(".numb").inputFilter(function(value) {
			return /^\d*$/.test(value); });

		if($('#proc').val()=='add'){
			var poID	 ='';
			$.ajaxSetup({async: false});
			$.post('process/get_process.php',{proc:'get_poID'},function(data){
				poID =  data['name'];
			},'json');
			$('#txt_po').val(poID);
		}
	});

	function getSupInfo(id){

		$("#tb-data tbody tr").html("<td colspan='9' align='center'>ยังไม่มีรายการสินค้า</td>");
		$("#tb-data tfoot").html("");
		$("#btn-submit").hide();
		$.post( "process/ajax_response.php", { func: "getSupInfo", id: id }, function( data ) {

			//$("#sup_address").val((data).sup_address);
			//$("#province_name_th").val((data).province_name_th);
			// $("#district_name_th").val((data).district_name_th);
			// $("#subDistrict_name_th").val((data).subDistrict_name_th);
			$("#hdfsupName").val((data).sup_name);


		}, "json");
	}

	function openModal(){
		var supID = $('#supID').val();
		if(supID == ''){
			$('#supID_error').show();
			return false;
		}else{
			$('#supID_error').hide();
		}
		var code = '';
		var name = '';
		var sup_name = $('#hdfsupName').val();

		$.post( "process/ajax_response.php", { func: "getProduct", code: code, name: name,supID: supID  }, function( data ) {
			console.log(data);
			var html = "";

			html += '<div class="modal fade" id="frm-modal" tabindex="-1" role="dialog">';
			html += '<div class="modal-dialog modal-lg" role="document">';
			html += '<div class="modal-content">';

			html += '<div class="modal-header">';
			html += '<div class="col-sm-2">';
			html += '<h4 class="modal-title" id="largeModalLabel">ค้นหาสินค้า</h4>';
			html += '</div>';
			html += '<div class="col-sm-10 align-right">';
			html += '<b>บริษัทคู่ค้า: '+sup_name+'</b>';
			html += '</div>';
			html += '</div>'; //header

			html += '<div class="modal-body">';

			html += '<div class="row">';
			html += '<div class="col-sm-4 col-sm-offset-1">';
			html += '<div class="form-group">';
			// html += '<b>รหัสสินค้า</b>';
			html += '<div class="form-line">';
			html += '<input type="text" placeholder="รหัสสินค้า" id="s_productCode" name="s_productCode" class="form-control">';
			html += '</div>';
			html += '</div>';
			html += '</div>';

			html += '<div class="col-sm-4">';
			html += '<div class="form-group">';
			// html += '<b>ชื่อสินค้า</b>';
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
			html += '</div>'; //row

			// html += '<div class="table-responsive">';
			html += '<table class="table table-bordered" id="tb-search">';
			html += '<thead>';
			html += '<tr>';
			html += '<th width="5%">ลำดับ</th>';
			html += '<th width="10%">รหัสสินค้า</th>';
			html += '<th width="30%">ชื่อสินค้า</th>';
			html += '<th width="15%">ประเภท</th>';
			html += '<th width="10%">ยี่ห้อ</th>';
			html += '<th width="20%">คุณลักษณะ</th>';
			html += '<th width="5%">จำนวน</th>';
			html += '<th width="5%">จุดสั่งซื้อ</th>';
			html += '<th width="10%"></th>';
			html += '</tr>';
			html += '</thead>';
			html += '<tbody>';

			if(data){

				/* if(data){
					
					
				} */
				for(var i = 0; i < data.length; i++ ){
					var index = i+1;
					html += '<tr>';
					html += '<td align="center">'+index+'</td>';
					html += '<td>'+data[i].productCode+'</td>';
					html += '<td>'+data[i].productName+'</td>';
					html += '<td>'+data[i].productTypeName+'</td>';
					html += '<td>'+data[i].brandName+'</td>';
					html += '<td>'+data[i].attr+'</td>';
					html += '<td align="right">'+data[i].productUnit+'</td>';
					html += '<td align="right">'+data[i].orderPoint+'</td>';
					html += '<td align="center"><button type="button" class="btn bg-grey waves-effect" onclick="addProduct(\''+data[i].productID+'\', \''+data[i].productCode+'\', \''+data[i].productName+'\', \''+data[i].productTypeName+'\', \''+data[i].brandName+'\', \''+data[i].attr+'\');">เลือก</button></td>';
					html += '</tr>';
				}
			}
			else {
				html += '<tr>';
				html += '<td colspan="8" align="center">ไม่พบข้อมูล</td>';
				html += '</tr>';
			}

			html += '</tbody>';
			html += '</table>';

			html += '</div>'; // body

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
		var supID = $('#supID').val();
		$.post( "process/ajax_response.php", { func: "getProduct", code: code, name: name,supID: supID  }, function( data ) {

			var html = "";

			html += '<div class="table-responsive">';
			html += '<table class="table table-bordered" id="tb-search">';
			html += '<thead>';
			html += '<tr>';
			html += '<th width="5%">ลำดับ</th>';
			html += '<th width="10%">รหัสสินค้า</th>';
			html += '<th width="30%">ชื่อสินค้า</th>';
			html += '<th width="15%">ประเภท</th>';
			html += '<th width="10%">ยี่ห้อ</th>';
			html += '<th width="20%">คุณลักษณะ</th>';
			html += '<th width="5%">จำนวน</th>';
			html += '<th width="5%">จุดสั่งซื้อ</th>';
			html += '<th width="10%"></th>';
			html += '</tr>';
			html += '</thead>';
			html += '<tbody>';

			if(data){
				for(var i = 0; i < data.length; i++ ){
					var index = i+1;
					html += '<tr>';
					html += '<td align="center">'+index+'</td>';
					html += '<td>'+data[i].productCode+'</td>';
					html += '<td>'+data[i].productName+'</td>';
					html += '<td>'+data[i].productTypeName+'</td>';
					html += '<td>'+data[i].brandName+'</td>';
					html += '<td>'+data[i].attr+'</td>';
					html += '<td align="right">'+data[i].productUnit+'</td>';
					html += '<td align="right">'+data[i].orderPoint+'</td>';
					html += '<td align="center"><button type="button" class="btn bg-grey waves-effect" onclick="addProduct(\''+data[i].productID+'\', \''+data[i].productCode+'\', \''+data[i].productName+'\', \''+data[i].productTypeName+'\', \''+data[i].brandName+'\', \''+data[i].attr+'\');">เลือก</button></td>';
					html += '</tr>';
				}
			}
			else {
				html += '<tr>';
				html += '<td colspan="8" align="center">ไม่พบข้อมูล</td>';
				html += '</tr>';
			}

			html += '</tbody>';
			html += '</table>';
			html += '</div>';

			$("#tb-search").html(html);

		}, "json");

	}

	function addProduct(productID, productCode, productName,productTypeName, brandName, attr){

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
		html += '<td>'+productTypeName+'</td>';
		html += '<td>'+brandName+'</td>';
		html += '<td>'+attr+'</td>';;
		html += '<td><div class="form-line"><input type="text" value="1" name="price['+productID+']" class="form-control text-right numb" onblur="calUnitPrice(this);" required></div></td>';
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
			return /^\d*$/.test(value);
		});
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
		
		var price = Number($(obj).parent().parent().parent().find('td:eq(5) input').val().replace(/[^0-9.-]+/g,""));;
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
