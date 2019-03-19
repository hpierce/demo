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
	$number = $_GET['number'];
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
#	Basic info
#
#---------------------------------------------------------------------------
	$query = "select * from main where account_number = '$number' order by filename";
	$result = mysqli_query($db, $query);
	$row = mysqli_fetch_array($result);
	$noi = stripslashes($row['name_on_invoice']);
	$sa = stripslashes($row['service_address']);
#---------------------------------------------------------------------------
#
#	Start
#
#---------------------------------------------------------------------------
	echo "<html>
<head>
<title>Account $number</title>
</head>
<body bgcolor=ffffff><font face=arial,helvetica><br><br>
<h1 align=center>Account: $number<br>
Service Address: $sa<br>
Name on Invoice: $noi<br>
</h1><br>\n";
#---------------------------------------------------------------------------
#
#	Display
#
#---------------------------------------------------------------------------
	$query = "select * from main where account_number = '$number' order by filename";
	$result = mysqli_query($db, $query);
	$num_results = mysqli_num_rows($result);
#---------------------------------------------------------------------------
#
#	Info
#
#---------------------------------------------------------------------------
	echo "<center>
<p><table border=1 cellspacing=0 cellpadding=4 width=80%>
<tr><td bgcolor=cccccc align=left>Bill Date</td>
<td bgcolor=cccccc align=left>Supplier 1 Name</td><td bgcolor=cccccc align=left>Supplier 1 Amount</td><td bgcolor=cccccc align=left>Supplier2 Name</td><td bgcolor=cccccc align=left>Supplier 2 Amount</td>
<td bgcolor=cccccc align=left>New Charges</td><td bgcolor=cccccc align=left>Balance Forward</td><td bgcolor=cccccc align=left>Total Credit Amount</td><td bgcolor=cccccc align=left>Total Amount Due</td>
<td bgcolor=cccccc align=left>Meter Start</td><td bgcolor=cccccc align=left>Meter End</td><td bgcolor=cccccc align=left>Next Meter Read</td>
<td bgcolor=cccccc align=left>Number of Days</td></font></tr>\n";
#---------------------------------------------------------------------------
#
#	Data
#
#---------------------------------------------------------------------------

	for ($i=0; $i <$num_results; $i++)
	{
		$row = mysqli_fetch_array($result);
		echo '<tr><td><a href=MD/';
		echo stripslashes($row['filename']);
		echo '>';
		echo stripslashes($row['bill_date']);
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
