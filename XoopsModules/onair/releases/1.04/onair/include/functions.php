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
 * @version      $Id:functions.php 2009-07-31 13:10 culex $
 * @since         File available since Release 1.0.4
 */
 
 /**
 * Make day number into daynames
 *
 * @param   Place       $User side
 * @param   integer     $repeat 1
 * @return  Status
 */ 
function onair_Numbers2Days($oa_day)
{
// Give name to all instances of day number
$day_arr=array(
		"0" => _MD_ONAIR_SUNDAYNAME,
        "1" => _MD_ONAIR_MONDAYNAME,
        "2" => _MD_ONAIR_TUEDAYNAME,
        "3" => _MD_ONAIR_WEDDAYNAME,
		"4" => _MD_ONAIR_THUDAYNAME,
		"5" => _MD_ONAIR_FRIDAYNAME,
		"6" => _MD_ONAIR_SATDAYNAME);
		return $day_arr[$oa_day];
}
 /**
 * Make day number into daynames
 *
 * @param   Place       $Admin side
 * @param   integer     $repeat 1
 * @return  Status
 */ 
function onair_Numbers2DaysAdmin($oa_day)
{
// Give name to all instances of day number
$day_arr=array(
		"0" => _AM_ONAIR_SUNDAYNAME,
        "1" => _AM_ONAIR_MONDAYNAME,
        "2" => _AM_ONAIR_TUEDAYNAME,
        "3" => _AM_ONAIR_WEDDAYNAME,
		"4" => _AM_ONAIR_THUDAYNAME,
		"5" => _AM_ONAIR_FRIDAYNAME,
		"6" => _AM_ONAIR_SATDAYNAME);
		return $day_arr[$oa_day];
}
 /**
 * Make day number into daynames
 *
 * @param   Place       $block
 * @param   integer     $repeat 1
 * @return  Status
 */ 
function onair_Numbers2DaysBlock($oa_day)
{
// Give name to all instances of day number
$day_arr=array(
		"0" => _MB_ONAIR_SUNDAYNAME,
        "1" => _MB_ONAIR_MONDAYNAME,
        "2" => _MB_ONAIR_TUEDAYNAME,
        "3" => _MB_ONAIR_WEDDAYNAME,
		"4" => _MB_ONAIR_THUDAYNAME,
		"5" => _MB_ONAIR_FRIDAYNAME,
		"6" => _MB_ONAIR_SATDAYNAME);
		return $day_arr[$oa_day];
}

 /**
 * Show events by day
 *
 * @param   Place       $User side
 * @param   integer     $repeat 1
 * @return  Status
 */ 	
