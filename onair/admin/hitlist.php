<?php
/**

 * Onair module
 *
 * Form to upload plist
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
 * @version      $Id:post.php 2009-06-19 13:22 culex $
 * @since         File available since Release 1.0.0
 */
      include_once 'admin_header.php';

include_once XOOPS_ROOT_PATH.'/class/xoopslists.php';
include XOOPS_ROOT_PATH.'/class/xoopsformloader.php';
include XOOPS_ROOT_PATH.'/include/xoopscodes.php';
include '../include/functions.php';
include '../include/classes.php';

onair_clean_illegalSongData();

	global $xoopsModule, $xoopsDB, $myts, $plistop, $xoopsModuleConfig;    		
	$myts =& MyTextSanitizer::getInstance();
	
	$plistop = 'plistform'; 
	$oa_listdir = "modules/onair/";

/**
 * Show upload form
 *
 * @param   Place       $In admin show upload plistform
 * @param   integer     $repeat 1
 * @return  Status
 */ 
function onair_ImageForm() {

	global $xoopsModuleConfig,$xoopsModule,$oa_maxfilesize;
	include XOOPS_ROOT_PATH."/class/xoopsformloader.php";
	$my_form = new XoopsThemeForm("Upload", "form", "hitlist.php");
	$my_form->insertBreak(_AM_ONAIR_UPLOADSONGSDESC, '');
	$my_form->setExtra( "enctype='multipart/form-data'" ) ; 
	$plist_box = new XoopsFormFile("Image", "plist", 500000);
	$plist_box->setExtra( "size ='50'") ;
	$my_form->addElement($plist_box); 
	$select = new XoopsFormSelect("Selection","select",$value = null,1,$multiple=False);
	$options = array("Playtime (winamp)","Direttore Logfile","Freehand");
	$select->addOptionArray($options);
	$button_tray = new XoopsFormElementTray('' ,'');
	$button_tray->addElement(new XoopsFormButton('', 'plistpost',"Submit", 'submit'));
	$my_form->addElement($select);
	$my_form->addElement($button_tray);
	$my_form->display();
	}
	foreach ( $_POST as $k => $v ) { 
	${$k} = $v; 
	}
	if ( isset($plistpost) ) {
	$plistop = 'plistpost';
	}

