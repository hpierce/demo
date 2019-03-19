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
<tr><font size=+1><td bgcolor=cccccc align=left>Name on Invoice</td><td bgcolor=cccccc align=left>Service Address</td><td bgcolor=cccccc align=left>Account Number</td>
<td bgcolor=cccccc align=left>Supplier 1 Name</td><td bgcolor=cccccc align=left>Supplier 1 Amount</td><td bgcolor=cccccc align=left>Supplier2 Name</td><td bgcolor=cccccc align=left>Supplier 2 Amount</td>
<td bgcolor=cccccc align=left>New Charges</td><td bgcolor=cccccc align=left>Balance Forward</td><td bgcolor=cccccc align=left>Total Credit Amount</td><td bgcolor=cccccc align=left>Total Amount Due</td>
<td bgcolor=cccccc align=left>Bill Date</td><td bgcolor=cccccc align=left>Meter Start</td><td bgcolor=cccccc align=left>Meter End</td><td bgcolor=cccccc align=left>Next Meter Read</td>
<td bgcolor=cccccc align=left>Number of Days</td></font></tr>\n";

	$query = "select * from main order by filename";
	$result = mysqli_query($db, $query);
	$num_results = mysqli_num_rows($result);

	for ($i=0; $i <$num_results; $i++)
	{
		$row = mysqli_fetch_array($result);
		echo '<tr><td><a href=MD/';
		echo stripslashes($row['filename']);
		echo '>';
		echo stripslashes($row['name_on_invoice']);
		echo '</a><br></td><td>';
		echo stripslashes($row['service_address']);
		echo '<br></td><td><a href=display.php?number=';
		echo stripslashes($row['account_number']);
		echo '>';
		echo stripslashes($row['account_number']);
		echo '</a><br></td><td>';
		echo stripslashes($row['supplier1_name']);
		echo '<br></td><td>';
		echo stripslashes($row['supplier1_amount']);
		echo '<br></td><td>';
		echo stripslashes($row['supplier2_name']);
		echo '<br></td><td>';
		echo stripslashes($row['supplier2_amount']);
		echo '<br></td><td>';
		echo stripslashes($row['new_charges']);
		echo '<br></td><td>';
		echo stripslashes($row['balance_forward']);
		echo '<br></td><td>';
		echo stripslashes($row['total_credit_amount']);
		echo '<br></td><td>';
		echo stripslashes($row['total_amount_due']);
		echo '<br></td><td>';
		echo stripslashes($row['bill_date']);
		echo '<br></td><td>';
		echo stripslashes($row['meter_start']);
		echo '<br></td><td>';
		echo stripslashes($row['meter_end']);
		echo '<br></td><td>';
		echo stripslashes($row['next_meter_read']);
		echo '<br></td><td>';
		echo stripslashes($row['number_of_days']);
		echo "<br></td></tr>\n";
	}
	echo "</table></center>\n";
	echo "<br><br></body></html>\n";
?>
