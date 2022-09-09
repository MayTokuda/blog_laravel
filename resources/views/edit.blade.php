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
                    <form action="{{ route('update', ['id' => $article->id ] ) }}" method="POST" enctype="multipart/form-data">
                        @csrf 
                        <dl class="form-list">
                            <dt>画像</dt><div class="color-red">
                                {{-- 本文のエラーメッセージ --}}
                                @if ($errors->has('image'))
                                    {{$errors->first('image')}}
                                @endif
                            </div>

                            <!-- <input type="file" name="image" id="file_photo" style="display:none;" value="{{$article->image}}" accept="image/png,image/jpeg"> -->
                            <!-- <dd><label class="img-label" for="file_photo">画像を選択</label></dd> -->

                            <!-- 選択した画像を表示する処理 -->
                            <img id="sample1" class="article-img show-img" src="{{ \Storage::url($article->image) }}" alt="" width="100%">
                            <dd><input type="file" id="input1" name="image" value="{{$article->image}}"accept="image/png,image/jpeg"/></dd>

                            <dt>タイトル</dt><div class="color-red">
                                {{-- 本文のエラーメッセージ --}}
                                @if ($errors->has('title'))
                                    {{$errors->first('title')}}
                                @endif
                            </div>

                            <dd><input type="text" name="title" value="{{$article->title}}" placeholder="タイトルの文字入力は「20文字以下」です。"></dd>

                            <dt>タグ</dt>
                            <div class="color-red">
                                {{-- 本文のエラーメッセージ --}}
                                @if ($errors->has('tag'))
                                    {{$errors->first('tag')}}
                                @endif
                            </div>
                            <dd><input type="text" name="tag" value="{{$tag_str}}" placeholder="タグの文字入力は「20文字以下」です。"></dd>

                            <dt>本文</dt>
                            <div class="color-red">
                                {{-- 本文のエラーメッセージ --}}
                                @if ($errors->has('body'))
                                    {{$errors->first('body')}}
                                @endif
                            </div>
                            <dd><textarea name="body" value="{{$article->body}}" placeholder="ブログ本文の文字入力は「200文字以下」です。">{{$article->body}}</textarea></dd>
                        </dl>
                        <button type="submit" class="btn btn-secondary">投稿する</button>
                        <a href="{{ route('dashbord') }}"><button type="button" class="btn btn-secondary">キャンセル</button></a>
                    </form>
                    </main>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
