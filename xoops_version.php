<?php
/**
 * Onair Module
 *
 * Use this to show details, picture and schedule of timed events in a block. 
 *
 * LICENSE
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license       http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author       Michael Albertsen (culex) <http://www.culex.dk>
 * @version      $Id:xoops_version.php 2009-07-29 22:51 culex $
 * @since         File available since Release 1.0.0
 */
$modversion['name'] =_MI_ONAIR_MODULE_NAME;
$modversion['version'] = 1.04;
$modversion['description'] = _MI_ONAIR_MODULE_DESC;
$modversion['credits'] = "Developped by Culex http://www.culex.dk";
$modversion['author'] = "Culex";
$modversion['help'] = "top.html";
$modversion['license'] = "GPL see LICENSE";
$modversion['official'] = 1;
$modversion['image'] = "onair_logo.png";
$modversion['dirname'] = "onair";

// Sql file (must contain sql generated by phpMyAdmin or phpPgAdmin)
// All tables should not have any prefix!
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";

// Tables created by sql file (without prefix!)
$modversion['tables'][0] = "oa_program";
$modversion['tables'][1] = "oa_playlist";

//Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

// Menu
$modversion['hasMain'] = 1;
$modversion['sub'][1]['name'] = _MI_ONAIR_PLAYLISTMENU; 
$modversion['sub'][1]['url'] = "playlists.php"; 


// Blocks
$modversion['blocks'][1]['file'] = "simple_now.php";
$modversion['blocks'][1]['name'] = "Now Onair";
$modversion['blocks'][1]['description'] = 'Shows a simple script on whats on now';
$modversion['blocks'][1]['show_func'] = "b_Onair_Show";
$modversion['blocks'][1]['template'] = "onair_block.html";

// Templates
$modversion['templates'][1]['file'] = 'onair_index.html';
$modversion['templates'][1]['description'] = '';
$modversion['templates'][2]['file'] = 'onair_program.html';
$modversion['templates'][2]['description'] = '';
$modversion['templates'][3]['file'] = 'onair_detail.html';
$modversion['templates'][3]['description'] = '';
$modversion['templates'][4]['file'] = 'onair_playlists.html';
$modversion['templates'][4]['description'] = '';
$modversion['templates'][5]['file'] = 'onair_playlistdetail.html';
$modversion['templates'][5]['description'] = '';
	// Templates used by jquery to show content inside Div in block
$modversion['templates'][6]['file'] = 'onair_div1.html';
$modversion['templates'][6]['description'] = '';
$modversion['templates'][7]['file'] = 'onair_div2.html';
$modversion['templates'][7]['description'] = '';

$modversion['config'][] = array(
	'name' 			=> 'timetype',
	'title' 		=> '_MI_ONAIR_TIMETYPE',
	'description' 	=> '_MI_ONAIR_TIMESTYLE',
	'formtype' 		=> 'select',
	'formtype' 		=> 'yesno',
	'valuetype' 	=> 'int',
	'default' 		=> 0);
	
$modversion['config'][] = array(
	'name' 			=> 'onair_timezone',
	'title' 		=> '_MI_ONAIR_TIMEZONE',
	'description' 	=> '_MI_ONAIR_TIMEZONEDESC',
	'formtype' 		=> 'textbox',
	'valuetype' 	=> 'text',
	'default' 		=> 'Europe/Copenhagen');
	
/*
$modversion['config'][] = array(
	// XoopsFormSelectTimezone($caption, $name, $value=null, $size=1)
	'name' 			=> 'tzone',
	'title' 		=> '_MI_ONAIR_TIMEZONE',
	'description' 	=> '',
	'formtype' 		=> 'timezone',
	'valuetype' 	=> 'float',
	'default' 		=> "1",
	'category'		=> 'general');
*/
	
