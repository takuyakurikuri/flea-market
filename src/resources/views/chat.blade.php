@extends('layouts.app')

@section('title')
    <title>取引チャット</title>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/chat.css') }}">
@endsection

@section('header-on')
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <aside class="col-12 col-md-3 bg-secondary text-white p-3 sidebar">
            <h5>その他の取引</h5>
            @foreach ($listItems as $listItem)
                @php
                    $relatedPurchase = $listItem->purchases->firstWhere('user_id', $user->id)
                        ?? $listItem->purchases->first();
                @endphp
                <div class="mt-2">
                    <a href="{{ route('chat.show', ['purchase' => $relatedPurchase->id]) }}" class="text-white text-decoration-none">
                        <p class="mb-0">{{ $listItem->name }}</p>
                    </a>
                </div>
            @endforeach
        </aside>

        <main class="col-12 col-md-9 p-3">
            <div class="d-flex justify-content-between mb-4">
                <h4 class="mt-2 fw-bold">「{{ $partner->name }}」さんとの取引</h4>
                @if ($purchase->user_id === Auth::id() && $purchase->status !== 'completed')
                    <form action="{{route('transaction.completed',['purchase' => $purchase])}}" method="post">
                        @csrf
                        @method('patch')
                        <button type="submit" class="btn btn-danger">取引を終了する</button>
                    </form>

                @elseif($purchase->status === 'completed')
                    <p>取引が完了しました</p>
                @endif
            </div>

            <div class="d-flex flex-wrap align-items-center border p-3 mb-4">
                <img src="{{ asset('storage/' . $item->image_path) }}" class="img-thumbnail me-3" alt="{{ $item->name }}" style="max-width: 150px;">
                <div>
                    <h5 class="mb-2">{{ $item->name }}</h5>
                    <p class="text-danger mb-0">￥{{ number_format($item->price) }}（税込）</p>
                </div>
            </div>

            @foreach ($chats as $chat)
                <div class="chat-message mb-4 {{ $chat->user->id === Auth::id() ? 'text-end' : 'text-start' }}">
                    <div class="d-flex {{ $chat->user->id === Auth::id() ? 'flex-row-reverse' : '' }} align-items-center">
                        <img src="{{ asset('storage/' . $chat->user->image_path) }}"
                            alt="画像なし"
                            class="user-icon rounded-circle border me-2"
                            width="50" height="50">
                        <div class="user-name">{{ $chat->user->name }}</div>
                    </div>

                    <div class="d-flex {{ $chat->user->id === Auth::id() ? 'flex-row-reverse' : '' }} mt-1">
                        <div class="message-content">
                            <div class="chat-bubble p-2 rounded {{ $chat->user->id === Auth::id() ? 'text-white bg-success-subtle' : 'bg-light' }}">
                                @if ($chat->user->id === Auth::id())
                                    <p class="text-start text-body mb-0">{{ $chat->message }}</p>
                                    @if ($chat->image_path)
                                        <img src="{{ asset('storage/' . $chat->image_path) }}" class="rounded" alt="{{ $chat->name }}" style="max-width: 200px;">
                                    @endif
                                @else
                                    <p class="mb-0">{{ $chat->message }}</p>
                                    @if ($chat->image_path)
                                        <img src="{{ asset('storage/' . $chat->image_path) }}" class="rounded" alt="{{ $chat->name }}" style="max-width: 200px;">
                                    @endif
                                @endif

                            </div>

                            @if ($chat->user->id === Auth::id())
                                <div class="text-end mt-1">
                                    <form action="{{route('chat.correct',['purchase'=>$purchase,'chat'=>$chat])}}" method="post" class="d-inline">
                                        @csrf
                                        @method('patch')
                                        <button type="button" class="btn btn-sm btn-light"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editChatModal"
                                            data-chat-id="{{ $chat->id }}"
                                            data-message="{{ $chat->message }}"
                                            data-image="{{ $chat->image_path ? asset('storage/' . $chat->image_path) : '' }}"
                                            data-update-url="{{ route('chat.correct', ['purchase' => $purchase, 'chat' => $chat]) }}">
                                            編集
                                        </button>
                                    </form>
                                    <form action="{{route('chat.delete',['purchase'=>$purchase,'chat'=>$chat])}}" method="post" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="chat_id" value="{{ $chat->id }}">
                                        <button type="submit" class="btn btn-sm btn-danger">削除</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach


            @error('message')
                {{$message}}
            @enderror
            @error('image_path')
                {{$message}}
            @enderror

            <form action="{{ route('chat.send', ['purchase' => $purchase]) }}"
                method="post"
                enctype="multipart/form-data"
                class="row gx-2 gy-2 align-items-center mt-4"
                id="chat-form">
                @csrf
                <div class="col-12 col-md">
                    <input type="text" name="message" id="message-input" class="form-control" placeholder="取引メッセージを記入してください">
                </div>
            
                <div class="col-auto">
                    <label for="image_path" class="btn btn-outline-danger nowrap">画像を追加</label>
                    <input type="file" name="image_path" accept="image/*" class="d-none" id="image_path">
                </div>

                <div class="col-auto">
                    <button type="submit" class="btn btn-primary nowrap">送信</button>
                </div>
            </form>
        </main>
    </div>
