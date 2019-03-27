<?php
#---------------------------------------------------------------------------
#
#   Script Name: index.php
#
#       Purpose: Display tasks
#
#---------------------------------------------------------------------------
#
#	Includes
#
#---------------------------------------------------------------------------
	include( "db.php" );
#---------------------------------------------------------------------------
#
#	Connect
#
#---------------------------------------------------------------------------
	$db = mysqli_connect($hostname, $username, $password, $datab);
	if (!$db)
	{
		echo "Error: Could not connect to database. Please try again later.\n";
		exit;
	}
#---------------------------------------------------------------------------
#
#	Display
#
#---------------------------------------------------------------------------
	echo "<html>
<head>
<title>Pepco Database</title>
</head>
<body bgcolor=ffffff><font face=arial,helvetica><h1 align=center>Pepco Database</h1><center>
<br>
<p><table border=1 cellspacing=0 cellpadding=4 width=80%>
<tr>
<font size=+1>
<td bgcolor=cccccc align=left>Account Number</td>
<td bgcolor=cccccc align=left>Name on Invoice</td>
<td bgcolor=cccccc align=left>Service Address</td>
</font>
</tr>\n";

	$query = "select distinct account_number,name_on_invoice,service_address from main order by account_number";
	$result = mysqli_query($db, $query);
	$num_results = mysqli_num_rows($result);

	for ($i=0; $i <$num_results; $i++)
	{
		$row = mysqli_fetch_array($result);
		$an = stripslashes($row['account_number']);
		$noi = stripslashes($row['name_on_invoice']);
		$sa = stripslashes($row['service_address']);

		echo "<tr><td><a href=display.php?number=$an>$an</a><br></td><td>$noi<br></td><td>$sa<br></td></tr>\n";
	}
	echo "</table></center>
<br><br></body></html>\n";
?>