function onair_ShowByDay($oa_day){
	// Function to show all days where days is equal to the selected one
	$oa_timetype = onair_GetModuleOption('timetype');
	global $xoopsDB,$xoopsTpl,$timetype,$xoopsModuleConfig,$backgroundcolor;
	$dayname = onair_Numbers2Days($oa_day);
	$msg = array();
	if (isset($_POST['oa_id'])) {$oa_day=date('w');}
	$myts =& MyTextSanitizer::getInstance();
	$query = 'SELECT * FROM '.$xoopsDB->prefix('oa_program').' WHERE oa_day='.$myts->addSlashes("$oa_day").' ORDER BY oa_day,oa_start ASC';
	$result = $xoopsDB->query($query);
	$i = $xoopsDB->getRowsNum($result);
	

	while ($sqlfetch=$xoopsDB->fetchArray($result)) {
	$backgroundcolor = onair_ChangeBg($oa_day,$myts->htmlSpecialChars($myts ->stripSlashesGPC($sqlfetch["oa_start"])),$myts->htmlSpecialChars($myts ->stripSlashesGPC($sqlfetch["oa_stop"])));
	$msg['bgc'] = $backgroundcolor;
	$msg['oa_id'] = $myts->htmlSpecialChars($myts ->stripSlashesGPC($sqlfetch["oa_id"]));
	$msg['oa_day'] = onair_Numbers2Days($myts->htmlSpecialChars($myts ->stripSlashesGPC($sqlfetch["oa_day"])));
	$msg['oa_station'] = $myts->htmlSpecialChars($myts ->stripSlashesGPC($sqlfetch["oa_station"]));
	$msg['oa_name'] = $myts->htmlSpecialChars($myts ->stripSlashesGPC($sqlfetch["oa_name"]));
	$msg['oa_title'] = $myts->htmlSpecialChars($myts ->stripSlashesGPC($sqlfetch["oa_title"]));
	$msg['bgc'] = $backgroundcolor;
if ($xoopsModuleConfig['timetype']==1){
	$message['start'] = date('h:i:s a', strtotime($sqlfetch['oa_start'])); 
	$message['stop'] =  date('h:i:s a', strtotime($sqlfetch['oa_stop']));
		} else {
	$message['start'] = date('H:i:s', strtotime($sqlfetch['oa_start'])); 
	$message['stop'] =  date('H:i:s', strtotime($sqlfetch['oa_stop']));
		}
		
	$msg['oa_start'] = $myts->htmlSpecialChars($myts->stripSlashesGPC($message["start"]));
	$msg['oa_stop'] = $myts->htmlSpecialChars($message["stop"]);
	$msg['oa_image'] = "<img src='".XOOPS_URL."/".$xoopsModuleConfig['imagedir'].$myts->htmlSpecialChars($sqlfetch["oa_image"]) . "' height='".$xoopsModuleConfig['shotheight']."' width='".$xoopsModuleConfig['shotwidth']."' alt='"._VISITWEBSITE."' /></img>";
	$msg['oa_description'] = $myts->displayTarea($myts ->stripSlashesGPC($sqlfetch["oa_description"]),1,1,1);
	$i--;
	
	$xoopsTpl->assign('lang_startname',_MD_ONAIR_STARTNAME);
	$xoopsTpl->assign('lang_titlename',_MD_ONAIR_TITLENAME);
	$xoopsTpl->assign('lang_namename',_MD_ONAIR_NAMENAME);
	$xoopsTpl->assign('lang_startstop',_MD_ONAIR_STARTSTOP);
	$xoopsTpl->assign('lang_djimage',_MD_ONAIR_DJIMAGE);
	$xoopsTpl->assign('lang_dayname', $dayname);
	$xoopsTpl->append('posts', $msg);
}

}

 /**
 * Show events sorted by name
 *
 * @param   Place       $User side
 * @param   integer     $repeat 1
 * @return  Status		$where oa_name is like $oa_name
 */ 
