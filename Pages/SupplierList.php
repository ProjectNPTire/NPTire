<!DOCTYPE html>
<html>

<?php include 'css.php';?>

<body class="theme-red">
    <?php include 'MasterPage.php';?>

    <section class="content">
        <div class="container-fluid">
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>รายการคู่ค้า</h2>
                        </div>
                        <div class="body">
                            <form action="SupplierInfo.php" method="POST">
                                <div class="icon-and-text-button-demo align-right">
                                    <button type="submit" class="btn btn-primary waves-effect"><span>เพิ่มข้อมูล</span><i class="material-icons">add_box</i></button>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                        <thead>
                                            <tr>
                                                <th>ลำดับ</th>
                                                <th>ชื่อคู่ค้า/บริษัท</th>
                                                <th>เบอร์โทรศัพท์</th>
                                                <th>ที่อยู่</th/>
                                                    <!-- <th>สถานะ</th/> -->
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th>1</th>
                                                        <td>บริษัท สยามมิชลิน จำกัด</td>
                                                        <td>02-700-3993</td>
                                                        <td>33/4 อาคารเดอะไนน์ทาวเวอร์แกรนด์พระราม
                                                            9 อาคารเอ ชั้น
                                                            21 ถนนพระราม
                                                            9 แขวงและเขตห้วยขวาง กรุงเทพฯ 10310
                                                        </td>
                                               <!--  <td>
                                                    <div class="switch">
                                                        <label><input type="checkbox" disabled checked><span class="lever"></span></label>
                                                    </div>
                                                </td> -->
                                                <td align="center">
                                                    <a class="btn bg-warning btn-xs waves-effect">
                                                        <i class="material-icons">edit</i>
                                                    </a>
                                                    <a class="btn bg-red btn-xs waves-effect">
                                                        <i class="material-icons">delete_forever</i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>บริษัท โยโกฮาม่า เอเชีย จำกัด</td>
                                                <td>0-2664-0451</td>
                                                <td>
                                                    235 / 20-25 ซอย สุขุมวิท 21 แขวง คลองเตยเหนือ เขต วัฒนา กรุงเทพมหานคร 10110
                                                </td>
                                                <!-- <td>
                                                    <div class="switch">
                                                        <label><input type="checkbox" disabled><span class="lever"></span></label>
                                                    </div>
                                                </td> -->
                                                <td align="center">
                                                    <a class="btn bg-warning btn-xs waves-effect">
                                                        <i class="material-icons">edit</i>
                                                    </a>
                                                    <a class="btn bg-red btn-xs waves-effect">
                                                        <i class="material-icons">delete_forever</i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>บริษัท บริดจสโตนเซลส์ (ประเทศไทย) จำกัด</td>
                                                <td>02-636-1555</td>
                                                <td>
                                                    990 ถนน พระราม 4 แขวง สีลม เขต บางรัก กรุงเทพมหานคร 10500
                                                </td>
                                                <!-- <td>
                                                    <div class="switch">
                                                        <label><input type="checkbox" disabled><span class="lever"></span></label>
                                                    </div>
                                                </td> -->
                                                <td align="center">
                                                    <a class="btn bg-warning btn-xs waves-effect">
                                                        <i class="material-icons">edit</i>
                                                    </a>
                                                    <a class="btn bg-red btn-xs waves-effect">
                                                        <i class="material-icons">delete_forever</i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td>บริษัท ดันลอปไทร์ (ไทยแลนด์) จำกัด</td>
                                                <td>02-744-0199</td>
                                                <td>
                                                    909 อาคารแอมเพิลทาวเวอร์ ชั้น 4 ห้อง 4/1
                                                    ถนนบางนา-ตราด แขวงบางนา เขตบางนา
                                                    กรุงเทพมหานคร 10260
                                                </td>
                                                <td align="center">
                                                    <a class="btn bg-warning btn-xs waves-effect">
                                                        <i class="material-icons">edit</i>
                                                    </a>
                                                    <a class="btn bg-red btn-xs waves-effect">
                                                        <i class="material-icons">delete_forever</i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>5</td>
                                                <td>บริษัท ดีสโตน จำกัด</td>
                                                <td>02-420-0038</td>
                                                <td>
                                                    84 หมู่ที่ 7 ซอยสินประสงค์ ถนนเพชรเกษม ตำบลอ้อมน้อย อำเภอกระทุ่มแบน จังหวัดสมุทรสาคร 74130
                                                </td>
                                                <td align="center">
                                                    <a class="btn bg-warning btn-xs waves-effect">
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
            <!-- #END# Basic Examples -->
        </div>
    </section>

    <?php include 'js.php';?>
</body>

</html>