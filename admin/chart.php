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
 * @version      $Id:top.php 2009-06-19 13:22 culex $
 * @since         File available since Release 1.0.0
 */
        include_once 'admin_header.php';
		include_once XOOPS_ROOT_PATH.'/class/xoopslists.php';
		include XOOPS_ROOT_PATH.'/class/xoopsformloader.php';
		include XOOPS_ROOT_PATH.'/include/xoopscodes.php';
		include '../include/functions.php';
		include '../include/classes.php';
		
		$top_timetype = onair_GetModuleOption('timetype');
		
        if (isset($_GET['op']) && $_GET['op'] == 'chart_show') {
        $op = 'chart_show';
        }
		
		if (isset($_GET['op']) && $_GET['op'] == 'chart_create') {
        $op = 'chart_create';
        }
		
		if (isset($_GET['op']) && $_GET['op'] == 'chart_delete') {
        $op = 'chart_delete';
        }

		if (empty($op)) {
        $op = 'chart_index';
        }

/**
 * Choose from chart menu
 *
 * @param   Place       $In admin choose your action from menu
 * @param   integer     $repeat 1
 * @return  Status
 */ 		
 
function onair_chartIndex() {
        global $xoopsModule;
        xoops_cp_header();
        echo '<table class="outer" width="100%"><tr><td class="even">';
        echo "<a href='chart.php?op=chart_show'>"._AM_ONAIR_CHARTSHOWALL."</a><br />";
		echo _AM_ONAIR_CREATECHARTFORWEEK;
		while ($weeks <= 52){
		echo "<a href='chart.php?op=chart_create&amp;ch_week=$weeks'>".$weeks."</a> ";
		$weeks++;
		}
		echo "<br><a href='index.php?op=chart_index'>"._AM_ONAIR_BACK2INDEX."</a><br />";
        echo "</td></tr></table>";
        xoops_cp_footer();
		}

/**
 * Delete chart 
 *
 * @param   Place       $In admin delete chart from database
 * @param   integer     $repeat 1
 * @return  Status
 */ 
function onair_ChartDel($del=0) {
        global $xoopsDB;
        if (isset($_POST['del']) && $_POST['del'] == 1) {
        $result = $xoopsDB->query("DELETE FROM ".$xoopsDB->prefix("oa_charts")
		." WHERE ch_chartid = ".intval($_POST['ch_chartid'])."");
        redirect_header("chart.php",2,_AM_ONAIR_CHARTDEL);
        exit();
        }
        else {
        xoops_cp_header();
        xoops_confirm(array('ch_chartid' => $_GET['ch_chartid'], 'del' => 1), 'chart.php?op=chart_delete',
		_AM_ONAIR_SUREDELETE);
        xoops_cp_footer();
        }
		}
		
/**
 * Save edited chart to database
 *
 * @param   Place       $In admin saves your edited chart
 * @param   integer     $repeat 1
 * @return  Status
 */ 
function onair_ChartSave() {
        global $xoopsDB,$top_timetype,$numbers2days;

        $xoopsDB->query("UPDATE ".$xoopsDB->prefix('oa_charts')." SET ch_charttitle = "
		.$xoopsDB->quoteString($_POST['ch_charttitle']).", ch_chartsong = ".$xoopsDB->quoteString($_POST['ch_chartsong'])
		.", ch_songweekstotal = ".$xoopsDB->quoteString($_POST['ch_songweekstotal']).", ch_songlastweek = "
		.$xoopsDB->quoteString($_POST['ch_songlastweek']).", ch_songtopplace = ".$xoopsDB->quoteString($_POST['ch_songtopplace'])
		.", ch_songthisweek = ".$xoopsDB->quoteString($_POST['ch_songthisweek']).", ch_songweek = "
		.$xoopsDB->quoteString($_POST['ch_songweek']).", ch_songplaytime = "
		.$xoopsDB->quoteString($_POST['ch_songplaytime'])." WHERE ch_chartid = ".intval($_POST['ch_chartid'])."");
        redirect_header("top.php",2,_AM_ONAIR_CHARTMOD.$_POST['approved']);
		exit();
		}
		
