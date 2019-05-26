<!DOCTYPE html>
<html>
<head>
	<title>Page Title</title>
	<style>
		table, th, td {
			border: 1px solid black;
			border-collapse: collapse;
		}
		th, td {
			padding: 5px;
		}
	</style>
</head>
<body>

	<table width="100%" border="1">
		<tr>
			<th>วันที่</td>
			<th >รหัส</th>
			<th>ชื่อ</th>		
		</tr>
		<tr>
			<td width="15%" rowspan="4">15/05/2019</td>
			<td  rowspan="2">001</td>
			<td>นาย ก</td>		
		</tr>
		<tr>
			<td>นาย ข</td>
		</tr>
		<tr>
			<td rowspan="2">002</td>
			<td>นาย ก</td>
		</tr>

		<tr>
			<td>นาย ข</td>
		</tr>
		<tr>
			<td width="15%" rowspan="4">17/05/2019</td>
			<td rowspan="2">001</td>
			<td>นาย ก</td>		
		</tr>
		<tr>
			<td>นาย ข</td>
		</tr>
		<tr>
			<td  rowspan="2">002</td>
			<td>นาย ก</td>
		</tr>

		<tr>
			<td>นาย ข</td>
		</tr>
	</table>


</body>
</html>