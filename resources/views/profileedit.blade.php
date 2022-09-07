@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('プロフィール編集画面') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @foreach ($errors->all() as $error)
                    <div class="color-red">
                        <li>{{$error}}</li>
                    </div>
                    @endforeach

                    {{ __('プロフィール編集') }}
                    <main class="container">
                    <form action="{{ route('profileupdate', ['id' => $user->id ] ) }}" method="POST" enctype="multipart/form-data">
                        @csrf 
                        <dl class="form-list">
                            <dt>画像</dt>

                            {{-- <dd><input type="file" name="profile_image" value="{{$user->profile_image}}" accept="image/png,image/jpeg"></dd> --}}
                            
                            <img class="user-img" src="{{ asset('storage/' .$user->profile_image) }}" width="75vw"><br>
                            <input type="file" name="profile_image" id="file_photo" style="display:none;" value="{{$user->profile_image}}" accept="image/png,image/jpeg">

                            <dd><label class="img-label" for="file_photo">画像を選択</label></dd>

                            <dt>ニックネーム</dt>
                            <dd><input type="text" name="name" value="{{$user->name}}"></dd>

                            <dt>エリア</dt>
                            <dd><input type="text" name="area" value="{{$user->area}}"></dd>

                            <dt>趣味</dt>
                            <dd><input type="text" name="hobby" value="{{$user->hobby}}"></dd>

                            <dt>自己紹介文</dt>
                            <dd><textarea name="body" value="{{$user->introduction}}">{{$user->introduction}}</textarea></dd>
                        </dl>
                        <button type="submit" class="btn btn-secondary">登録する</button>
                        <a href="{{ route('dashbord') }}"><button type="button" class="btn btn-secondary">キャンセル</button></a>
                    </form>
                    </main>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection