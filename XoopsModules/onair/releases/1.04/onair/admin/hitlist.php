<?php
include '../../mainfile.php';
include '../include/functions.php';
global $xoopsDB;
$checksong ="";
$onair_songData ="";

// check database for existing data
$myts =& MyTextSanitizer::getInstance();
$onair_songdata = onair_File_Get_Contents_Utf8($oa_pluginfile);
$checksong = "SELECT MAX(oa_songid) FROM".$xoopsDb->prefix('oa_hitlist')." song"; 
$result = $xoopsDB->query($checksong);
while ($sqlfetch=$xoopsDB->fetchArray($result)) {
	$messageid = $myts->htmlSpecialChars($sqlfetch["oa_songid"});
	$messagetime = $myts->htmlSpecialChars($sqlfetch["oa_songtime"});
	$messageyear = $myts->htmlSpecialChars($sqlfetch["oa_songyear"});
	$messageweek = $myts->htmlSpecialChars($sqlfetch["oa_songweek"});
	$messagesong = $myts->htmlSpecialChars($sqlfetch["oa_songsong"});
}

if ($onair_songdata != $messagesong['oa_songsong']) 
{
$oa_songid="";
$oa_songtime = time();
$oa_songyear = date('Y');
$oa_songweek = date('W');

$songinsert = "INSERT INTO ".$xoopsDb->prefix('oa_hitlist')." (oa_songid, oa_songtime, oa_songyear, oa_songweek, oa_songsong) VALUES (".$xoopsDB->quoteString($oa_songid).",".$xoopsDB->quoteString($oa_songtime).",".$xoopsDB->quoteString($oa_songyear).",".$xoopsDB->quoteString($oa_songweek).",".$xoopsDB->quoteString($messagesong).")";

                if (!$result = $xoopsDB->query($songinsert)) {
                $oa_send = _AM_ONAIR_ERRORINSERT;
                }
} else if ($onair_songdata == $messagesong['oa_songsong']) {
$oa_songid="";
$oa_songtime = time();
$oa_songyear = date('Y');
$oa_songweek = date('W');
		$xoopsDB->query("UPDATE ".$xoopsDB->prefix('oa_hitlist')." SET oa_songtime = ".$xoopsDB->quoteString($oa_songtime).", oa_songsong = "
		.$xoopsDB->quoteString($messagesong)." WHERE oa_songid = MAX(oa_songid)");
        redirect_header("index.php",2,_AM_ONAIR_EVENTMOD);
		exit();

}


?>