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
							<h2>ข้อมูลสั่งซื้อสินค้า</h2>
						</div>
						<div class="body">
							<form id="" method="POST">
								<div class="row clearfix">
									<div class="col-sm-3">
										<div class="form-group form-float">
											<b>เลขที่ใบสั่งซื้อ*</b>
											<div class="form-line">
												<input type="text" name="txtName" class="form-control" required>
											</div>
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group form-float">
											<b>วันที่สั่งซื้อ*</b>
											<div class="form-line">
												<input type="text" name="txtName" class="form-control" required>
											</div>
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group form-float">
											<b>คู่ค้า*</b>
											<select class="form-control show-tick">
												<option value="0">บริษัท มิชเชอลิน จำกัด</option>
												<option value="1">บริษัท โยโกอาม่า จำกัด</option>
											</select>	
										</div>
									</div>
									<div class="col-sm-2">
										<div class="icon-and-text-button-demo">
											<button type="button" class="btn btn-primary waves-effect" data-toggle="modal" data-target="#largeModal">
												<span>เพิ่มสินค้า</span>
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
			<!-- Large Size -->
			<div class="modal fade" id="largeModal" tabindex="-1" role="dialog">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title" id="largeModalLabel">รายการสินค้า</h4>
						</div>
						<div class="modal-body">
							<div class="table-responsive">
								<table class="table">
									<thead>
										<tr>
											<th>ลำดับ</th>
											<th>รหัส</th>
											<th>ชื่อ</th>
											<th>ยี่ห้อ</th>
											<th>รุ่น</th>
											<th>ขนาด</th>
											<th>หน่วย</th>
											<th>จำนวน</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>1</td>
											<td>PD001</td>
											<td>TOYO PROXES ST3 III</td>
											<td>TOYO</td>
											<td>PROXES ST3 III</td>
											<td>15นิ้ว</td>
											<td>ชุดx4</td>
											<td>
												<div class="form-line">
													<input type="number" min="1" value="1" name="txtName" class="form-control" required>
												</div>
											</td>
											<td>
												<button type="button" class="btn bg-grey waves-effect">
													<i class="material-icons">done</i>
												</button>
											</td>
										</tr>
										<tr>
											<td>2</td>
											<td>PD002</td>
											<td>YOKOHAMA ADVAN dB Decibel V551</td>
											<td>YOKOHAMA</td>
											<td>ADVAN Decibel V551</td>
											<td>15 นิ้ว</td>
											<td>ชุดx4</td>
											<td>
												<div class="form-line">
													<input type="number" min="1" value="1" name="txtName" class="form-control" required>
												</div>
											</td>
											<td>
												<button type="button" class="btn bg-grey waves-effect">
													<i class="material-icons">done</i>
												</button>
											</td>
										</tr>
										<tr>
											<td>3</td>
											<td>PD003</td>
											<td>COSMIS-XT-005R Eco (ขอบ15″)</td>
											<td>COSMIS</td>
											<td>XT-005R</td>
											<td>15 นิ้ว</td>
											<td>ชุดx4</td>
											<td>
												<div class="form-line">
													<input type="number" min="1" value="1" name="txtName" class="form-control" required>
												</div>
											</td>
											<td>
												<button type="button" class="btn bg-grey waves-effect">
													<i class="material-icons">done</i>
												</button>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-link waves-effect">SAVE CHANGES</button>
							<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php include 'js.php';?>
</body>

</html>
