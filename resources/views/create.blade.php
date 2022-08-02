@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('create(新規記事投稿)') }}
                    <main class="container">
                        <form action="{{ route('post_store') }}" method="post">
                            @csrf 
                            <dl class="form-list">
                                <dt>画像</dt>
                                <dd><input type="file" name="image" accept="image/png,image/jpeg"></dd>
                                <dt>タイトル</dt>
                                <dd><input type="text" name="title"></dd>
                                <dt>タグ</dt>
                                <dd><input type="text" name="tag"></dd>
                                <dt>本文</dt>
                                <dd><textarea name="body"></textarea></dd>
                            </dl>
                            <button type="submit">投稿する</button>
                            <a href="{{ route('dashbord') }}">キャンセル</a>
                        </form>
                    </main>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
