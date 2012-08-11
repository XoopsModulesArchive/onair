<?php
//%%%%%%	Config etc	%%%%%
define("_AM_ONAIR_CONFIG","Configure");
define("_AM_ONAIR_EDIT","Edit");
define("_AM_ONAIR_EVENTDEL","Event deleted");
define("_AM_ONAIR_EVENTMOD","Event modified");

//%%%%%%	Tables, titles, posts	%%%%%
define("_AM_ONAIR_DAY","Day");
define("_AM_ONAIR_START","Start");
define("_AM_ONAIR_STOP","Stop");
define("_AM_ONAIR_STATION","Station name");
define("_AM_ONAIR_ACTION","Action");
define("_AM_ONAIR_NAME","Name of host");
define("_AM_ONAIR_IMAGE","Picture");
define("_AM_ONAIR_DESCRIPTION","Description of show");
define("_AM_ONAIR_TITLE","Title of show");
define("_AM_ONAIR_MESSAGE","Event:");
define("_AM_ONAIR_IMAGE_SELECTFORMAT","Select Image format");
define("_AM_ONAIR_DEL","Delete");
define("_AM_ONAIR_APPROVE2","Approve event?");
define("_AM_ONAIR_SUBMIT","Submit");
define("_AM_ONAIR_SUREDELETE","Delete this Event?");
define("_AM_ONAIR_EDITENTRY","Edit this schedule");
define("_AM_ONAIR_EVENTAPPROVE","Event had been approved");
define("_AM_ONAIR_ENTRY","Enter new event");
define("_AM_ONAIR_NODESCRIPTION","No description for this event.");

//added 1.04
define("_AM_ONAIR_SONGSHOWALL","Show all songs");
define("_AM_ONAIR_SONGDEL","Song is deleted");
define("_AM_ONAIR_SONGMOD","Song has been modified");
define("_AM_ONAIR_SONG","Artist - Title");
define("_AM_ONAIR_SONGID","Song id: ");
define("_AM_ONAIR_SONGTITLE","Song title");
define("_AM_ONAIR_SONGDATETIME","Date/time played");

//Added 1.05
define("_AM_ONAIR_UPLOADSONGS","Upload song data");
define("_AM_ONAIR_UPLOADSONGSDESC","Choose here the format of your player log file. (DireTTore or Playtime_Winamp_Plugin).<br /><br />Check the content the file if you need to make a custom file.<br><br>The songs will then be put each and independently into a table with date, start time, week number, Artist - title, and year, and will be used to make a chart / Hitlist of your most played music.<br>");

//%%%%%%	Days	%%%%%
define("_AM_ONAIR_SUNDAYNAME","Sunday");
define("_AM_ONAIR_MONDAYNAME","Monday");
define("_AM_ONAIR_TUEDAYNAME","Tuesday");
define("_AM_ONAIR_WEDDAYNAME","Wednesday");
define("_AM_ONAIR_THUDAYNAME","Thursday");
define("_AM_ONAIR_FRIDAYNAME","Friday");
define("_AM_ONAIR_SATDAYNAME","Saturday");
$oa_days = array( 
            0 => 'Sunday', 1 => 'monday', 
			2 => 'tuesday', 3 => 'wednesday',
			4 => 'thursday', 5 => 'friday',
            6 => 'saturday', 7 => 'sunday', 
            );
			
//%%%%%%	Images etc	%%%%%
define("_AM_IMAGEUPLOAD_","Upload new image");
define("_AM_SELECT_IMAGE","Select picture");
define("_AM_ONAIR_PROGRAM_EDIT","Edit event");
define("_AM_ONAIR_ADDNEW","Add new event");
define("_AM_ONAIR_UPLOADSUCCESS","<h4>File uploaded successfully!</h4>");
define("AM_ONAIR_SAVEDAS","Saved as: ");
define("_AM_ONAIR_FULLPATH","Full path: ");
define("_AM_ONAIR_ADDIMAGE","Opload New Image");
define("_AM_ONAIR_GOING2UPLOADFORM","Getting Uploadform <br> Please Wait....");

//%%%%%%	Plugins	%%%%%
define("_AM_ONAIR_PLUGINSELECT","Select (Now playing track) plugin to use");
define("_AM_ONAIR_PLUGINNONE","-----");
define("_AM_ONAIR_PLUGINDIRETTORE","DireTTore (or txt-fil include)");
define("_AM_ONAIR_PLUGINSP","StationPlaylist");
define("_AM_ONAIR_PLUGINWINAMP","Winamp (now playing 1.4)");

//%%%%%%	Stream file	%%%%%
define("_AM_ONAIR_STREAM","Link to stream (empty is default)");

//%%%%%%	Various messages	%%%%%
define("_AM_ONAIR_ERRORINSERT","Error inserting data");
define("_AM_ONAIR_DATE","Date for show");
define("_AM_ONAIR_PLAYLIST","Tracklist (alternative info etc)");
define("_AM_ONAIR_PLAYLISTSHOWALL","Show playlists");
define("_AM_ONAIR_BACK2INDEX","Back to main index");
define("_AM_ONAIR_MAKEPLAYLIST","Create playlist");
define("_AM_ONAIR_PL","From these data");
define("_AM_ONAIR_ADDPLAYLIST","Create New Playlist");
define("_AM_ONAIR_GOING2PLAYLISTFORM","Getting Playlist Form....");

define("_AM_ONAIR_NAMEMODULE","Onair");
define("_AM_ONAIR_NEWEVENT","You have a new event");
define("_AM_ONAIR_THANKS","Data is saved to database!");
define("_AM_ONAIR_NOTEXISTEVENT","You must attach playlist to existing event!");
define("_AM_ONAIR_SHOWPLAYLISTS","Show all playlists");
define("_AM_ONAIR_HELP","Help");
?>