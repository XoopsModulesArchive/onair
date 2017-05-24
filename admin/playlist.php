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
 * @version      $Id:playlist.php 2009-06-19 13:22 culex $
 * @since         File available since Release 1.0.0
 */
        include_once 'admin_header.php';
		include_once XOOPS_ROOT_PATH.'/class/xoopslists.php';
		include XOOPS_ROOT_PATH.'/class/xoopsformloader.php';
		include XOOPS_ROOT_PATH.'/include/xoopscodes.php';
		include '../include/functions.php';
		include '../include/classes.php';
		
		$pl_timetype = onair_GetModuleOption('timetype');
		
        if (isset($_GET['op']) && $_GET['op'] == 'Playlistshow') {
        $op = 'Playlistshow';
        }
        if (isset($_GET['op']) && $_GET['op'] == 'Playlistedit') {
        $op = 'Playlistedit';
        }        
        if (isset($_GET['op']) && $_GET['op'] == 'Playlistdel') {
        $op = 'Playlistdel';
        }
        if (isset($_POST['op']) && $_POST['op'] == 'Playlistsave') {
        $op = 'Playlistsave';
        }
		if (isset($_GET['op']) && $_GET['op'] == 'Playlist') {
        $op = 'Playlist';
        }
		if (empty($op)) {
        $op = 'Playlistchoice';
        }
		if (isset($_GET['op']) && $_GET['op'] == 'Playlist' && $_GET['oa_id']=='') {
		redirect_header("index.php?op=Eventshow",4,_AM_ONAIR_NOTEXISTEVENT);
		}
		
/**
 * Choose from playlist menu
 *
 * @param   Place       $In admin choose your action from menu
 * @param   integer     $repeat 1
 * @return  Status
 */ 		
function onair_PlaylistChoice() {
        global $xoopsModule;
        xoops_cp_header();
        echo '<table class="outer" width="100%"><tr><td class="even">';
        echo "<a href='playlist.php?op=Playlistshow'>"._AM_ONAIR_PLAYLISTSHOWALL."</a><br />";
		echo "<a href='index.php?op=choice'>"._AM_ONAIR_BACK2INDEX."</a><br />";
        echo '</td></tr></table>';
        xoops_cp_footer();
		}

/**
 * Delete playlist 
 *
 * @param   Place       $In admin delete playlist from database
 * @param   integer     $repeat 1
 * @return  Status
 */ 
function onair_PlaylistDel($del=0) {
        global $xoopsDB;
        if (isset($_POST['del']) && $_POST['del'] == 1) {
        $result = $xoopsDB->query("DELETE FROM ".$xoopsDB->prefix("oa_playlist")
		." WHERE pl_id = ".intval($_POST['pl_id'])."");
        redirect_header("playlist.php",2,_AM_ONAIR_PLAYLISTDEL);
        exit();
        }
        else {
        xoops_cp_header();
        xoops_confirm(array('pl_id' => $_GET['pl_id'], 'del' => 1), 'playlist.php?op=Playlistdel',
		_AM_ONAIR_SUREDELETE);
        xoops_cp_footer();
        }
		}

/**
 * Save edited playlist to database
 *
 * @param   Place       $In admin saves your edited playlist
 * @param   integer     $repeat 1
 * @return  Status
 */ 
function onair_PlaylistSave() {
        global $xoopsDB,$pl_timetype,$numbers2days;

        $xoopsDB->query("UPDATE ".$xoopsDB->prefix('oa_playlist')." SET pl_day = "
		.$xoopsDB->quoteString($_POST['pl_day']).", pl_station = ".$xoopsDB->quoteString($_POST['pl_station'])
		.", pl_title = ".$xoopsDB->quoteString($_POST['pl_title']).", pl_name = "
		.$xoopsDB->quoteString($_POST['pl_name']).", pl_start = ".$xoopsDB->quoteString($_POST['pl_start'])
		.", pl_stop = ".$xoopsDB->quoteString($_POST['pl_stop']).", pl_image = "
		.$xoopsDB->quoteString($_POST['pl_image']).", pl_description = "
		.$xoopsDB->quoteString($_POST['pl_description']).", pl_date = "
		.$xoopsDB->quoteString($_POST['pl_date'])." WHERE pl_id = ".intval($_POST['pl_id'])."");
        redirect_header("playlist.php",2,_AM_ONAIR_PLAYLISTMOD.$_POST['approved']);
		exit();
		}

