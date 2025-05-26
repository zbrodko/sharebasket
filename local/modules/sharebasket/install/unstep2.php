<?
use \Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
if (!check_bitrix_sessid()) {
    return;
}
if ($errorException = $APPLICATION->getException()) {
    CAdminMessage::showMessage(
        Loc::getMessage('UNINSTALL_FAILED') . ': ' . $errorException->GetString()
    );
} else {
    CAdminMessage::showNote(
        Loc::getMessage('UNINSTALL_SUCCESS')
    );
}
?>
<form action="<?= $APPLICATION->GetCurPage() ?>">
    <input type="hidden" name="lang" value="<?= LANGUAGE_ID ?>">
    <input type="submit" name="" value="<?= Loc::getMessage("MOD_BACK") ?>">
</form>