<!DOCTYPE html>
<html>

<?php
$path = "../";
include($path."include/config_header_top.php");
include 'css.php';
$path_image = $path."file_productImg/";
$page_key ='3_3';
/*$sql     = " SELECT *
            FROM tb_user
            ";

$query = $db->query($sql);
$nums = $db->db_num_rows($query); */


 $filter = '';
if($s_billNo){
    $filter .= " and billNo  like '%".$s_billNo."%'";
}

if($_SESSION["userType"]==2){
     $filter .= " and userID  = '".$_SESSION['sys_id']."'";
}
if($s_userID){
   $filter .= " and userID ='".$s_userID."'";
}


$field = "* ";
$table = "tb_bill";
$pk_id = "billID";
$wh = "1=1 {$filter}";
$orderby = "order by billID DESC";
$limit =" LIMIT ".$goto ." , ".$page_size ;
$sql = "select ".$field." from ".$table." where ".$wh ." ".$orderby .$limit;

$query = $db->query($sql);
$nums = $db->db_num_rows($query);
$total_record = $db->db_num_rows($db->query("select ".$field." from ".$table." where ".$wh));

chk_role($page_key,'isSearch',1) ;

?>

<body class="theme-red">
    <?php include 'MasterPage.php';?>

    <section class="content">
        <div class="container-fluid">
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>รายการเบิกสินค้า</h2>
                        </div>
                        <div class="body">
                            <form id="frm-search" method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
                                <input type="hidden" id="proc" name="proc" value="">
                                <input type="hidden" id="form_page" name="form_page" value="TransferList.php">
                                <input type="hidden" id="billID" name="billID" value="">
                                <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size;?>">
                                <input type="hidden" id="page" name="page" value="<?php echo $page;?>">


                                <div class="row clearfix">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                          <b>เลขที่ใบเบิก </b>
                                            <div class="form-line">
                                                <input type="text " name="s_billNo" id="s_billNo" class="form-control" placeholder="เลขที่ใบเบิก" value="<?php echo $s_billNo;?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">

                                      <div class="form-group">
                                        <b>ผู้เบิก</b>
                                        <div class="form-group form-float">
                                            <select name="s_userID" id="s_userID" class="form-control show-tick" data-live-search="true"  >
                                                <option value="">เลือก</option>
                                            <?php
                                                $s_p=" SELECT * from tb_user order by firstname asc";
                                                $q_p = $db->query($s_p);
                                                $n_p = $db->db_num_rows($q_p);
                                               while($r_p = $db->db_fetch_array($q_p)){?>
                                                <option value="<?php echo $r_p['userID'];?>"  <?php echo ($s_userID==$r_p['userID'])?"selected":"";?>> <?php echo $r_p['firstname'].' '.$r_p['lastname'];?></option>

                                            <?php }  ?>
                                            </select>
                                        </div>
                                      </div>
                      
                                    </div>
                                </div>

                                 <div class="icon-and-text-button-demo align-center">
                                    <button  class="btn btn-success waves-effect" onClick="searchData();"><span>ค้นหา</span><?php echo $img_view;?></button>
                                </div>
                                <div class="icon-and-text-button-demo align-right">
                                    <button  class="btn btn-primary waves-effect" onClick="addData();" style="<?php echo chk_role($page_key,'isadd');?>"> <span>เพิ่มข้อมูล</span><?php echo $img_add;?></button>
                                </div>
                                <div>
                                    <table class="table table-bordered table-striped table-hover  dataTable "> <!--js-basic-example-->
                                        <thead>
                                            <tr>
                                                <th width="5%">ลำดับ</th>
                                                <th width="10%">เลขที่</th>
                                                <th width="10%">วันที่</th>
                                                <th width="20%">ผู้เบิก</th>
                                                <th width="10%">สถานะ</th>
                                                <th width="10%">จัดการ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if($nums>0){
                                                $i=0;
                                               while ($rec = $db->db_fetch_array($query)) {
                                                $i++;
                                                $del = '';
                                                if($rec[billStstus]==1  && ($_SESSION['sys_id']==$rec['userID'] || $_SESSION['userType']==1)){
                                                  $del = ' <a style="'.chk_role($page_key,'isDel').'" class="btn bg-red btn-xs waves-effect"  onClick="cencelData('.$rec['billID'].');"  title="ยกเลิก" >'.$img_cancel.'</a>';
                                                }
                                                $info = ' <a style="'.chk_role($page_key,'isSearch').'" class="btn btn-info btn-xs waves-effect" onClick="infoData('.$rec['billID'].');" title="รายละเอียด">'.$img_info.'</a>'; 
                                                 
                                            ?>
                                                <tr>
                                                    <td  style="text-align: center;"><?php echo $i+$goto;?></td>
                                                    <td style="text-align: center;"><?php echo $rec['billNo'];?></td>
                                                    <td style="text-align: center;"><?php echo conv_date($rec['billDate']);?></td>
                                                    <td style="text-align: center;"><?php echo $rec['billBy'];?></td>
                                                    <td style="text-align: center;"><?php echo $arr_bill_status[$rec['billStstus']];?></td>
                                                    <td style="text-align: center;"><?php echo $info.$del;?>
                                                      <input type="hidden" id="show_no_<?php echo $rec['billID'];?>" value="<?php echo $rec['billNo'];?>" >
                                                      <input type="hidden" id="show_name_<?php echo $rec['billID'];?>" value="<?php echo $rec['billBy'];?>" >
                                                      <input type="hidden" id="show_date_<?php echo $rec['billID'];?>" value="<?php echo conv_date($rec['billDate']);?>" >
                                                      <input type="hidden" id="show_status_<?php echo $rec['billID'];?>" value="<?php echo $arr_bill_status[$rec['billStstus']];?>" >
                                                      <input type="hidden" id="show_cancelname_<?php echo $rec['billID'];?>" value="<?php echo $rec['cancelBy'];?>" >
                                                      <input type="hidden" id="show_canceldate_<?php echo $rec['billID'];?>" value="<?php echo conv_date($rec['cancelDate']);?>" >
                                                     

                                                         <!--  <span  data-toggle="modal" data-target="#largeModal">
                                                            <button id="btn_info" type="button" class="btn btn-info btn-xs waves-effect" data-toggle="tooltip" data-placement="top" title="ข้อมูล">
                                                                <i class="material-icons">info_outline</i>
                                                            </button>
                                                        </span> -->
                                                    </td>
                                                </tr>
                                            <?php }
                                            }else{
                                                echo '<tr><td colspan="7" align="center">ไม่พบข้อมูล</td></tr>';
                                            }
                                            ?>


                                        </tbody>
                                    </table>
                                       <?php echo ($nums > 0) ? endPaging("frm-search", $total_record) : ""; ?>
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



 <!-- Large Size -->
    <div class="modal fade" id="ModalDetail" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="largeModalLabel">ข้อมูลการเบิกสินค้า</h4>
                </div>
                <div class="modal-body">
                 
                  <div class="row clearfix">
                      <div class="col-sm-4">
                            <b>เลขที่ใบเบิก</b>
                           <div class="form-group" id="txt_no"></div>
                      </div>
                      <div class="col-sm-4">
                            <b>ชื่อผู้เบิก</b>
                           <div class="form-group" id="txt_name"></div>
                      </div>
                      <div class="col-sm-4">
                            <b>วันที่เบิก</b>
                           <div class="form-group" id="txt_date"></div>
                      </div>

                  </div>
                    <table class="table table-bordered table-striped table-hover  dataTable " > <!--js-basic-example-->
                            <thead>
                                <tr>

                                    <th width="5%">ลำดับ</th>
                                    <th width="15%">รหัสสินค้า</th>
                                    <th width="20%">ชื่อสินค้า</th>
                                    <th width="20%">ยี่ห้อ</th>
                                    <th width="20%">สถานที่จัดเก็บ</th>
                                    <th width="10%">จำนวน</th>
                                    <th width="5%">หน่วยนับ</th>
                                </tr>
                            </thead>
                            <tbody id="ModalDATA">
                            </tbody>
                    </table>
                    <br>
                    <br>
                    <div class="row clearfix">
                      <div class="col-sm-4">
                            <b>สถานะ</b>
                           <div class="form-group" id="txt_status"></div>
                      </div>
                      <div class="col-sm-4">
                            <b>ชื่อผู้ยกเลิก</b>
                           <div class="form-group" id="txt_candel_name"></div>
                      </div>
                      <div class="col-sm-4">
                            <b>วันที่ยกเลิก</b>
                           <div class="form-group" id="txt_candel_date"></div>
                      </div>

                  </div>
                </div>

               
                
                 <div class="modal-footer">
                   <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">ปิด</button>
                 </div>
                     <!-- <div class="modal-footer">
                        <button type="button" class="btn btn-link waves-effect">SAVE CHANGES</button>
                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                    </div> -->
                </div>
            </div>
        </div>
