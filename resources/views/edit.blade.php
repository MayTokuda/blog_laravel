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

                    {{ __('編集') }}
                    <main class="container">
                    <form action="{{ route('update', ['id' => $article->id ] ) }}" method="POST">
                        @csrf 
                        <dl class="form-list">
                            <dt>画像</dt>
                            <!-- ラジオボックスを入れる -->
                            
                            <dd><input type="file" name="image" value="{{$article->image}}" accept="image/png,image/jpeg"></dd>
                            <dt>タイトル</dt>
                            <dd><input type="text" name="title" value="{{$article->title}}"></dd>
                            <dt>タグ</dt>
                            <dd><input type="text" name="tag" value="{{$article->tag}}"></dd>
                            <dt>本文</dt>
                            <dd><textarea name="body" value="{{$article->body}}">{{$article->body}}</textarea></dd>
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
