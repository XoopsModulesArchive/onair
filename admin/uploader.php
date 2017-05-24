<?php
/**

 * Onair module
 *
 * Form to upload image
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
		
	global $xoopsModule, $xoopsDB, $myts, $imageop, $xoopsModuleConfig;    		
	$myts = MyTextSanitizer::getInstance();
	

	$imageop = 'imageform'; 
	$oa_maxfilesize = onair_GetModuleOption('maxfilesize');
	$oa_width = onair_GetModuleOption('maximumw');
	$oa_height = onair_GetModuleOption('maximh');
	$oa_imgdir = onair_GetModuleOption('imagedir');

/**
 * Show upload form
 *
 * @param   Place       $In admin show upload imageform
 * @param   integer     $repeat 1
 * @return  Status
 */ 
function onair_ImageForm() {

	global $xoopsModuleConfig,$xoopsModule,$oa_maxfilesize;
include XOOPS_ROOT_PATH."/class/xoopsformloader.php";
	$my_form = new XoopsThemeForm("Upload", "form", "uploader.php");
	$my_form->setExtra( "enctype='multipart/form-data'" ) ; 
	$img_box = new XoopsFormFile("Image", "photo", $oa_maxfilesize);
	$img_box->setExtra( "size ='50'") ;
	$my_form->addElement($img_box); 
	$button_tray = new XoopsFormElementTray('' ,'');
	$button_tray->addElement(new XoopsFormButton('', 'imagepost',"Submit", 'submit'));
	$my_form->addElement($button_tray);
	$my_form->display();
	}



	foreach ( $_POST as $k => $v ) { 
	${$k} = $v; 
	}
	if ( isset($imagepost) ) {
	$imageop = 'imagepost';
	}

switch ($imageop) {
case "imagepost": 
	$max_imgsize = $oa_maxfilesize; 
	$max_imgwidth = $oa_width; 
	$max_imgheight = $oa_height; 
	$allowed_mimetypes = array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/x-png','image/jpg');
	$img_dir = XOOPS_ROOT_PATH ."/". $oa_imgdir ;

	include_once(XOOPS_ROOT_PATH."/class/uploader.php");
	$field = $_POST["xoops_upload_file"][0] ; 

	if( !empty( $field ) || $field != "" ) { 


	$uploader = new XoopsMediaUploader($img_dir, $allowed_mimetypes, $max_imgsize, $max_imgwidth, $max_imgheight);
	$uploader->setPrefix( 'img' ) ;
	if( $uploader->fetchMedia( $field ) && $uploader->upload() ) { 
	redirect_header("index.php",5,_AM_ONAIR_UPLOADSUCCESS." <br> ".AM_ONAIR_SAVEDAS. $uploader->getSavedFileName()." <br> "._AM_ONAIR_FULLPATH.$uploader->getSavedDestination());

	} else { 
	redirect_header("index.php",5,"".$uploader->getErrors());
	echo $uploader->getErrors();
	}
	}
break; 

case 'imageform':
default:
	xoops_cp_header();
	onair_ImageForm();
	xoops_cp_footer();
break;
	} 
?>