<script>

function searchData(){
  $("#frm-search").submit();
}
function infoData(id){

  $('#txt_no').html($('#show_no_'+id).val());
  $('#txt_name').html($('#show_name_'+id).val());
  $('#txt_date').html($('#show_date_'+id).val());
  $('#txt_status').html($('#show_status_'+id).val());
  $('#txt_candel_name').html($('#show_cancelname_'+id).val());
  $('#txt_candel_date').html($('#show_canceldate_'+id).val());


  var html ='';
  $.ajaxSetup({async: false});
  $.post('process/get_process.php',{proc:'get_product_bill',id:id},function(data){
      $.each(data,function(index,value){
      html += '<tr>';
          html += '<td align="center">'+(index+1)+'</td>';
          html += '<td align="center">'+value['productCode']+'</td>';
          html += '<td align="center">'+value['productName']+'</td>';
          html += '<td align="center">'+value['brand']+'</td>';
          html += '<td align="center">'+value['locationName']+'</td>';
          html += '<td align="center">'+value['billDescUnit']+'</td>';
          html += '<td align="center">'+value['unitType']+'</td>';
          
      html += '</tr>';
    });
  },'json');
  $('#ModalDATA').html(html);    



  $('#ModalDetail').modal('show');
}
function addData(){
  $("#proc").val("add");
  $("#frm-search").attr("action","TransferInfo.php").submit();
}

function cencelData(id){
  if(confirm("ต้องการยกเลิกข้อมูลใช่หรือไม่ ?")){
    $("#proc").val("cancel");
    $("#billID").val(id);
    $("#frm-search").attr("action","process/Transfer_process.php").submit();
  }
}

</script>
