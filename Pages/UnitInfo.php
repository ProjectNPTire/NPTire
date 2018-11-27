<!DOCTYPE html>
<html>

<?php include 'css.php';?>

<body class="theme-red">
	<?php include 'MasterPage.php';?>

	<section class="content">
		<div class="container-fluid">
			<div class="row clearfix">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="card">
						<div class="header">
							<h2>ข้อมูลหน่วยสินค้า</h2>
						</div>
						<div class="body">
							<form id="" method="POST">
								<div class="form-group form-float">
									<b>รหัสหน่วยสินค้า*</b>
									<div class="form-line">
										<input type="text" name="txtName" class="form-control" required>
									</div>
								</div>
								<div class="form-group form-float">
									<b>ชื่อหน่วยสินค้า*</b>
									<div class="form-line">
										<input type="text" name="txtName" class="form-control" placeholder="ตัวอย่าง: ชื่อxจำนวน" required>
									</div>
								</div>
								<div class="form-group form-float">
									<b>จำนวนต่อหน่วย*</b>
									<div class="form-line">
										<input type="number" min="1" name="txtName" class="form-control" required>
									</div>
								</div>
								<div class="form-group form-float">
									<b>การใช้งาน</b>
									<select class="form-control show-tick">
										<option value="0">ใช้งาน</option>
										<option value="1">ไม่ใช้งาน</option>
									</select>
								</div>
								<div class="align-center">
									<button class="btn btn-success waves-effect" type="submit">บันทึก</button>
									<button class="btn btn-default waves-effect" type="button">ยกเลิก</button>
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