/**
 * Edit choosen Chart
 *
 * @param   Place       $In admin Load data to edit form and send to onair_ChartSave
 * @param   integer     $repeat 1
 * @return  Status
 */ 
function onair_ChartEdit($ch_chartid) {

	global $xoopsModuleConfig,$xoopsModule,$xoopsDB,$top_timetype,$myts;
	include XOOPS_ROOT_PATH."/class/xoopsformloader.php";
	$chartform = new XoopsThemeForm("Chart", "form", "chart.php?op=chart_save&amp;ch_chartid=$ch_chartid"); 
	$myts = MyTextSanitizer::getInstance();
	$result=$xoopsDB->query("SELECT ch_chartid, ch_charttitle, ch_chartsong, ch_chartweekstotal, ch_chartlastweek, ch_charttopplace, ch_chartthisweek, ch_chartweek ,ch_chartplaytime FROM ".$xoopsDB->prefix("oa_chart")." WHERE ch_chartid=".intval($ch_chartid)." ORDER BY ch_chartthisweek LIMIT 0,20");
	
	list($ch_chartid, $ch_charttitle, $ch_chartsong, $ch_chartweekstotal, $ch_chartlastweek, $ch_charttopplace, $ch_chartthisweek, $ch_chartweek, $ch_chartplaytime) = $xoopsDB->fetchRow($result);
	 
	 $id_chart_hidden = new XoopsFormHidden("ch_chartid", $ch_chartid);
	 $title_chart_hidden = new XoopsFormHidden("ch_charttitle", $myts->htmlSpecialChars($myts ->stripSlashesGPC($ch_charttitle)));
	 $song_chart_hidden = new XoopsFormHidden("ch_chartsong", $myts->htmlSpecialChars($myts ->stripSlashesGPC($ch_chartsong)));
	 $weekstotal_chart_hidden = new XoopsFormHidden("ch_chartweekstotal", $myts->htmlSpecialChars($myts ->stripSlashesGPC($ch_weekstotal)));
	 $lastweek_chart_hidden = new XoopsFormHidden("ch_chartlastweek", $ch_chartlastweek);
	 $topplace_chart_hidden = new XoopsFormHidden("ch_charttopplace", $ch_charttopplace);
	 $thisweek_chart_hidden = new XoopsFormHidden("ch_chartthisweek", $ch_chartthisweek);
	 $week_chart_hidden = new XoopsFormHidden("ch_chartweek", $ch_chartweek);
	 $playtime_chart_hidden = new XoopsFormHidden("ch_chartplaytime", $ch_chartplaytime);
	
	// SELECT PROGRAM TO ADD CHART TO...
	
	$chart_song = new XoopsFormText(_AM_ONAIR_CHARTSONG, "ch_chartsong", 150, 150, $myts->htmlSpecialChars($myts ->stripSlashesGPC($ch_chartsong)));
	$chartform->addElement($ch_chartsong);
	
	$chartweekstotal = new XoopsFormText(_AM_ONAIR_CHARTWEEKSTOTAL, "ch_chartweekstotal", 2, 2, $myts->htmlSpecialChars($myts ->stripSlashesGPC($ch_chartweekstotal)));
	$chartform->addElement($ch_chartweekstotal);
	
	$chartlastweek = new XoopsFormText(_AM_ONAIR_CHARTLASTWEEK, "ch_chartlastweek", 2, 2, $ch_chartlastweek);
	$chartform->addElement($ch_chartlastweek);	

	$charttopplace = new XoopsFormText(_AM_ONAIR_CHARTTOPPLACE, "ch_charttopplace", 2, 2, $ch_charttopplace);
	$chartform->addElement($ch_charttopplace);
	
	$chartthisweek = new XoopsFormText(_AM_ONAIR_CHARTTHISWEEK, "ch_chartthisweek", 2, 2, $ch_chartthisweek);
	$chartform->addElement($ch_chartthisweek);
	
	$chartweek = new XoopsFormText(_AM_ONAIR_CHARTWEEK, "ch_chartweek", 2, 2, $myts->htmlSpecialChars($myts ->stripSlashesGPC($ch_chartweek)));
	$chartform->addElement($ch_chartweek);
	
	$chartplaytime = new XoopsFormText(_AM_ONAIR_CHARTPLAYTIME, "ch_chartplaytime", 8, 8, $myts->htmlSpecialChars($myts ->stripSlashesGPC($ch_chartplaytime)));
	$chartform->addElement($ch_chartplaytime);
	
		// SUBMIT BUTTON AND SHOW FORM
		$op_hidden = new XoopsFormHidden("op", "chart_save");
        $chartform->addElement($op_hidden);
        
		
        $chartform->addElement($id_chart_hidden);
        $chartform->addElement($title_chart_hidden);			
		$button_tray = new XoopsFormElementTray('' ,'');
		$button_tray->addElement(new XoopsFormButton('', 'chart_save',"Submit", 'submit'));
		$chartform->addElement($button_tray);
		$chartform->display();
		}
		
