<?php the_post(); ?>
<h1><?php the_title(); ?></h1>
<?php
$events = get_post_meta( get_the_ID(), 'events', true );
echo "<pre>$events</pre>";
$events = json_decode( $events, true );
usort( $events, function ( $item1, $item2 ) {
    return $item1['date'] <=> $item2['date'];
} );

$events_monthly = [];
foreach ( $events as $ev ) {
	$m = substr( $ev['date'], 0, 7 );
	if ( ! isset( $events_monthly[$m] ) ) {
		$events_monthly[$m] = array();
	}
	$events_monthly[$m][] = $ev;
}
// echo '<pre>' . json_encode( $events_monthly ) . '</pre>';

$start_year = intval( substr( $events[0]['date'], 0, 4 ) );
$end_year = intval( substr( $events[sizeof($events) - 1]['date'], 0, 4 ) );

$start_month = intval( substr( $events[0]['date'], 5, 2 ) );
$end_month = intval( substr( $events[sizeof($events) - 1]['date'], 5, 2 ) );

$col = 4;
$col_no = 0;
echo "<table class='main'>";
$end = false;

$year = $start_year;
$month = $start_month;

while ( false == $end ) {
	$events_in_month = $events_monthly[$year . '-' . str_pad( $month, 2, '0', STR_PAD_LEFT )] ?? array();

	$dateObject = DateTime::createFromFormat( 'n', $month );

	// Month name to display at top
	$monthName = $dateObject->format( 'F' );

	//calculate number of days in a month
	$no_of_days = cal_days_in_month( CAL_GREGORIAN, $month, $year );

	// This will calculate the week day of the first day of the month
	// Sunday = 0, Saturday = 6
	$j = date( 'w', mktime( 0, 0, 0, $month, 1, $year ) );

	//// if starting day of the week is Monday then add following two lines ///
	$j = $j - 1;
	if ( $j < 0 ) { $j = 6; }  // if it is Sunday //
	//// end of if starting day of the week is Monday ////

	// Blank starting cells of the calendar
	$adj = str_repeat( "<td bgcolor='#cccccc'>&nbsp;</td>", $j );
	// Days left after the last day of the month
	$blank_at_end = 42 - $j - $no_of_days;
	if ( $blank_at_end >= 7 ) { $blank_at_end = $blank_at_end - 7; }
	// Blank ending cells of the calendar
	$adj2 = str_repeat( "<td bgcolor='#cccccc'>&nbsp;</td>", $blank_at_end );

	/// Starting of top line showing year and month to select ///////////////
	if ( ( $col_no % $col ) == 0 ) {
		echo '</tr><tr>';
	}
	?>
	<td>
		<table border="1">
			<tr>
				<td colspan="7" align="center"><?php echo "$monthName $year"; ?></td>
			</tr>
			<tr>
				<th>Sen</th>
				<th>Sel</th>
				<th>Rab</th>
				<th>Kam</th>
				<th>Jum</th>
				<th>Sab</th>
				<th>Aha</th>
			</tr>
			<tr>
				<?php
				//////// Starting of the days//////////
				for ( $i = 1; $i <= $no_of_days; $i++ ) {
					$has_event = array_search(
						$year . '-' . str_pad( $month, 2, '0', STR_PAD_LEFT ) . '-' . str_pad( $i, 2, '0', STR_PAD_LEFT ),
						array_column( $events_in_month, 'date' ),
					);

					echo $adj . "<td " . ($has_event !== false ? 'bgcolor="#88ffff"' : '') . ">$i</td>";
					$adj = '';
					$j++;
					if ( $j == 7 ) {
						echo '</tr><tr>'; // start a new row
						$j = 0;
					}
				}
				echo $adj2;   // Blank the balance cell of calendar at the end
				?>
			</tr>
		</table>
		<?php
		if ( sizeof( $events_in_month ) > 0 ) {
			foreach ( $events_in_month as $ev ) {
				$date = (DateTime::createFromFormat( 'Y-m-d', $ev['date'] ))->format( 'j M' );
				echo "<p><strong>$date</strong>: " . $ev['name'] . '</p>';
			}
		}
		?>
	</td>
	<?php
	$col_no = $col_no + 1;

	if ( $year == $end_year && $month == $end_month ) {
		$end = true;
	}

	$month++;
	if ( $month > 12 ) {
		$month = 1;
		$year++;
	}
}
?>
</table>
