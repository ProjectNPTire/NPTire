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
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>ลำดับ</th>
                                            <th>ชื่อคู่ค้า/บริษัท</th>
                                            <th>เบอร์โทรศัพท์</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>1</th>
                                            <td>บริษัท สยามมิชลิน จำกัด</td>
                                            <td>02-700-3993</td>
                                            <td>
                                                <a class="btn bg-grey btn-xs waves-effect" href="OrderInfo.php">
                                                    <i class="material-icons">done</i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>บริษัท โยโกฮาม่า เอเชีย จำกัด</td>
                                            <td>0-2664-0451</td>
                                            <td>
                                                <a class="btn bg-grey btn-xs waves-effect" href="OrderInfo.php">
                                                    <i class="material-icons">done</i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>บริษัท บริดจสโตนเซลส์ (ประเทศไทย) จำกัด</td>
                                            <td>02-636-1555</td>
                                            <td>
                                                <a class="btn bg-grey btn-xs waves-effect" href="OrderInfo.php">
                                                    <i class="material-icons">done</i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>บริษัท ดันลอปไทร์ (ไทยแลนด์) จำกัด</td>
                                            <td>02-744-0199</td>
                                            <td>
                                                <a class="btn bg-grey btn-xs waves-effect" href="OrderInfo.php">
                                                    <i class="material-icons">done</i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td>บริษัท ดีสโตน จำกัด</td>
                                            <td>02-420-0038</td>
                                            <td>
                                                <a class="btn bg-grey btn-xs waves-effect" href="OrderInfo.php">
                                                    <i class="material-icons">done</i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
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