/**
 * Show all playlist in database
 *
 * @param   Place       $In admin Show all playlists
 * @param   integer     $repeat 1
 * @return  Status
 */ 
function onair_ChartShow() {
        global $xoopsDB, $myts, $top_days,$xoopsModuleConfig,$top_timetype;
        
        xoops_cp_header();
		$myts = MyTextSanitizer::getInstance();
		$weeks = 1;
		echo "<table border='0' width='100%' class='outer' align='center'>
        <tr><td class='even'><b><center>Week numbes.: ";
		while ($weeks <= 52){
		echo "<a href='chart.php?op=chart_show&amp;ch_week=$weeks'>".$weeks."</a> ";
		$weeks++;
		}
		
		echo "</b></td></center><table border='0' width='100%' class='outer' align='center'>
        <tr><td class='even'><b>"._AM_ONAIR_CHARTTHISWEEK."</b></td><td class='even'><b>"
		._AM_ONAIR_CHARTLASTWEEK."</b></td><td class='even'><b>"._AM_ONAIR_CHARTTOPPLACE."</b></td><td class='even'><b>"
		._AM_ONAIR_CHARTWEEKSTOTAL."</b></td><td class='even'><b>"._AM_ONAIR_CHARTSONG."</b></td><td colspan='2' class='even'><center><b>"
		._AM_ONAIR_ACTION."</center></b></td></tr>";
		$showbyweek = $_GET['ch_week'];
		$result=$xoopsDB->queryF("SELECT * FROM ".$xoopsDB->prefix("oa_chart")." WHERE ch_chartweek=".intval($showbyweek)." ORDER BY ch_chartthisweek limit 0,20;");
	    while($myrow=$xoopsDB->fetchArray($result)) {
		//$ch_chartid = $myrow['ch_chartid'];
		$ch_chartsong = $myrow['ch_chartsong'];
		$ch_chartweekstotal = $myrow['ch_chartweekstotal'];
		$ch_chartlastweek = $myrow['ch_chartlastweek'];
		$ch_charttopplace = $myrow['ch_charttopplace'];
		$ch_chartthisweek = $myrow['ch_chartthisweek'];
		//$ch_chartweek = $myrow['ch_chartweek'];
		//$ch_chartplaytime = $myrow['ch_chartplaytime'];
        echo "</td>
		<td class='odd'>$ch_chartthisweek&nbsp;</td>
		<td class='odd'>$ch_chartlastweek&nbsp;</td>
		<td class='odd'>$ch_charttopplace&nbsp;</td>
		<td class='odd'>$ch_chartweekstotal&nbsp;</td>
		<td class='odd'>$ch_chartsong&nbsp;</td>
		<td class='odd'><a href='top.php?op=chart_edit&amp;ch_chartid=$ch_chartid'>"._AM_ONAIR_EDIT."</a></td>
		<td class='odd'><a href='top.php?op=chart_delete&amp;ch_chartid=$ch_chartid'>"._AM_ONAIR_DEL."</a></td>
        </tr>";
        }
        echo "</table>";
        xoops_cp_footer();
}

