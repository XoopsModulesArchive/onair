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
 * @version      $Id:simple_now.php 2009-06-19 13:55 culex $
 * @since         File available since Release 1.0.0
 */
		include 'header.php';
		include 'include/functions.php';
		$xoopsOption['template_main'] = 'onair_playlists.html';
		include XOOPS_ROOT_PATH.'/header.php';
		global $xoopsDB,$show,$myts;
		$myts =& MyTextSanitizer::getInstance();
		$show='';
if (isset($_GET['show']) && $_GET['show'] == 'title') {
        $show = 'title';
        $pl_title = $myts->addSlashes($pl_title);
		}
if (isset($_GET['show']) && $_GET['show'] == 'name') {
        $show = 'name';
        $pl_name = $myts->addSlashes($pl_name);
		}



switch($show) {
        case "title":
                onair_PlaylistByTitle($_REQUEST["pl_title"]);
                break;
		case "name":
				onair_PlaylistByName($_GET["pl_name"]);
				break;
		default :
				onair_PlaylistAll();
				break;
}
include XOOPS_ROOT_PATH.'/footer.php';
?>