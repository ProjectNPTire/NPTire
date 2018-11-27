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
							<h2>ข้อมูลสินค้า</h2>
						</div>
						<div class="body">
							<form id="" method="POST">
								<div class="form-group form-float">
									<b>รหัสสินค้า*</b>
									<div class="form-line">
										<input type="text" name="txtName" class="form-control" required>
									</div>
								</div>
								<div class="form-group form-float">
									<b>ชื่อสินค้า*</b>
									<div class="form-line">
										<input type="text" name="txtName" class="form-control" placeholder="ตัวอย่าง: ชื่อxจำนวน" required>
									</div>
								</div>
								<div class="form-group form-float">
									<b>ยี่ห้อ</b>
									<select class="form-control show-tick">
										<option value="0">ใช้งาน</option>
										<option value="1">ไม่ใช้งาน</option>
									</select>
								</div>
								<div class="form-group form-float">
									<b>รุ่น</b>
									<select class="form-control show-tick">
										<option value="0">ใช้งาน</option>
										<option value="1">ไม่ใช้งาน</option>
									</select>
								</div>
								<div class="form-group form-float">
									<b>หน้ากว้าง*</b>
									<div class="form-line">
										<input type="text" name="txtName" class="form-control" required>
									</div>
								</div>
								<div class="form-group form-float">
									<b>ขอบล้อ*</b>
									<div class="form-line">
										<input type="text" name="txtName" class="form-control" required>
									</div>
								</div>
								<div class="form-group form-float">
									<b>จุดสั่งซื้อ*</b>
									<div class="form-line">
										<input type="text" name="txtName" class="form-control" required>
									</div>
								</div>
								<div class="form-group form-float">
									<b>การใช้งาน</b>
									<select class="form-control show-tick">
										<option value="0">ใช้งาน</option>
										<option value="1">ไม่ใช้งาน</option>
									</select>
								</div>
								<div class="form-group">
									<b>รายละเอียด</b>
									<div class="form-line">
										<textarea rows="1" class="form-control no-resize auto-growth" required></textarea>
									</div>
								</div>
								<div class="form-group form-float">
									<b>รูปภาพ</b>
									<input type="file" name="fileToUpload" id="fileToUpload">
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