function onair_ShowByName($oa_name){
	// Function to show names similar to the one choosen
	// Sorting by day, start time and name..
	global $xoopsDB,$xoopsTpl,$oa_name,$xoopsModuleConfig,$myts;
	
	$msg = array();
	$myts =& MyTextSanitizer::getInstance();
	$oa_name = $_REQUEST['oa_name'];
	$query = 'SELECT * FROM '.$xoopsDB->prefix('oa_program').' WHERE oa_name LIKE "%'.$myts->addSlashes($oa_name).'%" ORDER BY oa_day,oa_start ASC';
	$result = $xoopsDB->query($query);
	$i = $xoopsDB->getRowsNum($result);
	

	while ($sqlfetch=$xoopsDB->fetchArray($result)) {
	$backgroundcolor = onair_ChangeBg($myts->htmlSpecialChars($myts ->stripSlashesGPC($sqlfetch["oa_day"])),$myts->htmlSpecialChars($myts ->stripSlashesGPC($sqlfetch["oa_start"])),$myts->htmlSpecialChars($myts ->stripSlashesGPC($sqlfetch["oa_stop"])));
	$msg['bgc'] = $backgroundcolor;
	$msg['oa_id'] = $myts->htmlSpecialChars($myts ->stripSlashesGPC($sqlfetch["oa_id"]));
	$dayname = onair_Numbers2Days($myts->htmlSpecialChars($sqlfetch["oa_day"]));
	$msg['oa_day2'] = onair_Numbers2Days($myts->htmlSpecialChars($sqlfetch["oa_day"]));
	$msg['oa_station'] = $myts->htmlSpecialChars($myts ->stripSlashesGPC($sqlfetch["oa_station"]));
	$msg['oa_name'] = $myts->htmlSpecialChars($myts ->stripSlashesGPC($sqlfetch["oa_name"]));
	$msg['oa_title'] = $myts->htmlSpecialChars($myts ->stripSlashesGPC($sqlfetch["oa_title"]));
if ($xoopsModuleConfig['timetype']==1){
	$message['start'] = date('h:i:s a', strtotime($sqlfetch['oa_start'])); 
	$message['stop'] =  date('h:i:s a', strtotime($sqlfetch['oa_stop']));
		} else {
	$message['start'] = date('H:i:s', strtotime($sqlfetch['oa_start'])); 
	$message['stop'] =  date('H:i:s', strtotime($sqlfetch['oa_stop']));
		}
	$msg['oa_start'] = $myts->htmlSpecialChars($message["start"]);
	$msg['oa_stop'] = $myts->htmlSpecialChars($message["stop"]);
	$msg['oa_image'] = "<img src='".XOOPS_URL."/".$xoopsModuleConfig['imagedir'].$myts->htmlSpecialChars($sqlfetch["oa_image"]) . "' height='".$xoopsModuleConfig['shotheight']."' width='".$xoopsModuleConfig['shotwidth']."' alt='"._VISITWEBSITE."' /></img>";
	$msg['oa_description'] = $myts->displayTarea($myts ->stripSlashesGPC($sqlfetch["oa_description"]),1,1,1);
	$i--;
	
	$xoopsTpl->assign('lang_startname',_MD_ONAIR_STARTNAME);
	$xoopsTpl->assign('lang_titlename',_MD_ONAIR_TITLENAME);
	$xoopsTpl->assign('lang_namename',_MD_ONAIR_NAMENAME);
	$xoopsTpl->assign('lang_startstop',_MD_ONAIR_STARTSTOP);
	$xoopsTpl->assign('lang_djimage',_MD_ONAIR_DJIMAGE);
	$xoopsTpl->assign('lang_dayname', $dayname);
	$xoopsTpl->append('posts', $msg);
}
}
 /**
 * Show extended info based on id
 *
 * @param   Place       $User side
 * @param   integer     $repeat 1
 * @return  Status
 */ 
function onair_ShowExtInfo($oa_id){
	// Function to show extended information about the show, dj, start -> stop, etc etc 
	global $xoopsDB,$xoopsTpl,$oa_id, $oa_days,$xoopsModuleConfig;
	
	$msg = array();
	$oa_id = $_GET['oa_id'];
	$query = 'SELECT * FROM '.$xoopsDB->prefix('oa_program').' WHERE oa_id='.intval($oa_id).'';
	$result = $xoopsDB->queryF($query);
	$myts =& MyTextSanitizer::getInstance();

	while ($sqlfetch=$xoopsDB->fetchArray($result)) {
	$msg['oa_id'] = $myts->htmlSpecialChars($sqlfetch["oa_id"]);
	$msg['oa_day'] = onair_Numbers2Days($myts->htmlSpecialChars($myts ->stripSlashesGPC($sqlfetch["oa_day"])));
	$msg['oa_station'] = $myts->htmlSpecialChars($myts ->stripSlashesGPC($sqlfetch["oa_station"]));
	$msg['oa_name'] = $myts->htmlSpecialChars($myts ->stripSlashesGPC($sqlfetch["oa_name"]));
	$msg['oa_title'] = $myts->htmlSpecialChars($myts ->stripSlashesGPC($sqlfetch["oa_title"]));
	if ($xoopsModuleConfig['timetype']==1){
	$message['start'] = date('h:i:s a', strtotime($sqlfetch['oa_start'])); 
	$message['stop'] =  date('h:i:s a', strtotime($sqlfetch['oa_stop']));
		} else {
	$message['start'] = date('H:i:s', strtotime($sqlfetch['oa_start'])); 
	$message['stop'] =  date('H:i:s', strtotime($sqlfetch['oa_stop']));
		}
		
	$msg['oa_start'] = $myts->htmlSpecialChars($message["start"]);
	$msg['oa_stop'] = $myts->htmlSpecialChars($message["stop"]);
	$msg['oa_image'] = "<img src='".XOOPS_URL."/".$xoopsModuleConfig['imagedir'].$myts->htmlSpecialChars($sqlfetch["oa_image"]) . "' height='".$xoopsModuleConfig['maximh']."' width='".$xoopsModuleConfig['maximumw']."' alt='"._VISITWEBSITE."' /></img>";
	$msg['oa_description'] = $myts->displayTarea($myts ->stripSlashesGPC($sqlfetch["oa_description"]),1,1,1);
	$msg['oa_with'] = _MD_ONAIR_WITH;
	$xoopsTpl->append('info', $msg);	
}
}
 /**
 * Get xoops_config data
 *
 * Borrowed function from News 1.63 module 
 * (http://xoops.instant-zero.com/modules/repository/product.php?prod_id=1)
 * --------------------------------
 * @param   Place       $User side
 * @param   integer     $repeat 1
 * @return  Status
 */ 
