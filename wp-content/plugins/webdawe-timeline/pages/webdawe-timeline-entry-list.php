<?php
/**
 * Timeline List
 */
global $wpdb;

include_once WEBDAWE_PLUGIN_DIR . 'classes/WebdaweTimelineEntry.php';

$timelineEntry = new WebdaweTimelineEntry($wpdb, $_GET['tid']);


?>
<div class='container'>
    <h2>Timeline Entries</h2>
    <p>List of Entries for <?php echo $timelineEntry->getTitle();?></p>
    <table class="widefat">
        <thead>
        <tr>
            <th>Time</th>
            <th>Title</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php if ($entries = $timelineEntry->getEntryData()):?>
            <?php foreach ($entries as  $row):?>
                <tr>
                    <td><?php echo $row['time'];?></td>
                    <td><?php echo $row['title'];?></td>
                    <td>
                        <a href="<?php echo admin_url('admin.php?page=webdawe_timeline_entry_form&id=' .$row['id'] . '&tid=' .$_GET['tid'] .
                        '&t=' .$timelineEntry->getTitle());?>">Edit</a></td>
                </tr>
            <?php endforeach;?>
        <?php else:?>
            <tr>
                <td colspan="4">No Timelines Added yet!!</td>
            </tr>
        <?php endif;?>
        </tbody>
    </table>
