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
 * @version      $Id:simple_now.php 2009-06-19 13:45 culex $
 * @since         File available since Release 1.0.0
 */
 
if (!defined('XOOPS_ROOT_PATH')) {
	die("XOOPS root path not defined");
}
include XOOPS_ROOT_PATH.'/class/xoopsformloader.php';

/**
 * Timeselect class
 *
 * Create 24 hours array for select drop down in admin, stepped by 15 minutes interval
 *
 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license       http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author       Michael Albertsen (culex) <http://www.culex.dk>
 * @version      $Id:simple_now.php 2009-06-19 13:45 culex $
 * @since         File available since Release 1.0.0
 */  
class onair_XoopsFormTimeEuro extends XoopsFormElementTray
{
	function onair_XoopsFormTimeEuro ($caption, $name, $size = 15, $value=0)
	{
			global $xoopsModule, $xoopsDB, $xoopsModuleConfig;
			
	$oa_start = strtotime('00:00:00');
	$oa_end = strtotime('23:59:59');
	
		$this->XoopsFormElementTray($caption, '&nbsp;');
		$timearray = array();
		for ( $i=$oa_start; $i < $oa_end;  $i+= 900) {
		$key = $i;
		$timearray[$key] = date('H:i:s',$i);
		}
		ksort($timearray);
		// XoopsFormDateTime XoopsFormDateTime( $caption, $name, [ $size = 15], [ $value = 0]  )
		$timeselect = new XoopsFormSelect('', $name,$size = 15, $value = 0);
		$timeselect->addOptionArray($timearray);
		$this->addElement($timeselect);
	}
}
/**
 * Timeselect class
 *
 * Create 12 hours (am/pm) array for select drop down in admin, stepped by 15 minutes interval
 *
 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license       http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author       Michael Albertsen (culex) <http://www.culex.dk>
 * @version      $Id:simple_now.php 2009-06-19 13:45 culex $
 * @since         File available since Release 1.0.0
 */  
class onair_XoopsFormTimeUs extends XoopsFormElementTray
{

	function onair_XoopsFormTimeUs ($caption, $name, $size = 15, $value=0)
	{
	$oa_start = strtotime('00:00:00');
	$oa_end = strtotime('23:59:59');
	
		$this->XoopsFormElementTray($caption, '&nbsp;');
		$timearray = array();
		for ( $i=$oa_start; $i < $oa_end;  $i+= 900) {
		$key = $i;
		$timearray[$key] = date('h:i:s a',$i);
		}
		ksort($timearray);
		$timeselect = new XoopsFormSelect('', $name,$size = 15, $value = 0);
		$timeselect->addOptionArray($timearray);
		$this->addElement($timeselect);
	}
}

/**
 * Image class
 *
 * Reads content of imagefolder and prepare filenames for database
 *
 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license       http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author       Michael Albertsen (culex) <http://www.culex.dk>
 * @version      $Id:simple_now.php 2009-06-19 13:45 culex $
 * @since         File available since Release 1.0.0
 */  
class onair_OaLists
{
        function getImgListAsArray($dirname, $prefix="")
        {
            $filelist = array();
            if ($handle = opendir($dirname)) {
                while (false !== ($file = readdir($handle))) {
                    if ( preg_match("/(\.gif|\.jpg|\.png|\.jpeg)$/i", $file) ) {
                        $file = $prefix.$file;
                        $filelist[$file] = $file;
                    }
                }
                closedir($handle);
                asort($filelist);
                reset($filelist);
            }
            return $filelist;
        }

}
?>