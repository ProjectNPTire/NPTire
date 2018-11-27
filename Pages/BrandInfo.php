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
							<h2>ข้อมูลยี่ห้อสินค้า</h2>
						</div>
						<div class="body">
							<form id="" method="POST">
								<div class="form-group form-float">
									<b>รหัสยี่ห้อสินค้า*</b>
									<div class="form-line">
										<input type="text" name="txtName" class="form-control" required>
									</div>
								</div>
								<div class="form-group form-float">
									<b>ชื่อยี่ห้อสินค้า*</b>
									<div class="form-line">
										<input type="text" name="txtName" class="form-control" placeholder="ตัวอย่าง: ชื่อxจำนวน" required>
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
			<div class="row clearfix">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="card">
						<div class="header">
							<h2>รายการรุ่นสินค้า</h2>
						</div>
						<div class="body">
							<form action="UserInfo.php" method="POST">
                                <div class="icon-and-text-button-demo align-right">
                                    <button type="button" class="btn btn-primary waves-effect"><span>เพิ่มข้อมูล</span><i class="material-icons">add_box</i></button>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                        <thead>
                                            <tr>
                                                <th>ลำดับ</th>
                                                <th>ชื่อรุ่นสินค้า</th>
                                                <th>รายละเอิยด</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>Energy XM2</td>
                                                <td></td>
                                                <!-- <td>
                                                    <div class="switch">
                                                        <label><input type="checkbox" disabled checked><span class="lever"></span></label>
                                                    </div>
                                                </td> -->
                                                <td>
                                                    <a class="btn bg-default btn-xs waves-effect">
                                                        <i class="material-icons">edit</i>
                                                    </a>
                                                    <a class="btn bg-red btn-xs waves-effect">
                                                        <i class="material-icons">delete_forever</i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>Agilis</td>
                                                <td></td>
                                               <!--  <td>
                                                    <div class="switch">
                                                        <label><input type="checkbox" disabled><span class="lever"></span></label>
                                                    </div>
                                                </td> -->
                                                <td>
                                                    <a class="btn bg-default btn-xs waves-effect">
                                                        <i class="material-icons">edit</i>
                                                    </a>
                                                    <a class="btn bg-red btn-xs waves-effect">
                                                        <i class="material-icons">delete_forever</i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>Primacy 4</td>
                                                <td></td>
                                               <!--  <td>
                                                    <div class="switch">
                                                        <label><input type="checkbox" disabled><span class="lever"></span></label>
                                                    </div>
                                                </td> -->
                                                <td>
                                                    <a class="btn bg-default btn-xs waves-effect">
                                                        <i class="material-icons">edit</i>
                                                    </a>
                                                    <a class="btn bg-red btn-xs waves-effect">
                                                        <i class="material-icons">delete_forever</i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td>XCD2</td>
                                                <td></td>
                                                <!-- <td>
                                                    <div class="switch">
                                                        <label><input type="checkbox" disabled checked><span class="lever"></span></label>
                                                    </div>
                                                </td> -->
                                                <td>
                                                    <a class="btn bg-default btn-xs waves-effect">
                                                        <i class="material-icons">edit</i>
                                                    </a>
                                                    <a class="btn bg-red btn-xs waves-effect">
                                                        <i class="material-icons">delete_forever</i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>5</td>
                                                <td>LTX FORCE</td>
                                                <td></td>
                                               <!--  <td>
                                                    <div class="switch">
                                                        <label><input type="checkbox" disabled checked><span class="lever"></span></label>
                                                    </div>
                                                </td> -->
                                                <td>
                                                   <a class="btn bg-default btn-xs waves-effect">
                                                        <i class="material-icons">edit</i>
                                                    </a>
                                                    <a class="btn bg-red btn-xs waves-effect">
                                                        <i class="material-icons">delete_forever</i>
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
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
