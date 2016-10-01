<?php
/**
 * Timeline List
 */
global $wpdb;
error_reporting(E_ALL);
ini_set('display_errors', 'On');
include_once WEBDAWE_PLUGIN_DIR . '/classes/WebdaweTimelineEntry.php';

$timelineEntry = new WebdaweTimelineEntry($wpdb);

$heading = 'Add Timeline Entry';
if ($id = $_GET['id'])
{
    $heading = 'Edit Timeline Entry';
    $timelineEntry->loadEntry($id);

}

$heading .= ' for ' . $_GET['t'];

$fields = array(
    'time'  =>  array( 'group' => 'Timeline Entry', 'label' => 'Time', 'type' => 'text', 'params' => 'size="100"', 'value' => $timelineEntry->getTime()),
    'title'  =>  array( 'group' => 'Timeline Entry', 'label' => 'Title', 'type' => 'text', 'params' => 'size="100"', 'value' => $timelineEntry->getTitle()),
    'description' =>array( 'group' => 'Timeline Entry', 'label' => 'Description', 'type' => 'wp_editor', 'params' => 'style="width:60%;"', 'value' => $timelineEntry    ->getDescription()),
);
$success = 1;
if (isset($_POST["update"]))
{

    foreach ( $fields as $key => $options)
    {
        $timelineEntry->setData($key, $_POST[$key]);
    }
    $success = 0;
    try
    {
        $timelineEntry->save();
        $success = 2;
        //wp_ob_end_flush_all();
        webdawe_output_buffer();
        wp_redirect(admin_url('admin.php?page=webdawe_timeline_entry_list&tid=' . $_GET['tid']));
        exit;

    }
    catch (Exception $error)
    {
        $success = 0;
    }

}
webdawe_draw_form($heading, $fields, $success);
?>
