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
	// $state = '123456';	

	$browser_url = $oauth->getAuthorizeUrl(VKOAuthResponseType::CODE, $client_id, $redirect_uri, $display, $scope, $state);
} catch(Exception $e) {
	echo 'Error 1: ' . $e->getMessage();
}
echo '<a href="https://oauth.vk.com/authorize?client_id=7596093&display=popup&redirect_uri=https://oauth.vk.com/blank.html&scope=market,photos&response_type=token&v=5.52">Токен</a><br>';
echo '<a href="' . $browser_url .'">Получить token</a><br>';
// header('Location:' . $browser_url);

if($_GET['code']){
	$access_token = '2b1192994d3960e750bd47dbcb02e178d06cd1ad686e42f88d2b980447ae0ec85e93689831f1037bf1cf0';
	$vk = new VKApiClient('5.101');

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
		$cfile = curl_file_create($image_path,'image/jpeg','test223.jpg');
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
			// echo "<pre>";
			// print_r($imgUploaded);
			// echo "</pre>";
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
				'owner_id' => -198706665,
				'name' => 'test',
				'category_id' => '1',
				'description' => 'description',
				'price' => 120.00,
				'main_photo_id' => $imgUploaded[0]['id'],
				'url' => 345,
				'url' => 'test.local',

			)
		);
		
	} catch (Exception $e) {
		echo 'Error: ' . $e->getMessage() . "<br>";
	}
}

