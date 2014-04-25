 <?php
	//echo "Selected Date: ".$_GET['dateSelected'];
 	$cDate = date("Ymd");
 	$path = get_template_directory_uri();

 	$filetoread = $path."/tvshowsxmls/playlist".$cDate.".xml";

	// $filetoread = TEMPLATEPATH."/tvshowsxmls/playlist".$_GET['dateSelected'].".xml";
	//$filetoread = TEMPLATEPATH."/tvshowsxmls/playlist20130904.xml";
	$xml=simplexml_load_file($filetoread);
	?>
    <ul>
    <?php
	$amorpmt = "";
	if(count($xml->Clip) > 0){
		foreach($xml->Clip as $showinfo){
			/*$convert = "SELECT TIME_FORMAT(  '".$showinfo->PlayAt."',  '%h:%i %p' )";
			$resconvert = mysql_query($convert);
			$rowconvet = mysql_fetch_array($resconvert);
			$showAt = $rowconvet[0];*/
			$explodetime = explode(":",$showinfo->PlayAt);
			if($explodetime[0] < 12){
				$amorpm = "AM";
				$timeHour = $explodetime[0];
				
			}else{
				$amorpm = "PM";
				if($explodetime[0] == 12)
					$timeHour = $explodetime[0];
				else
					$timeHour = $explodetime[0] - 12;
					
				if($timeHour <= 9)
					$timeHour = "0".$timeHour;
			}
			$showAt = $timeHour.":".$explodetime[1];
			if($amorpmt != $amorpm){
				$amorpmt = $amorpm;
				echo "<li class='ampm'>".$amorpm."</li>";
			}
			echo "<li><span class='stime'>".strtolower($showAt)."</span><span class='stitle'>".$showinfo->Title."</span></li>";
		}
	}else{
		echo "<li>No listings available</li>";
	}
	
	?>          
    </ul>