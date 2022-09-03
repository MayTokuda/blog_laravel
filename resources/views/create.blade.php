@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success " role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <?php $user = Auth::user(); ?>{{ $user->name}}さんの新規投稿記事
                    <main class="container">
                        <form action="{{ route('post_store') }}" method="post" enctype="multipart/form-data">
                            @csrf 
                            <dl class="form-list">
                                <dt>画像</dt>
                                <div class="color-red">
                                    {{-- 画像のエラーメッセージ --}}
                                    @if ($errors->has('image'))
                                        {{$errors->first('image')}}
                                    @endif
                                </div>
                                {{-- 画像の入力エリア --}}
                                <dd><input type="file" name="image" accept="image/png,image/jpeg"></dd>

                                <dt>タイトル</dt>
                                <div class="color-red">
                                    {{-- タイトルのエラーメッセージ --}}
                                    @if ($errors->has('title'))
                                        {{$errors->first('title')}}
                                    @endif
                                </div>    
                                    {{-- タイトルの入力エリア --}}
                                <dd><input type="text" name="title"></dd>

                                <dt>タグ</dt>
                                <div class="color-red">
                                    {{-- タグのエラーメッセージ --}}
                                    @if ($errors->has('tag'))
                                        {{$errors->first('tag')}}
                                    @endif
                                </div>
                                {{-- タグの入力エリア --}}
                                <dd><input type="text" name="tag"></dd>

                                <dt>本文</dt>
                                <div class="color-red">
                                    {{-- 本文のエラーメッセージ --}}
                                    @if ($errors->has('body'))
                                        {{$errors->first('body')}}
                                    @endif
                                </div>
                                {{-- 本文の入力エリア --}}
                                <dd><textarea name="body"></textarea></dd>

                            </dl>
                            <button type="submit" class="btn btn-secondary">投稿する</button>
                        </form>
                            <a href="{{ route('dashbord') }}"><button type="button" class="btn btn-secondary">ブログの一覧に戻る</button></a></td>
                    </main>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
