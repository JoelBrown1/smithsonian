<?php
	header( 'Content-Type: application/json' );

	$date = $_GET['date'];
	// echo "the date to load is: ".$date;
	/** Loads the WordPress Environment and Template */
	require('../../../wp-blog-header.php');


	$fileToLoad = loadDailySchedule( $date );	

	echo json_encode($fileToLoad);
?>