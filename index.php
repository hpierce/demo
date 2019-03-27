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
<td bgcolor=cccccc align=left>Name on Invoice</td>
<td bgcolor=cccccc align=left>Service Address</td>
<td bgcolor=cccccc align=left>Account Number</td>
<td bgcolor=cccccc align=left>Supplier 1 Name</td>
<td bgcolor=cccccc align=left>Supplier 1 Amount</td>
<td bgcolor=cccccc align=left>Supplier2 Name</td>
<td bgcolor=cccccc align=left>Supplier 2 Amount</td>
<td bgcolor=cccccc align=left>New Charges</td>
<td bgcolor=cccccc align=left>Balance Forward</td>
<td bgcolor=cccccc align=left>Total Credit Amount</td>
<td bgcolor=cccccc align=left>Total Amount Due</td>
<td bgcolor=cccccc align=left>Bill Date</td>
<td bgcolor=cccccc align=left>Meter Start</td>
<td bgcolor=cccccc align=left>Meter End</td>
<td bgcolor=cccccc align=left>Next Meter Read</td>
<td bgcolor=cccccc align=left>Number of Days</td>
</font>
</tr>\n";

	$query = "select * from main order by account_number,bill_date";
	$result = mysqli_query($db, $query);
	$num_results = mysqli_num_rows($result);

	for ($i=0; $i <$num_results; $i++)
	{
		$row = mysqli_fetch_array($result);
		$fn = stripslashes($row['filename']);
		$noi = stripslashes($row['name_on_invoice']);
		$sa = stripslashes($row['service_address']);
		$an = stripslashes($row['account_number']);
		$sup1n = stripslashes($row['supplier1_name']);
		$sup1a = stripslashes($row['supplier1_amount']);
		$sup2n = stripslashes($row['supplier2_name']);
		$sup2a = stripslashes($row['supplier2_amount']);
		$new = stripslashes($row['new_charges']);
		$bf = stripslashes($row['balance_forward']);
		$tca =  stripslashes($row['total_credit_amount']);
		$tad = stripslashes($row['total_amount_due']);
		$bd = stripslashes($row['bill_date']);
		$mets = stripslashes($row['meter_start']);
		$mete = stripslashes($row['meter_end']);
		$metn = stripslashes($row['next_meter_read']);
		$nod = stripslashes($row['number_of_days']);

		echo "<tr><td><a href=files/$fn>$noi</a><br></td><td>$sa<br></td><td><a href=display.php?number=$an>$an</a><br></td><td>$sup1n<br></td><td>$sup1a<br></td><td>$sup2n<br></td><td>$sup2a<br></td><td>$new<br></td><td>$bf<br></td><td>$tca<br></td><td>$tad<br></td><td>$bd<br></td><td>$mets<br></td><td>$mete<br></td><td>$metn<br></td><td>$nod<br></td></tr>\n";
	}
	echo "</table></center>
<br><br></body></html>\n";
?>
