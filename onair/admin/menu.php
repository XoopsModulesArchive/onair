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
 * @version      $Id:menu.php 2009-09-99 13:25 culex $
 * @since         File available since Release 1.0.5
 */
 
 // Items in the left-side menu for amin
 
$adminmenu[1]['title'] = _MI_ONAIR_PROGRAM_EDIT;
$adminmenu[1]['link'] = "admin/index.php?op=Eventshow";
$adminmenu[2]['title'] = _MI_ONAIR_ADDNEW;
$adminmenu[2]['link'] = "admin/index.php?op=Addnew";
$adminmenu[3]['title'] = _MI_ONAIR_ADDIMAGE;
$adminmenu[3]['link'] = "admin/index.php?op=ImageUpload";
$adminmenu[4]['title'] = _MI_ONAIR_PLAYLISTMENU;
$adminmenu[4]['link'] = "admin/playlist.php?op=Playlistshow";
$adminmenu[5]['title'] = _MI_ONAIR_SONGS;
$adminmenu[5]['link'] = "admin/songs.php";
$adminmenu[6]['title'] = _MI_ONAIR_HELP;
$adminmenu[6]['link'] = "admin/help.php";

?>