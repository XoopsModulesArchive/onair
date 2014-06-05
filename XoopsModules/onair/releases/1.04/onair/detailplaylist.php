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
 * @version      $Id:detailplaylist.php 2009-06-19 13:49 culex $
 * @since         File available since Release 1.0.0
 */
		include 'header.php';
		include 'include/functions.php';
		$xoopsOption['template_main'] = 'onair_playlistdetail.html';
		include XOOPS_ROOT_PATH.'/header.php';
		global $xoopsDB;
if (isset($_GET['plext']) && $_GET['plext'] == 'info') {
        $plext = 'info';
		}

$pl_id=intval($pl_id);
switch($plext) {
        case "info":
                onair_PlaylistById($_GET["pl_id"]);
                break;
}
include XOOPS_ROOT_PATH.'/footer.php';
?>