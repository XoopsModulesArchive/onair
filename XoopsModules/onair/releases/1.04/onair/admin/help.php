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
 * @version      $Id:help.php 4.33 2009-06-07 15:12 culex $
 * @since         File available since Release 1.0.0
 */
 
  include_once 'admin_header.php';
		include_once XOOPS_ROOT_PATH.'/class/xoopslists.php';
		include XOOPS_ROOT_PATH.'/class/xoopsformloader.php';
		include XOOPS_ROOT_PATH.'/include/xoopscodes.php';
		include '../include/functions.php';
		include '../include/classes.php';
		xoops_cp_header();
echo "<p>Culex On-air was originally build as a radio related script to run a rotator showing who is currently on-air, the radio staions name, the title of the show, when it started, when it will end, show picture of the dj and what song he is currently playing.</p>
<p>Now it has progressed a little to be included in a 2-parted container / scroller showing also the same information about what will come just after current event. Also you can click the front rotators image to move on and see the details of this event in a separate page.</p>
<p>As I was working and rewriting the module from the older version, I descided to include also the ability to add playlists to every independent show, and I hope I acomplished this ok.</p>
<p>Later I discovered this module can be used to many other things, not just radio shows. </p>
<p>It could serve also nicely as a banner rotator with the details shoing more info about the client, or showing movies playing in a theater, concerts currently playing somewhere, maybe event churches could use this to show events cumming up or in progress.... Use as you like actually :)<br />
</p>
<p><strong>Installation</strong><br />
  ------------</p>
<p>1)	upload the onair folder to your XOOPS_ROOT/modules/<br />
  and install as a normal module.</p>
<p>2)	Go to preferences and set up you timeformat (12 hours / 24 hours).<br />
  Dont use both formats. The script gets confused as it only understands ONE time type at the ...well time.<br />
  3) set up the paths for plugins, imagepath, image size etc etc, and your ready to roll.</p>
<p>4) Choose ADD new to fill out infor about your show and choose already uploaded images for the event + plugins<br />
  used by you station. A good idea would be to upload the images first and the Add new.</p>
<p>5) The plugins write songinfo to a small file on your your hp to let you show wich song your playing. <br />
  Default is Now Playing (winamp) and for DireTTore </p>
  <br><br>
  <strong><u>Setup : RDS plug-in (Direttore)</strong></u> <a href='http://www.culex.dk/modules/PDdownloads/visit.php?cid=3&lid=2' target='_blank'>Download here</a><br><br>1) Install using the downloaded file, and run program. The settings are pretty easy to follow. <br>1) Just type in your ftp.<br>2) password to ftp.<br>3) Where do you want txt file to be upload to and name of txt file / Onair default is root <em>(/)</em> and <em>(direttore.txt)</em><br>4) Path to your local folder of DireTTore log files.<br>5) Test and your ready to use.<br><br><center><img src='../images/helpfiles/direttore_01.png' align='center'></img></center>
  <br><br>
  <strong><u>Setup : Now Playing plug-in (winamp)</strong></u> <a href='http://www.culex.dk/modules/PDdownloads/visit.php?cid=3&lid=1' target='_blank'>Download here</a>
  <br><br>
  The installation of this plugin is a little more complex but follow these instructions and<br>you'll have no problems (i hope).<br><br>
  1) Install as normal program on your pc.
  2) Open winamp and choose setting like this<br><br><center><img src='../images/helpfiles/np_00.png'></img></center>
  <br><br>3) Make setting similar to these.:
  <center><br><br><img src='../images/helpfiles/np_01.png'</img><br>
  <br><img src='../images/helpfiles/np_02.png'</img><br>
  <br><img src='../images/helpfiles/np_03.png'</img><br>
  <br><img src='../images/helpfiles/np_04.png'</img><br></center>
  <br>4) Open Now playing html-template on your local installation like this.: <br><br><center><img src='../images/helpfiles/np_05.png'</img></center><br><br>
  <br>Delete all text from the file in your favorite editor and insert this (<em>As shown in the picture</em>:
  <br><br><form >
  <label>
    <input style='background-color:#FF6' value='[np:Artist1] - [np:Title1]' size='26' maxlength='26' />
  </label>
</form><br>The template.html file is usually placed in your <em>c:\Program Files\Winamp\np_templates</em> Folder.<br><br>That's it!<br>Any other question write in my forum <a href='http://www.culex.dk/forum/viewforum.php?forum=1'><strong>here</strong></a><br><br>";
  xoops_cp_footer();
?>