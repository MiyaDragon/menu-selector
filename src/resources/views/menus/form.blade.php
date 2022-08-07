@csrf

<div class="form-group">
    <label for="menu_name">献立名</label>
    <span class="text-danger small">必須</span>
    <p class="text-muted small my-1">30文字以内</p>
    <input type="text" class="form-control @error('menu_name') is-invalid @enderror" id="menu_name" name="menu_name" required value="{{ $menu->name ?? old('menu_name') }}">
    @include('error_input_under', ['name' => 'menu_name'])
</div>

<div class="form-group mt-3">
    <label for="genre_name">ジャンル名</label>
    <span class="text-danger small">必須</span>
    <p class="text-muted small my-1">20文字以内</p>
    <input type="text" class="form-control @error('genre_name') is-invalid @enderror" id="genre_name" name="genre_name" required value="{{ $menu->genre->name ?? old('genre_name') }}">
    @include('error_input_under', ['name' => 'genre_name'])
</div>

<div class="form-group mt-3">
    <label for="menu_image">画像</label>
    @isset($menu)
    <span class="text-dark small">(変更の場合のみ)</span>
    @endisset
    <p class="text-muted small my-1">※画像は .jpg .png に対応しています。</p>
    <input type="file" accept="image/jpeg, image/png" class="form-control @error('menu_image') is-invalid @enderror" id="menu_image" name="menu_image">
    @include('error_input_under', ['name' => 'menu_image'])
</div>

<div class="d-grid gap-2 my-4">
    <button type="submit" class="btn btn-warning text-white btn-lg">{{ $btn_name }}</button>
</div>
