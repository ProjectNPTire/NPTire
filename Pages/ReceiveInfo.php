<!DOCTYPE html>
<html>

<?php
$path = "../";
include($path."include/config_header_top.php");
include 'css.php';
$page_key ='3_2';

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
                                                <input type="text" id="poID" name="poID" class="form-control" placeholder="EX: PO-19010001" onkeypress="chkEnter(event)">
                                            </div>
											<label id="poID_error" class="error" for="poID">ไม่พบข้อมูลใบสั่งซื้อ</label>
											<label id="poID2_error" class="error" for="poID">ใบสั่งซื้อนี้ถูกยกเลิก</label>
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

	    $(".numb").inputFilter(function(value) {
			return /^\d*$/.test(value); });
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
					$('#poID2_error').show();
				}else{
					var html = "";

					html += '<div class="form-group">';
					html += '<table id="tb-data" class="table table-bordered">';
					html += '<thead>';
					html += '<tr>';
					html += '<th>ลำดับ</th>';
					html += '<th style="text-align:left">รหัสสินค้า</th>';
					html += '<th style="text-align:left">ชื่อสินค้า</th>';
					html += '<th style="text-align:right">ราคา/ชิ้น</th>';
					html += '<th style="text-align:right">จำนวน</th>';
					html += '<th style="text-align:right">รวม</th>';
					html += '<th style="text-align:right">รับแล้ว</th>';
					html += '<th style="text-align:right">ค้างรับ</th>';
					html += '<th width="10%" style="text-align:right">รับเข้า</th>';
					html += '<th style="text-align:left">ตำแหน่งเก็บ</th>';
					html += '</tr>';
					html += '</thead>';
					html += '<tbody>';

					if(data["po_desc"]){
						for(var i = 0; i < data["po_desc"].length; i++ ){

							var received_qty = (data["po_desc"][i].received_qty) ? data["po_desc"][i].received_qty : 0 ;

							html += '<tr>';
							html += '<td align="center">'+(i+1)+'</td>';
							html += '<td>'+data["po_desc"][i].productCode+'</td>';
							html += '<td>'+data["po_desc"][i].productName+'</td>';
							html += '<td align="right">'+addCommas(data["po_desc"][i].price)+'</td>';
							html += '<td align="right">'+addCommas(data["po_desc"][i].qty)+'</td>';
							html += '<td align="right">'+addCommas(data["po_desc"][i].amount)+'</td>';
							html += '<td align="right">'+addCommas(received_qty)+'</td>';
							html += '<td align="right">'+addCommas(data["po_desc"][i].qty - data["po_desc"][i].received_qty)+'</td>';
							html += '<td align="right"><div class="form-line"><input type="text" maxlength="'+addCommas(data["po_desc"][i].qty - data["po_desc"][i].received_qty).length+'" value="'+addCommas(data["po_desc"][i].qty - data["po_desc"][i].received_qty)+'" id="qty['+data["po_desc"][i].productID+']" name="qty['+data["po_desc"][i].productID+']" class="form-control text-right numb" onblur="NumberFormat(this);checkReceiveQTY(this);" required></div></td>';
							html += '<td align="right">';
							html += '<select name="locationID['+data["po_desc"][i].productID+']" class="form-control show-tick" data-live-search="true">';

							for (var j = 0; j < data["location"].length; j++) {
								html += '<option value="'+data["location"][j].locationID+'">'+data["location"][j].locationName+'</option>';
							}
							html += '</select>';
							html += '</td>';
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
