<?php
//======================================================================================
//Short Code usage  - WP editors can use short code [WEBDAWE_TIMELINE id='{{timelineId}}']
//--------------------------------------------------------------------------------------

add_shortcode('webdawe-timeline','load_webdawe_timeline');
//[webdawe_timeline id="1"]
/**
 * [webdawe_timeline_block description]
 * @return [type] [description]
 */
function load_webdawe_timeline($atts)
{
    $attributes = shortcode_atts(array('id' => 0), $atts);

    include_once WEBDAWE_PLUGIN_DIR . '/pages/webdawe-timeline-shortcode.php';
    //echo '<h1> ' . print_r($atts, true) . '</h1>';
}
