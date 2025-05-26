<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

//$this->setFrameMode(true);
//$this->addExternalCss("/bitrix/css/main/bootstrap.css");
?>

<button type="button" onclick="getShortUrl()" class="btn btn-primary share-btn" data-toggle="modal" data-target="#Modal">
  Поделиться корзиной
</button>

<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalLabel">Поделиться корзиной</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Скопируйте ссылку, чтобы поделиться корзиной. При открытии ссылки другим пользователем, товары из вашей корзины будут добавлены в его корзину.
      </div>
      <div class="modal-footer flex-nowrap">
        <input class="form-control" type="text" id="short-url" placeholder="Короткая ссылка" readonly>
        <button type="button" onclick="copyURL()" data-dismiss="modal" class="btn btn-primary">Скопировать</button>
      </div>
    </div>
  </div>
</div>