@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('User一覧') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <a href="{{ route('dashbord') }}"><button type="button" class="btn btn-secondary">ブログ一覧(全て)</button></a></td><br>
                    メンバーの一覧画面です！

                    <table class="table" border="1" width="500" cellpadding="3" cellspacing="1">
                        <thead>
                            <tr>
                                <th>ユーザー名</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($allusers as $user)
                            <tr>
                                <td><a href="profile/{{$user->id}}"> {{ $user->name }}</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <table class="table" border="1" width="500" cellpadding="3" cellspacing="1">
                        <thead>
                            <tr>
                                <th>タグの種類</th>
                            </tr>
                        </thead>
                        <tbody>

                        <tbody>
                            @foreach($tags as $tag)
                                <tr>
                                    <td><a href="/allsearch/{{ $tag->name }}">{{ $tag->name }}({{ $tag->count_name }})</a></td>
                                </tr>
                            @endforeach
                        </tbody>   
                    </table>    

                    <table class="table" border="1" width="500" cellpadding="3" cellspacing="1">
                        <thead>
                            <tr>
                                <th>ユーザー名</th>
                                <th>記事タイトル</th>
                                <th>写真</th>
                                <th>記事本文</th>
                                <th>日付</th>
                                <th>タグ</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>{{ $item->user->name }}</td>
                                    <td><a href="/show/{{ $item->id }}">{{ $item->title }}</td>
                                    <td><img class="article-img" src="{{ \Storage::url($item->image) }}" width="75vw"></td>
                                    <td>{{ $item->body }}</td>
                                    <td>{{ $item->created_at->format('Y-m-d') }}</td>
                                        @foreach($item->tags as $tag)
                                            <td>{{ $tag->name }}</td>
                                        @endforeach
                                </tr>
                            @endforeach
                        </tbody>   
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
