<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/sanitize.css')}}">
    @yield('title')
    @yield('css')
</head>
<body>
    <header class="bg-dark text-white py-2">
        <div class="container">
            <div class="d-flex justify-content-between  flex-wrap my-2 gap-3">
                
                <div class="d-flex align-items-center">
                    {{--<img class="logo" src="{{ asset('images/logo.svg') }}" alt="COACHTECH">--}}
                </div>
            
                @if (!Request::is(['register', 'login']))
                    <form class="d-flex w-50 flex-grow-1">
                        <input class="form-control mx-2" type="search" placeholder="なにをお探しですか？">
                    </form>
                        @if(Auth::check())
                            <form action="/logout" method="post" class="d-flex align-items-center">
                                @csrf
                                <button class="btn btn-secondary me-2">ログアウト</button>
                            </form>
                        @else
                            <a class="btn btn-secondary me-2" href="/login">ログイン</a>
                        @endif
                        <a class="btn btn-secondary me-2" href="/mypage">マイページ</a>
                        <a class="btn btn-secondary" href="/sell">出品</a>
                @endif
            </div>
        </div>
    </header>
    <main>
        @yield('content')
    </main>
</body>

</html>
