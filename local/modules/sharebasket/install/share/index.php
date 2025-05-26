<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Application; 
use Bitrix\Main\Context;

if(CModule::IncludeModule('sharebasket')){
    
    $request = Context::getCurrent()->getRequest();
    $hlid = $request["hl"];
    if($hlid) {
        $res = Sharebasket\Basket::copyBasket($hlid);
        // Если ответ пришел успешно то делаем редирект на корзину 
        if($res){
            LocalRedirect("/");
        }
       
    } else {
        LocalRedirect("/");
    }
} 