function onair_GetModuleOption($option, $repmodule='onair')
{
	global $xoopsModuleConfig, $xoopsModule;
	static $tbloptions= Array();
	if(is_array($tbloptions) && array_key_exists($option,$tbloptions)) {
		return $tbloptions[$option];
	}

	$retval = false;
	if (isset($xoopsModuleConfig) && (is_object($xoopsModule) && $xoopsModule->getVar('dirname') == $repmodule && $xoopsModule->getVar('isactive'))) {
		if(isset($xoopsModuleConfig[$option])) {
			$retval= $xoopsModuleConfig[$option];
		}
	} else {
		$module_handler =& xoops_gethandler('module');
		$module =& $module_handler->getByDirname($repmodule);
		$config_handler =& xoops_gethandler('config');
		if ($module) {
		    $moduleConfig =& $config_handler->getConfigsByCat(0, $module->getVar('mid'));
	    	if(isset($moduleConfig[$option])) {
	    		$retval= $moduleConfig[$option];
	    	}
		}
	}
	$tbloptions[$option]=$retval;
	return $retval;
}
 /**
 * Get playlist data by id
 *
 * @param   Place       $User side
 * @param   integer     $repeat 1
 * @return  Status
 */ 
function onair_PlayListById($pl_id){
	// Function to show playlist 
	// based on the id-select
	global $xoopsDB,$xoopsTpl,$pl_name,$xoopsModuleConfig;
	
	$msg = array();
	$pl_id = $_REQUEST['pl_id'];
	$query = 'SELECT * FROM '.$xoopsDB->prefix('oa_playlist').' WHERE pl_id ='.intval($pl_id).'';
	$result = $xoopsDB->query($query);
	$i = $xoopsDB->getRowsNum($result);
	$myts =& MyTextSanitizer::getInstance();

	while ($sqlfetch=$xoopsDB->fetchArray($result)) {
	$msg['pl_id'] = $myts->htmlSpecialChars($sqlfetch["pl_id"]);
	$msg['pl_day'] = onair_Numbers2Days($myts->htmlSpecialChars($sqlfetch["pl_day"]));
	$msg['pl_station'] = $myts->htmlSpecialChars($myts ->stripSlashesGPC($sqlfetch["pl_station"]));
	$msg['pl_name'] = $myts->htmlSpecialChars($myts ->stripSlashesGPC($sqlfetch["pl_name"]));
	$msg['pl_title'] = $myts->htmlSpecialChars($myts ->stripSlashesGPC($sqlfetch["pl_title"]));
if ($xoopsModuleConfig['timetype']==1){
	$message['start'] = date('h:i:s a', strtotime($sqlfetch['pl_start'])); 
	$message['stop'] =  date('h:i:s a', strtotime($sqlfetch['pl_stop']));
		} else {
	$message['start'] = date('H:i:s', strtotime($sqlfetch['pl_start'])); 
	$message['stop'] =  date('H:i:s', strtotime($sqlfetch['pl_stop']));
		}
	$messagedatetime = strtotime($sqlfetch["pl_date"]);
	$messagedate = date('d-m-Y',$messagedatetime); 
	$msg['pl_date'] = $myts->htmlSpecialChars($myts ->stripSlashesGPC($messagedate));	
	$msg['pl_start'] = $myts->htmlSpecialChars($myts ->stripSlashesGPC($message["start"]));
	$msg['pl_stop'] = $myts->htmlSpecialChars($myts ->stripSlashesGPC($message["stop"]));
	$msg['pl_image'] = "<img src='".XOOPS_URL."/".$xoopsModuleConfig['imagedir'].$myts->htmlSpecialChars($sqlfetch["pl_image"]) . "' height='".$xoopsModuleConfig['maximh']."' width='".$xoopsModuleConfig['maximumw']."' alt='"._VISITWEBSITE."' /></img>";
	$msg['pl_description'] = $myts->displayTarea($myts ->stripSlashesGPC($sqlfetch["pl_description"]),1,1,1);
	$i--;
	$xoopsTpl->assign('lang_with', _MD_ONAIR_WITH);
	$xoopsTpl->assign('lang_ondate',_MD_ONAIR_ONDATE);
	$xoopsTpl->append('info', $msg);
}
}

 /**
 * Get playlist data by name
 *
 * @param   Place       $User side
 * @param   integer     $repeat 1
 * @return  Status
 */ 