/**
 * Edit choosen playlist
 *
 * @param   Place       $In admin Load data to edit form and send to onair_PlaylistSave
 * @param   integer     $repeat 1
 * @return  Status
 */ 
function onair_PlaylistEdit($pl_id) {

	global $xoopsModuleConfig,$xoopsModule,$xoopsDB,$pl_timetype,$myts;
include XOOPS_ROOT_PATH."/class/xoopsformloader.php";
	$playlistform = new XoopsThemeForm("PlayList", "form", "playlist.php?op=Playlistsave&amp;pl_id=$pl_id"); 
	$myts = MyTextSanitizer::getInstance();
	$result=$xoopsDB->query("SELECT pl_day, pl_title, pl_name, pl_start, pl_stop, pl_image, pl_date, pl_description,pl_station FROM ".$xoopsDB->prefix("oa_playlist")." WHERE pl_id=".intval($pl_id)."");
	
	list($pl_day,$pl_title,$pl_name,$pl_start,$pl_stop,$pl_image,$pl_date,$pl_description,$pl_station) = $xoopsDB->fetchRow($result);
	 
	 $id_playlist_hidden = new XoopsFormHidden("pl_id", $pl_id);
	 $day_playlist_hidden = new XoopsFormHidden("pl_day", $pl_day);
	 $title_playlist_hidden = new XoopsFormHidden("pl_title", $myts->htmlSpecialChars($myts ->stripSlashesGPC($pl_title)));
	 $name_playlist_hidden = new XoopsFormHidden("pl_name", $myts->htmlSpecialChars($myts ->stripSlashesGPC($pl_name)));
	 $start_playlist_hidden = new XoopsFormHidden("pl_start", $pl_start);
	 $stop_playlist_hidden = new XoopsFormHidden("pl_stop", $pl_stop);
	 $image_playlist_hidden = new XoopsFormHidden("pl_image", $pl_image);
	 $date_playlist_hidden = new XoopsFormHidden("pl_date", $pl_date);
	$station_playlist_hidden = new XoopsFormHidden("pl_station", $myts->htmlSpecialChars($myts ->stripSlashesGPC($pl_station)));
	// SELECT PROGRAM TO ADD PLAYLIST TO...
	
	$infoday = new XoopsFormText(_AM_ONAIR_DAY, "pl_day", 75, 75, $myts->htmlSpecialChars($myts ->stripSlashesGPC($pl_day)));
	$playlistform->addElement($infoday);
		
	$infotitle = new XoopsFormText(_AM_ONAIR_TITLE, "pl_title", 75, 75, $myts->htmlSpecialChars($myts ->stripSlashesGPC($pl_title)));
	$playlistform->addElement($infotitle);
	
	$infoname = new XoopsFormText(_AM_ONAIR_NAME, "pl_name", 75, 75, $myts->htmlSpecialChars($myts ->stripSlashesGPC($pl_name)));
	$playlistform->addElement($infoname);
	
	$infostart = new XoopsFormText(_AM_ONAIR_START, "pl_start", 75, 75, $pl_start);
	$playlistform->addElement($infostart);	

	$infostop = new XoopsFormText(_AM_ONAIR_STOP, "pl_stop", 75, 75, $pl_stop);
	$playlistform->addElement($infostop);
	
	$infoimage = new XoopsFormText(_AM_ONAIR_IMAGE, "pl_image", 75, 75, $pl_image);
	$playlistform->addElement($infoimage);
	
	$infostation = new XoopsFormText(_AM_ONAIR_STATION, "pl_station", 75, 75, $myts->htmlSpecialChars($myts ->stripSlashesGPC($pl_station)));
	$playlistform->addElement($infostation);
	
	//SELECT DATE TO SAVE
	$playlistformdate = new XoopsFormTextDateSelect (_AM_ONAIR_DATE, "pl_date", $size=15, date('D.m.y'));
	$playlistform->addElement($playlistformdate);

		// DESCRIPTION / PLAYLIST FOR THE DATED SHOW
		
		$playlistformdescription = 
		new XoopsFormDhtmlTextArea(_AM_ONAIR_DESCRIPTION, 'pl_description', $myts->htmlSpecialChars($myts ->stripSlashesGPC($pl_description)), 10, 50);
        $playlistform->addElement($playlistformdescription);
		
		// SUBMIT BUTTON AND SHOW FORM
		$op_hidden = new XoopsFormHidden("op", "Playlistsave");
        $playlistform->addElement($op_hidden);
        
		
        $playlistform->addElement($id_playlist_hidden);
        $playlistform->addElement($day_playlist_hidden);		
        $playlistform->addElement($image_playlist_hidden);
        $playlistform->addElement($name_playlist_hidden);
        $playlistform->addElement($date_playlist_hidden);			
        $playlistform->addElement($start_playlist_hidden);						
        $playlistform->addElement($stop_playlist_hidden);	
		$playlistform->addElement($title_playlist_hidden);	
		$playlistform->addElement($station_playlist_hidden);		
		$button_tray = new XoopsFormElementTray('' ,'');
		$button_tray->addElement(new XoopsFormButton('', 'Playlistsave',"Submit", 'submit'));
		$playlistform->addElement($button_tray);
		$playlistform->display();
		}

