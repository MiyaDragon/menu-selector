@extends('app')

@section('content')
@include('nav')
<div class="container text-center">
    <div class="card mt-3 mx-auto" style="width: 500px;">
        <!-- <img src="..." class="card-img-top" alt="..."> -->
        <div class="card-body">
            <h5 class="card-title">カレーライス</h5>
            <div class="card-text">
                <select class="form-select">
                    <option style="display: none;">選択してください</option>
                    <option value="1">ジャンル１</option>
                    <option value="2">ジャンル２</option>
                    <option value="3">ジャンル３</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary mt-3">決定</button>
        </div>
    </div>
</div>
@endsection