function onair_PlaylistByName($pl_name){
	// Function to show names similar to the one choosen
	// Sorting by day, start time and name..
	global $xoopsDB,$xoopsTpl,$oa_name,$xoopsModuleConfig;
	$myts =& MyTextSanitizer::getInstance();
	$msg = array();
	$pl_name = $_REQUEST['pl_name'];
	$query = 'SELECT * FROM '.$xoopsDB->prefix('oa_playlist').' WHERE pl_name LIKE "%'.$myts->addSlashes($pl_name).'%" ORDER BY pl_date, pl_day, pl_start ASC';
	$result = $xoopsDB->query($query);
	$i = $xoopsDB->getRowsNum($result);
	

	while ($sqlfetch=$xoopsDB->fetchArray($result)) {
	$messagedatetime = strtotime($sqlfetch["pl_date"]);
	$messagedate = date('d-m-Y',$messagedatetime); 
	$msg['pl_date'] = $myts->htmlSpecialChars($messagedate);
	$msg['pl_id'] = $myts->htmlSpecialChars($sqlfetch["pl_id"]);
	$msg['pl_day'] = onair_Numbers2Days($myts->htmlSpecialChars($myts ->stripSlashesGPC($sqlfetch["pl_day"])));
	$msg['pl_station'] = $myts->htmlSpecialChars($myts ->stripSlashesGPC($sqlfetch["pl_station"]));
	$msg['pl_name'] = $myts->htmlSpecialChars($myts ->stripSlashesGPC($sqlfetch["pl_name"]));
	$msg['pl_title'] = $myts->htmlSpecialChars($myts ->stripSlashesGPC($sqlfetch["pl_title"]));
if ($xoopsModuleConfig['timetype']==1){
	$message['start'] = date('h:i:s a', strtotime($sqlfetch['pl_start'])); 
	$message['stop'] =  date('h:i:s a', strtotime($sqlfetch['pl_stop']));
		} else {
	$message['start'] = date('H:i:s', strtotime($sqlfetch['pl_start'])); 
	$message['stop'] =  date('H:i:s', strtotime($sqlfetch['pl_stop']));
		}
		
	$msg['pl_start'] = $myts->htmlSpecialChars($message["start"]);
	$msg['pl_stop'] = $myts->htmlSpecialChars($message["stop"]);
	$msg['pl_image'] = "<img src='".XOOPS_URL."/".$xoopsModuleConfig['imagedir'].$myts->htmlSpecialChars($sqlfetch["pl_image"]) . "' height='".$xoopsModuleConfig['shotheight']."' width='".$xoopsModuleConfig['shotwidth']."' alt='"._VISITWEBSITE."' /></img>";
	$msg['pl_description'] = $myts->displayTarea($myts ->stripSlashesGPC($sqlfetch["oa_description"]),1,1,1);
	
	$i--;
	$xoopsTpl->append('posts', $msg);
	$xoopsTpl->assign('lang_datename',_MD_ONAIR_DATENAME);
	$xoopsTpl->assign('lang_startname',_MD_ONAIR_STARTNAME);
	$xoopsTpl->assign('lang_stopname',_MD_ONAIR_STOPNAME);
	$xoopsTpl->assign('lang_titlename',_MD_ONAIR_TITLENAME);
	$xoopsTpl->assign('lang_namename',_MD_ONAIR_NAMENAME);
}
}
 /**
 * Get playlist data by title
 *
 * @param   Place       $User side
 * @param   integer     $repeat 1
 * @return  Status
 */ 
