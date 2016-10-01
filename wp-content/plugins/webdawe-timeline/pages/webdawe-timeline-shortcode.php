<?php
/**
 * Display Time line.
 */
global $wpdb;

include_once WEBDAWE_PLUGIN_DIR . '/classes/WebdaweTimeline.php';

$timelineId = $atts['id'];

$timeline = new WebdaweTimeline($wpdb, $timelineId);
?>
<?php if ($timeline->hasData()) :?>
	<h1><?php echo $timeline->getTitle();?></h1>
	<p><?php echo $timeline->getDescription();?></p>
	<?php print_r($timeline->getTimelineEntries());?>
<?php endif;?>