switch ($plistop) {
case "plistpost": 
	$allowed_mimetypes = array('text/plain');
	$plist_dir = XOOPS_ROOT_PATH ."/". $oa_listdir ;
	include_once(XOOPS_ROOT_PATH."/class/uploader.php");
	$field = $_POST["xoops_upload_file"][0] ; 
	
	if( !empty( $field ) || $field != "" ) { 
	$uploader = new XoopsMediaUploader($plist_dir, $allowed_mimetypes, 500000,null,null);
	$uploader->setPrefix( 'img' ) ;
	if( $uploader->fetchMedia( $field ) && $uploader->upload() ) { 
	//redirect_header("index.php",5,_AM_ONAIR_UPLOADSUCCESS." <br> ".AM_ONAIR_SAVEDAS. $uploader->getSavedFileName()." <br> "._AM_ONAIR_FULLPATH.$uploader->getSavedDestination());
	$savename = $uploader->getSavedFileName();
	
	if ($select == '0'){
	onair_ExplodeTextWinamp($_POST['select'],$savename);
	}
	if ($select == '1'){
	onair_ExplodeTextDirettore($_POST['select'],$savename);
	}
	if ($select == '2'){
	onair_ExplodeTextFreehand($_POST['select'],$savename);
	}
	} else { 
	//redirect_header("index.php",5,"".$uploader->getErrors());
	echo $uploader->getErrors();
	}
	}
break; 

case 'plistform':
default:
	xoops_cp_header();
		$select ='';
	$filename='';
	onair_ImageForm();
	xoops_cp_footer();
break;
	} 
	
	function onair_ExplodeTextWinamp($select,$savedname) {
	global $xoopsDB,$uploader,$plist_dir,$myts;
	$oa_listtype = $_POST['select'];
	if ($oa_listtype == "0") {
	// Read data to database
	$file = $plist_dir."/".$uploader->getSavedFileName();
	$fp = fopen($file, "r");
	$data = fread($fp, filesize($file));
	fclose($fp);
	//$output = str_replace("\t", "", $data);
	$output = explode("\n", $data);
	$myts =& MyTextSanitizer::getInstance();
	foreach($output as $var) {
		$tmp = explode("\t", $var);
		$oa_date = $myts->htmlSpecialChars($tmp[0]);
		$oa_time = $myts->htmlSpecialChars($tmp[1]);
		$oa_filepath = $myts->htmlSpecialChars($tmp[3]);
		$oa_heartbeatcount = $myts->htmlSpecialChars($tmp[11]);
		$weekname = date('W', strtotime($tmp[1])); 
		$dayname = date('w', strtotime($tmp[1]));
		$year = date('Y', strtotime($tmp[1]));
		$playtime = date('i:s', $tmp[11]);
		$date = date('d-m-Y', strtotime($tmp[0]));
$sql="INSERT INTO ".$xoopsDB->prefix("oa_hitlist")." (oa_songid, oa_songsong, oa_songtime, oa_songday, oa_songweek, oa_songyear, oa_songplaytime) VALUES ('', ".$xoopsDB->quoteString(htmlspecialchars($tmp[3],ENT_QUOTES)).", ".$xoopsDB->quoteString($date).", ".$xoopsDB->quoteString($dayname).", ".$xoopsDB->quoteString($weekname).", ".$xoopsDB->quoteString($year).", ".$xoopsDB->quoteString($playtime).")";
	if (!$result = $xoopsDB->query($sql)) {
				$import = AM_WRONGFILEFORMAT;
                }				
	}		
	}
	else
	{
	$import = AM_THANKS;
	}
	redirect_header("hitlist.php",2,$import);
	}
	
	
	function onair_ExplodeTextDirettore($select,$savedname) {
	global $xoopsDB,$uploader,$plist_dir,$myts;
	$oa_listtype = $_POST['select'];
	if ($oa_listtype == "1") {
	// Read data to database
	$file = $plist_dir."/".$uploader->getSavedFileName();
	$fp = fopen($file, "r");
	$data = fread($fp, filesize($file));
	fclose($fp);
	$data1 = str_replace("   ", "\t",$data);
	$output = explode ("\t", $data1);
	$datefinder = explode ("\t", $data1);
	foreach($datefinder as $breaker) {
		$bk = explode ("\r", $breaker);
		$oa_song = htmlspecialchars($tmp[0],ENT_QUOTES);
		$oa_date = date( "d-m-Y", strtotime( $breaker[5] ) );
		$oa_weekname = date( "W", strtotime( $breaker[5] ) );
		$dayname = date( "w", strtotime( $breaker[5] ) );
		$year = date( "Y", strtotime( $breaker[5] ) );
	}
	$myts =& MyTextSanitizer::getInstance();
	foreach($output as $var) {
		$tmp0 = str_replace ( "\r", "", $var);
		$tmp = explode ("\n", $tmp0);
		$playtime = $tmp[1];
 
 $sql="INSERT INTO ".$xoopsDB->prefix("oa_hitlist")." (oa_songid, oa_songsong, oa_songtime, oa_songday, oa_songweek, oa_songyear, oa_songplaytime) VALUES ('', ".$xoopsDB->quoteString($oa_songsong).", ".$xoopsDB->quoteString($oa_date).", ".$xoopsDB->quoteString($dayname).", ".$xoopsDB->quoteString($oa_weekname).", ".$xoopsDB->quoteString($year).", ".$xoopsDB->quoteString($playtime).")";
	
	if (!$result = $xoopsDB->query($sql)) 
	{
				$import = AM_WRONGFILEFORMAT;
    }				
	}		
	}
	else
	{
	$import = AM_THANKS;
	}
	redirect_header("hitlist.php",2,$import); 
	}
	
	
		function onair_ExplodeTextFreehand($select,$savedname) {
	global $xoopsDB,$uploader,$plist_dir,$myts;
	$oa_listtype = $_POST['select'];
	if ($oa_listtype == "2") {
	// Read data to database
	$file = $plist_dir."/".$uploader->getSavedFileName();
	$fp = fopen($file, "r");
	$data = fread($fp, filesize($file));
	fclose($fp);
	$output = preg_split('/[\r\n]+/', $data, -1, PREG_SPLIT_NO_EMPTY);
	$output1 = str_replace("''", "'",$output);
	$myts =& MyTextSanitizer::getInstance();
	foreach($output1 as $var) {
		$tmp = explode(";", $var);
		$oa_song = htmlspecialchars($tmp[0],ENT_QUOTES);
		$oa_date = $tmp[1];
		$weekname = date('W', strtotime($tmp[1])); 
		$dayname = date('w', strtotime($tmp[1]));
		$year = date('Y', strtotime($tmp[1]));
		$playtime = $tmp[2];
		$date = date('d-m-Y', strtotime($tmp[1]));
$sql="INSERT INTO ".$xoopsDB->prefix("oa_hitlist")." (oa_songid, oa_songsong, oa_songtime, oa_songday, oa_songweek, oa_songyear, oa_songplaytime) VALUES ('', ".$xoopsDB->quoteString($oa_song).", ".$xoopsDB->quoteString($date).", ".$xoopsDB->quoteString($dayname).", ".$xoopsDB->quoteString($weekname).", ".$xoopsDB->quoteString($year).", ".$xoopsDB->quoteString($playtime).")";
	if (!$result = $xoopsDB->query($sql)) {
				$import = AM_WRONGFILEFORMAT;
                }				
	}		
	}
	else
	{
	$import = AM_THANKS;
	}
	//redirect_header("hitlist.php",2,$import);
	}
	?>