function onair_PlaylistByTitle($pl_title){
	// Function to show names similar to the one choosen
	// Sorting by day, start time and name..
	global $xoopsDB,$xoopsTpl,$pl_title,$xoopsModuleConfig;
	
	$msg = array();
	$pl_title = $_GET['pl_title'];
	if ($_GET['pl_title'] ==''){$pl_title='';}
	$query = 'SELECT * FROM '.$xoopsDB->prefix('oa_playlist').' WHERE pl_title LIKE "%'.$myts->addSlashes($pl_title).'%" ORDER BY pl_date, pl_day, pl_start ASC';
	$result = $xoopsDB->query($query);
	$i = $xoopsDB->getRowsNum($result);
	$myts =& MyTextSanitizer::getInstance();

	while ($sqlfetch=$xoopsDB->fetchArray($result)) {
	$msg['pl_id'] = $myts->htmlSpecialChars($sqlfetch["pl_id"]);
	$msg['pl_day'] = onair_Numbers2Days($myts->htmlSpecialChars($sqlfetch["pl_day"]));
	$msg['pl_station'] = $myts->htmlSpecialChars($myts ->stripSlashesGPC($sqlfetch["pl_station"]));
	$msg['pl_name'] = $myts->htmlSpecialChars($myts ->stripSlashesGPC($sqlfetch["pl_name"]));
	$msg['pl_title'] = $myts->htmlSpecialChars($myts ->stripSlashesGPC($sqlfetch["pl_title"]));
	$messagedatetime = strtotime($sqlfetch["pl_date"]);
	$messagedate = date('d-m-Y',$messagedatetime); 
	$msg['pl_date'] = $myts->htmlSpecialChars($messagedate);
if ($xoopsModuleConfig['timetype']==1){
	$message['start'] = date('h:i:s a', strtotime($sqlfetch['pl_start'])); 
	$message['stop'] =  date('h:i:s a', strtotime($sqlfetch['pl_stop']));
		} else {
	$message['start'] = date('H:i:s', strtotime($sqlfetch['pl_start'])); 
	$message['stop'] =  date('H:i:s', strtotime($sqlfetch['pl_stop']));
		}
		
	$msg['pl_start'] = $myts->htmlSpecialChars($message["start"]);
	$msg['pl_stop'] = $myts->htmlSpecialChars($message["stop"]);
	$msg['pl_image'] = "<img src='".XOOPS_URL."/".$xoopsModuleConfig['imagedir'].$myts->htmlSpecialChars($sqlfetch["pl_image"]) . "' height='".$xoopsModuleConfig['shotheight']."' width='".$xoopsModuleConfig['shotwidth']."' alt='"._VISITWEBSITE."' /></img>";
	$msg['pl_description'] = $myts->displayTarea($myts ->stripSlashesGPC($sqlfetch["oa_description"]),1,1,1);
	
	$i--;
	$xoopsTpl->append('posts', $msg);
}
	$xoopsTpl->assign('lang_datename',_MD_ONAIR_DATENAME);
	$xoopsTpl->assign('lang_startname',_MD_ONAIR_STARTNAME);
	$xoopsTpl->assign('lang_stopname',_MD_ONAIR_STOPNAME);
	$xoopsTpl->assign('lang_titlename',_MD_ONAIR_TITLENAME);
	$xoopsTpl->assign('lang_namename',_MD_ONAIR_NAMENAME);
}
 /**
 * Get playlist all
 *
 * @param   Place       $User side
 * @param   integer     $repeat 1
 * @return  Status
 */ 
