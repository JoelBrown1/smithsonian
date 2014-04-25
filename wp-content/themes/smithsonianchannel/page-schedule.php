<?php 
// Template Name: Schedule
get_header();
?>

<div class="mainTitle">
		  <div class="page-container clearfix">
			<h1><?php the_title(); ?></h1>
		</div>
	</div>
    

<div id="tDate">
	<div id="dateContainer">
		<div id="today">
			<?php  $mydate=getdate(date("U")); ?>
			<div id="day">
				<?php echo "$mydate[weekday]"; ?>
			</div>
			<div id="fullDate">
				<?php echo "$mydate[month] $mydate[mday], $mydate[year]"; ?>
			</div>
		</div>
		<div id="showPlaying">
			<div class="playing">NOW PLAYING:</div>
			<div class="currentShow"><span class="titleStamp"><?php echo $sArray[$sindex]["Title"];?></span></div>
			<div class="eTitle"><?php echo $sArray[$sindex]["Episode"];?></div>
			<div class="eDescription"><?php echo $sArray[$sindex]["EpisodeSummary"];?></div>
		</div>
	</div>
</div>
<div class="main">
	<script type="text/javascript">
		var dailySchedule = <?php echo json_encode($scheduleXML) ?>;
	</script> 
<input type="hidden" id="selectedDate" value="<?php echo date('j');?>"> 
	<div class="scheduleContainer">
		<div class="calendar-wrapper clearfix">
			<div class="dmloader"></div>
		    <div id="dateToDisplay"></div>
		    <div id="calenderSchedule"></div>
		</div>
		<div id="scheduleData">
			<div id="fSchedule">FULL SCHEDULE
            <h2 class="toggleSchedule"><?php echo "$mydate[weekday]"; ?> <?php echo "$mydate[month] $mydate[mday], $mydate[year]"; ?> <img src="<?php echo get_template_directory_uri(); ?>/images/calendar_icon.png" alt="open calender" class="calender-icon" width="23" /></h2>
            </div>
			<div id="fSDescriptor"><span id="time">Time</span><span id="program">Program</span></div>
			<div id="scheduleScroller"></div>
            <p class="standardTime">All times are in EST</p>
		</div>
	</div>
</div>
<?php get_footer(); ?>
