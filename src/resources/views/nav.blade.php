<nav class="py-2 bg-light border-bottom">
    <div class="container d-flex flex-wrap">
        <ul class="nav me-auto">
            <li class="nav-item">
                <a class="nav-link link-dark px-2 fs-5 text-warning fw-bolder" href="/" style="color: primary;">献立セレクター</a>
            </li>
        </ul>
        <ul class="nav">
            @guest
            <li class="nav-item">
                <a class="btn btn-outline-warning nav-link link-dark px-2 me-2" href="{{ route('register') }}">ユーザー登録</a>
            </li>
            <li class="nav-item">
                <a class="btn btn-warning nav-link link-dark px-2" href="{{ route('login') }}">ログイン</a>
            </li>
            @endguest

            @auth
            <li class="nav-item">
                <a class="btn btn-outline-warning nav-link link-dark px-2 me-2" href="{{ route('users.show') }}">マイページ</a>
            </li>
            <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-warning nav-link link-dark px-2">ログアウト</button>
                </form>
            </li>
            @endauth
        </ul>
    </div>
</nav>
