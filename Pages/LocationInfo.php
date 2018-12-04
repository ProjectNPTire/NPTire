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
							<h2>ข้อมูลตำแหน่งจัดเก็บสินค้า</h2>
						</div>
						<div class="body">
							<form id="" method="POST">
								<div class="form-group form-float">
									<b>รหัสตำแหน่งจัดเก็บสินค้า*</b>
									<div class="form-line">
										<input type="text" name="txtName" class="form-control" required>
									</div>
								</div>
								<div class="form-group form-float">
									<b>ชื่อตำแหน่งจัดเก็บสินค้า*</b>
									<div class="form-line">
										<input type="text" name="txtName" class="form-control" required>
									</div>
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
