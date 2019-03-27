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
#	Beginning of head
#
#---------------------------------------------------------------------------
	echo "<html>
<head>
     <script type=\"text/javascript\" src=\"https://www.gstatic.com/charts/loader.js\"></script>
<script type=\"text/javascript\">
     var data;
     var chart;

      // Load the Visualization API and the chart package.
      google.charts.load('current', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the chart, passes in the data and
      // draws it.
      function drawChart() {

        // Create our data table.
        data = new google.visualization.DataTable();
        data.addColumn('string', 'Date');
        data.addColumn('number', 'Cost');
        data.addRows([\n";
#---------------------------------------------------------------------------
#
#	Chart data
#
#---------------------------------------------------------------------------
	$query = "select * from main where account_number = '$number' order by bill_date";
	$result = mysqli_query($db, $query);
	$num_results = mysqli_num_rows($result);
	$rn = $num_results - 1;
	for ($i=0; $i <$rn; $i++)
	{
		$row = mysqli_fetch_array($result);
		$bd = stripslashes($row['bill_date']);
		$sup1 = stripslashes($row['supplier1_amount']);
		$sup2 = stripslashes($row['supplier2_amount']);
		$new = stripslashes($row['new_charges']);
		$tota = $sup1 + $sup2 + $new;
		echo "['$bd', $tota],\n";
	}
	$row = mysqli_fetch_array($result);
	$bd = stripslashes($row['bill_date']);
	$sup1 = stripslashes($row['supplier1_amount']);
	$sup2 = stripslashes($row['supplier2_amount']);
	$new = stripslashes($row['new_charges']);
	$tota = $sup1 + $sup2 + $new;
	echo "['$bd', $tota]\n";
#---------------------------------------------------------------------------
#
#	End of head
#
#---------------------------------------------------------------------------
echo "        ]);

        // Set chart options
        var options = {'title':'',
                       'width':1400,
                       'height':600};

        // Instantiate and draw our chart, passing in some options.
        chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        google.visualization.events.addListener(chart, 'select', selectHandler);
        chart.draw(data, options);
      }

      function selectHandler() {
        var selectedItem = chart.getSelection()[0];
        var value = data.getValue(selectedItem.row, 0);
        alert('The user selected ' + value);
      }

    </script>

<title>Account $number</title>
</head>\n";

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
#	Body
#
#---------------------------------------------------------------------------
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
<div id=\"chart_div\"></div><br><br>
<p><table border=1 cellspacing=0 cellpadding=4>
<tr><td align=center>A</td><td align=center>B</td>
<td align=center>C</td><td align=center>D</td>
<td align=center>E</td>
</tr>

<tr><td bgcolor=cccccc align=left>Bill Date</td>
<td bgcolor=cccccc align=left>Supplier 1 Amount</td>
<td bgcolor=cccccc align=left>Supplier 2 Amount</td>
<td bgcolor=cccccc align=left>New Charges</td>
<td bgcolor=cccccc align=left>Sum of B-D</td>
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
		$tota = $sup1 + $sup2 + $new;
		echo "<tr><td><a href=files/$fn>$bd</a></td><td>$sup1</td><td>$sup2</td><td>$new</td><td>$tota</td></tr>\n";
	}
#---------------------------------------------------------------------------
#
#	Close html
#
#---------------------------------------------------------------------------
	echo "</table>
<br><br></body></html>\n";
?>
