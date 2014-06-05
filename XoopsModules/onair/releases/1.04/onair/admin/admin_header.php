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
 * @version      $Id:admin_header.php 630 2009-06-07 15:12 culex $
 * @since         File available since Release 1.0.0
 */
 
	include '../../../mainfile.php';
	include_once XOOPS_ROOT_PATH.'/class/xoopsmodule.php';
	include XOOPS_ROOT_PATH.'/include/cp_functions.php';
	if ( $xoopsUser ) {
	$xoopsModule = XoopsModule::getByDirname("onair");

		if ( !$xoopsUser->isAdmin($xoopsModule->mid()) ) { 
		redirect_header(XOOPS_URL."/",2,_NOPERM);
		exit();
		}
	}
	else {
	redirect_header(XOOPS_URL."/",2,_NOPERM);
	exit();
	}

	if ( file_exists("../language/".$xoopsConfig['language']."/admin.php") ) {
	include("../language/".$xoopsConfig['language']."/admin.php");
	}
	else {
	include("../language/english/admin.php");
	}
	
?>