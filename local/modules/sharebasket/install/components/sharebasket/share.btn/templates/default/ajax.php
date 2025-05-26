<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");


use Bitrix\Sale;
use Bitrix\Main\Loader; 
use Bitrix\Highloadblock;

Loader::includeModule("sale");
Loader::IncludeModule('highloadblock');

function createShortUrl($hlId) {
    $url = 'http://'.$_SERVER['SERVER_NAME'].'/share/?hl='.$hlId;
    $show = false;
    $rsData = CBXShortUri::GetList(Array(),Array());
    while($arRes = $rsData->Fetch()) {
      if ($arRes["URI"] == $url){
        $str_SHORT_URI = $arRes["SHORT_URI"];
        $show = true;
      }
    }
    if ($show) {
      return 'http://'.$_SERVER['SERVER_NAME'].'/'.$str_SHORT_URI;
    } else {
      $str_SHORT_URI = CBXShortUri::GenerateShortUri();
      $arFields = [
        "URI" => $url,
        "SHORT_URI" => $str_SHORT_URI,
        "STATUS" => "301",
      ];
      $ID = CBXShortUri::Add($arFields);
      return 'http://'.$_SERVER['SERVER_NAME'].'/'.$str_SHORT_URI;
    }
}

function getBasket() {
    $userID = Sale\Fuser::getId();
    $basket = Sale\Basket::loadItemsForFUser($userID, 's1');
    foreach ($basket as $item) {
         $ids[] = $item->getProductId();
    }
    return saveHL($ids, $userID);
}

function saveHL($ids, $userID) {
    
    $entity = Highloadblock\HighloadBlockTable::compileEntity('ShareBasket'); 
    $entity_data_class = $entity->getDataClass();     
    
    $request = $entity_data_class::getList(array(
       "select" => array("*"),
       "order" => array("ID" => "ASC"),
       "filter" => array("UF_USER_ID"=>$userID) 
    ))->fetch();
    
    if($request){
        $data = array(
            "UF_IDS" => json_encode($ids),
            "UF_USER_ID" => $userID, 
        );
        $entity_data_class::update($request['ID'], $data);
        $hlId = $request['ID'];
    } else {
        $data = array(
            "UF_IDS" => json_encode($ids),
            "UF_USER_ID" => $userID, 
        );
    
        $result = $entity_data_class::add($data);
        $hlId = $result->getId();
    }
    
    return createShortUrl($hlId); 
}

$res = getBasket();

echo json_encode($res);