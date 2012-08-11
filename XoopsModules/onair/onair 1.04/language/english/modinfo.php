<?php
//%%%%%%	Names, titles	%%%%%
define("_MI_ONAIR_MODULE_NAME","Culex Onair rotator");
define("_MI_ONAIR_HELP","Help");

// A brief description of this module
define("_MI_ONAIR_MODULE_DESC","Set up your on-air script with this module to display who is on now with time, station picture etc");

//%%%%%%	Configs		%%%%%
define("_MI_ONAIR_PLAYLISTMENU","See playlists");
define("_MI_ONAIR_TIMETYPE","Time type - use 12 hours ? (no = 24 hours)");
define("_MI_ONAIR_TIMEZONE","Choose timezone default is +0");
define("_MI_ONAIR_MAXFILESIZE","Max. size of oploaded file in bytes");
define("_MI_ONAIR_SHOTDIR","Where is shots placed");
define("_MI_ONAIR_IMGDIR","Where are images placed");
define("_MI_ONAIR_IMGHEIGHT","Max. Height of pictures");
define("_MI_ONAIR_IMGWIDTH","Max. width of pictures");
define("_MI_ONAIR_SHOTHEIGHT","Height of shots");
define("_MI_ONAIR_SHOTWIDTH","Width of shots");
define("_MI_ONAIR_TIMETYPE","Choose timetype Eu (24 hours) or US (12 hours): ");
define("_MI_ONAIR_ALLOWHTML","Allow HTML?");
define("_MI_ONAIR_PROGRAM_EDIT","Show/Edit/Delete/Approve");
define("_MI_ONAIR_ADDNEW","New Event");
define("_MI_ONAIR_ADDIMAGE","Upload Image");
define("_MI_ONAIR_CONFIG","Settings");

//%%%%%%	Plugins	%%%%%
define("_MI_ONAIR_PLUGINDIR_DIRETTORE_DESC","Url for DireTTore - or another program that uploads 
<br>as <i>Artist - title</i> to a simple .txt file.");
define("_MI_ONAIR_PLUGINDIR_DIRETTORE","Url track-info file (txt format).");
define("_MI_ONAIR_PLUGINDIR_SP","Url of .txt-file generated by Station Playlist.");
define("_MI_ONAIR_PLUGINDIR_SP_DESC","The file must be in txt-format and located somewhere on your server.<br> If you like you can also show info from another server, but keep it simple<br> only 1 - 2 lines of text otherwise this will be too much info for the block,<br> and the block will be too crowded with text.");
define("_MI_ONAIR_PLUGINDIR_WINAMP","Now Playing 1.4 by Antti Nevala & Lauri Nevala Track info fil (txt format)");
define("_MI_ONAIR_PLUGINDIR_WINAMP_DSC","Url on the .txt-file generated by Now Playing.");

//%%%%%%	Stream	%%%%%
define("_MI_ONAIR_STREAM","Link for 'playing now' (m3u file, live stream or net radio link.)<br> Must be an absolute path like (http://www.mysite.com/stream.wma) or similar.");
define("_MI_ONAIR_STREAM_DESC","This is ment as a url for the stream of internet radios, wma,m3u,asx, <br>but can actually also be a link for a chart on the net, a movie trailer ...whatever you like.");
?>