/**
 * Show all playlist in database
 *
 * @param   Place       $In admin Show all playlists
 * @param   integer     $repeat 1
 * @return  Status
 */ 
function onair_PlaylistShow() {
        global $xoopsDB, $myts, $pl_days,$xoopsModuleConfig,$pl_timetype;
        
        xoops_cp_header();
		$myts = MyTextSanitizer::getInstance();
        echo "<table border='0' width='100%' class='outer' align='center'>
        <tr><td class='even'><b>"._AM_ONAIR_DATE."</b></td><td class='even'><b>"
		._AM_ONAIR_TITLE."</b></td><td class='even'><b>"._AM_ONAIR_START."</b></td><td class='even'><b>"
		._AM_ONAIR_STOP."</b></td><td colspan='2' class='even'><center><b>"
		._AM_ONAIR_ACTION."</center></b></td></tr>";


        $result=$xoopsDB->query("SELECT pl_id, pl_day, pl_title, pl_start, pl_stop ,"
		." pl_image, pl_description, pl_date FROM ".$xoopsDB->prefix("oa_playlist")." ORDER BY pl_date,pl_start");
	    while($myrow=$xoopsDB->fetchArray($result)) {
		$pl_id = $myrow['pl_id'];
		$pl_day = $myrow['pl_day'];
		$pl_title = $myts->htmlSpecialChars($myts ->stripSlashesGPC($myrow['pl_title']));
			if ($pl_timetype==0) {
		$pl_start = date("H:i:s",strtotime($myrow['pl_start']));
		$pl_stop = date("H:i:s",strtotime($myrow['pl_stop']));
		} 
		if ($pl_timetype==1) {
		$pl_start = date("h:i:s a",strtotime($myrow['pl_start']));
		$pl_stop = date("h:i:s a",strtotime($myrow['pl_stop']));
		}	

		$pl_image = $myrow['pl_image'];				
		$pl_description = $myts->htmlSpecialChars($myts ->stripSlashesGPC($myrow['pl_description']));		
		$pl_date = $myrow['pl_date'];	
        echo "</td>
		<td class='odd'>$pl_date&nbsp;</td>
		<td class='odd'>$pl_title&nbsp;</td>
		<td class='odd'>$pl_start&nbsp;</td>
		<td class='odd'>$pl_stop&nbsp;</td>
		<td class='odd'><a href='playlist.php?op=Playlistedit&amp;pl_id=$pl_id'>"._AM_ONAIR_EDIT."</a></td>
		<td class='odd'><a href='playlist.php?op=Playlistdel&amp;pl_id=$pl_id'>"._AM_ONAIR_DEL."</a></td>
        </tr>";
        }
        echo "</table>";
        xoops_cp_footer();
}

