  <!DOCTYPE html>
  <html>

  <?php $path = "../";
  include($path."include/config_header_top.php");
  include 'css.php';
  $page_key ='3_2';
  $sql     = " SELECT *
  FROM tb_brand
  where brandID ='".$brandID."' ";

  $query = $db->query($sql);
  $nums = $db->db_num_rows($query);
  $rec = $db->db_fetch_array($query);
  $proc = ($proc=='')?"add":$proc;
  $txt =  ($proc=='add')?"เพิ่ม":"แก้ไข";
  $readonly = "readonly";
  T

  ?>

  <body class="theme-red">
  	<?php include 'MasterPage.php';?>

  	<section class="content">
  		<div class="container-fluid">
  			<div class="row clearfix">
  				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
  					<div class="card">
  						<div class="header">
  							<h2><?php echo $txt;?>ข้อมูลยี่ห้อสินค้า</h2>
  						</div>
  						<form id="frm-input" method="post" enctype="multipart/form-data" action="process/brand_process.php" >
  							<input type="hidden" id="proc" name="proc" value="<?php echo $proc;?>">
  							<input type="hidden" id="brandID" name="brandID" value="<?php echo $brandID;?>">
  							<input type="hidden" id="form_page" name="form_page" value="<?php echo  $form_page?>">
  							<input type="hidden" id="chk" name="chk" value="0">
  							<input type="hidden" id="chk2" name="chk2" value="0">
                <input type="hidden" id="chk1" name="chk1" value="0">
                <div class="body">
                  <div class="row clearfix">
                   <div class="col-sm-12 align-right"><b><span style="color:red">* กรอกข้อมูลให้ครบทุกช่อง</span></b>
                   </div>
                 </div>
                 <div class="row clearfix">
                   <div class="col-sm-6">
                    <b>รหัสยี่ห้อสินค้า</b>
                    <div class="form-group">
                     <div class="form-line">
                      <input type="text" name="brandCode" id="brandCode" class="form-control" placeholder="รหัสยี่ห้อสินค้า" value="<?php echo $rec['brandCode'];?>" <?php echo $readonly;?>>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <b>ชื่อยี่ห้อสินค้า</b>
                  <div class="form-group">
                   <div class="form-line">
                    <input type="text " onkeyup="chkName();" name="brandName" id="brandName" class="form-control" placeholder="ชื่อยี่ห้อสินค้า" value="<?php echo $rec['brandName'];?>" <?php echo $_SESSION["userType"] == "2" ? $readonly : '';?>>
                  </div>
                  <label id="brandName-error" class="error" for="brandName">กรุณาระบุ ชื่อยี่ห้อสินค้า</label>
                  <label id="brandName-error2" class="error" for="brandName">มีชื่อยี่ห้อสินค้านี้แล้ว</label>
                </div>
              </div>
            </div>


            <div class="row clearfix">
              <div class="col-sm-6">
                <b>อักษรย่อยี่ห้อสินค้า</b>
                <div class="form-group">
                 <div class="form-line">
                  <input type="text " oninput="this.value=this.value.replace(/\s/g, '');" onkeyup="chkNameShort();" maxlength="2" name="brandNameShort" id="brandNameShort" class="form-control" placeholder="อักษรย่อยี่ห้อสินค้า" value="<?php echo $rec['brandNameShort'];?>" <?php echo $_SESSION["userType"] == "2" ? $readonly : '';?>>
                </div>
                <div class="help-info">กรอกได้ไม่เกิน2ตัวอักษร</div>
                <label id="brandNameShort-error" class="error" for="brandNameShort">กรุณาระบุ อักษรย่อยี่ห้อสินค้า</label>
                <label id="brandNameShort-error2" class="error" for="brandNameShort">อักษรย่อยี่ห้อสินค้านี้แล้ว</label>
              </div>
            </div>
            <div class="col-sm-6">
              <b>การใช้งานข้อมูล</b>
              <div class="form-group form-float">
                <select name="status" id="status" class="form-control show-tick" data-live-search="true" <?php echo $_SESSION["userType"] == "2"  ? 'disabled' : '';?> onchange="delData('status',this.value,'hdfstatus');">
                  <?php asort($arr_active);
                  foreach ($arr_active as $key => $value) {?>
                    <option value="<?php echo $key;?>"  
                      <?php 
                      if(($rec['isEnabled']  != "")){
                        echo ($rec['isEnabled']==$key)?"selected":"";
                      }
                      ?>><?php echo $value;?></option>
                    <?php }  ?>
                  </select>
                  <input type="hidden" name="hdfstatus" id="hdfstatus" value="<?php echo $proc == "edit"  ? $rec['isEnabled'] : '1';?>">
                </div>
              </div>
            </div>

            <div class="align-center">
              <button type="button" class="btn btn-success waves-effect" onclick="chkinput();">บันทึก</button>
              <button type="button" class="btn btn-warning waves-effect" onclick="OnCancel();">ยกเลิก</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</section>