function onair_PlaylistAll(){
	// Function to show names similar to the one choosen
	// Sorting by day, start time and name..
	global $xoopsDB,$xoopsTpl,$xoopsModuleConfig;
	$msg = array();
	$myts =& MyTextSanitizer::getInstance();
	$query = 'SELECT * FROM '.$xoopsDB->prefix('oa_playlist').' ORDER BY pl_date, pl_day, pl_start ASC';
	$result = $xoopsDB->query($query);
	$i = $xoopsDB->getRowsNum($result);
	
	while ($sqlfetch=$xoopsDB->fetchArray($result)) {
	$msg['pl_id'] = $myts->htmlSpecialChars($sqlfetch["pl_id"]);
	$msg['pl_day'] = onair_Numbers2Days($myts->htmlSpecialChars($sqlfetch["pl_day"]));
	$msg['pl_station'] = $myts->htmlSpecialChars($myts ->stripSlashesGPC($sqlfetch["pl_station"]));
	$msg['pl_name'] = $myts->htmlSpecialChars($myts ->stripSlashesGPC($sqlfetch["pl_name"]));
	$msg['pl_title'] = $myts->htmlSpecialChars($myts ->stripSlashesGPC($sqlfetch["pl_title"]));
	$messagedatetime = strtotime($sqlfetch["pl_date"]);
	$messagedate = date('d-m-Y',$messagedatetime); 
	$msg['pl_date'] = $myts->htmlSpecialChars($messagedate);
if ($xoopsModuleConfig['timetype']==1){
	$message['start'] = date('h:i:s a', strtotime($sqlfetch['pl_start'])); 
	$message['stop'] =  date('h:i:s a', strtotime($sqlfetch['pl_stop']));
		} else {
	$message['start'] = date('H:i:s', strtotime($sqlfetch['pl_start'])); 
	$message['stop'] =  date('H:i:s', strtotime($sqlfetch['pl_stop']));
		}
		
	$msg['pl_start'] = $myts->htmlSpecialChars($message["start"]);
	$msg['pl_stop'] = $myts->htmlSpecialChars($message["stop"]);
	$msg['pl_image'] = "<img src='".XOOPS_URL."/".$xoopsModuleConfig['imagedir'].$myts->htmlSpecialChars($sqlfetch["pl_image"]) . "' height='".$xoopsModuleConfig['shotheight']."' width='".$xoopsModuleConfig['shotwidth']."' alt='"._VISITWEBSITE."' /></img>";
	$msg['pl_description'] = $myts->displayTarea($myts ->stripSlashesGPC($sqlfetch["pl_description"]));
	$i--;
	
	$xoopsTpl->assign('lang_datename',_MD_ONAIR_DATENAME);
	$xoopsTpl->assign('lang_startname',_MD_ONAIR_STARTNAME);
	$xoopsTpl->assign('lang_stopname',_MD_ONAIR_STOPNAME);
	$xoopsTpl->assign('lang_titlename',_MD_ONAIR_TITLENAME);
	$xoopsTpl->assign('lang_namename',_MD_ONAIR_NAMENAME);
	$xoopsTpl->append('posts', $msg);
}
}
 /**
 * Converts encoding of non utf-8 files to utf-8
 * 
 * @param   Place       $User side
 * @param   integer     $repeat 1
 * @return  Status		$utf-8 format text from txt file
 */ 

function onair_File_Get_Contents_Utf8($fn) {
     $content = file_get_contents($fn);
	 $content = str_replace("_", " ", $content); // replace underline with space
	 $content = str_replace (".mp3",  "",  $content); // removes Extensions
	 $content = str_replace (".wav",  "",  $content); // removes Extensions
	 $content = preg_replace('/\s\s+/', ' ', $content);
	 $content = strtolower($content); // Make all letters lowercase
      return mb_convert_encoding($content, 'UTF-8',
          mb_detect_encoding($content, 'UTF-8, ISO-8859-1', true));
} 
 /**
 * Changes backgroundcolor in td where program is onair
 * 
 * @param   Place       $User side
 * @param   integer     $repeat 1
 * @return  Status		$changes background color to #FF0000
 */ 