/**
 * Create playlist with data from choosen event
 *
 * @param   Place       $In admin choose event to make playlist to
 * @param   integer     $repeat 1
 * @return  Status
 */ 
function onair_Playlist($oa_id) {
	global $xoopsModuleConfig,$xoopsModule,$xoopsDB,$pl_timetype,$oa_id,$oa_day,$myts;
	include XOOPS_ROOT_PATH."/class/xoopsformloader.php";
	$oa_id = $_GET['oa_id'];
	$playlistform = new XoopsThemeForm("Playlist", "form", "playlist.php?op=Playlistpost&amp;pl_id=$oa_id"); 
	$myts = MyTextSanitizer::getInstance();
	
	$result=$xoopsDB->query("SELECT oa_id, oa_day, oa_title, oa_name, oa_start, oa_stop, oa_image,oa_station FROM ".$xoopsDB->prefix("oa_program")." WHERE oa_id=".intval($oa_id)."");
	$myts = MyTextSanitizer::getInstance();
	list($oa_id,$oa_day,$oa_title,$oa_name,$oa_start,$oa_stop,$oa_image,$oa_station) = $xoopsDB->fetchRow($result);
     $id_playlist_hidden = new XoopsFormHidden("pl_id", $myts->htmlSpecialChars($myts ->stripSlashesGPC($oa_id)));
	 $day_playlist_hidden = new XoopsFormHidden("pl_day", $oa_day);
	 $image_playlist_hidden = new XoopsFormHidden("pl_image", $oa_image);
	 $name_playlist_hidden = new XoopsFormHidden("pl_name", $myts->htmlSpecialChars($myts ->stripSlashesGPC($oa_name)));
	 $start_playlist_hidden = new XoopsFormHidden("pl_start", $oa_start);
	 $stop_playlist_hidden = new XoopsFormHidden("pl_stop", $oa_stop);
	 $title_playlist_hidden = new XoopsFormHidden("pl_title", $myts->htmlSpecialChars($myts ->stripSlashesGPC($oa_title)));
	 $station_playlist_hidden = new XoopsFormHidden("pl_station", $myts->htmlSpecialChars($myts ->stripSlashesGPC($oa_station)));

	// SELECT PROGRAM TO ADD PLAYLIST TO...
	
	$infoday = new XoopsFormText(_AM_ONAIR_DAY, "pl_day", 75, 75, $myts->htmlSpecialChars($myts ->stripSlashesGPC($oa_day)));
	$playlistform->addElement($infoday);
		
	$infotitle = new XoopsFormText(_AM_ONAIR_TITLE, "pl_title", 75, 75, $myts->htmlSpecialChars($myts ->stripSlashesGPC($oa_title)));
	$playlistform->addElement($infotitle);
	
	$infoname = new XoopsFormText(_AM_ONAIR_NAME, "pl_name", 75, 75, $myts->htmlSpecialChars($myts ->stripSlashesGPC($oa_name)));
	$playlistform->addElement($infoname);
	
	$infostart = new XoopsFormText(_AM_ONAIR_START, "pl_start", 75, 75, $oa_start);
	$playlistform->addElement($infostart);	

	$infostop = new XoopsFormText(_AM_ONAIR_STOP, "pl_stop", 75, 75, $oa_stop);
	$playlistform->addElement($infostop);
	
	$infostation = new XoopsFormText(_AM_ONAIR_STATION, "pl_station", 75, 75, $myts->htmlSpecialChars($myts ->stripSlashesGPC($oa_station)));
	$playlistform->addElement($infostation);
	
	//SELECT DATE TO SAVE
	$playlistformdate = new XoopsFormTextDateSelect (_AM_ONAIR_DATE, "pl_date", $size=15, date('D.m.y'));
	$playlistform->addElement($playlistformdate);

		// DESCRIPTION / PLAYLIST FOR THE DATED SHOW
		$pl_description='';
		
		$playlistformdescription = 
		new XoopsFormDhtmlTextArea(_AM_ONAIR_DESCRIPTION, 'pl_description', $myts->htmlSpecialChars($myts ->stripSlashesGPC($pl_description)), 10, 50);
        $playlistform->addElement($playlistformdescription);
		
		// SUBMIT BUTTON AND SHOW FORM
		$op_hidden = new XoopsFormHidden("op", "Playlistpost");
        $playlistform->addElement($op_hidden);
        
		
        $playlistform->addElement($id_playlist_hidden);
        $playlistform->addElement($day_playlist_hidden);		
        $playlistform->addElement($image_playlist_hidden);
        $playlistform->addElement($name_playlist_hidden);
        $playlistform->addElement($name_playlist_hidden);			
        $playlistform->addElement($start_playlist_hidden);						
        $playlistform->addElement($stop_playlist_hidden);	
		$playlistform->addElement($title_playlist_hidden);	
		$playlistform->addElement($station_playlist_hidden);
		$button_tray = new XoopsFormElementTray('' ,'');
		$button_tray->addElement(new XoopsFormButton('', 'Playlistpost',"Submit", 'submit'));
		$playlistform->addElement($button_tray);
		$playlistform->display();
		}
	// end up using the function selector
		if(!isset($_POST['op'])) {
		$op = isset($_GET['op']) ? $_GET['op'] : 'Playlistchoice';
			} else { 
			$op = $_POST['op']; 
			}
			
		// Switch for choises
		global $op;
		$pl_id = intval($pl_id);
		$oa_id = intval($oa_id);
	switch($op) {
        case "Playlistsave":
                onair_PlaylistSave();
                break;
        case "Playlistedit":
                xoops_cp_header();
				onair_PlaylistEdit($_GET["pl_id"]);
				xoops_cp_footer();
                break;
        case "Playlistdel":
                onair_PlaylistDel();
                break;
        case "Playlistshow":
                onair_PlaylistShow();
                break;        
		case "Playlist":
				xoops_cp_header();
				onair_Playlist($_GET["oa_id"]);
				xoops_cp_footer();
				break;		
		case "Playlistpost":
		global $myts,$xoopsDB;
	$myts = MyTextSanitizer::getInstance();
		$pl_id	= $myts->htmlSpecialChars($_POST["pl_id"]);
		$pl_day	= $myts->htmlSpecialChars($_POST["pl_day"]);
        $pl_date = $myts->htmlSpecialChars($_POST["pl_date"]);
		$pl_title = $myts->htmlSpecialChars($_POST["pl_title"]);
		$pl_name = $myts->htmlSpecialChars($_POST["pl_name"]);
		$pl_image = $myts->htmlSpecialChars($_POST["pl_image"]);
		$pl_start = $myts->htmlSpecialChars($_POST["pl_start"]);
		$pl_stop = $myts->htmlSpecialChars($_POST["pl_stop"]);				
		$pl_description = $myts->htmlSpecialChars($_POST["pl_description"]);
		$pl_station = $myts->htmlSpecialChars($_POST["pl_station"]);		
		             
        $sqlinsert="INSERT INTO ".$xoopsDB->prefix("oa_playlist")." (pl_id, pl_day, pl_title, pl_date, pl_start, pl_stop,pl_description, pl_image, pl_name, pl_station) VALUES ('', ".$xoopsDB->quoteString($pl_day).", ".$xoopsDB->quoteString($pl_title).", ".$xoopsDB->quoteString($pl_date).", ".$xoopsDB->quoteString($pl_start).", ".$xoopsDB->quoteString($pl_stop).", ".$xoopsDB->quoteString($pl_description).", ".$xoopsDB->quoteString($pl_image).", ".$xoopsDB->quoteString($pl_name).", ".$xoopsDB->quoteString($pl_station).")";

                if (!$result = $xoopsDB->query($sqlinsert)) {
				redirect_header("index.php",2,_AM_ONAIR_ERRORINSERT);
                }				
				redirect_header("index.php",2,_AM_ONAIR_THANKS);
				
break; 
case "Playlistchoice": 
default:
                onair_PlaylistChoice();
                break;						
} 
	 ?>
