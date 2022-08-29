<nav class="py-2 bg-orange-gradation border-bottom sticky-top">
    <div class="container d-flex flex-wrap">
        <ul class="nav me-auto">
            <li class="nav-item">
                <a class="nav-link link-white px-2 fs-5 text-white fw-bolder" href="/">
                    <i class="fas fa-utensils text-white me-1"></i>
                    献立セレクター
                </a>
            </li>
        </ul>
        <ul class="nav">
            @guest
            <li class="nav-item">
                <a class="btn btn-success nav-link text-white px-2 me-2" href="{{ route('register') }}">ユーザー登録</a>
            </li>
            <li class="nav-item">
                <a class="btn btn-outline-orange bg-white nav-link link-orange px-2" href="{{ route('login') }}">ログイン</a>
            </li>
            @endguest

            @auth
            <li class="nav-item dropdown">
                <a class="nav-link" type="button" aria-expanded="false" data-bs-toggle="dropdown">
                    <i class="fas fa-utensils fa-2x text-white"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-end mt-0">
                    <a class="dropdown-item small mb-1" href="{{ route('menus.calendar') }}">
                        <i class="far fa-calendar-alt me-1"></i>
                        献立カレンダー
                    </a>
                    <a class="dropdown-item small mb-1" href="{{ route('menus.create') }}">
                        <i class="fas fa-plus me-1"></i>
                        献立登録
                    </a>
                    <a class="dropdown-item small mb-1" href="{{ route('menus.index') }}">
                        <i class="far fa-edit me-1"></i>
                        献立編集
                    </a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" type="button" aria-expanded="false" data-bs-toggle="dropdown">
                    <i class="fas fa-user-circle fa-2x text-white"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-end mt-0">
                    <a class="dropdown-item small mb-1" href="{{ route('home') }}">
                        <i class="fas fa-home me-1"></i>
                        ホーム
                    </a>
                    <a class="dropdown-item small mb-1" href="{{ route('users.edit') }}">
                        <i class="fas fa-user-cog me-1"></i>
                        アカウント設定
                    </a>
                    <button type="submit" class="dropdown-item small mb-1" form="logout-button">
                        <i class="fas fa-sign-out-alt me-1 text-danger"></i>
                        ログアウト
                    </button>
                </div>
            </li>
            <form method="POST" action="{{ route('logout') }}" id="logout-button">
                @csrf
            </form>
            @endauth
        </ul>
    </div>
</nav>
