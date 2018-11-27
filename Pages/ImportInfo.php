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
							<h2>ข้อมูลรับเข้าสินค้า</h2>
						</div>
						<div class="body">
							<form id="" method="POST">
								<div class="row clearfix">
									<div class="col-sm-5">
										<div class="form-group form-float">
											<b>เลขที่ใยนำเข้า*</b>
											<div class="form-line">
												<input type="text" name="txtName" class="form-control" required>
											</div>
										</div>
									</div>
									<div class="col-sm-5">
										<div class="form-group form-float">
											<b>วันที่นำเข้า*</b>
											<div class="form-line">
												<input type="text" name="txtName" class="form-control" required>
											</div>
										</div>
									</div>
									<div class="col-sm-2">
										<div class="icon-and-text-button-demo">
											<button type="button" class="btn btn-primary waves-effect">
												<span>เพิ่มเอกสาร</span>
												<i class="material-icons">add_box</i>
											</button>
										</div>
									</div>
								</div>
								<div class="table-responsive">
									<table class="table table-hover">
										<thead>
											<tr>
												<th>ลำดับ</th>
												<th>รหัสสินค้า</th>
												<th>ชื่อสินค้า</th>
												<th>ยี่ห้อสินค้า</th>
												<th>รุ่นสินค้า</th>
												<th>ขนาดสินค้า</th>
												<th>หน่วยนับ</th>
												<th>ตำแหน่ง</th>
												<th></th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>1</td>
												<td>TOYO PROXES ST3 III</td>
												<td>TOYO PROXES</td>
												<td>TOYO</td>
												<td>PROXES ST3 III</td>
												<td>15นิ้ว</td>
												<td>ชุดx4</td>
												<td>
													<select class="form-control show-tick">
														<option value="0">ห้องเก็บของ1</option>
														<option value="1">ห้องเก็บของ2</option>
														<option value="1">ห้องเก็บของ3</option>
													</select>
												</td>
												<td>
													<button type="button" class="btn bg-red waves-effect">
														<i class="material-icons">delete_forever</i>
													</button>
												</td>
											</tr>
											<tr>
												<td>2</td>
												<td>YOKOHAMA ADVAN dB Decibel V551</td>
												<td>YOKOHAMA ADVAN</td>
												<td>YOKOHAMA</td>
												<td>ADVAN Decibel V551</td>
												<td>15 นิ้ว</td>
												<td>ชุดx4</td>
												<td>
													<select class="form-control show-tick">
														<option value="0">ห้องเก็บของ1</option>
														<option value="1">ห้องเก็บของ2</option>
														<option value="1">ห้องเก็บของ3</option>
													</select>
												</td>
												<td>
													<button type="button" class="btn bg-red waves-effect">
														<i class="material-icons">delete_forever</i>
													</button>
												</td>
											</tr>
											<tr>
												<td>3</td>
												<td>COSMIS-XT-005R Eco</td>
												<td>COSMIS XT-005R Eco (ขอบ15″)</td>
												<td>COSMIS</td>
												<td>XT-005R</td>
												<td>15 นิ้ว</td>
												<td>ชุดx4</td>
												<td>
													<select class="form-control show-tick">
														<option value="0">ห้องเก็บของ1</option>
														<option value="1">ห้องเก็บของ2</option>
														<option value="1">ห้องเก็บของ3</option>
													</select>
												</td>
												<td>
													<button type="button" class="btn bg-red waves-effect">
														<i class="material-icons">delete_forever</i>
													</button>
												</td>
											</tr>
										</tbody>
									</table>
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
