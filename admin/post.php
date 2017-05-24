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
 * @version      $Id:post.php 2009-06-19 13:23 culex $
 * @since         File available since Release 1.0.0
 */
        include_once ('admin_header.php');
		include '../include/functions.php';
        global $xoopsDB,$oa_start,$oa_stop;

		$oa_timetype = onair_GetModuleOption('timetype');
                $myts = MyTextSanitizer::getInstance();
        $oa_id="";        
        $oa_day = $myts->htmlSpecialChars($_POST["oa_day"]);
		$oa_station = $myts->htmlSpecialChars($_POST["oa_station"]);
		$oa_name = $myts->htmlSpecialChars($_POST["oa_name"]);
		$oa_title = $myts->htmlSpecialChars($_POST["oa_title"]);
		if (onair_GetModuleOption('timetype')=='0'){
		$oa_start = date('H:i:s', $_POST['oa_start']); 
		$oa_stop = date('H:i:s', $_POST['oa_stop']); 
		if ($oa_stop < $oa_start) {
		$_oa_stop = '23:59:59';
		}
		}
		if (onair_GetModuleOption('timetype')=='1'){
		$oa_start = date('h:i:s a', $_POST['oa_start']); 
		$oa_stop = date('h:i:s a', $_POST['oa_stop']); 
		if ($oa_stop < $oa_start) {
		$oa_stop = '23:59:59';
		}
		} 
		$oa_image = $myts->htmlSpecialChars($_POST["oa_image"]);
		$oa_description = $myts->htmlSpecialChars($_POST["oa_description"]);
        $oa_plugin = $myts->htmlSpecialChars($_POST["oa_plugin"]);
        $oa_stream = $myts->htmlSpecialChars($_POST["oa_stream"]);
		      
        $sqlinsert="INSERT INTO ".$xoopsDB->prefix("oa_program")." (oa_day, oa_station, oa_name, oa_title,oa_start, oa_stop, oa_image, oa_description, oa_plugin, oa_stream) VALUES (".$xoopsDB->quoteString($oa_day).", ".$xoopsDB->quoteString($oa_station).", ".$xoopsDB->quoteString($oa_name).", ".$xoopsDB->quoteString($oa_title).", ".$xoopsDB->quoteString($oa_start).", ".$xoopsDB->quoteString($oa_stop).", ".$xoopsDB->quoteString($oa_image).", ".$xoopsDB->quoteString($oa_description).", ".$xoopsDB->quoteString($oa_plugin).", ".$xoopsDB->quoteString($oa_stream).")";

                if (!$result = $xoopsDB->query($sqlinsert)) {
                $oa_send = _AM_ONAIR_ERRORINSERT;
                }

                // Send mail to webmaster
                if ($xoopsModuleConfig['adminmail'] == 1) {
                $subject = $xoopsConfig['sitename']." - "._AM_ONAIR_NAMEMODULE;
                $xoopsMailer =& getMailer();
                $xoopsMailer->useMail();
                $xoopsMailer->setToEmails($xoopsConfig['adminmail']);
                $xoopsMailer->setFromEmail($xoopsConfig['adminmail']);
                $xoopsMailer->setFromName($xoopsConfig['sitename']);
                $xoopsMailer->setSubject($subject);
                $xoopsMailer->setBody(_AM_ONAIR_NEWEVENT." ".XOOPS_URL."/modules/onair/");
                $xoopsMailer->send();
                }

				$oa_send = "<br />"._AM_ONAIR_THANKS;

     redirect_header("index.php",2,$oa_send);
?>