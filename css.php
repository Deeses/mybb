<?php
/**
 * Edited by PersonalPerson
 *
 * MyBB 1.8
 * Copyright 2014 MyBB Group, All Rights Reserved
 *
 * Website: http://www.mybb.com
 * License: http://www.mybb.com/about/license
 *
 */

define("IN_MYBB", 1);
define("NO_ONLINE", 1);
define('THIS_SCRIPT', 'css.php');

require_once "./inc/init.php";
#Let's remove this shall we?
//require_once MYBB_ROOT . $config['admin_dir'] . '/inc/functions_themes.php';

#Added from functions_themes
function minify_stylesheet($stylesheet)
{
	// Remove comments.
	$stylesheet = preg_replace('@/\*.*?\*/@s', '', $stylesheet);
	// Remove whitespace around symbols.
	$stylesheet = preg_replace('@\s*([{}:;,])\s*@', '\1', $stylesheet);
	// Remove unnecessary semicolons.
	$stylesheet = preg_replace('@;}@', '}', $stylesheet);
	// Replace #rrggbb with #rgb when possible.
	$stylesheet = preg_replace('@#([a-f0-9])\1([a-f0-9])\2([a-f0-9])\3@i','#\1\2\3',$stylesheet);
	$stylesheet = trim($stylesheet);
	return $stylesheet;
}

$stylesheet = $mybb->get_input('stylesheet', MyBB::INPUT_INT);

if($stylesheet)
{
	$options = array(
		"limit" => 1
	);
	$query = $db->simple_select("themestylesheets", "stylesheet", "sid=".$stylesheet, $options);
	$stylesheet = $db->fetch_field($query, "stylesheet");

	#Why?
	//$plugins->run_hooks("css_start");

	#No need to have this an option. Let's just do it okay?
	//if(!empty($mybb->settings['minifycss']))
	//{
		#minify_stylesheet was in functions_theme but moved here to make of a load
		$stylesheet = minify_stylesheet($stylesheet);
	//}
	
	#Why?
	//$plugins->run_hooks("css_end");

	header("Content-type: text/css");
	echo $stylesheet;
}
exit;
