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
 * @version      $Id:simple_now.php 2009-06-19 13:29 culex $
 * @since         File available since Release 1.0.0
 */

 /**
 * Create data for block
 *
 * @param   Place       $Block getting data
 * @param   integer     $repeat 1
 * @return  Status
 */ 
function b_Onair_ajaxcall() { 
	include_once XOOPS_ROOT_PATH.'/modules/onair/include/functions.php';
	global $xoopsDB,$xoopsModuleConfig, $XoopsConfig,$xoopsTpl,$xoopsLogger;  
	//$xoopsLogger->activated = false;
	$oa_lng = onair_GetModuleOption('language');
	if ( file_exists(XOOPS_ROOT_PATH.'/modules/onair/language/'.$oa_lng.'/blocks.php') ) {
	include(XOOPS_ROOT_PATH.'/modules/onair/language/'.$oa_lng.'/blocks.php');
	}
	else {
	include(XOOPS_ROOT_PATH.'/modules/onair/language/english/blocks.php');
	}
	// Get data now
	$nowday=date('w');
	// Set absolute maximum time of the day
	$nextstop="23:59:59";
	// Get dir, hight, width, and timetype from config
	$oa_imagedir = onair_GetModuleOption('imagedir');
	$oa_shothigh = onair_GetModuleOption('shotheight');
	$oa_shotwide = onair_GetModuleOption('shotwidth');
	$timetype = onair_GetModuleOption('timetype');
	
	// IF timetype = American (12 hour am/pm)
	if ($timetype=='1')
	{ $nowtime =date('h:i:s a');	}
	// IF european time (24 hour)
	else if ($timetype=='0'){$nowtime =date('H:i:s');}
	$block = array(); 
	$myts =& MyTextSanitizer::getInstance();

	// Get data according to current time
	$sql = "SELECT * FROM  ".$xoopsDB->prefix("oa_program")." WHERE ('$nowtime' BETWEEN oa_start AND oa_stop) AND '$nowday' = oa_day ORDER BY oa_day,oa_start LIMIT 1";
	$result=$xoopsDB->queryF($sql);
	if ($xoopsDB->getRowsNum($result)>'1') {
	$dayoffset='1';
	} else {
	$dayoffset='0';
	}
	while($myrow=$xoopsDB->fetchArray($result))
	{ 
	$limiter = $myrow['oa_stop'];
	$message = array(); 
	$oa_pluginname = $myrow['oa_plugin'];
	include XOOPS_ROOT_PATH.'/modules/onair/plugins/plugins.php';
	$message['id'] = $myrow['oa_id']; 
	$message['day'] = onair_Numbers2DaysBlock($myrow['oa_day']); 
	if ($timetype=='1'){
	$message['start'] = date('h:i:s a', strtotime($myrow['oa_start'])); 
	$message['stop'] =  date('h:i:s a', strtotime($myrow['oa_stop']));
	$nextstop =  date('h:i:s a', strtotime($myrow['oa_stop']));
	$nextbeginabsolute = "12:00:00 am";
		} else if ($timetype=='0'){
	$message['start'] = date('H:i:s', strtotime($myrow['oa_start'])); 
	$message['stop'] =  date('H:i:s', strtotime($myrow['oa_stop']));
	$nextstop =  date('H:i:s', strtotime($myrow['oa_stop']));
	$nextbeginabsolute = "00:00:00";
		}
	$title = $myts->stripSlashesGPC($myrow["oa_title"]);
	$message['title'] = $title;
	$station = $myts->stripSlashesGPC($myrow["oa_station"]);
	$message['station'] = $station;
	$name = $myts->stripSlashesGPC($myrow["oa_name"]);
	$message['name'] = $name;
	$description = $myts->stripSlashesGPC($myrow["oa_description"]);
	$message['description'] = $description;	
	$image = $myrow["oa_image"];
	$message['image'] = "<img src='".XOOPS_URL."/".$oa_imagedir.$image."' height='".$oa_shothigh."' width='".$oa_shotwide."' alt='"._VISITWEBSITE."' /></img>";
	$message['host'] = _MB_ONAIR_HOST;
	$block['onair'][] = $message; 
	} 
	if ($nowday =='6'|$dayoffset>'0'){
	$nowday2 = '0';
	} else {
	$nowday2 = $nowday + $dayoffset;
	}
	// Get data according to upcomming event
	$sqlnext2 = "SELECT * FROM  ".$xoopsDB->prefix("oa_program")." WHERE '$nextstop' >= oa_start AND '$nowday' = oa_day order by oa_start, oa_stop LIMIT 1";
	$resultnext2=$xoopsDB->getRowsNum($sqlnext2);
				if ($resultnext2 < 1 && $nowday == 0) {
			$sqlnext = "SELECT * FROM  ".$xoopsDB->prefix("oa_program")." WHERE oa_day = '1' order by oa_start, oa_stop LIMIT 1";
			$resultnext=$xoopsDB->queryF($sqlnext);
			}
		
		if ($resultnext2 < 1 && $nowday == 6) {
		 $sqlnext = "SELECT * FROM  ".$xoopsDB->prefix("oa_program")." WHERE '$nextstop' <= oa_start AND '$nowday' = oa_day order by oa_start, oa_stop LIMIT 1";
			$resultnext=$xoopsDB->queryF($sqlnext);
			if ($resultnext < 1) {
			$sqlnext = "SELECT * FROM  ".$xoopsDB->prefix("oa_program")." WHERE '$nextbeginabsolute' <= oa_start AND '$nowday' = '0' order by oa_start, oa_stop LIMIT 1";
			$resultnext=$xoopsDB->queryF($sqlnext);
			}
		}
		if ($resultnext2 < 1 && $nowday <= 5 && $nowday >= 1){
		$sqlnext = "SELECT * FROM  ".$xoopsDB->prefix("oa_program")." WHERE '$nextbeginabsolute' <= oa_start AND '$nowday'+1 = oa_day order by oa_start, oa_stop LIMIT 1";
	$resultnext=$xoopsDB->queryF($sqlnext);
		}
		if ( $resultnext ){ 

while($myrownext=$xoopsDB->fetchArray($resultnext))
	{ 
	$messagenext = array(); 
	$messagenext['id'] = $myrownext['oa_id']; 
	$messagenext['day'] = onair_Numbers2DaysBlock($myrownext['oa_day']); 
	if ($timetype=='1'){
	$messagenext['start'] = date('h:i:s a', strtotime($myrownext['oa_start'])); 
	$messagenext['stop'] =  date('h:i:s a', strtotime($myrownext['oa_stop']));
		} else {
	$messagenext['start'] = date('H:i:s', strtotime($myrownext['oa_start'])); 
	$messagenext['stop'] =  date('H:i:s', strtotime($myrownext['oa_stop']));
		}
	$titlenext = $myts->stripSlashesGPC($myrownext["oa_title"]);
	$messagenext['title'] = $titlenext;
	$stationnext = $myts->stripSlashesGPC($myrownext["oa_station"]);
	$messagenext['station'] = $stationnext;
	$namenext = $myts->stripSlashesGPC($myrownext["oa_name"]);
	$messagenext['name'] = $namenext;
	$descriptionnext = $myts->stripSlashesGPC($myrownext["oa_description"]);
	$messagenext['description'] = $descriptionnext;	

	$imagenext = $myts->stripSlashesGPC($myrownext["oa_image"]);
	$messagenext['image'] = "<img src='".XOOPS_URL."/".$oa_imagedir.$imagenext."' height='".$oa_shothigh."' width='".$oa_shotwide."' alt='"._VISITWEBSITE."' /></img>";
	$messagenext['comup'] = _MB_ONAIR_COMINGUP;
	$block['onair2'][] = $messagenext; 
	}
	}else{ 
		echo mysql_error(); 
		return false; 
	} 
	return $block; 
	unset($block);
	}
	

?>