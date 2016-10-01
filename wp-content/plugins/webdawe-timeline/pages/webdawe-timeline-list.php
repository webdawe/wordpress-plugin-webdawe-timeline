<?php
/**
 * Timeline List
 */
global $wpdb;

include_once WEBDAWE_PLUGIN_DIR . 'classes/WebdaweTimeline.php';

$timeline = new WebdaweTimeline($wpdb);
?>
<div class='container'>
    <h2>Timeline</h2>
    <p>List of Timelines</p>
    <table class="widefat">
        <thead>
        <tr>
            <th>Title</th>
            <th>style</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php if ($timelines = $timeline->getTimelineList()):?>
            <?php foreach ($timelines as $key => $row):?>
                <tr>
                    <td><?php echo $row->title;?></td>
                    <td><?php echo $row->style;?></td>
                    <td>
                        <a href="<?php echo admin_url('admin.php?page=webdawe_timeline_form&id=' .$row->id);?>">Edit</a> | <a href="<?php echo admin_url('admin.php?page=webdawe_timeline_entry_list&tid=' .$row->id);?>">Manage Entries</a></td>
                </tr>
            <?php endforeach;?>
        <?php else:?>
            <tr>
                <td colspan="4">No Timelines Added yet!!</td>
            </tr>
        <?php endif;?>
        </tbody>
    </table>
