@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('プロフィール') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('プロフィール編集') }}
                    <main class="container">
                    <form action="{{ route('profileedit', ['id' => $user->id ] ) }}" method="POST" enctype="multipart/form-data">
                        @csrf 
                        <dl class="form-list">
                            <dt>画像</dt>
                            <dd><input type="file" name="image" value="{{$user->image}}" accept="image/png,image/jpeg"></dd>
                            <dt>ニックネーム</dt>
                            <dd><input type="text" name="username" value="{{$user->name}}"></dd>
                            <dt>エリア</dt>
                            <dd><input type="text" name="area" value="{{$user->area}}"></dd>
                            <dt>趣味</dt>
                            <dd><input type="text" name="hobby" value="{{$user->hobby}}"></dd>
                            <dt>自己紹介文</dt>
                            <dd><textarea name="introduction" value="{{$user->introduction}}">{{$user->introduction}}</textarea></dd>
                        </dl>
                        <button type="submit">登録する</button>
                        <a href="{{ route('dashbord') }}">キャンセル</a>
                    </form>
                    </main>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection