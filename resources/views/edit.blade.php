@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('編集画面') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('記事投稿編集画面') }}
                    <main class="container">
                        <form action="{{ route('update') }}" method="post">
                            @csrf 
                            <dl class="form-list">
                                <dt>画像</dt>
                                <dd><input type="file" name="image" accept="image/png,image/jpeg" value="{{$article->image}}"></dd>
                                <dt>タイトル</dt>
                                <dd><input type="text" name="title"value="{{$article->title}}"></dd>
                                <dt>タグ</dt>
                                <dd><input type="text" name="tag"value="{{$article->tag}}"></dd>
                                <dt>本文</dt>
                                <dd><textarea name="body"value="{{$article->body}}">{{$article->body}}</textarea></dd>
                            </dl>
                            <button type="submit">編集</button>
                            <button type="submit"><a href="{{ route('dashbord') }}">キャンセル</a></button>
                        </form>
                    </main>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
