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
</head>\n";

echo "<body bgcolor=ffffff><font face=arial,helvetica><br><br>
<h1 align=center>Account: $number<br>
Service Address: $sa<br>
Name on Invoice: $noi<br>
</h1><br>\n";
#---------------------------------------------------------------------------
#
#	Display
#
#---------------------------------------------------------------------------
	$query = "select * from main where account_number = '$number' order by bill_date";
	$result = mysqli_query($db, $query);
	$num_results = mysqli_num_rows($result);
#---------------------------------------------------------------------------
#
#	Info
#
#---------------------------------------------------------------------------
	echo "<center>
<p><table border=1 cellspacing=0 cellpadding=4>
<tr><td align=center>A</td><td align=center>B</td>
<td align=center>C</td><td align=center>D</td>
<td align=center>E</td><td align=center>F</td>
<td align=center>G</td> <td align=center>H</td><td align=center>I</td><td align=center>J</td></tr>
<tr><td bgcolor=cccccc align=left>Bill Date</td>
<td bgcolor=cccccc align=left>Supplier 1 Amount</td>
<td bgcolor=cccccc align=left>Supplier 2 Amount</td>
<td bgcolor=cccccc align=left>New Charges</td>
<td bgcolor=cccccc align=left>Balance Forward</td>
<td bgcolor=cccccc align=left>Sum of B-E</td>
<td bgcolor=cccccc align=left>Total Credit Amount</td>
<td bgcolor=cccccc align=left>Total Amount Due</td>
<td bgcolor=cccccc align=left>Sum of G-H</td>
<td bgcolor=cccccc align=left>Subtract F-I</td>
</tr>\n";
#---------------------------------------------------------------------------
#
#	Data
#
#---------------------------------------------------------------------------
	for ($i=0; $i <$num_results; $i++)
	{
		$row = mysqli_fetch_array($result);
		$fn = stripslashes($row['filename']);
		$bd = stripslashes($row['bill_date']);
		$sup1 = stripslashes($row['supplier1_amount']);
		$sup2 = stripslashes($row['supplier2_amount']);
		$new = stripslashes($row['new_charges']);
		$bf = stripslashes($row['balance_forward']);
		$billa = $sup1 + $sup2 + $new + $bf;

		$tca = stripslashes($row['total_credit_amount']);
		$tad = stripslashes($row['total_amount_due']);
		$billb = $tca + $tad;

		$good = abs(round($billa - $billb,2));

		echo "<tr><td><a href=files/$fn>$bd</a></td><td>$sup1</td><td>$sup2</td><td>$new</td><td>$bf</td><td>$billa</td><td>$tca</td><td>$tad</td><td>$billb</td><td>$good</td></tr>";
	}
	echo "</table>
<br><table border=1 cellspacing=0 cellpadding=4>
<tr><td><img src=images/accounting.jpg></td>
<td><a href=timeline.php?number=$number><img src=images/cost.jpg></a></td>
<td><img src=images/comparison.jpg></td></tr>
</table>
<br><br></body></html>\n";
?>
