@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('記事一覧') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- {{ __('dashbord(ブログ記事の一覧を表示する)') }} -->
                    @if (session('err_msg'))
                        <p class="text-danger">
                            {{ session('err_msg') }}
                        </p>
                    @endif

                    <?php $user = Auth::user(); ?>{{ $user->name}}さんのブログ<br>

                    <a href="{{ route('post_create') }}"><button type="button" class="btn btn-secondary">新規ブログ作成</button></a></td>
                    <a href="{{ route('dashbord') }}"><button type="button" class="btn btn-secondary">ブログ一覧(全て)</button></a></td>
                    <a href="{{ route('profile') }}"><button type="button" class="btn btn-secondary">プロフィール</button></a></td>
                    <a href="{{ route('other_users') }}"><button type="button" class="btn btn-secondary">メンバーのブログ一覧(全て)</button></a></td>

                    <table class="table" border="1" width="500" cellpadding="3" cellspacing="1">
                        <thead>
                            <tr>
                                {{-- <th>記事番号</th> --}}
                                <th>記事タイトル</th>
                                <th>写真</th>
                                <th>記事本文</th>
                                <th>日付</th>
                                <th>タグ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($articles as $article)
                            <tr>
                                {{-- <td>{{ $article->id }}</td> --}}
                                <td><a href="/show/{{ $article->id }}">{{ $article->title }}</a></td>
                                <td><img class="article-img" src="{{ \Storage::url($article->image) }}" width="75vw"></td>
                                <td>{{ Str::limit( $article->body, 25 ) }}</td>
                                <td>{{ $article->created_at->format('Y-m-d')}}</td>
                                <td>{{ $article->tags()->value('name') }}</td>
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
                            @foreach($tags as $tag)
                            <tr>
                                <td><a href="/search/{{ $tag->name }}">{{ $tag->name }}({{ $tag->count_name }})</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <table class="table" border="1" width="500" cellpadding="3" cellspacing="1">
                        <thead>
                            <tr>
                                <th>日付</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($days as $day)
                            <tr>
                                <td><a href="/search_time/{{ $day->date }}">{{ $day->date }}</a></td>
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