function onair_chart($ch_week) {
	global $xoopsModuleConfig,$xoopsModule,$xoopsDB,$chart_timetype,$ch_week,$myts;
	include XOOPS_ROOT_PATH."/class/xoopsformloader.php";
	$chartform = new XoopsThemeForm("chart", "form", "chart.php?op=chartpost&amp;ch_chartid=$ch_chartid"); 
	$myts = MyTextSanitizer::getInstance();
	
	$result=$xoopsDB->query("SELECT SELECT oa_songsong, count( * ) FROM ".$xoopsDB->prefix("oa_hitlist")." WHERE oa_songweek=".intval($ch_week)." GROUP BY oa_songsong ORDER BY COUNT( * ) DESC LIMIT 0 , 20;");
	$myts = MyTextSanitizer::getInstance();
	list($oa_songid , $oa_songsong , $oa_songtime , $oa_songday , $oa_songweek , $oa_songyear , $oa_songplaytime) = $xoopsDB->fetchRow($result);
     
	 $id_chart_hidden = new XoopsFormHidden("oa_songid", $myts->htmlSpecialChars($myts ->stripSlashesGPC($oa_songid)));
	 $song_chart_hidden = new XoopsFormHidden("oa_songsong", $oa_songsong);
	 $time_chart_hidden = new XoopsFormHidden("oa_songtime", $oa_songtime);
	 $day_chart_hidden = new XoopsFormHidden("oa_songday", $myts->htmlSpecialChars($myts ->stripSlashesGPC($oa_songday)));
	 $week_chart_hidden = new XoopsFormHidden("oa_songweek", $oa_songweek);
	 $year_chart_hidden = new XoopsFormHidden("oa_songyear", $oa_songyear);
	 $playtime_chart_hidden = new XoopsFormHidden("oa_songplaytime", $myts->htmlSpecialChars($myts ->stripSlashesGPC($oa_songyear)));

	// SELECT PROGRAM TO ADD PLAYLIST TO...
	$counter = 1;
	while ($counter<=10;$counter++){
	$infotitle = new XoopsFormText(_AM_ONAIR_CHARTTITLE, "cl_charttitle", 150, 150, $myts->htmlSpecialChars($myts ->stripSlashesGPC(onair_DateOfWeek($oa_songyear, $oa_songday))));
	$chartform->addElement($infotitle);
		
	$infosong = new XoopsFormText(_AM_ONAIR_CHARTSONG, "cl_chartsong", 150, 150, $myts->htmlSpecialChars($myts ->stripSlashesGPC($oa_songsong)));
	$chartform->addElement($infosong);
	
	$infoweekstotal = new XoopsFormText(_AM_ONAIR_CHARTTOTAL, "cl_charttotal", 2, 2, $myts->htmlSpecialChars($myts ->stripSlashesGPC(onair_WeeksTotal($oa_songsong))));
	$chartform->addElement($infoweekstotal);
	
	$infolastweek = new XoopsFormText(_AM_ONAIR_CHARTLASTWEEK, "cl_chartlastweek", 2, 2, onair_ChartLastWeek($oa_songsong,$oa_songweek));
	$chartform->addElement($infolastweek);	

	$infotopplace = new XoopsFormText(_AM_ONAIR_CHARTTOPPLACE, "cl_charttopplace", 2, 2, onair_TopPlace($oa_songsong));
	$chartform->addElement($infotopplace);
	
	$infothisweek = new XoopsFormText(_AM_ONAIR_CHARTTHISWEEK, "cl_chartthisweek", 2, 2, $myts->htmlSpecialChars($myts ->stripSlashesGPC(onair_GetThisWeekPos ($oa_songweek, $oa_songsong))));
	$chartform->addElement($infothisweek);
	}
		
		// SUBMIT BUTTON AND SHOW FORM
		$op_hidden = new XoopsFormHidden("op", "Chartpost");
        $chartform->addElement($op_hidden);
        
		
        $chartform->addElement($id_chart_hidden);
        $chartform->addElement($song_chart_hidden);		
        $chartform->addElement($time_chart_hidden);
        $chartform->addElement($day_chart_hidden);
        $chartform->addElement($week_chart_hidden);			
        $chartform->addElement($year_chart_hidden);						
        $chartform->addElement($playtime_chart_hidden);	
		$button_tray = new XoopsFormElementTray('' ,'');
		$button_tray->addElement(new XoopsFormButton('', 'chartpost',"Submit", 'submit'));
		$chartform->addElement($button_tray);
		$chartform->display();
		}
