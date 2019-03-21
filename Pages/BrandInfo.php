<!DOCTYPE html>
<html>

<?php $path = "../";
include($path."include/config_header_top.php");
include 'css.php';
$page_key ='2_2';
$sql     = " SELECT *
FROM tb_brand
where brandID ='".$brandID."' ";

$query = $db->query($sql);
$nums = $db->db_num_rows($query);
$rec = $db->db_fetch_array($query);
$proc = ($proc=='')?"add":$proc;
$txt =  ($proc=='add')?"เพิ่ม":"แก้ไข";
$readonly = "readonly";
T

?>

<body class="theme-red">
	<?php include 'MasterPage.php';?>

	<section class="content">
		<div class="container-fluid">
			<div class="row clearfix">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="card">
						<div class="header">
							<h2><?php echo $txt;?>ข้อมูลยี่ห้อสินค้า</h2>
						</div>
						<form id="frm-input" method="post" enctype="multipart/form-data" action="process/brand_process.php" >
							<input type="hidden" id="proc" name="proc" value="<?php echo $proc;?>">
							<input type="hidden" id="brandID" name="brandID" value="<?php echo $brandID;?>">
							<input type="hidden" id="form_page" name="form_page" value="<?php echo  $form_page?>">
							<input type="hidden" id="chk" name="chk" value="0">
							<input type="hidden" id="chk2" name="chk2" value="0">
							<div class="body">
								<div class="row clearfix">
									<div class="col-sm-12">
										<b>รหัสยี่ห้อสินค้า <span style="color:red"> *</span></b>
										<div class="form-group">
											<div class="form-line">
												<input type="text " <?php echo $readonly ?> name="brandCode" id="brandCode" class="form-control" value="<?php echo $rec['brandCode'];?>">
											</div>
										</div>
									</div>
								</div>
								<div class="row clearfix">
									<div class="col-sm-12">
										<b>ชื่อยี่ห้อสินค้า <span style="color:red"> *</span></b>
										<div class="form-group">
											<div class="form-line">
												<input type="text " onkeyup="chk1();" name="brandName" id="brandName" class="form-control" placeholder="ชื่อยี่ห้อสินค้า" value="<?php echo $rec['brandName'];?>">
											</div>
											<label id="brandName-error" class="error" for="brandName">กรุณาระบุ ชื่อยี่ห้อสินค้า</label>
											<label id="brandName2-error" class="error" for="brandName">มีชื่อยี่ห้อสินค้านี้แล้ว</label>
										</div>
									</div>
								</div>
								<div class="row clearfix">
									<div class="col-sm-12">
										<b>ชื่อย่อยี่ห้อสินค้า <span style="color:red"> *</span></b>
										<div class="form-group">
											<div class="form-line">
												<input type="text" maxlength="2" onkeyup="chk2();" name="brandName_short" id="brandName_short" class="form-control" placeholder="ชื่อย่อยี่ห้อสินค้า" value="<?php echo $rec['brandName_short'];?>">
											</div>
											<label id="brandName_short-error" class="error" for="brandName_short">กรุณาระบุ ชื่อย่อ</label>
											<label id="brandName_short2-error" class="error" for="brandName_short">มีชื่อย่อนี้แล้ว</label>
										</div>
									</div>
								</div>
								<div class="row clearfix">
									<div class="col-sm-12">
										<b>รายละเอียด </b>
										<div class="form-group">
											<div class="form-line">
												<textarea  class="form-control" placeholder="รายละเอียด" id="brandDetail" name="brandDetail"> <?php echo $rec['brandDetail'];?> </textarea>
											</div>
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



		if($('#brandName').val()==''){
			$('#brandName-error').show();
			$('#brandName').focus();
			return false;
		}else{
			$('#brandName-error').hide();
		}

		if($('#brandName_short').val()==''){
			$('#brandName_short-error').show();
			$('#brandName_short').focus();
			return false;
		}else{
			$('#brandName_short-error').hide();
		}

		if($('#chk').val()==1){
			return false;
		}

if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
			$("#frm-input").submit();
		}
	}

	$(document).ready(function() {

		$('.error').hide();

		if($('#proc').val()=='add'){
          var brandCode	 ='';
          $.ajaxSetup({async: false});
          $.post('process/get_process.php',{proc:'get_brandCode'},function(data){
           brandCode =  data['name'];
         },'json');
          $('#brandCode').val(brandCode);
        }

	});

	function chk1(){
		var brandName= $('#brandName').val();
		var brandID= $('#brandID').val();
		$.ajaxSetup({async: false});
		$.post('process/get_process.php',{proc:'chk_brandName',brandName:brandName,brandID:brandID},function(data){
			if(data==1){
				$('#brandName2-error').show();
				$('#chk').val(1);
			}else{
				$('#brandName2-error').hide();
				$('#chk').val(0);

			}

		},'json');
	}

	function chk2(){
		var brandName_short= $('#brandName_short').val();
		var brandID= $('#brandID').val();
		$.ajaxSetup({async: false});
		$.post('process/get_process.php',{proc:'chk_brandName_short',brandName_short:brandName_short,brandID:brandID},function(data){
			if(data==1){
				$('#brandName_short2-error').show();
				$('#chk2').val(1);
			}else{
				$('#brandName_short2-error').hide();
				$('#chk2').val(0);

			}

		},'json');
	}

//username2
</script>
