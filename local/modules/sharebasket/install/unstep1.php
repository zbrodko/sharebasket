<?
use \Bitrix\Main\Localization\Loc;

if (!check_bitrix_sessid()){
    return;
} 
IncludeModuleLangFile(__FILE__);

foreach(GetModuleEvents('iblock', 'OnModuleUnInstall', true) as $arEvent)
	ExecuteModuleEventEx($arEvent);
?>

<form action="<?= $APPLICATION->GetCurPage() ?>">
    <?= bitrix_sessid_post() ?>
    <input type="hidden" name="lang" value="<?= LANG ?>">
    <input type="hidden" name="id" value="sharebasket">
    <input type="hidden" name="uninstall" value="Y">
    <input type="hidden" name="step" value="2">
    <?= CAdminMessage::ShowMessage(Loc::getMessage("MOD_UNINST_WARN")) ?>
    <p><?= Loc::getMessage("MOD_UNINST_SAVE") ?></p>
    <p><input type="checkbox" name="save_data" id="save_data" value="Y" checked><label for="save_data"><?= Loc::getMessage("MOD_UNINST_SAVE_TABLES") ?></label></p>
    <input type="submit" name="" value="<?= Loc::getMessage("MOD_UNINST_DEL") ?>">
</form>
