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
                            <h2>รายการสินค้า</h2>
                        </div>
                        <div class="body">
                         <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ลำดับ</th>
                                        <th>รหัสสินค้า</th>
                                        <th>ชื่อสินค้า</th>
                                        <th>ยี่ห้อ</th>
                                        <th>รุ่น</th>
                                        <th>ขนาด</th>
                                        <th>หน่วยนับ</th>
                                        <th>จำนวน</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>TOYO-PROXES ST3 III-15</td>
                                        <td>TOYO PROXES</td>
                                        <td>TOYO</td>
                                        <td>PROXES ST3 III</td>
                                        <td>15นิ้ว</td>
                                        <td>ชุดx4</td>
                                        <td><span class="badge bg-red">1 ชุด</span></td>
                                        <td>
                                            <button type="button" class="btn btn-info btn-xs waves-effect" data-toggle="tooltip" data-placement="top" title="สั่งซื้อ">
                                                <i class="material-icons">input</i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>YOKOHAMA-ADVAN dB Decibel V551-15</td>
                                        <td>YOKOHAMA ADVAN</td>
                                        <td>YOKOHAMA</td>
                                        <td>ADVAN Decibel V551</td>
                                        <td>15 นิ้ว</td>
                                        <td>ชุดx4</td>
                                        <td><span class="badge bg-red">1 ชุด</span></td>
                                        <td>
                                            <button type="button" class="btn btn-info btn-xs waves-effect" data-toggle="tooltip" data-placement="top" title="สั่งซื้อ">
                                                <i class="material-icons">input</i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>COSMIS-XT-005R Eco-15</td>
                                        <td>COSMIS XT-005R Eco (ขอบ15″)</td>
                                        <td>COSMIS</td>
                                        <td>XT-005R</td>
                                        <td>15 นิ้ว</td>
                                        <td>ชุดx4</td>
                                        <td><span class="badge bg-red">1 ชุด</span></td>
                                        <td>
                                            <button type="button" class="btn btn-info btn-xs waves-effect" data-toggle="tooltip" data-placement="top" title="สั่งซื้อ">
                                                <i class="material-icons">input</i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>  
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>
    <?php include 'js.php';?>
</body>

</html>
