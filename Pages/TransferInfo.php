<!DOCTYPE html>
<html>
<?php
$path = "../";
include($path."include/config_header_top.php");
include 'css.php';
$page_key ='6_1';
$form_page = $form_page;

$sql     = " SELECT *
FROM tb_product
where productID ='".$productID."' ";

$query = $db->query($sql);
$nums = $db->db_num_rows($query);
$rec = $db->db_fetch_array($query);
$proc = ($proc=='')?"add":$proc;
$txt =  ($proc=='add')?"เพิ่ม":"แก้ไข";
// if($proc=='add'){
// 	$rec['billDate'] = date('Y-m-d');
//   $rec['billBy'] = $_SESSION['sys_name'];
// }
$s_location = "SELECT * from tb_location order by locationName ";
?>

<body class="theme-red">
  <?php include 'MasterPage.php';?>
  <section class="content">
    <div class="container-fluid">
      <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <div class="card">
            <div class="header">
              <h2>เพิ่มข้อมูลเบิกสินค้า</h2>
            </div>
            <form id="frm-input" method="post" enctype="multipart/form-data" action="process/Transfer_process.php" >
              <input type="hidden" id="proc" name="proc" value="<?php echo $proc;?>">
              <input type="hidden" id="form_page" name="form_page" value="<?php echo  $form_page?>">
              <div class="body">
                <div class="form-group">
                  <div class="icon-and-text-button-demo align-right">
                    <a class="btn btn-primary waves-effect" onClick="popup();">
                      <span>เลือกสินค้า</span>
                      <i class="material-icons">add_box</i>
                    </a>
                  </div>
                </div>
                <div class="form-group">
                  <table class="table table-hover table-bordered" id="tb_data"> <!--js-basic-example-->
                    <thead>
                      <tr>
                        <th width="5%" align="center">ลำดับ</th>
                        <th align="center">รหัสสินค้า</th>
                        <th width="12%" align="center">ชื่อสินค้า</th>
                        <th align="center">ประเภท</th>
                        <th align="center">ยี่ห้อ</th>
                        <th width="12%" align="center">คุณลักษณะ</th>
                        <th align="center">ประเภทตำแหน่งจัดเก็บ</th>
                        <th align="center">ตำแหน่งจัดเก็บ</th>
                        <th width="10%" align="right">จำนวน</th>
                        <th width="8%" align="center">หน่วยนับ</th>
                        <th width="5%"></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $i=0; $total=0;?>
                      <td colspan="11" align="center">ยังไม่มีรายการสินค้า</td>
                    </tbody>
                  </table>
                  <label id="tb_data-error" class="error" for="tb_data">กรุณาเลือกสินค้าที่ต้องการ</label>
                </div>
                <input type="hidden" id="rowid" value="<?php echo $i;?>">

                <div id="btn-submit" class="align-center" hidden>
                  <button type="button" class="btn btn-success waves-effect" onclick="chkinput();">บันทึก</button>
                  <button type="button" class="btn btn-warning waves-effect" onclick="OnCancel();">ยกเลิก</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <!-- #END# Advanced Form Example With Validation -->
    </div>
  </section>
  <?php include 'js.php';?>
</body>

</html>


<!-- Large Size -->
<div class="modal fade" id="ModalProduct" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title" id="largeModalLabel">ข้อมูลในคลังสินค้า</h4>
        <form>
          <br><br><br>
          <div class="row">
            <div class="col-sm-4 col-sm-offset-1">
              <div class="form-group">
               <!-- <b>รหัสสินค้า</b> -->
               <div class="form-group form-float">
                <select class="form-control show-tick" name="s_searchType" id="s_searchType">
                  <option value="0">ค้นหาข้อมูลทั้งหมด</option>
                  <option value="1">ตำแหน่งเก็บ</option>
                  <option value="2">สินค้า</option>
                  <option value="3">ประเภท</option>
                  <option value="4">ยี่ห้อ</option>
                  <!--  <option value="3">ชื่อสินค้า</option>-->
                </select>
              </div>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-group">
              <!--  <b>ชื่อสินค้า</b> -->
              <div class="input-group">
               <div class="form-line">
                 <input type="text " name="s_productName" id="s_productName" class="form-control" placeholder="รหัส/ชื่อ" value="<?php echo $s_productName;?>">
               </div>
             </div>
           </div>
         </div>
         <div class="col-sm-2">
          <div class="form-group">
            <div class="text-center">
              <a  class="btn btn-success waves-effect"onclick="get_search();" ><span>ค้นหา</span><?php echo $img_view;?></a>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
  <div class="modal-body">
   <table class="table table-bordered table-striped table-hover  dataTable "> <!--js-basic-example-->
     <thead>
       <tr>
         <th width="5%"></th>
         <th width="20%">ประเภทตำแหน่งจัดเก็บ</th>
         <th width="20%">ตำแหน่งจัดเก็บ</th>
         <th width="65%">ข้อมูลสินค้า</th>
         <th width="10%">จำนวน</th>
       </tr>
     </thead>
     <tbody  id="ModalDATA">
     </tbody>
   </table>
 </div>

 <div class="modal-footer">
  <button type="button" class="btn btn-success waves-effect" onclick="onsubmitModal();">เลือก</button>
  <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">ปิด</button>
