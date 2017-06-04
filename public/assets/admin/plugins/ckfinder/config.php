<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
date_default_timezone_set('Asia/Saigon');
$time = date('AyAmAd');
$objlogin = (isset($_SESSION[$time])) ? substr($_SESSION[$time], 5, 10) : '';

function CheckAuthentication() {
    //if (isset($_SESSION[$GLOBALS['objlogin']])) {
    return true;
    //} else {
    //   return false;
    //}
}

$config['LicenseName'] = 'bict.vn';
$config['LicenseKey'] = 'BNHY-MFK1-P111-X7B9-MVFK-UL5A-11XH';

//$obj1 = $_SESSION[$objlogin];
//$baseUrl = $obj1['D_DirRoot']; 
//$baseUrl = base64_decode($baseUrl) . '/upload/';
$baseUrl = 'http://localhost:8088/cucxuctien/public/upload/ckfinder/media/';
$baseDir = resolveUrl($baseUrl);

//echo '---'.$baseDir;
$config['Thumbnails'] = Array(
    'url' => $baseUrl . '_thumbs',
    'directory' => $baseDir . '_thumbs',
    'enabled' => true,
    'directAccess' => false,
    'maxWidth' => 300,
    'maxHeight' => 190,
    'bmpSupported' => false,
    'quality' => 80);
$config['Images'] = Array(
    'maxWidth' => 1875,
    'maxHeight' => 1200,
    'quality' => 80);
if (isset($_GET['rt'])) {
    if ($_GET['rt'] == 'service' || $_GET['rt'] == 'news') {
        $config['Thumbnails'] = Array('url' => $baseUrl . '_thumbs', 'directory' => $baseDir . '_thumbs', 'enabled' => true,
            'directAccess' => false, 'maxWidth' => 300, 'maxHeight' => 190, 'bmpSupported' => false, 'quality' => 80);
        $config['Images'] = Array('maxWidth' => 800, 'maxHeight' => 600, 'quality' => 80);
    }
}
/*
  if (isset($_GET['id'])) {
  switch ($_GET['id']) {
  case 'product':
  $config['Thumbnails'] = Array('url' => $baseUrl . '_thumbs', 'directory' => $baseDir . '_thumbs', 'enabled' => true,
  'directAccess' => false, 'maxWidth' => 220, 'maxHeight' => 265, 'bmpSupported' => false, 'quality' => 80);
  $config['Images'] = Array('maxWidth' => 1000, 'maxHeight' => 1029, 'quality' => 80);
  break;
  case 'slider':
  $config['Thumbnails'] = Array('url' => $baseUrl . '_thumbs', 'directory' => $baseDir . '_thumbs', 'enabled' => true,
  'directAccess' => false, 'maxWidth' => 210, 'maxHeight' => 60, 'bmpSupported' => false, 'quality' => 80);
  $config['Images'] = Array('maxWidth' => 800, 'maxHeight' => 340, 'quality' => 80);
  break;
  case 'avatar':
  $config['Thumbnails'] = Array('url' => $baseUrl . '_thumbs', 'directory' => $baseDir . '_thumbs', 'enabled' => true,
  'directAccess' => false, 'maxWidth' => 80, 'maxHeight' => 100, 'bmpSupported' => false, 'quality' => 80);
  $config['Images'] = Array('maxWidth' => 300, 'maxHeight' => 400, 'quality' => 80);
  break;
  case 'ads':
  $config['Thumbnails'] = Array('url' => $baseUrl . '_thumbs', 'directory' => $baseDir . '_thumbs', 'enabled' => true,
  'directAccess' => false, 'maxWidth' => 210, 'maxHeight' => 60, 'bmpSupported' => false, 'quality' => 80);
  $config['Images'] = Array('maxWidth' => 800, 'maxHeight' => 340, 'quality' => 80);
  break;
  default:
  $config['Thumbnails'] = Array('url' => $baseUrl . '_thumbs', 'directory' => $baseDir . '_thumbs', 'enabled' => true,
  'directAccess' => false, 'maxWidth' => 100, 'maxHeight' => 100, 'bmpSupported' => false, 'quality' => 80);
  $config['Images'] = Array('maxWidth' => 1600, 'maxHeight' => 1200, 'quality' => 80);
  break;
  }
  }
 */
