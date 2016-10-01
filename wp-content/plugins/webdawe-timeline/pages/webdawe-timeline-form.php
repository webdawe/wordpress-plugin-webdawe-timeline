<?php
/**
 * Timeline List
 */
global $wpdb;

include_once WEBDAWE_PLUGIN_DIR . '/classes/WebdaweTimeline.php';

$timeline = new WebdaweTimeline($wpdb);

$heading = 'Add Timeline';
if ($id = $_GET['id'])
{
    $heading = 'Edit Timeline';
    $timeline->loadTimeline($id);

}

$styleOptions = array(''=> 'Choose Style','webdawe_one'=>'Webdawe One','webdawe_two'=>'Webdawe Two','webdawe_three'=>'Webdawe Three');
$fields = array(
    'title'  =>  array( 'group' => 'Timeline Details', 'label' => 'Title', 'type' => 'text', 'params' => 'size="100"', 'value' => $timeline->getTitle()),
    'description' =>array( 'group' => 'Timeline Details', 'label' => 'Description', 'type' => 'wp_editor', 'params' => 'style="width:60%;"', 'value' => $timeline->getDescription()),
    'style'  =>  array( 'group' => 'Timeline Details', 'label' => 'Style', 'type' => 'select', 'params' => 'size="100"','options' => $styleOptions,'value' => $timeline->getStyle()),
);
$success = 1;
if (isset($_POST["update"]))
{

    foreach ( $fields as $key => $options)
    {
        $timeline->setData($key, $_POST[$key]);
    }
    $success = 0;
    try
    {
        $timeline->save();
        $success = 2;
        //wp_ob_end_flush_all();
        webdawe_output_buffer();
        wp_redirect(admin_url('admin.php?page=webdawe_timeline_list'));
        exit;

    }
    catch (Exception $error)
    {
        $success = 0;
    }

}
webdawe_draw_form($heading, $fields, $success);
?>