<?php include 'js.php';?>
</body>

</html>

<script>
  function OnCancel()
  {

   $(location).attr('href',"<?php echo  $form_page?>");
 }

 function chkinput(){

  if($('#proc').val()=='edit'){
    var brandID= $('#brandID').val();
    $.ajaxSetup({async: false});
    $.post('process/get_process.php',{proc:'chk_editbrand',brandID:brandID},function(data){
      if(data > 0){
        alert('ไม่สามารถแก้ไขข้อมูลได้ เนื่องจากยี่ห้อนี้มีการใช้ข้อมูลนี้อยู่');
        $('#chk1').val(1);
        return false;
      }else{
        $('#chk1').val(0);
      }
    },'json');    
  }

  if($('#chk1').val()==1){
    return false;
  }


  if($('#chk').val()==1){
    $('#brandName-error2').show();
    $('#brandName').focus();
    return false;
  }else{
    $('#brandName-error2').hide();
  }


  if($('#brandName').val()==''){
    $('#brandName-error').show();
    $('#brandName').focus();
    return false;
  }else{
    $('#brandName-error').hide();
  }

  if($('#chk2').val()==1){
    $('#brandNameShort-error2').show();
    $('#brandNameShort').focus();
    return false;
  }else{
    $('#brandNameShort-error2').hide();
  }

  if($('#brandNameShort').val()==''){
    $('#brandNameShort-error').show();
    $('#brandNameShort').focus();
    return false;
  }else{
    $('#brandNameShort-error').hide();
  }

  if($('#brandNameShort').val().length !=2){
    $('#brandNameShort-error').show();
    $('#brandNameShort').focus();
    return false;
  }else{
    $('#brandNameShort-error').hide();
  }

  if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
    $("#frm-input").submit();
  }
}

$(document).ready(function() {
 $('.form-line').removeClass('focused');
 $('.error').hide();

 if($('#proc').val()=='add'){
  var brandCode	 ='';
  $.ajaxSetup({async: false});
  $.post('process/get_process.php',{proc:'get_brandCode'},function(data){
   brandCode =  data['name'];
 },'json');
  $('#brandCode').val(brandCode);
}

  		});

function chkName(){
 var brandName= $('#brandName').val();
 var brandID= $('#brandID').val();
 $.ajaxSetup({async: false});
 $.post('process/get_process.php',{proc:'chk_brandName',brandName:brandName,brandID:brandID},function(data){
  $('.error').hide();
  if(data==1){
   $('#brandName-error2').show();
   $('#chk').val(1);
 }else{
   $('#brandName-error2').hide();
   $('#chk').val(0);

 }

},'json');
}

function chkNameShort(){
 var brandNameShort= $('#brandNameShort').val();
 var brandID= $('#brandID').val();
 $.ajaxSetup({async: false});
 $.post('process/get_process.php',{proc:'chk_brandNameShort',brandNameShort:brandNameShort,brandID:brandID},function(data){
  $('.error').hide();
  if(data==1){
   $('#brandNameShort-error2').show();
   $('#chk2').val(1);
 }else{
   $('#brandNameShort-error2').hide();
   $('#chk2').val(0);

 }

},'json');
}

function delData(parent_id,id,hdf_id){
 var brandID = $('#brandID').val();
 $.ajaxSetup({async: false});
 $.post('process/get_process.php',{proc:'chkDelData_Brand',brandID:brandID},function(data){
  if(data > 0){
   alert('ไม่สามารถยกเลิกข้อมูลได้ เนื่องจากยี่ห้อสินค้านี้มีการใช้ข้อมูลนี้อยู่');
   $('#'+parent_id).val(1);
   return false;
 }else{
   $('#'+hdf_id).val(id);
 }
},'json');

}

//username2
</script>