$config['RoleSessionVar'] = 'CKFinder_UserRole';

$config['AccessControl'][] = Array(
    'role' => '*',
    'resourceType' => '*',
    'folder' => '/',
    'folderView' => true,
    'folderCreate' => true,
    'folderRename' => true,
    'folderDelete' => true,
    'fileView' => true,
    'fileUpload' => true,
    'fileRename' => true,
    'fileDelete' => true);

$config['DefaultResourceTypes'] = '';
/*
$config['ResourceType'][] = Array(
    'name' => 'Files', // Single quotes not allowed
    'url' => $baseUrl . 'files',
    'directory' => $baseDir . 'files',
    'maxSize' => 0,
    'allowedExtensions' => '7z,aiff,asf,avi,bmp,csv,doc,docx,fla,flv,gif,gz,gzip,jpeg,jpg,mid,mov,mp3,mp4,mpc,mpeg,mpg,ods,odt,pdf,png,ppt,pptx,pxd,qt,ram,rar,rm,rmi,rmvb,rtf,sdc,sitd,swf,sxc,sxw,tar,tgz,tif,tiff,txt,vsd,wav,wma,wmv,xls,xlsx,zip',
    'deniedExtensions' => '');
*/
$config['ResourceType'][] = Array(
    'name' => 'Files',        // Single quotes not allowed
    'url' => $baseUrl . 'files',
    'directory' => $baseDir . 'files',
    'maxSize' => 0,
    'allowedExtensions' => '7z,aiff,asf,avi,bmp,csv,doc,docx,fla,flv,gif,gz,gzip,jpeg,jpg,mid,mov,mp3,mp4,mpc,mpeg,mpg,ods,odt,pdf,png,ppt,pptx,pxd,qt,ram,rar,rm,rmi,rmvb,rtf,sdc,sitd,swf,sxc,sxw,tar,tgz,tif,tiff,txt,vsd,wav,wma,wmv,xls,xlsx,zip',
    'deniedExtensions' => '');

$config['ResourceType'][] = Array(
    'name' => 'Images',
    'url' => $baseUrl . 'images',
    'directory' => $baseDir . 'images',
    'maxSize' => 0,
    'allowedExtensions' => 'bmp,gif,jpeg,jpg,png',
    'deniedExtensions' => '');

$config['ResourceType'][] = Array(
    'name' => 'Flash',
    'url' => $baseUrl . 'flash',
    'directory' => $baseDir . 'flash',
    'maxSize' => 0,
    'allowedExtensions' => 'swf,flv',
    'deniedExtensions' => '');
/*
$config['ResourceType'][] = Array(
    'name' => 'Flash',
    'url' => $baseUrl . 'flash',
    'directory' => $baseDir . 'flash',
    'maxSize' => 0,
    'allowedExtensions' => 'swf,flv',
    'deniedExtensions' => '');
*/
$config['CheckDoubleExtension'] = true;

$config['DisallowUnsafeCharacters'] = false;

$config['FilesystemEncoding'] = 'UTF-8';

$config['SecureImageUploads'] = true;

$config['CheckSizeAfterScaling'] = true;

$config['HtmlExtensions'] = array('html', 'htm', 'xml', 'js');

$config['HideFolders'] = Array(".*", "CVS");

$config['HideFiles'] = Array(".*");

$config['ChmodFiles'] = 0777;

$config['ChmodFolders'] = 0755;

$config['ForceAscii'] = false;

$config['XSendfile'] = false;


include_once "plugins/imageresize/plugin.php";
include_once "plugins/fileeditor/plugin.php";
include_once "plugins/zip/plugin.php";

$config['plugin_imageresize']['smallThumb'] = '90x90';
$config['plugin_imageresize']['mediumThumb'] = '120x120';
$config['plugin_imageresize']['largeThumb'] = '380x380';
$config['plugin_imageresize']['customer'] = '600x400';