// Switch for choises
		global $op;
		$ch_week = $_GET['ch_week'];
	switch($op) {
        case "chart_save":
                onair_ChartSave();
                break;
        case "chart_edit":
                xoops_cp_header();
				onair_ChartEdit($_GET["cl_chartweek"]);
				xoops_cp_footer();
                break;
        case "chart_delete":
                onair_ChartDel();
                break;
        case "chart_show":
                onair_ChartShow();
                break;        
		case "chart_create":
				xoops_cp_header();
				onair_Chart($_GET["ch_week"]);
				xoops_cp_footer();
				break;		
		case "chartpost":
		global $myts,$xoopsDB;
	$myts = MyTextSanitizer::getInstance();
		
		// ch_charttitle ch_chartsong ch_chartweekstotal ch_chartlastweek ch_charttopplace ch_chartthisweek ch_chartweek ch_chartplaytime
		
		$charttitle	= $myts->htmlSpecialChars($_POST["ch_charttitle"]);
		$chartsong	= $myts->htmlSpecialChars($_POST["ch_chartsong"]);
		$chartweekstotal	= $myts->htmlSpecialChars($_POST["ch_chartweekstotal"]);
        $chartlastweek = $myts->htmlSpecialChars($_POST["ch_chartlastweek"]);
		$charttopplace = $myts->htmlSpecialChars($_POST["ch_charttopplace"]);
		$chartthisweek = $myts->htmlSpecialChars($_POST["ch_chartthisweek"]);
		$chartweek = $myts->htmlSpecialChars($_POST["ch_chartweek"]);
		$chartplaytime = $myts->htmlSpecialChars($_POST["ch_chartplaytime"]);
		             
        $sqlinsert="INSERT INTO ".$xoopsDB->prefix("oa_chart")." (ch_chartid, ch_charttitle, ch_chartsong, ch_chartweekstotal, ch_chartlastweek, ch_charttopplace,ch_chartthisweek, ch_chartweek, ch_chartplaytime) VALUES ('', ".$xoopsDB->quoteString($charttitle).", ".$xoopsDB->quoteString($chartsong).", ".$xoopsDB->quoteString($chartweekstotal).", ".$xoopsDB->quoteString($chartlastweek).", ".$xoopsDB->quoteString($charttopplace).", ".$xoopsDB->quoteString($chartthisweek).", ".$xoopsDB->quoteString($chartweek).", ".$xoopsDB->quoteString($chartplaytime).")";

                if (!$result = $xoopsDB->query($sqlinsert)) {
				//redirect_header("chart.php",2,_AM_ONAIR_ERRORINSERT);
                }				
				//redirect_header("chart.php",2,_AM_ONAIR_THANKS);
				
break; 

case "chart_index": 
default:
                onair_ChartIndex();
                break;						
} 
		
		?>