</div>

<div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('review.store') }}">
            @csrf
            <input type="hidden" name="purchase_id" value="{{ $purchase->id }}">
            <input type="hidden" name="reviewer_id" value="{{ auth()->id() }}">
            <input type="hidden" name="reviewee_id" value="{{ $partner->id }}">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reviewModalLabel">取引が完了しました。</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
                </div>
                <div class="modal-body">
                    <label>今回の取引相手はどうでしたか？</label>
                    <br>
                    <div class="star-rating mb-3">
                        @for ($i = 5; $i >= 1; $i--)
                            <input type="radio" name="rating" id="rating{{ $i }}" value="{{ $i }}" required>
                            <label for="rating{{ $i }}">★</label>
                        @endfor
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">送信する</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="editChatModal" tabindex="-1" aria-labelledby="editChatModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editChatForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('patch')
            <input type="hidden" name="chat_id" id="editChatId">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editChatModalLabel">メッセージを編集</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editMessage" class="form-label">メッセージ</label>
                        <input type="text" name="message" id="editMessage" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="editImage" class="form-label">画像を変更</label>
                        <input type="file" name="image_path" id="editImage" class="form-control">
                        <div class="mt-2">
                            <label for="currentImagePreview">現在の画像</label>
                            <img id="currentImagePreview"
                                src=""
                                alt="現在の画像"
                                style="max-width: 100%;"
                                class="rounded border">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">変更を保存</button>
                </div>
            </div>
        </form>
    </div>
</div>

@if ($shouldShowModal)
    <script>
        window.addEventListener('DOMContentLoaded', function () {
            var reviewModal = new bootstrap.Modal(document.getElementById('reviewModal'));
            reviewModal.show();
        });
    </script>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const editModal = document.getElementById('editChatModal');
        editModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
    
            const chatId = button.getAttribute('data-chat-id');
            const message = button.getAttribute('data-message');
            const image = button.getAttribute('data-image');
            const updateUrl = button.getAttribute('data-update-url');
    
            const form = document.getElementById('editChatForm');
            form.action = updateUrl;
    
            document.getElementById('editChatId').value = chatId;
            document.getElementById('editMessage').value = message;
    
            const preview = document.getElementById('currentImagePreview');
            if (image) {
                preview.src = image;
                preview.style.display = 'block';
            } else {
                preview.style.display = 'none';
            }
        });
    });

    window.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('chat-form');
        const messageInput = document.getElementById('message-input');

        if (!form || !messageInput) return;

        messageInput.addEventListener('input', function () {
            localStorage.setItem('chat_message_draft', this.value);
        });

        const savedMessage = localStorage.getItem('chat_message_draft');
        if (savedMessage !== null) {
            messageInput.value = savedMessage;
        }

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            localStorage.removeItem('chat_message_draft');

            setTimeout(() => {
                form.submit();
            }, 100);
        });
    });

</script>

@endsection