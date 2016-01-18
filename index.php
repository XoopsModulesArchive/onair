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
 * @version      $Id:simple_now.php 2009-07-04 18:05 culex $
 * @since         File available since Release 1.0.3
 */
		include 'header.php';
		include 'include/functions.php';
		$xoopsOption['template_main'] = 'onair_program.html';
		include XOOPS_ROOT_PATH.'/header.php';
		global $xoopsDB;
$show='day';
if (!isset($_GET['oa_day'])){
$_GET['oa_day'] = date('w');
}
if (isset($_GET['show']) && $_GET['show'] == 'day') {
        $show = 'day';
        }
if (isset($_GET['show']) && $_GET['show'] == 'name') {
        $show = 'name';
        }

$xoopsTpl->assign('lang_sundayname', _MD_ONAIR_SUNDAYNAME);
$xoopsTpl->assign('lang_mondayname', _MD_ONAIR_MONDAYNAME);
$xoopsTpl->assign('lang_tuedayname', _MD_ONAIR_TUEDAYNAME);
$xoopsTpl->assign('lang_weddayname', _MD_ONAIR_WEDDAYNAME);
$xoopsTpl->assign('lang_thudayname', _MD_ONAIR_THUDAYNAME);
$xoopsTpl->assign('lang_fridayname', _MD_ONAIR_FRIDAYNAME);
$xoopsTpl->assign('lang_satdayname', _MD_ONAIR_SATDAYNAME);

switch($show) {
        case "day":
                onair_ShowByDay($_GET["oa_day"]);
                break;
		case "name":
				onair_ShowByName($_GET["oa_name"]);
				break;

}


include XOOPS_ROOT_PATH.'/footer.php';
?>