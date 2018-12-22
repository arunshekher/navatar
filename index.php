<?php
if ( ! defined('e107_INIT')) {
	//define('e_MINIMAL',true);
	require_once __DIR__ . '/../../class2.php';
}
//require_once __DIR__ . '/navatar.autoload.php';
$loader = require __DIR__ . '/vendor/autoload.php';
$loader->addPsr4('Navatar\\Plugin\\', __DIR__);

use LasseRafn\InitialAvatarGenerator\InitialAvatar;
use Navatar\Plugin\Navatar;


//$front = eFront::instance();
//$request = new eRequest;
//$front->getRequest();


//$front = eFront::instance();
//if(null === $front->getRequest())
//{
//	// init
//	$request = new eRequest();
//	$front->setRequest($request);
//
//	$dispatcher = new eDispatcher();
//	$front->setDispatcher($dispatcher);
//
//	$router = new eRouter();
//	$front->setRouter($router);
//
//	$response = new eResponse();
//	$front->setResponse($response);
//
//}
//
//
//Navatar::log($front->getRouter());


Navatar::log('index-loaded', 'from-index');

// if (strtolower($_SERVER['REQUEST_METHOD']) === 'get' ) {
	
// 	$navatar = new InitialAvatar();

// 	$image = $navatar->name('Arun Sekher')->size(250)->generate();
// 	//$image->stream('png', 100);
// 	header('Content-type: image/jpeg');
// 	echo $image->stream('png', 100);
// 	die;
// }



// echo '<img src="'.$_SERVER['PHP_SELF'].'?img=show" width="48" height="48" style="border-radius: 100%" />';
$path = realpath(__DIR__ . '/test.jpg');

$avatar = new InitialAvatar();

//$image = $avatar->name('Arun Sekher')->length(2)->fontSize(0.8)->size(250)->background('#85b58f')->color('#fff')->save($path, 100);
$image = $avatar->name('Arun Sekher')->length(2)->fontSize(0.6)->size(250)->background('#85b58f')->color('#fff')->generate()->save(e_AVATAR_UPLOAD.'navatar.png', 100);

//echo base64_encode($image->stream('jpg', 100));

// header('Content-type: image/jpeg');
// echo $image->stream('jpg', 100);
// die;

//$opts = array('overwrite' => TRUE, 'file_mask'=>'jpg,png,gif,jpeg', 'max_file_count' => 2);
//$uploaded = e107::getFile()->getUploaded(e_AVATAR_UPLOAD, 'prefix+ap_'.$tp->leadingZeros($udata['user_id'],7).'_', $opts);

//echo $tp->leadingZeros(1,7);