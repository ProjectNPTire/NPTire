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
                            <h2>รายการยี่ห้อสินค้า</h2>
                        </div>
                        <div class="body">
                            <form action="BrandInfo.php" method="POST">
                                <div class="icon-and-text-button-demo align-right">
                                    <button type="submit" class="btn btn-primary waves-effect"><span>เพิ่มข้อมูล</span><i class="material-icons">add</i></button>
                                </div>
                                <div class="table-responsive">
                                    <table width="100%" class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                        <thead>
                                            <tr>
                                                <th>ลำดับ</th>
                                                <th>ยี่ห้อสินค้า</th>
                                                <th>รายละเอิยด</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>MICHELIN</td>
                                                <td></td>
                                                <td>
                                                    <span  data-toggle="modal" data-target="#largeModal">
                                                        <button id="btn_info" type="button" class="btn btn-info btn-xs waves-effect" data-toggle="tooltip" data-placement="top" title="ข้อมูล">
                                                            <i class="material-icons">info_outline</i>
                                                        </button>
                                                    </span>
                                                    <a class="btn bg-orange btn-xs waves-effect">
                                                        <i class="material-icons">edit</i>
                                                    </a>
                                                    <a class="btn bg-red btn-xs waves-effect">
                                                        <i class="material-icons">delete_forever</i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>YOKOHAMA</td>
                                                <td></td>
                                                <td>
                                                    <span  data-toggle="modal" data-target="#largeModal">
                                                        <button id="btn_info" type="button" class="btn btn-info btn-xs waves-effect" data-toggle="tooltip" data-placement="top" title="ข้อมูล">
                                                            <i class="material-icons">info_outline</i>
                                                        </button>
                                                    </span>
                                                    <a class="btn bg-orange btn-xs waves-effect">
                                                        <i class="material-icons">edit</i>
                                                    </a>
                                                    <a class="btn bg-red btn-xs waves-effect">
                                                        <i class="material-icons">delete_forever</i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>DEESTONE</td>
                                                <td></td>
                                                <td>
                                                    <span  data-toggle="modal" data-target="#largeModal">
                                                        <button id="btn_info" type="button" class="btn btn-info btn-xs waves-effect" data-toggle="tooltip" data-placement="top" title="ข้อมูล">
                                                            <i class="material-icons">info_outline</i>
                                                        </button>
                                                    </span>
                                                    <a class="btn bg-orange btn-xs waves-effect">
                                                        <i class="material-icons">edit</i>
                                                    </a>
                                                    <a class="btn bg-red btn-xs waves-effect">
                                                        <i class="material-icons">delete_forever</i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td>DUNLOP</td>
                                                <td></td>
                                                <td>
                                                    <span  data-toggle="modal" data-target="#largeModal">
                                                        <button id="btn_info" type="button" class="btn btn-info btn-xs waves-effect" data-toggle="tooltip" data-placement="top" title="ข้อมูล">
                                                            <i class="material-icons">info_outline</i>
                                                        </button>
                                                    </span>
                                                    <a class="btn bg-orange btn-xs waves-effect">
                                                        <i class="material-icons">edit</i>
                                                    </a>
                                                    <a class="btn bg-red btn-xs waves-effect">
                                                        <i class="material-icons">delete_forever</i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>5</td>
                                                <td>GOODYEAR</td>
                                                <td></td>
                                                <td>
                                                    <span  data-toggle="modal" data-target="#largeModal">
                                                        <button id="btn_info" type="button" class="btn btn-info btn-xs waves-effect" data-toggle="tooltip" data-placement="top" title="ข้อมูล">
                                                            <i class="material-icons">info_outline</i>
                                                        </button>
                                                    </span>
                                                    <a class="btn bg-orange btn-xs waves-effect">
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