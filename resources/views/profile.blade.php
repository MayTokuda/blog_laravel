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

                    <!-- {{ __('profile(ブロフィールを表示する)') }} -->
                    @if (session('err_msg'))
                        <p class="text-danger">
                            {{ session('err_msg') }}
                        </p>
                    @endif

                    {{ $user->name}}さんのプロフィール<br>

                    <!-- プロフィール画像 -->
                    <img class="user-img" src="{{ asset('storage/' .$user->profile_image) }}" width="75vw"><br>

                    <div class="row">
                        <label class="col-sm-2 control-label" for="username">ニックネーム</label>
                        <div class="col-sm-10">
                            {{ $user->name }}
                        </div>
                    </div><br>

                    <div class="row">
                        <label class="col-sm-2 control-label" for="username">エリア</label>
                        <div class="col-sm-10">
                            {{ $user-> area }}
                        </div>
                    </div><br>

                    <div class="row">
                        <label class="col-sm-2 control-label" for="username">趣味</label>
                        <div class="col-sm-10">
                            {{ $user->hobby }}
                        </div>
                    </div><br>

                    <div class="row">
                        <label class="col-sm-2 control-label" for="username">自己紹介文</label>
                        <div class="col-sm-10">
                            {{ $user->introduction }}
                        </div>
                    </div>
                    @if(Auth::user()->id === $user->id)
                    <a href="/profileedit/{{$user->id}}"><button type="button" class="btn btn-secondary">プロフィール編集</button></a>
                    @endif
                    <a href="{{ route('dashbord') }}"><button type="button" class="btn btn-secondary">自分のブログの一覧に戻る</button></a></td>
                    <a href="{{ route('other_users') }}"><button type="button" class="btn btn-secondary">メンバーのブログ一覧に戻る</button></a></td>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
