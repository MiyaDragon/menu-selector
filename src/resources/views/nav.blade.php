<nav class="navbar navbar-expand navbar-dark bg-primary">

    <a class="navbar-brand" href="/">献立セレクター</a>

    <ul class="navbar-nav ml-auto">

        @guest
        <li class="nav-item">
            <a class="nav-link" href="{{ route('register') }}">ユーザー登録</a>
        </li>
        @endguest

        @guest
        <li class="nav-item">
            <a class="nav-link" href="{{ route('login') }}">ログイン</a>
        </li>
        @endguest

        @auth
        <li class="nav-item">
            <a class="nav-link" href="">マイページ</a>
        </li>
        @endauth

        @auth
        <li class="nav-item">
            <form method="POST" action="{{ route('logiout') }}">
                @csrf
                <button class="nav-link" type="submit">ログアウト</button>
            </form>
        </li>
        @endauth

    </ul>

</nav>
