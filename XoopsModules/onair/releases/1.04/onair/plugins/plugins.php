<?php
/**
 * Onair Module
 *
 * Chooses wich kind of plugin is used to display song info in block
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
 * @version      $Id:plugins.php 2009-07-31 13:14 culex $
 * @since         File available since Release 1.0.4
 */
 
if ($myrow["oa_stream"]==''){$oa_streamurl = onair_GetModuleOption('oa_streamlink');}
else if ($myrow["oa_stream"] !='') {$oa_streamurl = $myrow["oa_stream"];}
if ($oa_pluginname=='1') {
// DireTTOre includefile informations
$oa_pluginfile = onair_GetModuleOption('pluginfile_direttore');
$oa_text2utf8 = onair_File_Get_Contents_Utf8($oa_pluginfile);
onair_CheckSong($oa_text2utf8);
$message['pluginshow'] = "<b>"._MB_ONAIR_NOWPLAYING.'</b><br/><a href="'.$oa_streamurl.'" target="_blank">'.$oa_text2utf8.'</a>';
}
if ($oa_pluginname=='2') {
// StationPlaylist .txt-file includefile informations
$oa_pluginfile = onair_GetModuleOption('pluginfile_stationplaylist');
$oa_text2utf8 = onair_File_Get_Contents_Utf8($oa_pluginfile);
onair_CheckSong($oa_text2utf8);
$message['pluginshow'] = "<b>"._MB_ONAIR_NOWPLAYING.'</b><br><a href="'.$oa_streamurl.'" target="_blank">'.$oa_text2utf8.'</a>';
}
if ($oa_pluginname=='3') {
// Winamp Nowplaying 1.4 by Antti Nevala & Lauri Nevala (txt-file includefile informations)
$oa_pluginfile = onair_GetModuleOption('pluginfile_nowplaying');
$oa_text2utf8 = onair_File_Get_Contents_Utf8($oa_pluginfile);
onair_CheckSong($oa_text2utf8);
$message['pluginshow'] = "<b>"._MB_ONAIR_NOWPLAYING.'</b><br><a href="'.$oa_streamurl.'" target="_blank">'.$oa_text2utf8.'</a>';
}
if ($oa_pluginname=='0') {
$message['pluginshow'] = '';
}
?>

