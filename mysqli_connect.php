<?php # Script Search v1
$var = @$_GET['query'];
$trimmed = trim($var);

// Database Connection Info
DEFINE ('DB_USER', '');
DEFINE ('DB_PASSWORD', '');
DEFINE ('DB_HOST', '');
DEFINE ('DB_NAME', '');


//Make Connection
$dbc = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die ('Could not connect to MySQL: ' . mysqli_connect_error() );

$field_to_search = "NAME";

// Make the Query
// $q = "SELECT ABS(TRAN_ID) AS tid, CONCAT(TRAN_TYPE) AS type, CONCAT(TRAN_AMT) AS amount, CONCAT(NAME) AS name, CONCAT(TRAN_DATE) AS td, CONCAT(PURPOSE) AS purpose FROM party ORDER BY TRAN_AMT DESC";
$q = "SELECT ABS(TRAN_ID) AS tid, CONCAT(TRAN_TYPE) AS type, CONCAT(TRAN_AMT) AS amount, CONCAT(NAME) AS name, CONCAT(TRAN_DATE) AS td, CONCAT(PURPOSE) AS purpose FROM party WHERE $field_to_search LIKE '%$trimmed%' ORDER BY TRAN_AMT DESC";
$r = @mysqli_query ($dbc, $q);


// Count the number of returned rows
$num = mysqli_num_rows($r);
if ($num > 0) {
	echo "<p>We found $num transactions.</p>\n";
}

if ($r) {
	echo '<table align="center" cellspacing="2" cellpadding="2" width="75%">
		<tr><td align="left"><b>Transaction ID</b></td><td align="left"><b>Type</b></td><td align="left"><b>Amount</b></td><td align="left"><b>Name</b></td><td align="left"><b>Transaction Date</b></td><td align="left"><b>Purpose</b></td></tr>';

	while ($row = mysqli_fetch_array($r,MYSQLI_ASSOC)) {
		echo '<tr><td align="left">' . $row[tid] . '</td><td align="left">' . $row['type'] . '</td><td align="left">' . $row[amount] . '</td><td align="left">' . $row[name] . '</td><td align="left">' . $row['td'] . '</td><td align="left">' . $row['purpose'] . '</td></tr>';
	}
	echo '</table>';
	mysqli_free_result ($r);
} else {
	echo '<p class="error">The current transaction information could not be retrieved. We apologize for any inconvenience.</p>';
	echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
}

mysqli_close($dbc);

?> 