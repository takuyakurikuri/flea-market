@component('mail::message')
# 取引完了のお知らせ

{{ $purchase->user->name }}さんが商品「{{ $purchase->item->name }}」の取引を完了しました。

下記よりチャット画面をご確認いただけます。

@component('mail::button', ['url' => route('chat.show', ['purchase' => $purchase])])
チャット画面を開く
@endcomponent

今後ともよろしくお願いいたします。

@endcomponent
