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
                            <h2>ตำแหน่งสินค้า</h2>
                        </div>
                        <form id="" method="POST">
                            <div class="body">
                                <div class="row clearfix">
                                    <div class="col-sm-5">
                                        <div class="form-group form-float">
                                            <select name="txtProvince" class="form-control show-tick" data-live-search="true">
                                                <option>ตำแหน่ง</option>
                                                <option>สินคา</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="txtName" class="form-control" placeholder="รหัส/ชื่อ">
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-success waves-effect" type="submit">ค้นหา</button>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>ลำดับ</th>
                                                <th>รหัสตำแหน่งจัดเก็บ</th>
                                                <th>ชื่อตำแหน่งจัดเก็บ</th>
                                                <th>จำนวน</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>Location001</td>
                                                <td>แสดงสินค้าชั้น1</td>
                                                <td>61</td>
                                                <td>
                                                    <span  data-toggle="modal" data-target="#largeModal">
                                                        <button id="btn_info" type="button" class="btn btn-info btn-xs waves-effect" data-toggle="tooltip" data-placement="top" title="ข้อมูล">
                                                            <i class="material-icons">info_outline</i>
                                                        </button>
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>Location002</td>
                                                <td>ที่เก็บสินค้าชั้น2ตำแหน่งที่1</td>
                                                <td>63</td>
                                                <td>
                                                    <span  data-toggle="modal" data-target="#largeModal">
                                                        <button id="btn_info" type="button" class="btn btn-info btn-xs waves-effect" data-toggle="tooltip" data-placement="top" title="ข้อมูล">
                                                            <i class="material-icons">info_outline</i>
                                                        </button>
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>Location003</td>
                                                <td>ที่เก็บสินค้าชั้น2ตำแหน่งที่2</td>
                                                <td>66</td>
                                                <td>
                                                    <span  data-toggle="modal" data-target="#largeModal">
                                                        <button id="btn_info" type="button" class="btn btn-info btn-xs waves-effect" data-toggle="tooltip" data-placement="top" title="ข้อมูล">
                                                            <i class="material-icons">info_outline</i>
                                                        </button>
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td>Location004</td>
                                                <td>ที่เก็บสินค้าชั้น2ตำแหน่งที่3</td>
                                                <td>22</td>
                                                <td>
                                                    <span  data-toggle="modal" data-target="#largeModal">
                                                        <button id="btn_info" type="button" class="btn btn-info btn-xs waves-effect" data-toggle="tooltip" data-placement="top" title="ข้อมูล">
                                                            <i class="material-icons">info_outline</i>
                                                        </button>
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>5</td>
                                                <td>Location005</td>
                                                <td>ที่เก็บสินค้าชั้น2ตำแหน่งที่4</td>
                                                <td>33</td>
                                                <td>
                                                    <span  data-toggle="modal" data-target="#largeModal">
                                                        <button id="btn_info" type="button" class="btn btn-info btn-xs waves-effect" data-toggle="tooltip" data-placement="top" title="ข้อมูล">
                                                            <i class="material-icons">info_outline</i>
                                                        </button>
                                                    </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>แจ้งเตือนสินค้า</h2>
                        </div>
                        <div class="body">
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
                                        <th>จำนวน</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>TY2156516H20</td>
                                        <td>TOYO H20 215/65R16</td>
                                        <td>TOYO</td>
                                        <td>H20</td>
                                        <td>215/65R16</td>
                                        <td><span class="badge bg-red">1 ชุด</span></td>
                                        <td>
                                            <button type="button" class="btn btn-info btn-xs waves-effect" data-toggle="tooltip" data-placement="top" title="สั่งซื้อ">
                                                <i class="material-icons">input</i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>YK195515AE50</td>
                                        <td>YOKOHAMA AE50 195/55R15</td>
                                        <td>YOKOHAMA</td>
                                        <td>AE50</td>
                                        <td>195/55R15</td>
                                        <td><span class="badge bg-red">1 ชุด</span></td>
                                        <td>
                                            <button type="button" class="btn btn-info btn-xs waves-effect" data-toggle="tooltip" data-placement="top" title="สั่งซื้อ">
                                                <i class="material-icons">input</i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>BS2057015DUELERH/T684</td>
                                        <td>BRIDGESTONE DUELER H/T 684 205/70R15</td>
                                        <td>BRIDGESTONE</td>
                                        <td>DUELER H/T 684</td>
                                        <td>205/70R15</td>
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
                                    <th>รหัสสินค้า</th>
                                    <th>ชื่อสินค้า</th>
                                    <th>ยี่ห้อ</th>
                                    <th>รุ่น</th>
                                    <th>ขนาด</th>
                                    <th>จำนวน</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>TOYO-PROXES-ST3 III-15</td>
                                    <td>TOYO PROXES</td>
                                    <td>TOYO</td>
                                    <td>PROXES ST3 III</td>
                                    <td>15นิ้ว</td>
                                    <td>10</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>YOKOHAMA-ADVAN dB Decibel V551-15</td>
                                    <td>YOKOHAMA ADVAN</td>
                                    <td>YOKOHAMA</td>
                                    <td>ADVAN Decibel V551</td>
                                    <td>15 นิ้ว</td>
                                    <td>5</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>COSMIS-XT-005R Eco-15</td>
                                    <td>COSMIS XT-005R Eco (ขอบ15″)</td>
                                    <td>COSMIS</td>
                                    <td>XT-005R</td>
                                    <td>15 นิ้ว</td>
                                    <td>2</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                     <!-- <div class="modal-footer">
                        <button type="button" class="btn btn-link waves-effect">SAVE CHANGES</button>
                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                    </div> -->
                </div>
            </div>
        </div>
    </section>
    <?php include 'js.php';?>
</body>

</html>
