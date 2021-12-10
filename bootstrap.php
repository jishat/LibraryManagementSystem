<?php
include_once('vendor/autoload.php');
session_start();

define('DOCROOT', $_SERVER['DOCUMENT_ROOT']);
define('WEBROOT', 'https://librarymanagement.jishat.com/');
define('IMG', 'https://librarymanagement.jishat.com/assets/img/');
define('ASSETS', 'https://librarymanagement.jishat.com/assets/');
define('LAYOUT', DOCROOT.'/layout/');
define('ELEMENT', DOCROOT.'/element/');
define('UPLOADUSER', DOCROOT.'/upload/user/');
define('UPLOADBOOK', DOCROOT.'/upload/book/');
define('UPLOADNEWS', DOCROOT.'/upload/news/');
define('UPLOADNOTICE', DOCROOT.'/upload/notice/');
define('UPLOADUTILITY', DOCROOT.'/upload/utility/');
define('IMAGESUSER', 'https://librarymanagement.jishat.com/upload/user/');
define('IMAGESNEWS', 'https://librarymanagement.jishat.com/upload/news/');
define('IMAGESNOTICE', 'https://librarymanagement.jishat.com/upload/notice/');
define('IMAGESBOOK', 'https://librarymanagement.jishat.com/upload/book/');
define('IMAGESUTILITY', 'https://librarymanagement.jishat.com/upload/utility/');
define('ACTIONFRONT', WEBROOT.'action/');
define('APP', DOCROOT.'/app/');


define('ADMINELEMENT', DOCROOT.'/tjadmin/element/');
define('ADMINVIEW', 'https://librarymanagement.jishat.com/tjadmin/view/');
define('ADMIN', 'https://librarymanagement.jishat.com/tjadmin/');
define('ADMINFOLDER', 'tjadmin');

define('ACTION', WEBROOT.'admin/action/');

// Declare prefix
define('PREFIX', 'tj_');

// spl_autoload_register(function($class){
// 	include_once(APP.$class.".php");
// });

$urlPath = explode("/", dirname($_SERVER['PHP_SELF']));
$urlPath = array_reverse($urlPath);
$basename = basename(parse_url(basename($_SERVER['REQUEST_URI']), PHP_URL_PATH), ".php");
define('DIRECTORY', $urlPath[0]);
define('BASENAME', $basename);

// Building function
function trim_word($string, $max_words) {
   $word_array = explode(' ',$string);
   if(count($word_array) > $max_words && $max_words > 0)
      $string = implode(' ',array_slice($word_array, 0, $max_words)).'...';
   return $string;
}
