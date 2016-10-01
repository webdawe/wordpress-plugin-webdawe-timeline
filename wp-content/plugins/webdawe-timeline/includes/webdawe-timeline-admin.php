<?php
//Set up admin menu

add_action('admin_menu','webdawe_timeline_admin_menu');
function webdawe_timeline_admin_menu()
{
    add_menu_page(
        'Webdawe Timeline',
        'Webdawe Timeline',
        'administrator',
        'webdawe_timeline_list',
        'webdawe_timeline_list',
        'dashicons-groups'
    );
    add_submenu_page(
        'webdawe_timeline_list',
        'Add Timeline',
        'Add New',
        'administrator',
        'webdawe_timeline_form',
        'webdawe_timeline_form'
    );

    add_submenu_page(
        'webdawe_timeline_list',
        'List Timeline Entry',
        'List',
        'administrator',
        'webdawe_timeline_entry_list',
        'webdawe_timeline_entry_list'
    );

    remove_submenu_page('webdawe_timeline_entry_list');

    add_submenu_page(
        'webdawe_timeline_list',
        'Add Timeline Entry',
        'Add New Entry',
        'administrator',
        'webdawe_timeline_entry_form',
        'webdawe_timeline_entry_form'
    );

    remove_submenu_page('webdawe_timeline_entry_form');
}



if (!function_exists('webdawe_output_buffer'))
{
    function webdawe_output_buffer()
    {
        ob_start();
    }
}

add_action('init', 'webdawe_output_buffer');

/**
 * Show Timeline List
 */
function webdawe_timeline_list()
{
    global $wpdb;

    if (!current_user_can('manage_options'))
    {
        wp_die('Sorry!! You do not have sufficient permission to access this page!!');
    }

    require_once WEBDAWE_PLUGIN_DIR . '/pages/webdawe-timeline-list.php';
}

function webdawe_timeline_entry_list()
{
    global $wpdb;

    require_once WEBDAWE_PLUGIN_DIR . '/pages/webdawe-timeline-entry-list.php';
}

/**
 * Show Timeline Form
 */
function webdawe_timeline_form()
{
    global $wpdb;

    if (!current_user_can('manage_options'))
    {
        wp_die('Sorry!! You do not have sufficient permission to access this page!!');
    }

    require_once WEBDAWE_PLUGIN_DIR . '/pages/webdawe-timeline-form.php';
}


function webdawe_timeline_entry_form()
{
    global $wpdb;

    if (!current_user_can('manage_options'))
    {
        wp_die('Sorry!! You do not have sufficient permission to access this page!!');
    }

    require_once WEBDAWE_PLUGIN_DIR . '/pages/webdawe-timeline-entry_form.php';
}

function webdawe_draw_form($heading, $fields, $success)
{

    if ($success == 2) : ?>

        <div id="message" class="updated">Successfully saved</div>
    <?php endif;?>
    <?php if ($success == 0) : ?>

    <div class="error notice">
        <p>There has been an error!!</p>
    </div>
    <?php endif;?>
    <div class="wrap">
        <h2><i class="fa fa-cog" aria-hidden="true"></i>&nbsp;<?php echo $heading;?></h2>

        <form method="POST" action="">
            <table class="widefat">
                <?php $groupTitle = ''; ?>
                <?php foreach ( $fields as $key => $options) : ?>
                    <?php if($groupTitle =='' || $groupTitle != $options['group']) :?>
                        <?php $groupTitle = $options['group'];?>
                        <tr>
                            <td colspan="2"><h2><?php echo $groupTitle;?></h2></td>
                        </tr>
                    <?php endif;?>
                    <tr valign="top">
                        <th scope="row">
                            <label for="<?php echo $key;?>"  for="input-text">
                                <?php echo $options['label'] ?>
                            </label>
                        </th>
                        <td>
                            <?php if ($options['type'] == 'text') :?>
                                <input type="text" name="<?php echo $key;?>" <?php echo $options['params'];?>  value="<?php echo $options['value']; ?>" class="input-text"/>
                            <?php elseif($options['type'] == 'textarea') :?>
                                <textarea name="<?php echo $key;?>" <?php echo $options['params'];?>><?php echo $options['value'];?></textarea>
                            <?php elseif($options['type'] == 'select') :?>
                                <select name="<?php echo $key;?>" <?php echo $options['params'];?>>
                                    <?php foreach ($options['options'] as $optionValue => $optionTitle):?>
                                        <option value="<?php echo $optionValue?>" <?php if ($optionValue == $options['value']):?> selected="selected" <?php endif;?> ><?php echo $optionTitle?></option>
                                    <?php endforeach;?>

                                </select>
                            <?php elseif($options['type'] == 'wp_editor') :?>
                                <?php
                                $settings = array();

                                wp_editor($options['value'], $key, $settings);
                                ?>
                            <?php endif;?>
                        </td>
                    </tr>
                <?php endforeach;?>

            </table>
            <p>
                <input type="submit" value="Save" class="button-primary"/>
                <input type="hidden" name="update" value="Y" />
            </p>
        </form>
    </div>
<?php
}
