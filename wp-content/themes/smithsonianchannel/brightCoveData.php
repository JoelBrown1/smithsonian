<?php
	header( 'Content-Type: application/text' );

	$bSourceAPI = "http://api.brightcove.com/services/library?";
	// getting the data that was sent buy the url attached parameters
	$command 	= $_GET['command'];
	$any		= $_GET['any'];
	$token		= "42nLofnCvf5U3L_idEskcOthBakXB4Im6yuTjo7L-t4.";

	$dSource = $bSourceAPI
	."command=".$command
	."&any=".$any
	."&page_size=30"
	."&video_fields=id%2Cname%2CshortDescription%2ClongDescription%2Ctags%2CthumbnailURL"
	."&media_delivery=default"
	."&sort_by=PUBLISH_DATE%3ADESC"
	."&get_item_count=true"
	."&token=".$token;
	
	$content = file_get_contents($dSource);

	echo $content;
?>
