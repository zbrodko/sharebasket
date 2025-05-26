<?

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\Application;
use \Bitrix\Main\Loader;

Loc::loadMessages(__FILE__);
class sharebasket extends CModule {
    
    public  $MODULE_ID;
    public  $MODULE_VERSION;
    public  $MODULE_VERSION_DATE;
    public  $MODULE_NAME;
    public  $MODULE_DESCRIPTION;
    public  $HL_NAME;
    public  $HL_TABLE_NAME;
    public  $PARTNER_NAME;
    public  $PARTNER_URI;
    public  $SHOW_SUPER_ADMIN_GROUP_RIGHTS;
    public  $MODULE_GROUP_RIGHTS;
    public  $errors;
    
    function __construct(){
        $arModuleVersion = array();
        include_once(__DIR__ . '/version.php');
        $this->MODULE_VERSION = $arModuleVersion['VERSION'];
        $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        $this->MODULE_ID = 'sharebasket';
        $this->MODULE_NAME = 'Поделиться корзиной';
        $this->MODULE_DESCRIPTION = 'Модуль позволяющий делиться корзиной с другими пользователями';
        $this->HL_NAME = 'ShareBasket';
        $this->HL_TABLE_NAME = 'sharebasket';
        $this->PARTNER_NAME = 'Збродько Сергей';
        $this->PARTNER_URI = 'https://vk.com/zbrodko';
        $this->SHOW_SUPER_ADMIN_GROUP_RIGHTS = 'Y';
        $this->MODULE_GROUP_RIGHTS = 'Y';
    }
    
    function DoInstall(){
        
        
        $this->InstallHL();
        $this->InstallFiles();
        
        ModuleManager::RegisterModule($this->MODULE_ID);
        
        return true;
    }
    
    function DoUninstall(){
        
        $context = Application::getInstance()->getContext();
        $request = $context->getRequest();
        global $APPLICATION;
        
        if ($request["step"] < 2) {
            $APPLICATION->IncludeAdminFile(
                Loc::getMessage('MOD_UNINST_DEL'),
                __DIR__ . '/unstep1.php'
            );
        }
        
        if ($request["step"] == 2) {
            if ($request["save_data"] != "Y") {
                $this->UnInstallHL();
            }
            $this->UnInstallFiles();
            ModuleManager::UnRegisterModule($this->MODULE_ID);
            $APPLICATION->IncludeAdminFile(
                Loc::getMessage('MOD_UNINST_DEL'),
                __DIR__ . '/unstep2.php'
            );
        }
        
        return true;
    }
    
    function InstallHL(){
        Loader::IncludeModule('highloadblock');
    	$data = array(
    		'NAME' => $this->HL_NAME,
    		'TABLE_NAME' => $this->HL_TABLE_NAME
    	);         
        $result = \Bitrix\Highloadblock\HighloadBlockTable::add($data);
        if ($result->isSuccess()) {
            $hlId = $result->getId();
            $this->addData($hlId);
        }
    }
    
    function UnInstallHL(){
        Loader::IncludeModule('highloadblock');
        $result = \Bitrix\Highloadblock\HighloadBlockTable::getList(array('filter'=>array('=NAME'=>$this->HL_NAME)));
        if($row = $result->fetch()){
            \Bitrix\Highloadblock\HighloadBlockTable::delete($row['ID']);
        }
    }
    
    function InstallFiles(){
        
        CopyDirFiles(
            __DIR__ . '/components',
            $_SERVER['DOCUMENT_ROOT'] . '/local/components',
            true,
            true 
        );
        CopyDirFiles(
            __DIR__ . '/files',
            $_SERVER['DOCUMENT_ROOT'] . '/',
            true, 
            true  
        );
        return true;
    }
    function UnInstallFiles(){
        if (is_dir($_SERVER['DOCUMENT_ROOT'] . '/local/components/' . $this->MODULE_ID)) {
            DeleteDirFilesEx(
                '/local/components/' . $this->MODULE_ID
            );
        }
        DeleteDirFiles(
            __DIR__ . '/files',
            $_SERVER['DOCUMENT_ROOT'] . '/'
        );
        return true;
    }
    
    function addData($hlId){
        
        $fields = [
            [
                'USER_TYPE_ID' => 'string',
                'FIELD_NAME' => 'UF_USER_ID',
            ],
            [
                'USER_TYPE_ID' => 'string',
                'FIELD_NAME' => 'UF_IDS',
            ]
        ];
        
        foreach ($fields as $field) {
            $field['ENTITY_ID'] = 'HLBLOCK_'.$hlId;
            $obUserTypeEntity = new CUserTypeEntity();
            $fieldID = $obUserTypeEntity->Add($field);
        }
        return true;
    }
    
}