$modversion['config'][] = array(
	'name' 			=> 'shotwidth',
	'title' 		=> '_MI_ONAIR_SHOTWIDTH',
	'description' 	=> '_MI_ONAIR_SHOTWIDTHDSC',
	'formtype' 		=> 'textbox',
	'valuetype' 	=> 'int',
	'default' 		=> 80);

$modversion['config'][] = array(
	'name' 			=> 'shotheight',
	'title' 		=> '_MI_ONAIR_SHOTHEIGHT',
	'description' 	=> '_MI_ONAIR_SHOTHEIGHTDSC',
	'formtype' 		=> 'textbox',
	'valuetype' 	=> 'int',
	'default' 		=> 100);

$modversion['config'][] = array(
	'name' 			=> 'maximumw',
	'title' 		=> '_MI_ONAIR_IMGWIDTH',
	'description' 	=> '_MI_ONAIR_IMGWIDTHDSC',
	'formtype' 		=> 'textbox',
	'valuetype' 	=> 'int',
	'default' 		=> 200);

$modversion['config'][] = array(
	'name' 			=> 'maximh',
	'title' 		=> '_MI_ONAIR_IMGHEIGHT',
	'description' 	=> '_MI_ONAIR_IMGHEIGHTDSC',
	'formtype' 		=> 'textbox',
	'valuetype' 	=> 'int',
	'default' 		=> 240);

$modversion['config'][] = array(
	'name' 			=> 'pluginfile_direttore',
	'title' 		=> '_MI_ONAIR_PLUGINDIR_DIRETTORE',
	'description' 	=> '_MI_ONAIR_PLUGINDIR_DIRETTORE_DSC',
	'formtype' 		=> 'textbox',
	'valuetype' 	=> 'text',
	'default' 		=> 'http://www.yoursite.com/playlist.txt');

$modversion['config'][] = array(
	'name' 			=> 'pluginfile_stationplaylist',
	'title' 		=> '_MI_ONAIR_PLUGINDIR_SP',
	'description' 	=> '_MI_ONAIR_PLUGINDIR_SP_DSC',
	'formtype' 		=> 'textbox',
	'valuetype' 	=> 'text',
	'default' 		=> 'http://www.yoursite.com/playlist.txt');
	
$modversion['config'][] = array(
	'name' 			=> 'pluginfile_nowplaying',
	'title' 		=> '_MI_ONAIR_PLUGINDIR_WINAMP',
	'description' 	=> '_MI_ONAIR_PLUGINDIR_WINAMP_DSC',
	'formtype' 		=> 'textbox',
	'valuetype' 	=> 'text',
	'default' 		=> 'http://www.yoursite.com/playlist.txt');

$modversion['config'][] = array(
	'name' 			=> 'oa_streamlink',
	'title' 		=> '_MI_ONAIR_STREAM',
	'description' 	=> '_MI_ONAIR_STREAM_DESC',
	'formtype' 		=> 'textbox',
	'valuetype' 	=> 'text',
	'default' 		=> 'http://www.yoursite.com/mystream.m3u');	

$modversion['config'][] = array(
	'name' 			=> 'imagedir',
	'title' 		=> '_MI_ONAIR_IMGDIR',
	'description' 	=> '_MI_ONAIR_IMGDIRDSC',
	'formtype' 		=> 'textbox',
	'valuetype' 	=> 'text',
	'default' 		=> 'modules/onair/images/');
	
$modversion['config'][] = array(
	'name' 			=> 'maxfilesize',
	'title' 		=> '_MI_ONAIR_MAXFILESIZE',
	'description' 	=> '_MI_ONAIR_MAXFILESIZEDSC',
	'formtype' 		=> 'textbox',
	'valuetype' 	=> 'int',
	'default' 		=> 200000);


$modversion['config'][] = array(
	'name' 			=> 'adminmail',
	'title' 		=> '_MI_ONAIR_ALLOWHTML',
	'description' 	=> '',
	'formtype' 		=> 'yesno',
	'valuetype' 	=> 'int',
	'default' 		=> 1);

?>