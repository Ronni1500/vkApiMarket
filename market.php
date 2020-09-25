<?
include 'vendor/autoload.php';

use Asil\VkMarket\VkConnect;
use Asil\VkMarket\VkServiceDispatcher;
use Asil\VkMarket\Model\Photo;
use Asil\VkMarket\Model\Product;
  
$accessToken = '2b1192994d3960e750bd47dbcb02e178d06cd1ad686e42f88d2b980447ae0ec85e93689831f1037bf1cf0';
$ownerId = 7607859; // идентификатор владельца группы
$groupId = 198706665; // идентификатор группы
  
$connect = new VkConnect($accessToken, $groupId, $ownerId);
$vkService = new VkServiceDispatcher($connect);



  
$product = new Product('Товар 1', 'Описание товара...', 3, 212);
$photo = new Photo();
  
$photo->createMainPhoto('test2.jpg');


echo "<pre>";
print_r($photo);
echo "</pre>";
  
try{

} catch (Exception $e) {
    echo $e->getMessage();
}
$vkService->addProduct($product, $photo);

//https://oauth.vk.com/authorize?client_id=7607859&display=page&redirect_uri=https://oauth.vk.com/blank.html&scope=market,photos&response_type=token&v=5.52