function onair_ChangeBg ($day,$start,$stop){
     $timetype = onair_GetModuleOption('timetype');
// IF timetype = American (12 hour am/pm)
	if ($timetype=='1')
	{ $nowtime =date('h:i:s a');
		$nowday =date('w');
		if ($nowtime >= $start AND $nowtime < $stop AND $day == $nowday) {
		$backgroundcolor = 'no.png';
		}
			else 
			{ 
			$backgroundcolor = 'blank.png';
			}
	}
	// IF european time (24 hour)
	if ($timetype=='0'){
	$nowtime =date('H:i:s');
	$nowday =date('w');}
	if ($nowtime >= $start AND $nowtime < $stop AND $day == $nowday) {
		$backgroundcolor = 'no.png';
		}
			else 
			{ 
			$backgroundcolor = 'blank.png';
			}
			return $backgroundcolor;
} 
 /**
 * Updates or upload songinfo to database
 * with id, time, day, week, and song info
 *
 * @param   Place       $Server side
 * @param   integer     $repeat indefinitely
 * @return  Status
 */ 
function onair_CheckSong($song){
global $xoopsDB, $myts;
$myts =& MyTextSanitizer::getInstance();
$time=time();
$day=date('w');
$week=date('W');
$year=date('Y');

		// Do something to last entry
		$query = "SELECT * FROM ".$xoopsDB->prefix('oa_hitlist')." ORDER BY oa_songid DESC LIMIT 1";
		$query_error = NULL; 
		$result = $xoopsDB->query($query);
		$num_results2 = $xoopsDB->getRowsNum($result);		
		$msg = array();
			while ($sqlfetch=$xoopsDB->fetchArray($result)) {
			$msg['oa_songid'] = $myts->htmlSpecialChars($sqlfetch["oa_songid"]);
			$msg['oa_songtime'] = $myts->htmlSpecialChars($sqlfetch["oa_songtime"]);
			$msg['oa_songday'] = $myts->htmlSpecialChars($sqlfetch["oa_songday"]);
			$msg['oa_songweek'] = $myts->htmlSpecialChars($sqlfetch["oa_songweek"]);
			$msg['oa_songyear'] = $myts->htmlSpecialChars($sqlfetch["oa_songyear"]);
			$msg['oa_songsong'] = $myts->htmlSpecialChars($sqlfetch["oa_songsong"]);
			if ($msg['oa_songsong'] == $song)
			{
			
			$sql = "UPDATE ".$xoopsDB->prefix('oa_hitlist')." SET oa_songtime = ".$xoopsDB->quoteString($time)
		.", oa_songday = ".$xoopsDB->quoteString($day).", oa_songweek = ".$xoopsDB->quoteString($week).", oa_songyear = "
		.$xoopsDB->quoteString($year).", oa_songsong = ".$xoopsDB->quoteString($song)
		." WHERE oa_songid = ".intval($msg['oa_songid'])."";
		$result = $xoopsDB->queryF($sql);
		}
		
	 }
			if ($msg['oa_songsong'] != $song)
			{
			// Insert data
			
		$sqlinsert="INSERT INTO ".$xoopsDB->prefix("oa_hitlist")." (oa_songid, oa_songtime, oa_songday, oa_songweek, oa_songyear,oa_songsong) VALUES ('', ".$xoopsDB->quoteString($time).", ".$xoopsDB->quoteString($day).", ".$xoopsDB->quoteString($week).", ".$xoopsDB->quoteString($year).", ".$xoopsDB->quoteString($song).")";
		$result = $xoopsDB->queryF($sqlinsert);
		if (!$result = $xoopsDB->query($sqlinsert)) {
                
                }
	}
}	


?>