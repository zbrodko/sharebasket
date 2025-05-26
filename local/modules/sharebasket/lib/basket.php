<?

namespace Sharebasket;

use Bitrix\Highloadblock;
use Bitrix\Main\Loader;
use Bitrix\Sale;

class basket{
    
    function __construct(){ 
    }
    
    public static function copyBasket($hlid){
        return self::getHL($hlid);
    }
    
    protected static function getHL($hlid){
        
        Loader::IncludeModule('highloadblock');
        
        $entity = Highloadblock\HighloadBlockTable::compileEntity('ShareBasket'); 
        $entity_data_class = $entity->getDataClass();
        
        $request = $entity_data_class::getList(array(
           "select" => array("*"),
           "order" => array("ID" => "ASC"),
           "filter" => array("ID"=>$hlid) 
        ))->fetch();
        
        return self::toBasket($request['UF_IDS']);
    }
    
    protected static function toBasket($ids) {
        
        Loader::includeModule('sale');
        Loader::includeModule('catalog');
        
        $ids = json_decode($ids);
        
        $basket = \Bitrix\Sale\Basket::LoadItemsForFUser(
        	\Bitrix\Sale\Fuser::getId(),
        	SITE_ID
        );
        
        foreach ($ids as $id){
            $product = array('PRODUCT_ID' => $id, 'QUANTITY' => 1);
            $result = \Bitrix\Catalog\Product\Basket::addProductToBasket($basket, $product, array('SITE_ID' => SITE_ID));
        }
        $basket->save();
        
        return true;
        
    }
}

