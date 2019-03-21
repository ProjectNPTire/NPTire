<?php
include("config.php");
/****************************************************************************************************************************/
Class PHPDB{
	var $System_Server_Type;
	var $System_HostName,$System_UserName,$System_Password,$System_DBName;
	var $System_Connect,$System_Query,$System_RecordCount,$System_Result;

	function PHPDB($ServerType,$Host,$User,$Password,$DB){
		$this->System_Server_Type=$ServerType;
		$this->System_HostName=$Host;
		$this->System_UserName=$User;
		$this->System_Password=$Password;
		$this->System_DBName=$DB;
	}

	function CONNECT_SERVER(){
		switch($this->System_Server_Type){
			case 'SQLSRV'			:
				/*$connectionInfo = array(
					"Database"=>$this->System_DBName,
					 "UID"=>$this->System_UserName,
					 "PWD"=>$this->System_Password,
					 'ReturnDatesAsStrings'=>true,
					 //  "CharacterSet" => "UTF-8"
				);*/
				$connectionInfo = array("Database"=>$this->System_DBName, "UID"=>$this->System_UserName, "PWD"=>$this->System_Password, 'ReturnDatesAsStrings'=>true,"MultipleActiveResultSets"=>true,"CharacterSet"  => 'UTF-8');
				$this->System_Connect=sqlsrv_connect($this->System_HostName,$connectionInfo);
			break;
			case 'MSSQL'			:
				$this->System_Connect=mssql_connect($this->System_HostName,$this->System_UserName,$this->System_Password);
			break;
			case 'MYSQL'			:
				$this->System_Connect=mysql_connect($this->System_HostName,$this->System_UserName,$this->System_Password) or die(mysql_error());
			break;
			case 'MYSQLI'			:
			//$conn = mysqli_connect($serverName,$userName,$userPassword,$dbName);
				$this->System_Connect=mysqli_connect(
							$this->System_HostName,
							$this->System_UserName,
							$this->System_Password,
							$this->System_DBName) or die(mysql_error());
				mysqli_set_charset($this->System_Connect, "utf8");
			break;
			case 'SYBASE'		:	break;
			case 'INTERBASE'	:	break;
			case	'ORACLE'		:	break;
			case	'INFORMIX'	:	break;
			case	'DBASE'			:	break;
		}
		$this->SELECT_DBNAME();
		return $this->System_Connect;
	}

	function SELECT_DBNAME(){
		switch($this->System_Server_Type){
			case 'SQLSRV'			:	break;
			case 'MSSQL'			:
				MSSQL_SELECT_DB($this->System_DBName,$this->System_Connect);
			break;
			case 'MYSQL'			:
				mysql_select_db($this->System_DBName,$this->System_Connect) or die(mysql_error());
				mysql_db_query($this->System_DBName,"SET NAMES UTF8");
				//mysql_db_query($dbname,"SET NAMES UTF8");
			break;
			case 'MYSQLI'		:	break;
			case 'SYBASE'		:	break;
			case 'INTERBASE'	:	break;
			case	'ORACLE'		:	break;
			case	'INFORMIX'	:	break;
			case	'DBASE'			:	break;
		}
	}

	function db_begin(){
		$sql_begin = "BEGIN TRANSACTION";
		$this->query($sql_begin);
	}//BEGIN TRANSACTION

	function db_commit(){
		$sql_commit = "COMMIT";
		$this->query($sql_commit);
	}//COMMIT

	function query($SQL){



		switch($this->System_Server_Type){
			case 'SQLSRV'			:
				$param1 = array();
				$param2 = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
				$this->System_Query=sqlsrv_query($this->System_Connect,$SQL,$param1,$param2);
			break;
			case 'MSSQL'			:
				$this->System_Query=mssql_query($SQL,$this->System_Connect);
			break;
			case 'MYSQL'			:
				$this->System_Query=mysql_query($SQL,$this->System_Connect) or die($SQL."<br>".mysql_error());
			break;
			case 'MYSQLI'			:
				$this->System_Query=mysqli_query($this->System_Connect,$SQL);

			break;
		}
		return $this->System_Query;

	}

	function query_db($SQL,$database){
		switch($this->System_Server_Type){
			case 'SQLSRV'			:
				$param1 = array();
				$param2 = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
				$this->System_Query=sqlsrv_query($this->System_Connect,$SQL,$param1,$param2);
			break;
			case 'MSSQL'			:
				$this->System_Query=MSSQL_QUERY($SQL,$this->System_Connect);
			break;
			case 'MYSQL'			:
				$this->System_Query=mysql_db_query($database,$SQL,$this->System_Connect) or die($SQL."<br>".mysql_error());
			break;
			case 'SYBASE'		:	break;
			case 'INTERBASE'	:	break;
			case	'ORACLE'		:	break;
			case	'INFORMIX'	:	break;
			case	'DBASE'			:	break;
		}
		return $this->System_Query;
	}

	function condate($date){
		$monthname = array('','ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.');
		if($date == "" OR $date == "0000-00-00" ){
		return "";
		}else{
		$d = explode("-",$date);
		$nd = number_format($d[2],0)." ".$monthname[number_format($d[1],0)]." ".($d[0] + 543);
		return $nd;
		}
	}

	function genpercent($p){
		if($p == 0){
		$result = 'style="width:5px;"';
		}else{
		$percent = ($p/100)*400;
		$result = 'style="width:'.$percent.'px;"';
		}
		return $result;
	}

	function random_num($len){
		srand((double)microtime()*10000000);
		$chars = "ABCDEFGHJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz123456789";
		$ret_str = "";
		$num = strlen($chars);
		for($i=0;$i<$len;$i++){
		$ret_str .= $chars[rand()%$num];
		}
		return $ret_str;
	}

	function count_date($start,$end,$type){
		$s = explode("-",$start);
		$e = explode("-",$end);
		$scount = juliantojd ($s[1] , $s[2] , $s[0]);
		$ecount = juliantojd ($e[1] , $e[2] , $e[0]);
		$count = ($ecount - $scount);
		if($type == "t"){
			if($count == 0){
				$res = "วันนี้";
			}else{
				$res = number_format($count,0).' วันที่แล้ว';
			}
		}else{
			$res = number_format(($count+1),0).' วัน';
		}
		return $res;
	}

	function db_num_rows($Result){
		switch($this->System_Server_Type){
			case 'SQLSRV'			:
				if ($Result === false){
			       $this->System_RecordCount=0;
			    }else{
					$this->System_RecordCount=sqlsrv_num_rows($Result);
			    }
			break;
			case 'MSSQL'			:
				$this->System_RecordCount=mssql_num_rows($Result);
			break;
			case 'MYSQL'			:
				$this->System_RecordCount=mysql_num_rows($Result);
			break;
			case 'MYSQLI'			:
				$this->System_RecordCount=mysqli_num_rows($Result);
			break;
			case 'SYBASE'		:	break;
			case 'INTERBASE'	:	break;
			case	'ORACLE'		:	break;
			case	'INFORMIX'	:	break;
			case	'DBASE'			:	break;
		}
		return $this->System_RecordCount;
	}

	function db_fetch_array($Result){
		switch($this->System_Server_Type){
			case 'SQLSRV' :
					$this->System_Result=sqlsrv_fetch_array($Result);
			break;
			case 'MSSQL' :
					$this->System_Result=MSSQL_FETCH_ARRAY($Result);
			break;
			case 'MYSQL'			:
					$this->System_Result=MYSQL_FETCH_ARRAY($Result);
			break;
			case 'MYSQLI'			:
					$this->System_Result=mysqli_fetch_array($Result,MYSQLI_ASSOC);
			break;
			case 'SYBASE'		:	break;
			case 'INTERBASE'	:	break;
			case	'ORACLE'		:	break;
			case	'INFORMIX'	:	break;
			case	'DBASE'			:	break;
		}
		return $this->System_Result;
	}

	function db_fetch_field($Result,$Index,$Fieldname){
		switch($this->System_Server_Type){
			case 'SQLSRV'			: break;
			case 'MSSQL' :
				$this->System_Result=mssql_result($Result,$Index,$Fieldname);
			break;
			case 'MYSQL'	:
				$this->System_Result=mysql_result($Result,$Index,$Fieldname);
			break;
			case 'SYBASE'		:	break;
			case 'INTERBASE'	:	break;
			case	'ORACLE'		:	break;
			case	'INFORMIX'	:	break;
			case	'DBASE'			:	break;
		}
		return $this->System_Result;
	}

	function db_fetch_row($Result){
		switch($this->System_Server_Type){
			case 'SQLSRV'			: break;
			case 'MSSQL'			:
				$this->System_Result=mssql_fetch_row($Result);
			break;
			case 'MYSQL'			:
				$this->System_Result=mysql_fetch_row($Result);
			break;
			case 'SYBASE'		:	break;
			case 'INTERBASE'	:	break;
			case	'ORACLE'		:	break;
			case	'INFORMIX'	:	break;
			case	'DBASE'			:	break;
		}
		return $this->System_Result;
	}

	function db_close(){
		switch($this->System_Server_Type){
			case 'SQLSRV'			:
					sqlsrv_close($this->System_Connect);
			break;
			case 'MSSQL'			:
					MSSQL_CLOSE($this->System_Connect);
			break;
			case 'MYSQL'			:
					mysql_close($this->System_Connect);
			break;
			case 'SYBASE'		:	break;
			case 'INTERBASE'	:	break;
			case	'ORACLE'		:	break;
			case	'INFORMIX'	:	break;
			case	'DBASE'			:	break;
		}
	}

	function db_insert($tb_name ,$fields,$out_id=''){
		$fieldlist = '';
		$valuelist = '';
		while(list($key, $val) = each($fields)){
			$fieldlist .= ",$key ";
			switch (strtolower($val)) {
				case 'null':break;
				case '$set$':
					$f = "field_$key";
					$val = "'".($$f?implode(',',$$f):'')."'";
				break;
				default:
					$val = "'$val'";
				break;
	        }
			if(empty($funcs[$key]))
				$valuelist .= ",$val ";
			else
				$valuelist .= ",$funcs[$key]($val) ";
		}
		$valuelist = str_replace(", $", "", $valuelist);
		$valuelist = substr($valuelist,1,strlen($valuelist));
		$fieldlist = str_replace(", $", "", $fieldlist);
		$fieldlist = substr($fieldlist,1,strlen($fieldlist));
		//$fieldlist = ereg_replace(', $', '', $fieldlist);
		//$valuelist = ereg_replace(', $', '', $valuelist);

		$sql = "INSERT INTO $tb_name($fieldlist) VALUES ($valuelist)";
		$query_id = $this->query($sql);

		if($out_id=='y'){
			switch($this->System_Server_Type){
				case 'SQLSRV'			:
					/*$query = $this->query(" SELECT SCOPE_IDENTITY() AS ID ");
					$rs =  $this->db_fetch_array($query);
					return $rs['ID'];*/
					$query = $this->query("select @@identity as ID");
					$rs =  $this->db_fetch_array($query);
					return $rs['ID'];
				break;
				case 'MSSQL'			:
					$query = $this->query("select @@identity");
					$rs =  $this->db_fetch_array($query);
					return $rs['computed'];
				break;
				case 'MYSQL'			:
					return mysql_insert_id();
				break;
				case 'MYSQLI'			:
					return mysqli_insert_id($this->System_Connect);
				break;
				case 'SYBASE'		:	break;
				case 'INTERBASE'	:	break;
				case 'ORACLE'		:	break;
				case 'INFORMIX'		:	break;
				case 'DBASE'		:	break;
			}
		}
	}//insert

	function db_update($table , $fields,$cond){
		$valuelist = '';
		while(list($key, $val) = each($fields)){
			switch (strtolower($val)) {
				case 'null':
					break;
				case '$set$':
					$f = "field_$key";
					$val = "'".($$f?implode(',',$$f):'')."'";
					break;
				default:
					$val = "'$val'";
					break;
			}
			$valuelist .= ",$key = $val ";
			if (!empty($funcs)){
				if(!empty($funcs[$key]))$valuelist .= " ,$key = $funcs[$key]($val) ";
			}
		}

		//$valuelist = ereg_replace(', $', '', $valuelist);

		$valuelist = str_replace(", $", "", $valuelist);
		$valuelist = substr($valuelist,1,strlen($valuelist));
		//$len = strlen($valuelist);
		//$valuelist =substr($valuelist,0,($len-1));

		$sql = "UPDATE $table SET $valuelist  where  1=1  and ".$cond;
		$this->query($sql);
	}//update

	function db_delete($table , $cond){
		//global $menu_sub_id,$USER_BY,$TIMESTAMP;

		$sql = "DELETE FROM ".$table;
		if( $cond)	{
			$sql .= " where  1=1 and".$cond;
		}
		$this->query($sql);

		/*เก็บ LOG การใช้งานในแต่ละหน้า*/
		//log_aut('del',$_SESSION['sys_id'],$menu_sub_id,$USER_BY,$TIMESTAMP);
	}//db_delete

	function get_pos_no($per_id){
		$sql = "SELECT B.POS_NO FROM PER_PROFILE A JOIN POSITION_FRAME B ON A.POS_ID = B.POS_ID WHERE A.PER_ID = '".$per_id."' ";
		$query = $this->query($sql);
		$rec = $this->db_fetch_array($query);
		return $rec['POS_NO'];
	}

	function get_data_rec($sql){
		$query = $this->query($sql);
		return $rec = $this->db_fetch_array($query);
	}

	function get_data_field($sql,$se_field){
		$query = $this->query($sql);
		$rec = $this->db_fetch_array($query);
		return $rec[$se_field];
	}
	function getPositionHoldingDay($POSHIS_ID, $YEAR_BDG){
		$SHOLD = '';
		$EHOLD = "";
		$SDATE = ($YEAR_BDG-544)."-10-01";
		$EDATE = ($YEAR_BDG-543)."-09-30";
		$SDATEINT = (int)str_replace('-','',$SDATE);
		$EDATEINT = (int)str_replace('-','',$EDATE);

		if(trim($POSHIS_ID) != ''){
		  $sql  = "SELECT PER_ID, COM_SDATE FROM PER_POSITIONHIS WHERE POSHIS_ID = '".$POSHIS_ID."' ";
		  $query = $this->query($sql);
		  $rec = $this->db_fetch_array($query);
		  $PER_ID = $rec['PER_ID'];
		  $COM_SDATE = (int)str_replace('-','',$rec['COM_SDATE']);
		  if($COM_SDATE <= $SDATEINT){  //ตรวจสอบว่าวันที่มีผลบังคับใช่ มีค่าน้อยกว่าวันเริ่มปีงบประมาณหรือไม่
			  $SHOLD = $SDATE;
		  }else{
			  $SHOLD = $rec['COM_SDATE'];
		  }
		  //ตรวจสอบวันสิ้นสุดการถือครองตำแหน่ง
		  $query_chk = $this->query("SELECT TOP 1 COM_SDATE FROM PER_POSITIONHIS WHERE PER_ID = '".$PER_ID."' AND COM_SDATE > '".$rec['COM_SDATE']."' ORDER BY  COM_SDATE ASC   ");
		  $num_chk = $this->db_num_rows($query_chk);
		  $rec_chk = $this->db_fetch_array($query_chk);
		  if($num_chk > 0){
			 $COM_SDATECHK = (int)str_replace('-','',$rec_chk['COM_SDATE']);
			 if($COM_SDATECHK < $EDATEINT){
				$EHOLD =  date('Y-m-d',strtotime ('-1 days', strtotime($rec_chk['COM_SDATE']) ));
			 }else{
				 $EHOLD = $EDATE;
			 }
		  }else{
			   $EHOLD = $EDATE;
		  }

		  $query_day = $this->query("SELECT DATEDIFF(day,'".$SHOLD."','".$EHOLD."') AS YEAR_DAY ");
		  $rec_day = $this->db_fetch_array($query_day);
		  $YEAR_DAY = ($rec_day['YEAR_DAY']+1);
		  return $YEAR_DAY;
		}else{
			return 0;
		}

	}
	function getHoldingDayAll($s_date, $e_date, $org_id_3, $year_bdg,$num_year){
		$sql_pr = "SELECT PER_ID
		FROM BONUS_ADJUST
		WHERE YEAR_BDG = '".$year_bdg."'  AND ORG_ID_3 = '".$org_id_3."' AND POSTYPE_ID = 1 ";
		$query_pr = $this->query($sql_pr);
		$num = 0;
		while($rec = $this->db_fetch_array($query_pr)){
			$pos_holding = $this->getPositionHoldingDay($s_date,$e_date,$rec['PER_ID']);
			$num = $num + ($pos_holding/$num_year);
		}
		return $num;
	}
	function getPer($year_bdg, $postype, $org_id_3 = ''){
		 $filter = "";
		if(trim($org_id_3) != ''){
			$filter .= " AND A.ORG_ID_3 = '".$org_id_3."' ";
		}

		$SDATE = ($year_bdg-544)."-10-01";
		$EDATE = ($year_bdg-543)."-09-30";
		$sql  = "SELECT A.PER_ID FROM PER_PROFILE A WHERE A.POSTYPE_ID IN(".$postype.") AND ((A.PER_DATE_RESIGN >= '".$SDATE."') or A.PER_DATE_RESIGN IS NULL )  ";
		$query = $this->query($sql);

		while($rec = $this->db_fetch_array($query)){
			$sql_his ="SELECT  A.POSHIS_ID  FROM PER_POSITIONHIS A
			LEFT JOIN SETUP_POS_MANAGE B ON A.MANAGE_ID = B.MANAGE_ID  WHERE A.PER_ID = '".$rec['PER_ID']."' AND (B.MT_ID = 0 or B.MT_ID IS NULL) ".$filter;
			$query_his = $this->query($sql_his);
			$num_his = $this->db_num_rows($query_his);
			if($num_his > 0){
				while($rec_his = $this->db_fetch_array($query_his)){
					$arr[$rec_his['POSHIS_ID']] = $rec_his['POSHIS_ID'];
				}
			}else{
				$sql_his ="SELECT TOP 1  A.POSHIS_ID  FROM PER_POSITIONHIS A LEFT JOIN SETUP_POS_MANAGE B ON A.MANAGE_ID = B.MANAGE_ID WHERE A.PER_ID = '".$rec['PER_ID']."' AND (B.MT_ID = 0 or B.MT_ID IS NULL) ".$filter." ORDER BY COM_SDATE DESC ";
				$query_his = $this->query($sql_his);
				$rec_his = $this->db_fetch_array($query_his);
				if(trim($rec_his['POSHIS_ID']) != ''){
					$arr[$rec_his['POSHIS_ID']] = $rec_his['POSHIS_ID'];
				}
			}


		}// end while
		return $arr;
	}
	function getPerMg($year_bdg){

		$SDATE = ($year_bdg-544)."-10-01";
		$EDATE = ($year_bdg-543)."-09-30";
		$sql  = "SELECT A.PER_ID
				   FROM PER_PROFILE A
				   JOIN PER_POSITIONHIS B ON A.PER_ID = B.PER_ID
				   JOIN SETUP_POS_MANAGE_TYPE C ON B.MT_ID = C.MT_ID
				   WHERE C.MT_TYPE IN(1,2) AND B.ORG_ID_2 = 15 AND ((A.PER_DATE_RESIGN >= '".$SDATE."') or A.PER_DATE_RESIGN IS NULL )
				   GROUP BY A.PER_ID ";
		$query = $this->query($sql);

		while($rec = $this->db_fetch_array($query)){
			$sql_his ="SELECT  POSHIS_ID  FROM PER_POSITIONHIS WHERE PER_ID = '".$rec['PER_ID']."'  ";
			$query_his = $this->query($sql_his);
			$num_his = $this->db_num_rows($query_his);
			if($num_his > 0){
				while($rec_his = $this->db_fetch_array($query_his)){
					$arr[$rec_his['POSHIS_ID']] = $rec_his['POSHIS_ID'];
				}
			}else{
				$sql_his ="SELECT TOP 1  POSHIS_ID  FROM PER_POSITIONHIS WHERE PER_ID = '".$rec['PER_ID']."' ORDER BY COM_SDATE DESC ";
				$query_his = $this->query($sql_his);
				$rec_his = $this->db_fetch_array($query_his);
				if(trim($rec_his['POSHIS_ID']) != ''){
					$arr[$rec_his['POSHIS_ID']] = $rec_his['POSHIS_ID'];
				}
			}


		}// end while
		return $arr;
	}

	function CalBonusFram($salary, $count_per, $type){
		if($type == 1){ //เลขาธิการ
			$money_fram = 42000;
			$salary_price = 150000;
			$cal = ($salary_price - ($salary+$money_fram))*12;
		}else if($type == 2){
			$money_fram = (29000*$count_per);
			$salary_price = (110000*$count_per);
			$cal = ($salary_price-($salary+$money_fram))*12;
		}else if($type == 3){
			$money_fram = (10000*$count_per);
			$salary_price = (10000*$count_per);
			$cal = (($salary+$money_fram) - $salary_price)*12;
		}
		return $cal;
	}

	function pageTable($sql, $sqlall, $page, $targetpage, $ConPost, $s_file='', $span='', $TYPE=''){
		$pagination = "";
		$result = "";
		$lastpage = "";
		$adjacents = 1;

		//main
		$result1 = $this->query($sql);
		$total_pages1 = $this->db_num_rows($result1);

		//all
		$result2 = $this->query($sqlall);
		$a_total_unit = $this->db_num_rows($result2);

		if ((int)$page == 0) $page = 1;
		$prev = $page - 1;
		$next = $page + 1;
		$lastpage=@ceil($a_total_unit/10);
		$lpm1 = $lastpage - 1;

		if($lastpage){
			$pagination .= "<div class='browse_page'>";
				if ($page > 1){
					$pagination.= "<a href=\"#\" class='naviPN' onClick=\"FncLoad_Form('".$span."','".$s_file."','".$targetpage."=".$prev.$ConPost."','".$TYPE."');\">Prev</a>";
				}

				if ($lastpage < 7 + ($adjacents * 2)) {
					for ($counter = 1; $counter <= $lastpage; $counter++){
						if ($counter == $page){
							$pagination.= "<a href=\"#\" class='selectPage'\">".$counter."</a>";
						}else{
							$pagination.= "<a href=\"#\" onClick=\"FncLoad_Form('".$span."','".$s_file."','".$targetpage."=".$counter.$ConPost."','".$TYPE."');\">".$counter."</a>";
						}
					}
				}elseif($lastpage > 5 + ($adjacents * 2)) {
					if($page < 1 + ($adjacents * 2))  {
						for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
							if ($counter == $page){
								$pagination.= "<a href=\"#\" class='selectPage'\">".$counter."</a>";
							}else{
								$pagination.= "<a href=\"#\" onClick=\"FncLoad_Form('".$span."','".$s_file."','".$targetpage."=".$counter.$ConPost."','".$TYPE."');\">".$counter."</a>";
								//$pagination.= "<a href=\"#\" onClick=\"testajax('".$counter."');\">a".$counter."</a>";
							}
						}#end for
					}elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)){
						$pagination.= "<a href=\"#\" onClick=\"FncLoad_Form('".$span."','".$s_file."','".$targetpage."=1".$ConPost."','".$TYPE."');\">1</a>";
						$pagination.= "<a href=\"#\" onClick=\"FncLoad_Form('".$span."','".$s_file."','".$targetpage."=2".$ConPost."','".$TYPE."');\">2</a>";
						$pagination.= "<a class='SpaceC'>...</a>";
						for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++){
							if ($counter == $page)
								$pagination.= "<a href=\"#\" class='selectPage'\">".$counter."</a>";
							else
								$pagination.= "<a href=\"#\" onClick=\"FncLoad_Form('".$span."','".$s_file."','".$targetpage."=".$counter.$ConPost."','".$TYPE."');\">".$counter."</a>";
						}#end for
						$pagination.= "<a class='SpaceC'>...</a>";
						$pagination.= "<a href=\"#\" onClick=\"FncLoad_Form('".$span."','".$s_file."','".$targetpage."=".$lpm1.$ConPost."','".$TYPE."');\">".$lpm1."</a>";
						$pagination.= "<a href=\"#\" onClick=\"FncLoad_Form('".$span."','".$s_file."','".$targetpage."=".$lastpage.$ConPost."','".$TYPE."');\">".$lastpage."</a>";
					}else{
						$pagination.= "<a href=\"#\" onClick=\"FncLoad_Form('".$span."','".$s_file."','".$targetpage."=1".$ConPost."','".$TYPE."');\">1</a>";
						$pagination.= "<a href=\"#\" onClick=\"FncLoad_Form('".$span."','".$s_file."','".$targetpage."=2".$ConPost."','".$TYPE."');\">2</a>";
						$pagination.= "<a class='SpaceC'>...</a>";
						for($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++){
							if($counter == $page)
								$pagination.= "<a href=\"#\" class='selectPage'\">".$counter."</a>";
							else
								$pagination.= "<a href=\"#\" onClick=\"FncLoad_Form('".$span."','".$s_file."','".$targetpage."=".$counter.$ConPost."','".$TYPE."');\">".$counter."</a>";
						}#end for
					}
				}
				if ($page < $counter - 1){
					$pagination.= "<a href=\"#\" class='naviPN' onClick=\"FncLoad_Form('".$span."','".$s_file."','".$targetpage."=".$next.$ConPost."','".$TYPE."');\">Next</a>";
				}
			$pagination .= "<a class='SpaceC'>/".$a_total_unit."</a></div>";
		}
		return array($pagination,$result1,$lastpage);
	}

	//ใช้หน้า alert_popup
	function pageTable2($arr_data, $arr_data_all, $page, $targetpage, $ConPost, $s_file='', $span='', $TYPE=''){
		$pagination = "";
		$result = "";
		$lastpage = "";
		$adjacents = 1;

		//main
		$result1 = count($arr_data);

		//all
		$a_total_unit = count($arr_data_all);

		if ((int)$page == 0) $page = 1;
		$prev = $page - 1;
		$next = $page + 1;
		$lastpage=@ceil($a_total_unit/10);
		$lpm1 = $lastpage - 1;

		if($lastpage){
				$pagination .= "<div class='browse_page'>";
					if ($page > 1){
						$pagination.= "<a href=\"#\" class='naviPN' onClick=\"FncLoad_Form('".$span."','".$s_file."','".$targetpage."=".$prev.$ConPost."','".$TYPE."');\">Prev</a>";
					}

					if ($lastpage < 7 + ($adjacents * 2)) {
						for ($counter = 1; $counter <= $lastpage; $counter++){
							if ($counter == $page){
								$pagination.= "<a href=\"#\" class='selectPage'\">".$counter."</a>";
							}else{
								$pagination.= "<a href=\"#\" onClick=\"FncLoad_Form('".$span."','".$s_file."','".$targetpage."=".$counter.$ConPost."','".$TYPE."');\">".$counter."</a>";
							}
						}
					}elseif($lastpage > 5 + ($adjacents * 2)) {
						if($page < 1 + ($adjacents * 2))  {
							for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
								if ($counter == $page){
									$pagination.= "<a href=\"#\" class='selectPage'\">".$counter."</a>";
								}else{
									$pagination.= "<a href=\"#\" onClick=\"FncLoad_Form('".$span."','".$s_file."','".$targetpage."=".$counter.$ConPost."','".$TYPE."');\">".$counter."</a>";
									//$pagination.= "<a href=\"#\" onClick=\"testajax('".$counter."');\">a".$counter."</a>";
								}
							}#end for
						}elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)){
							$pagination.= "<a href=\"#\" onClick=\"FncLoad_Form('".$span."','".$s_file."','".$targetpage."=1".$ConPost."','".$TYPE."');\">1</a>";
							$pagination.= "<a href=\"#\" onClick=\"FncLoad_Form('".$span."','".$s_file."','".$targetpage."=2".$ConPost."','".$TYPE."');\">2</a>";
							$pagination.= "<a class='SpaceC'>...</a>";
							for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++){
								if ($counter == $page)
									$pagination.= "<a href=\"#\" class='selectPage'\">".$counter."</a>";
								else
									$pagination.= "<a href=\"#\" onClick=\"FncLoad_Form('".$span."','".$s_file."','".$targetpage."=".$counter.$ConPost."','".$TYPE."');\">".$counter."</a>";
							}#end for
							$pagination.= "<a class='SpaceC'>...</a>";
							$pagination.= "<a href=\"#\" onClick=\"FncLoad_Form('".$span."','".$s_file."','".$targetpage."=".$lpm1.$ConPost."','".$TYPE."');\">".$lpm1."</a>";
							$pagination.= "<a href=\"#\" onClick=\"FncLoad_Form('".$span."','".$s_file."','".$targetpage."=".$lastpage.$ConPost."','".$TYPE."');\">".$lastpage."</a>";
						}else{
							$pagination.= "<a href=\"#\" onClick=\"FncLoad_Form('".$span."','".$s_file."','".$targetpage."=1".$ConPost."','".$TYPE."');\">1</a>";
							$pagination.= "<a href=\"#\" onClick=\"FncLoad_Form('".$span."','".$s_file."','".$targetpage."=2".$ConPost."','".$TYPE."');\">2</a>";
							$pagination.= "<a class='SpaceC'>...</a>";
							for($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++){
								if($counter == $page)
									$pagination.= "<a href=\"#\" class='selectPage'\">".$counter."</a>";
								else
									$pagination.= "<a href=\"#\" onClick=\"FncLoad_Form('".$span."','".$s_file."','".$targetpage."=".$counter.$ConPost."','".$TYPE."');\">".$counter."</a>";
							}#end for
						}
					}
					if ($page < $counter - 1){
						$pagination.= "<a href=\"#\" class='naviPN' onClick=\"FncLoad_Form('".$span."','".$s_file."','".$targetpage."=".$next.$ConPost."','".$TYPE."');\">Next</a>";
					}
				$pagination .= "<a class='SpaceC'>/".$a_total_unit."</a></div>";
			}
		return array($pagination,$result1,$lastpage);
	}
	//xml
	function pageTableXML($perPage, $total, $page, $targetpage, $ConPost, $s_file='', $span='', $TYPE=''){
		$pagination = "";
		$result = "";
		$lastpage = "";
		$adjacents = 1;

		if ((int)$page == 0) $page = 1;
		$prev = $page - 1;
		$next = $page + 1;
		$lastpage=@ceil($total/20);
		$lpm1 = $lastpage - 1;

		if($lastpage){
			$pagination .= "<div class='browse_page'>";
				if ($page > 1){
					$pagination.= "<a href=\"#\" class='naviPN' onClick=\"FncLoad_Form('".$span."','".$s_file."','".$targetpage."=".$prev.$ConPost."','".$TYPE."');\">Prev</a>";
				}

				if ($lastpage < 7 + ($adjacents * 2)) {
					for ($counter = 1; $counter <= $lastpage; $counter++){
						if ($counter == $page){
							$pagination.= "<a href=\"#\" class='selectPage'\">".$counter."</a>";
						}else{
							$pagination.= "<a href=\"#\" onClick=\"FncLoad_Form('".$span."','".$s_file."','".$targetpage."=".$counter.$ConPost."','".$TYPE."');\">".$counter."</a>";
						}
					}
				}elseif($lastpage > 5 + ($adjacents * 2)) {
					if($page < 1 + ($adjacents * 2))  {
						for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
							if ($counter == $page){
								$pagination.= "<a href=\"#\" class='selectPage'\">".$counter."</a>";
							}else{
								$pagination.= "<a href=\"#\" onClick=\"FncLoad_Form('".$span."','".$s_file."','".$targetpage."=".$counter.$ConPost."','".$TYPE."');\">".$counter."</a>";
								//$pagination.= "<a href=\"#\" onClick=\"testajax('".$counter."');\">a".$counter."</a>";
							}
						}#end for
					}elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)){
						$pagination.= "<a href=\"#\" onClick=\"FncLoad_Form('".$span."','".$s_file."','".$targetpage."=1".$ConPost."','".$TYPE."');\">1</a>";
						$pagination.= "<a href=\"#\" onClick=\"FncLoad_Form('".$span."','".$s_file."','".$targetpage."=2".$ConPost."','".$TYPE."');\">2</a>";
						$pagination.= "<a class='SpaceC'>...</a>";
						for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++){
							if ($counter == $page)
								$pagination.= "<a href=\"#\" class='selectPage'\">".$counter."</a>";
							else
								$pagination.= "<a href=\"#\" onClick=\"FncLoad_Form('".$span."','".$s_file."','".$targetpage."=".$counter.$ConPost."','".$TYPE."');\">".$counter."</a>";
						}#end for
						$pagination.= "<a class='SpaceC'>...</a>";
						$pagination.= "<a href=\"#\" onClick=\"FncLoad_Form('".$span."','".$s_file."','".$targetpage."=".$lpm1.$ConPost."','".$TYPE."');\">".$lpm1."</a>";
						$pagination.= "<a href=\"#\" onClick=\"FncLoad_Form('".$span."','".$s_file."','".$targetpage."=".$lastpage.$ConPost."','".$TYPE."');\">".$lastpage."</a>";
					}else{
						$pagination.= "<a href=\"#\" onClick=\"FncLoad_Form('".$span."','".$s_file."','".$targetpage."=1".$ConPost."','".$TYPE."');\">1</a>";
						$pagination.= "<a href=\"#\" onClick=\"FncLoad_Form('".$span."','".$s_file."','".$targetpage."=2".$ConPost."','".$TYPE."');\">2</a>";
						$pagination.= "<a class='SpaceC'>...</a>";
						for($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++){
							if($counter == $page)
								$pagination.= "<a href=\"#\" class='selectPage'\">".$counter."</a>";
							else
								$pagination.= "<a href=\"#\" onClick=\"FncLoad_Form('".$span."','".$s_file."','".$targetpage."=".$counter.$ConPost."','".$TYPE."');\">".$counter."</a>";
						}#end for
					}
				}
				if ($page < $counter - 1){
					$pagination.= "<a href=\"#\" class='naviPN' onClick=\"FncLoad_Form('".$span."','".$s_file."','".$targetpage."=".$next.$ConPost."','".$TYPE."');\">Next</a>";
				}
			$pagination .= "<a class='SpaceC'>/".$total."</a></div>";
		}
		return array($pagination,$perPage,$lastpage);
	}

	function __destruct(){

	 $this->db_close();
	}

}

//parliament_hr

$db = new PHPDB($EWT_DB_TYPE,$EWT_ROOT_HOST,$EWT_ROOT_USER,$EWT_ROOT_PASSWORD,$EWT_DB_NAME);
$connectdb=$db->CONNECT_SERVER();

if($EWT_ROOT_HOST=='10.156.2.130'){
	//NitgenAccessManager
	$db_NGAC =new PHPDB($NGAC_DB_TYPE,$NGAC_ROOT_HOST,$NGAC_ROOT_USER,$NGAC_ROOT_PASSWORD,$NGAC_DB_NAME);
	$connectdb=$db_NGAC->CONNECT_SERVER();
}
?>
