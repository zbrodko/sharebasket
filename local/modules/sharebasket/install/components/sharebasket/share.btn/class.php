<?php
use \Bitrix\Main\Loader;
use \Bitrix\Main\Application;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

class SharePopUp extends CBitrixComponent {
    
    public function executeComponent() {
        // что-то делаем и результаты работы помещаем в arResult, для передачи в шаблон
        $this->arResult['SOME_VAR'] = 'some result data for template';

        $this->includeComponentTemplate();
    }
}