<?php
	//echo isset($page)."aaa";

	$default = 20;
/*	if(trim(isset($page_size)) == "")
		$page_size=$default;
	else
		$page_size=$page_size;
	if(trim(isset($page))=='')
		$page=1;
	else
		$page=$page;*/
	$page_size = (isset($page_size) == null) ? $default:$page_size;
	//$arrPage = array("20"=>"20","40"=>"40","60"=>"60","80"=>"80","100"=>"100","200"=>"200","2000"=>"ทั้งหมด");
	$arrPage = array("20"=>"20","50"=>"50","100"=>"100","500"=>"500","1000"=>"1000");
	$page = (isset($page) == null) ? 1:$page;
	 $goto  = ($page_size*($page-1));
//echo $page;


	function startPaging($form,$total_record){
		global $default , $arrPage , $page , $page_size;

		$page_size = ($page_size == "") ? $default:$page_size;

		$total_page = ceil($total_record/$page_size);

		$max_page = ($total_page > 4) ? 4:$total_page;

		$start_page = ($page == "") ? 1:$page-2;
		$start_page = ($start_page <= 0) ? 1:$start_page;

		$end_page = ($max_page+$start_page);
		$end_page = ($end_page > $total_page) ? $total_page:$end_page;

		$start_page = (($end_page - $start_page) < 4) ? $end_page-4:$start_page;
		$start_page = ($start_page <= 0) ? 1:$start_page;

		$startClass = ($page == 1) ? " class=\"disabled\" ":"";
		$endClass = ($page == $total_page) ? " class=\"disabled\" ":"";

		$html = "<div class=\"col-xs-6 col-sm-6 hidden-md hidden-lg\">
            	<div style=\"height:80px; display:table-cell; vertical-align:middle;\">
                    <div class=\"input-group\">
                      <span class=\"input-group-btn\">
                          <button type=\"button\" class=\"btn btn-default dropdown-toggle\" data-toggle=\"dropdown\">
                            แสดง ".$arrPage[$page_size]." <span class=\"caret\"></span>
                          </button>
                          <ul class=\"dropdown-menu\" role=\"menu\">";
						  foreach($arrPage as $key => $val){
						  	$html .= "<li><a href=\"javascript:void(0);\" onclick=\"$('#page_size').val('".$key."'); $('#page').val('1'); $('#".$form."').submit();\">แสดง ".$val."</a></li>";
						  }
                          $html .= "</ul>
                      </span>
                      <span class=\"input-group-addon\"> / หน้า จำนวน ".$total_record." รายการ</span>
                    </div>
                </div>
            </div>
            <div class=\"col-xs-6 col-sm-6 hidden-xs hidden-sm hidden-md hidden-lg\">
                <ul class=\"pagination pull-right\">";
				if($page == 1){
                  $html .= "<li $startClass ><a href=\"javascript:void(0);\" style=\"cursor:default\" >&laquo;</a></li>
                  <li $startClass ><a href=\"javascript:void(0);\" style=\"cursor:default\" >&#8249;</a></li>";
				}else{
					$html .= "<li $startClass ><a href=\"javascript:void(0);\" onclick=\"$('#page').val('1'); $('#".$form."').submit();\">&laquo;</a></li>
                  <li $startClass ><a href=\"javascript:void(0);\" onclick=\"$('#page').val('".($page-1)."'); $('#".$form."').submit();\">&#8249;</a></li>";
				}
				  for($i=$start_page;$i<=$end_page;$i++){
					  	$active = ($i == $page) ? " class=\"active\" ":"";
                  	$html .= "<li $active ><a href=\"javascript:void(0);\" onclick=\"$('#page').val('".($i)."'); $('#".$form."').submit();\">".$i."</a></li>";
				  }
				  if($page == $total_page){
					  $html .= "<li $endClass ><a href=\"javascript:void(0);\" style=\"cursor:default\">&#8250;</a></li>
					  <li $endClass ><a href=\"javascript:void(0);\" style=\"cursor:default\">&raquo;</a></li>";
				  }else{
					  $html .= "<li><a href=\"javascript:void(0);\" onclick=\"$('#page').val('".($page+1)."'); $('#".$form."').submit();\">&#8250;</a></li>
					  <li><a href=\"javascript:void(0);\" onclick=\"$('#page').val('".$total_page."'); $('#".$form."').submit();\">&raquo;</a></li>";
				  }
                $html .="</ul>
            </div>";

			return $html;
	}

	function endPaging($form,$total_record){

		global $default , $arrPage , $page , $page_size;

		$page_size = ($page_size == "") ? $default:$page_size;

		$total_page = ceil($total_record/$page_size);

		$max_page = ($total_page > 4) ? 4:$total_page;

		$start_page = ($page == "") ? 1:$page-2;
		$start_page = ($start_page <= 0) ? 1:$start_page;

		$end_page = ($max_page+$start_page);
		$end_page = ($end_page > $total_page) ? $total_page:$end_page;

		$start_page = (($end_page - $start_page) < 4) ? $end_page-4:$start_page;
		$start_page = ($start_page <= 0) ? 1:$start_page;

		$startClass = ($page == 1) ? " class=\"disabled\" ":"";
		$endClass = ($page == $total_page) ? " class=\"disabled\" ":"";


   	$html = '	<div class="row">
					<div class="col-sm-6 hidden-xs ">
			   			<div class="user-info">
			                <div class="info-container">
			                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></div>
			                    <div class="btn-group user-helper-dropdown">
			                        <i class=" waves-effect waves-block" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">แสดง '.$arrPage[$page_size].' / หน้า จำนวน '.$total_record.' รายการ</i>
			                        <ul class="dropdown-menu pull-left">';
			                           foreach($arrPage as $key => $val){
			                     $html .= "<li><a class=\" waves-effect waves-block\" href=\"javascript:void(0);\" onclick=\"$('#page_size').val('".$key."'); $('#page').val('1'); $('#".$form."').submit();\">แสดง ".$val."</a></li>";
			                          }
		$html .= '                  </ul>
			                    </div>
			                </div>
			            </div>
		             </div>';
		/*$html = "<div class=\"row\">
					<div class=\"col-sm-6 hidden-xs \">
				   	<div class=\"container\">
				    <ul class=\"navbar-nav\" >
						<li class=\"nav-item dropdown hvr-forward\"  style=\" background-color: #cce5ff; color: #004085;\">
					        <a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"navbarDropdownMenuLink\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">แสดง ".$arrPage[$page_size]." / หน้า จำนวน ".$total_record." รายการ</a>
					        <div class=\"dropdown-menu\" aria-labelledby=\"navbarDropdownMenuLink\"> ";
					           foreach($arrPage as $key => $val){
						  	$html .= "<a class=\"dropdown-item\" href=\"javascript:void(0);\" onclick=\"$('#page_size').val('".$key."'); $('#page').val('1'); $('#".$form."').submit();\">แสดง ".$val."</a>";
						  }

				$html .= "	</div>
				      	</li>
				  	</ul>
				  	</div>
					</div>";*/

		     $html .= "	 <div class=\"col-xs-12 col-sm-6\">
		                <ul class=\"pagination pull-right\">";
		                  if($page == 1){
							  $html .= "<li $startClass ><a href=\"javascript:void(0);\" style=\"cursor:default\" >&laquo;</a></li>
							  <li $startClass ><a href=\"javascript:void(0);\" style=\"cursor:default\" >&#8249;</a></li>";
							}else{
								$html .= "<li $startClass ><a href=\"javascript:void(0);\" onclick=\"$('#page').val('1'); $('#".$form."').submit();\">&laquo;</a></li>
							  <li $startClass ><a href=\"javascript:void(0);\" onclick=\"$('#page').val('".($page-1)."'); $('#".$form."').submit();\">&#8249;</a></li>";
							}
						  for($i=$start_page;$i<=$end_page;$i++){
							  	$active = ($i == $page) ? " class=\"active\" ":"";
						  	$html .= "<li $active ><a href=\"javascript:void(0);\" onclick=\"$('#page').val('".($i)."'); $('#".$form."').submit();\">".$i."</a></li>";
						  }
		                  if($page == $total_page){
							  $html .= "<li $endClass ><a href=\"javascript:void(0);\" style=\"cursor:default\">&#8250;</a></li>
							  <li $endClass ><a href=\"javascript:void(0);\" style=\"cursor:default\">&raquo;</a></li>";
						  }else{
							  $html .= "<li><a href=\"javascript:void(0);\" onclick=\"$('#page').val('".($page+1)."'); $('#".$form."').submit();\">&#8250;</a></li>
							  <li><a href=\"javascript:void(0);\" onclick=\"$('#page').val('".$total_page."'); $('#".$form."').submit();\">&raquo;</a></li>";
						  }
		                $html .= "</ul>
		            </div>
             </div>";

			return $html;
	}



?>
