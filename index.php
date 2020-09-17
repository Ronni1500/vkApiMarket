<?

include 'vendor/autoload.php';

use VK\Client\VKApiClient;
use VK\OAuth\{VKOAuth, VKOAuthDisplay, VKOAuthResponseType};
use VK\OAuth\Scopes\{VKOAuthGroupScope, VKOAuthUserScope};
// session_start();

try {
	$oauth = new VKOAuth();
	$client_id = 7596093;
	$redirect_uri = 'https://oauth.vk.com/'; 
	$display = VKOAuthDisplay::PAGE;
	$scope = array(VKOAuthUserScope::MARKET, VKOAuthUserScope::PHOTOS, VKOAuthUserScope::GROUPS);	
	// $state = '04955f4b04955f4b04955f4bc504e6b7760049504955f4b5bca61521fddf1408db370de';	

	$browser_url = $oauth->getAuthorizeUrl(VKOAuthResponseType::CODE, $client_id, $redirect_uri, $display, $scope, $state);
} catch(Exception $e) {
	echo 'Error 1: ' . $e->getMessage();
}
echo '<a href="https://oauth.vk.com/authorize?client_id=7596093&display=popup&redirect_uri=https://oauth.vk.com/blank.html&scope=market,photos&response_type=token&v=5.52">Токен</a><br>';
echo '<a href="' . $browser_url .'">Получить token</a><br>';
// header('Location:' . $browser_url);

if($_GET['code']){
	$access_token = '09d41aa65f222c8c2cdf5d0bf3d4307646653b90eb4bc28ecb2fd9dfb6d145fbfd930b9f0652d046a04cf';
	$vk = new VKApiClient('5.124');

	// try{
	// 	echo "<pre>";
	// 	print_r($vk->market()->getCategories(
	// 		$access_token,
	// 			array(
	// 				'count' => 100,
	// 				'offset' => 0
	// 			)
	// 		)
	// 	);
	// 	echo "</pre>";
	// } catch (Exception $e) {
	// 	echo $e->getMessage();
	// }
	try {
		$img = $vk->photos()->getMarketUploadServer(
			$access_token,
			array(
				'group_id' => 198706665,
				'main_photo' => 1				
			)
		);
		$seans = curl_init();
		curl_setopt($seans, CURLOPT_URL, $img['upload_url']);
    	// Указываем CURL, что будем отправлять POST запрос
		curl_setopt($seans, CURLOPT_POST, 1);
		curl_setopt($seans, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($seans, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));
		$image_path = dirname(__FILE__).'/test2.jpg';
		$cfile = curl_file_create($image_path,'image/jpeg','test2.jpg');
		curl_setopt($seans, CURLOPT_POSTFIELDS, array('file' => $cfile));
		$vozvrat_res = json_decode(curl_exec($seans), true);
		curl_close($seans);
		try{
			$imgUploaded = $vk->photos()->saveMarketPhoto(
				$access_token,
				array(
					'group_id' => 198706665,
					'photo' => stripslashes($vozvrat_res['photo']),
					'server' => $vozvrat_res['server'],
					'hash' => $vozvrat_res['hash'],
					'crop_data' => $vozvrat_res['crop_data'],
					'crop_hash' => $vozvrat_res['crop_hash']
				)
			);			
		} catch (Exception $e) {
			echo 'Error save photo: ' . $e->getMessage() . "<br>";
		}				
	} catch (Exception $e) {
		echo 'Error Photo: ' . $e->getMessage() . "<br>";
	}

	try {
		$vk->market()->add(
			$access_token,
			array(
				'owner_id' => 198706665,
				'name' => 'test',
				'category_id' => '1',
				'description' => 'description',
				'price' => 120.00,
				'main_photo_id' => 345,
				'photo_ids' => 345,
				'url' => 345,
				'url' => 'test.local',

			)
		);
		
	} catch (Exception $e) {
		echo 'Error: ' . $e->getMessage() . "<br>";
	}
}

