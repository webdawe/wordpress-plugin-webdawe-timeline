<?php
/**
 * @package Webdawe
 */
/*
Plugin Name: Webdawe Timeline
Plugin URI: http://webdawe.com.au/
Description: Webdawe Timeline gives you option to generate timelines and store them and use them anywhere in your wordpress with shortcodes. easy to generate and use.
Version: 1.0.0
Author: Anil Paul
Author URI: http://anilpaul.com.au
License: GPL
Text Domain: webdawe
*/
/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program

Copyright 2016 Anil Paul.
*/
define ('WEBDAWE_PLUGIN_DIR', plugin_dir_path(__FILE__));

require_once ('includes/webdawe-timeline-shortcode.php');
require_once ('includes/webdawe-timeline-admin.php');