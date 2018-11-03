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
							<h2>ข้อมูลเบิกินค้า</h2>
						</div>
						<div class="body">
							<form id="" method="POST">
								<div class="row clearfix">
									<div class="col-sm-5">
										<div class="form-group form-float">
											<b>เลขที่ใบเบิก*</b>
											<div class="form-line">
												<input type="text" name="txtName" class="form-control" required>
											</div>
										</div>
									</div>
									<div class="col-sm-5">
										<div class="form-group form-float">
											<b>วันที่เบิก*</b>
											<div class="form-line">
												<input type="text" name="txtName" class="form-control" required>
											</div>
										</div>
									</div>
									<div class="col-sm-2">
										<div class="icon-and-text-button-demo">
											<button type="button" class="btn btn-primary waves-effect">
												<span>เพิ่มสินค้า</span>
												<i class="material-icons">add_box</i>
											</button>
										</div>
									</div>
								</div>
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
												<th>ตำแหน่ง</th>
												<th></th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>Tiger Nixon</td>
												<td>System Architect</td>
												<td>Edinburgh</td>
												<td>61</td>
												<td>2011/04/25</td>
												<td>$320,800</td>
												<td>
													<select class="form-control show-tick">
														<option value="0">ใช้งาน</option>
														<option value="1">ไม่ใช้งาน</option>
													</select>
												</td>
												<td>
													<button type="button" class="btn bg-red waves-effect">
														<i class="material-icons">delete_forever</i>
													</button>
												</td>
											</tr>
											<tr>
												<td>Tiger Nixon</td>
												<td>System Architect</td>
												<td>Edinburgh</td>
												<td>61</td>
												<td>2011/04/25</td>
												<td>$320,800</td>
												<td>
													<select class="form-control show-tick">
														<option value="0">ใช้งาน</option>
														<option value="1">ไม่ใช้งาน</option>
													</select>
												</td>
												<td>
													<button type="button" class="btn bg-red waves-effect">
														<i class="material-icons">delete_forever</i>
													</button>
												</td>
											</tr>
											<tr>
												<td>Tiger Nixon</td>
												<td>System Architect</td>
												<td>Edinburgh</td>
												<td>61</td>
												<td>2011/04/25</td>
												<td>$320,800</td>
												<td>
													<select class="form-control show-tick">
														<option value="0">ใช้งาน</option>
														<option value="1">ไม่ใช้งาน</option>
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