</div>
</div>
</div>
</div>

<script>
  function popup(){
    $('#ModalProduct').modal('show');
    get_search();
  }
  function get_search() {
    $('#ModalDATA').html('');
    var type = $('#s_searchType').val();
    var name  = 	$('#s_productName').val();
    var html ='';
    $.ajaxSetup({async: false});
    $.post('process/get_process.php',{proc:'get_product',type:type,name:name},function(data){

      if(data != ''){

        $.each(data,function(index,value){
         html += '<tr>';
         html += '<td align="center">';
         html += '<input type="checkbox" id="F_productID_'+index+'"  value="'+value['productID']+'"  class="filled-in" >';
         html += '<label for="F_productID_'+index+'"></label>';
         html += '<input type="hidden" id="F_productCode_'+index+'" value="'+value['productCode']+'">';
         html += '<input type="hidden" id="F_productName_'+index+'" value="'+value['productName']+'">';
         html += '<input type="hidden" id="F_type_'+index+'" value="'+value['productTypeName']+'">';
         html += '<input type="hidden" id="F_brand_'+index+'" value="'+value['brandName']+'">';
         html += '<input type="hidden" id="F_locationTypeName_'+index+'" value="'+value['locationTypeName']+'">';
         html += '<input type="hidden" id="F_locationName_'+index+'" value="'+value['locationName']+'">';
         html += '<input type="hidden" id="F_ps_unit_'+index+'" value="'+value['ps_unit']+'">';
         html += '<input type="hidden" id="F_unitType_'+index+'" value="'+value['unitType']+'">';
         html += '<input type="hidden" id="F_attr_'+index+'" value="'+value['attr']+'">';
         html += '<input type="hidden" id="F_locationTypeID_'+index+'" value="'+value['locationTypeID_']+'">';
         html += '<input type="hidden" id="F_locationID_'+index+'" value="'+value['locationID']+'">';
         html += '</td>';
         html += '<td>'+value['locationTypeName']+'</td>';
         html += '<td>'+value['locationName']+'</td>';
         html += '<td>';
         html += '<b>รหัส</b> : '+value['productCode'];
         html += '<br><b>ชื่อ</b> : '+value['productName'];
         html += '<br><b>ประเภท</b> : '+value['productTypeName'];
         html += '<br><b>ยี่ห้อ</b> : '+value['brandName'];
         html += '<br><b>คุณลักษณะ</b> : '+value['attr'];

         html += '</td>';
         html += '<td align="center">'+value['ps_unit']+' '+value['unitType']+'</td>';
         html += '</tr>';
       });
      }else{
        html += '<tr>';
        html += '<td colspan="4" align="center">ไม่พบข้อมูล</td>';
        html += '</tr>';
      }
    },'json');
    $('#ModalDATA').html(html);
  }
  function OnCancel()
  {
    $(location).attr('href',"<?php echo  $form_page?>");
  }

  function chkinput(){
    var tr = $('#tb_data tbody tr');
    if(tr.length==0){
      $('#tb_data-error').show();
      return false;
    }

    if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
      $("#frm-input").submit();
    }
  }

  $(document).ready(function() {

    $('.error').hide();
    $(".numb").keyup(function() {//Can Be {0-9,.}
      chkFormatNam($(this).val(), $(this).attr('id'));
    });
  });


  function onsubmitModal(){
    debugger
    var html = '';
    if ($('#rowid').val() == 0) {
      $("#tb_data tbody").html("");
    }
    var rowid = parseInt($('#rowid').val());

    var arr_p_id = $('input[id^=F_productID_]');
    var arr_p_code = $('input[id^=F_productCode_]');
    var arr_p_name = $('input[id^=F_productName_]');
    var arr_type = $('input[id^=F_type_]');
    var arr_brand = $('input[id^=F_brand_]');
    var arr_attr = $('input[id^=F_attr_]');
    var arr_ltype_name = $('input[id^=F_locationTypeName_]');
    var arr_l_name = $('input[id^=F_locationName_]');
    var arr_unittype = $('input[id^=F_unitType_]');
    var arr_unit = $('input[id^=F_ps_unit_]');
    var arr_ltype_id = $('input[id^=F_locationTypeID_]');
    var arr_l_id = $('input[id^=F_locationID_]');
    if(arr_p_id.length>0){
      for (var i = 0; i < arr_p_id.length; i++) {
        

        if (arr_p_id[i].checked){
          rowid = rowid+1;

          html += '<tr>';
          html += '<td style="text-align:center">'+rowid+'</td>';
          html += '<td>'+arr_p_code[i].value;
          html += '<input type="hidden" name="productID[]" id="productID_'+rowid+'"  value="'+arr_p_id[i].value+'" >';
          html += '<input type="hidden" name="locationTypeID[]" id="locationTypeID_'+rowid+'"  value="'+arr_ltype_id[i].value+'" >'
          html += '<input type="hidden" name="locationID[]" id="locationID_'+rowid+'"  value="'+arr_l_id[i].value+'" >';
          html += '<input type="hidden" name="ALLUNIT[]" id="ALLUNIT_'+rowid+'"  value="'+arr_unit[i].value+'" >';
          html += '</td>';
          html += '<td>'+arr_p_name[i].value+'</td>';
          html += '<td>'+arr_type[i].value+'</td>';
          html += '<td>'+arr_brand[i].value+'</td>';
          html += '<td>'+arr_attr[i].value+'</td>';
          html += '<td>'+arr_ltype_name[i].value+'</td>';
          html += '<td>'+arr_l_name[i].value+'</td>';
          html += '<td>';
          html += '<div class="form-line">';
          html += '   <input type="text"  style="text-align: right;" class="form-control numb"   name="billDescUnit[]" id="billDescUnit_'+rowid+'" onBlur="NumberFormat(this);get_unit('+rowid+');" value="'+arr_unit[i].value+'" >';
          html += '</div>';
          html += '</td>';
          html += '<td>';
          html +=  arr_unittype[i].value;
          html += '</td>';
          html += '<td style="text-align: center;">';
          html += '<a class=\"btn bg-red btn-xs waves-effect\"  href=\"javascript:void(0);\" onClick=\"delData(this);\"><?php echo $img_del;?> </a>';
          html += '</td>';
          html += '</tr>';

        }
      }
    }

    var obj_id = $("#tb_data tbody tr");
    $.each(obj_id, function(){
      if(($(this).find('td:eq(1)').text()).toString() == (arr_p_code[arr_p_code.length-1].value).toString()){
        html = "";
        alert("มีสินค้านี้ในรายการเบิกแล้ว");
        return false;
      }
    });
    
    if(html != ""){
      $('#ModalProduct').modal('hide');
      $('#tb_data tbody').append(html);
      $('#rowid').val(rowid);
    }
    $(".numb").inputFilter(function(value) {
      return /^\d*$/.test(value);
    });
    $("#btn-submit").show();
    /*  F_productID_
      F_productCode_
      F_productName_
      F_locationName_
      F_locationID_
      F_ps_unit_
      F_brandID_
      F_brand_
      F_unitType_*/
    }
    function delData(obj){
      if(confirm("ยืนยันการลบข้อมูล ?")){
        $(obj).parent().parent().remove();
        get_total();
      }
    }
    function  get_unit(id){
      var all = $('#ALLUNIT_'+id).val();
      var unit = parseInt($('#billDescUnit_'+id).val().trim().replace(/,/g,''));
      if(unit>all){
        alert('เบิกเกินจำนวนที่มีในคลัง');
        $('#billDescUnit_'+id).val(all).click();
      }
    }

// (function($) {
//   $.fn.inputFilter = function(inputFilter) {
//     return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
//       if (inputFilter(this.value)) {
//         this.oldValue = this.value;
//         this.oldSelectionStart = this.selectionStart;
//         this.oldSelectionEnd = this.selectionEnd;
//       } else if (this.hasOwnProperty("oldValue")) {
//         this.value = this.oldValue;
//         this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
//       }
//     });
//   };
// }(jQuery));
</script>
