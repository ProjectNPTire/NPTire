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
								<div class="icon-and-text-button-demo align-right">
									<button type="button" class="btn btn-primary waves-effect">
										<span>เพิ่มเอกสาร</span>
										<i class="material-icons">add_box</i>
									</button>
								</div>
								<div class="table-responsive">
									<table class="table table-hover">
										<thead>
											<tr>
												<th>รหัสสินค้า</th>
												<th>ชื่อสินค้า</th>
												<th>ยี่ห้อสินค้า</th>
												<th>รุ่นสินค้า</th>
												<th>ขนาดสินค้า</th>
												<th>จำนวน</th>
												<th>ตำแหน่ง</th>
												<th></th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>TY2156516H20</td>
												<td>TOYO H20 215/65R16</td>
												<td>TOYO</td>
												<td>H20</td>
												<td>215/65R16</td>
												<td>21</td>
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
												<td>YK195515AE50</td>
												<td>YOKOHAMA AE50 195/55R15</td>
												<td>YOKOHAMA</td>
												<td>AE50</td>
												<td>195/55R15</td>
												<td>19</td>
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
												<td>BS2057015DUELERH/T684</td>
												<td>BRIDGESTONE DUELER H/T 684 205/70R15</td>
												<td>BRIDGESTONE</td>
												<td>DUELER H/T 684</td>
												<td>205/70R15</td>
												<td>20</td>
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
